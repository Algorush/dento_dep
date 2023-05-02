<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $this->bodyClassShare();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerServices();
    }

    /**
     * Prepare and share body class
     */
    protected function bodyClassShare()
    {
        $request = request();

        if($request->path() === '/'){
            $body_class = 'page-index';
        } else {
            $body_class = 'page-' . str_replace('/', '-', $request->path());
        }

        view()->share('body_class', $body_class);
    }

    /**
     * Registering app services
     */
    public function registerServices()
    {
        /**
         * Conditionally Loading Service Providers
         *
         * local - load all tech service providers
         * dev-server - load iseed and migrate generator service providers
         */
        if($this->app->environment() === 'local'){
            $this->app->register('Barryvdh\Debugbar\ServiceProvider');
            $this->app->register(DuskServiceProvider::class);
        }

        if($this->app->environment() === 'local' || $this->app->environment() === 'dev-server'){
            $this->app->register('Orangehill\Iseed\IseedServiceProvider');
        }
    }
}
