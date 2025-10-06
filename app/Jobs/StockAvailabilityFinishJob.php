<?php

namespace App\Jobs;


use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use JobHelper;

class StockAvailabilityFinishJob implements ShouldQueue
{
    use Queueable,Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(private \App\Models\Upload $upload)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        JobHelper::storeData($this->upload,'StockAvailabilityFinish');
    }
}
