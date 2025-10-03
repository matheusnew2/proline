<?php
namespace App\Helpers;

use App\Exceptions\JobException;
use App\Models\DataAmount;
use Exception;
use JsonHelper;
use Illuminate\Support\Facades\Storage;
class JobHelper
{
    public static function storeData($upload, $table)
    {
        $arr = [];
        try
        {   
            if(!class_exists("\\App\Models\\{$table}"))
                return false;

            $jsonFile = Storage::disk('local')->json($upload->file_path);
            if(empty($jsonFile[$table]))
            {
                return false;
            }
            DataAmount::create([
                'upload_id' => $upload->id,
                'table' => $table,
                'qtd' => count($jsonFile[$table])
            ]);
            
            $model = app("\\App\Models\\{$table}");
            $model->where('upload_id','=', $upload->id)->delete();
            
            foreach($jsonFile[$table] as $item)
            {
                $arr = JsonHelper::convertPayload($item);
                $arr['upload_id'] = $upload->id;
                $model->create($arr);
            }
        }
        catch(Exception $e)
        {   
            throw new JobException($e->getMessage(),extras:['table'=>$table,'data'=>$arr,'upload' => $upload]);
        }
    }
}