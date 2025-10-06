<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\JobHelper;

class ShelfLifeRegisterJob implements ShouldQueue
{
    use Batchable, Queueable,InteractsWithQueue,Dispatchable,SerializesModels;

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
        JobHelper::storeData($this->upload,'ShelfLifeRegister');
    }
}
