<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CSVServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'CSV',
            'App\Http\Components\CSV',
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
