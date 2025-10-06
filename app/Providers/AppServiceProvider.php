<?php

namespace App\Providers;

use App\Providers\CustomFailedJobProvider;
use Illuminate\Queue\Failed\FailedJobProviderManager;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }

}
