<?php

/*
|----------------------------------------------------------------------------------------------------------------------------------------------------
| WEB Routes - INICIO
|----------------------------------------------------------------------------------------------------------------------------------------------------
*/

// GERAL
use App\Http\Controllers\Web\Geral\HomeController as WebGeralController;

// SESSÃO
use App\Http\Controllers\Web\Sessao\LoginController as WebSessaoLoginController;

// ACADEMICO

// LOJA

// INSTITUIÇÕES

// ACESSOS
use App\Http\Controllers\Web\Acessos\Pessoas\PessoasController as WebAcessosPessoasController;

// LOGS

/*
|----------------------------------------------------------------------------------------------------------------------------------------------------
| WEB Routes - FINAL
|----------------------------------------------------------------------------------------------------------------------------------------------------
*/

// BIBLIOTECAS
use Illuminate\Support\Facades\Route;

// ROTAS DO DOMINIO PRINCIPAL
$routes = function () {
    // HTTPS
    Route::middleware("https")->group(function () {
        // LOGIN
        Route::get("/login", [WebSessaoLoginController::class, "index"])->name("web.plataforma.login");
        Route::post("/login", [WebSessaoLoginController::class, "index"]);

        // LOGOUT
        Route::get("/logout", [WebSessaoLoginController::class, "logout"])->name("web.plataforma.logout");

        // ROTAS COM LOGIN OBRIGATÓRIO
        Route::middleware("require.session")->group(function () {
            // ROTAS SÓ ACESSADAS VIA NAVEGADOR
            Route::middleware("require.browser")->group(function () {
                // HOME PAGE
                Route::get("/", [WebGeralController::class, "index"])->name("web.plataforma.home");

                // AGRUPRAMENTOS ACESSOS
                Route::prefix("/acessos")->group(
                    function () {
                        // PESSOAS
                        Route::prefix("/pessoas")->group(
                            function () {
                                // LISTAR
                                Route::get("/listar", [WebAcessosPessoasController::class, "listar"])->name("web.plataforma.acessos.pessoas.listar");

                                // CADASTRAR
                                Route::get("/cadastrar", [WebAcessosPessoasController::class, "cadastrar"])->name("web.plataforma.acessos.pessoas.cadastrar");
                                Route::post("/cadastrar", [WebAcessosPessoasController::class, "cadastrar"]);
                            }
                        );
                    }
                );
            });
        });
    });
};

Route::domain(env("APP_URL"))->group($routes);
