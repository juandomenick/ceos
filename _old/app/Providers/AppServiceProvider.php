<?php

namespace App\Providers;

use App\Services\Academico\GoogleClassroomService;
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
        $this->app->singleton(GoogleClassroomService::class, function () {
            return new GoogleClassroomService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.env') === 'production') {
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
