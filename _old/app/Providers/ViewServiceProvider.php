<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Class ViewServiceProvider
 *
 * @package App\Providers
 */
class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.dashboard.sidebar', function ($view) {
            $usuario = Auth::user();
            return $view->with([
                'sidebarItems' => config('sidebar'),
                'avatar' => $usuario->path_avatar,
                'nomeUsuario' => $usuario->primeiro_nome,
                'funcao' => $usuario->funcao
            ]);
        });

        View::composer('layouts.dashboard.nav', function ($view) {
            $usuario = Auth::user();
            return $view->with('nomeUsuario', $usuario->primeiro_nome);
        });

        Blade::include('layouts.forms.form-input', 'input');
        Blade::include('layouts.forms.form-input-file', 'inputFile');
        Blade::include('layouts.forms.form-textarea', 'textarea');
        Blade::include('layouts.forms.form-select', 'select');
        Blade::include('layouts.forms.form-checkbox', 'checkbox');
        Blade::include('layouts.forms.form-button', 'button');
    }
}
