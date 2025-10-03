<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUploadRequest;
use Illuminate\Http\Request;
use App\Models\Upload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Bus\BatchRepository;

use Laravel\Horizon\Jobs\RetryFailedJob;

class UploadsController extends Controller 
{
    private $tables =  [
        'TimeTrackingEvents','StoreCheckins',
        'MediaBuffer','MediaStart','MediaFinish', 
        'StockAvailabilityStart','StockAvailabilityRegister','StockAvailabilityFinish',
        'ShelfLifeStart','ShelfLifeRegister','ShelfLifeFinish',
        'PriceSurveyFinish','PriceSurveyRegister','PriceSurveyStart'
    ];


    public function getAllUploads()
    {
        $batchRepository = app(BatchRepository::class);
        $batches = $batchRepository->get();
        $uploads = [];
        foreach($batches as $batch)
        {
            $status = '';
            $failedJobs = $this->getFailedJobs($batch);
            $status = $this->batchStatus($batch,$failedJobs);
            $uploads[] = [
                'id'=>$batch->id,
                'name'=>$batch->name,
                'status'=>$status,
                'progress' => $batch->progress()
            ];
        }
        return $uploads;
    }

    private function getFailedJobs($batch)
    {
        $failedJobs = [];
        if(!empty($batch->failedJobIds))
        {
            $failedJobs = DB::table('failed_jobs')
                ->whereIn('uuid', $batch->failedJobIds)
                ->orderBy('failed_at')
                ->get();
        }
        return $failedJobs;
    }

    private function batchStatus($batch,$failedJobs)
    {
        $status = '';
        if($batch->pendingJobs == $batch->totalJobs && empty($failedJobs))
        {
            $status = 'pending';
            $upload = Upload::findOrFail($batch->name);
            $registros = $upload->getHasMany('TimeTrackingEvents')->count();
            if($registros  > 0)
                $status = 'processing';
            
        }

        else if($batch->finished() && $batch->progress() == 100)
        {
            $upload = Upload::findOrFail($batch->name);
            $status = 'success';
            
            foreach($this->tables as $table)
            {
                $amounts = $this->getAmounts($upload,$table);
                if($amounts['quantidadesJson'] != $amounts['quantidades'] && !empty($failedJobs))
                    $status = 'failed';
            }   
        }
        else if($batch->pendingJobs < $batch->totalJobs && empty($failedJobs))
            $status = 'processing';
        else if($batch->pendingJobs != 0)
        {
            if($failedJobs)
                $status = 'failed';   
        }
        return $status;
    }

    private function getAmounts($upload,$table)
    {
        $file= $upload->getAmountFile()->where('table','=',$table)->first();
        $quantidadesJson[$table] = 0;
        if($file)
        {
            $quantidadesJson[$table] = $file->qtd;
        }
        $quantidades[$table] = $upload->getHasMany($table)->count();
        return [
            'quantidadesJson' => $quantidadesJson,
            'quantidades' => $quantidades
        ];
    }

    public function show($batch_id)
    {
        $batch = Bus::findBatch($batch_id);
        if($batch)
        {
            $status = 'processing';
            if($batch->pendingJobs == $batch->totalJobs)
            {
                $status = 'pending';
            }

            $failedJobsNames = [];
            $quantidades = [];
            $quantidadesJson = [];
            $failedJobs = $this->getFailedJobs($batch);

            $upload = Upload::findOrFail($batch->name);
            
            foreach($this->tables as $table)
            {
                $file= $upload->getAmountFile()->where('table','=',$table)->first();
                if($file)
                {
                    $quantidadesJson[$table] = $file->qtd;
                }
                $quantidades[$table] = $upload->getHasMany($table)->count();
            }
            $batchStatus = $this->batchStatus($batch,$failedJobs);

            if(!$batch->finished() || $batchStatus == 'failed')
            {
                foreach($failedJobs as $failed)
                    $failedJobsNames[] = $this->failedJobPayload($failed);
            }

            $array[$batch->id] = [
                'batch' => $batch ,
                'progress' => $batch->progress(),
                'failed_jobs' => $failedJobsNames,
                'status' => $status,
                'quantidades' => $quantidades,
                'arquivo' => $quantidadesJson
            ];
            return $array;
        }
    }
    private function failedJobPayload($failed)
    {
        $json = json_decode($failed->payload);
        if($json)
        {
            $retry = !empty($json->retry_of) ? '(Retry)' : '';
            $parteLog = explode("\n",$failed->exception);
            return  [
                'name' => $json->displayName,
                'date' => date('Y-m-d H:i:s', $json->pushedAt),
                'exception' => $parteLog[0],
                'retry' => $retry,
                'id' => $json->id
            ];
        }
    }
    public function create(CreateUploadRequest $request)
    {
        $uploadedFile = $request->file('file');
        $jsonContent = $uploadedFile->get();

        $data = json_decode($jsonContent, true);
        if($this->validateJson(array_keys($data)))
        {
            $path = Storage::putFile('files', $request->file('file'));
            $upload = Upload::create(['file_path' => $path]);
            if($upload)
            {
                $this->dispatchJobs($upload);
            }
            echo json_encode($upload->id);
        }
        else
        {
            return response('Invalid Json',400);    
        }
    }
    private function validateJson($tabelas)
    {
        foreach($tabelas as $tabela)
        {
            if(in_array($tabela,$this->tables)) 
            {
                return true;
            }
            return false;
        }
    }
    private function dispatchJobs($upload)
    {
        $jobs = [];
        foreach($this->tables as $table)
        {
            $class = "\\App\\Jobs\\{$table}Job";
            $jobs[] = new $class($upload);
        }
        if($jobs)
        {
            Bus::batch($jobs)->allowFailures()->name($upload->id)->onConnection('redis')->dispatch();
        }

    }
    public function reprocessBatch($batch_id)
    {
        $batch = Bus::findBatch($batch_id);
        if($batch)
        {
            $this->reprocessJob($batch->failedJobIds);
        }
    }
    public function reprocessJob($job_id)
    {
        $job_id = !is_array($job_id) && !empty($job_id) ? [$job_id] : $job_id;
        $failedJobs = DB::table('failed_jobs')
            ->whereIn('uuid', $job_id)
            ->get();

        foreach($failedJobs as $failed)
        {
            $json = json_decode($failed->payload);
            if($json && empty($json->retry_of))
            {
                dispatch(new RetryFailedJob($json->id));
            }
        }
    }

}
