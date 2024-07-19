<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        providerRegister('app/Repositories', 'App\Repositories', $this->app);
        App::bind('App\Repositories\Interfaces\Academico\Questoes\QuestaoRepository', 'App\Repositories\Academico\Questoes\QuestaoRepositoryEloquent');
        App::bind('App\Repositories\Interfaces\Academico\HabilidadeRepository', 'App\Repositories\Academico\HabilidadeRepositoryEloquent');
        App::bind('App\Repositories\Interfaces\Academico\CompetenciaRepository', 'App\Repositories\Academico\CompetenciaRepositoryEloquent');
        App::bind('App\Repositories\Interfaces\Academico\AtividadeRepository', 'App\Repositories\Academico\AtividadeRepositoryEloquent');
        App::bind('App\Repositories\Interfaces\Academico\DisciplinaRepository', 'App\Repositories\Academico\DisciplinaRepositoryEloquent');
        App::bind('App\Repositories\Interfaces\Academico\Questoes\QuestaoRepository', 'App\Repositories\Academico\Questoes\QuestaoRepositoryEloquent');
        App::bind('App\Repositories\Interfaces\Academico\EquipeRepository', 'App\Repositories\Academico\EquipeRepositoryEloquent');
        App::bind('App\Repositories\Interfaces\Academico\Turmas\TurmaRepository', 'App\Repositories\Academico\Turmas\TurmaRepositoryEloquent');
        App::bind('App\Repositories\Interfaces\Academico\Atividades\AtividadeRepository', 'App\Repositories\Academico\Atividades\AtividadeRepositoryEloquent');
        App::bind('App\Repositories\Interfaces\Academico\Atividades\AtividadeDesignavelRepository', 'App\Repositories\Academico\Atividades\AtividadeDesignavelRepositoryEloquent');
        App::bind('App\Repositories\Interfaces\Usuarios\AlunoRepository', 'App\Repositories\Usuarios\AlunoRepositoryEloquent');
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
