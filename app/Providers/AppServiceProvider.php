<?php

namespace App\Providers;

use App\Models\OrderProcess;
use App\Observers\OrderProcessObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        OrderProcess::observe(OrderProcessObserver::class);
    }
}
