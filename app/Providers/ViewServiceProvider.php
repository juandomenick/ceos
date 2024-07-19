<?php

namespace App\Providers;

// HELPERS
use App\Helpers\SecurityHelper;
use App\Helpers\StringHelper;
use App\Helpers\DeviceHelper;
use App\Helpers\EnvironmentHelper;
use App\Helpers\GitHelper;

// BIBLIOTECAS
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public $helpers;

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
        // SETANDO GLOBALMENTE A VARIAVEL HELPERS
        View::composer('*', function ($view) {
            $view->with('securityHelper', new SecurityHelper);
            $view->with('deviceHelper', new DeviceHelper);
            $view->with('stringHelper', new StringHelper);
            $view->with('gitHelper', new GitHelper);
            $view->with('environmentHelper', new EnvironmentHelper);
        });
    }
}
