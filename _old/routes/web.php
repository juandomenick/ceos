<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Rotas de autenticação e cadastro
 */
Auth::routes();
Auth::routes(['verify' => true]);

/* Página inicial que redireciona para o login */
Route::get('/', function () {
    return redirect('/login');
});

/* Login do responsável */
Route::get('/login-responsavel', function () {
    return view('auth.login-responsavel');
})->name('login.responsavel');

/* Login com Conta Google */
Route::namespace('Auth')->group(function () {
    Route::get('login/google', 'LoginGoogleController@redirectToGoogle');
    Route::get('login/google/callback', 'LoginGoogleController@handleGoogleCallback');
});

/**
 * Rota do dashboard
 */
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

/**
 * Rotas de Localização (Estados e Cidades)
 */
Route::namespace('Dashboard\Geral\Localizacao')->group(function () {
    Route::get('estados', 'EstadoController@index');
    Route::get('estados/{id}/cidades', 'CidadeController@listarPorEstado');
});

/**
 * Rotas de atualização de dados pessoais e senha
 */
Route::namespace('Dashboard\DadosPessoais')->middleware('verified')->prefix('/dados-pessoais')->group(function () {
    /* Atualização de dados pessoais */
    Route::get('/perfil', 'PerfilController@edit')->name('perfil.editar');
    Route::put('/perfil/{id}', 'PerfilController@update')->name('perfil.atualizar');

    /* Atualização de senha */
    Route::get('/senha', 'AtualizarSenhaController@edit')->name('senha.editar');
    Route::put('/senha/{id}', 'AtualizarSenhaController@update')->name('senha.atualizar');
});

/**
 * Rotas de gerenciamento do tipo "Usuários"
 */
Route::namespace('Dashboard\Usuarios')->middleware('verified')->prefix('/usuarios')->group(function () {
    Route::resource('diretores', 'Diretores\DiretorController')->middleware(['role:administrador']);
    Route::resource('coordenadores', 'Coordenadores\CoordenadorController');
    Route::resource('professores', 'Professores\ProfessorController')->middleware(['role:administrador']);
    Route::resource('alunos', 'Alunos\AlunoController')->middleware(['role:administrador|professor']);
});

/**
 * Rotas de gerenciamento do tipo "Acadêmico"
 */
Route::namespace('Dashboard\Academico')->middleware('verified')->prefix('/academico')->group(function () {
    Route::resource('instituicoes','Instituicoes\InstituicaoController');
    Route::resource('cursos','Cursos\CursoController');
    Route::resource('disciplinas','Disciplinas\DisciplinaController');
    Route::resource('turmas/ingresso','Turmas\IngressoTurmaController')->names('turmas.ingresso')->only('index', 'store');
    Route::resource('turmas','Turmas\TurmaController');
    Route::resource('turmas.atividades','Turmas\AtividadeTurmaController');
    Route::resource('equipes','Equipes\EquipeController');
    Route::resource('competencias','Competencias\CompetenciaController');
    Route::resource('habilidades','Habilidades\HabilidadeController');
    Route::namespace('Questoes')->group(function () {
        Route::resource('questoes','QuestaoController');
        Route::get('questoes/{id}/duplicar','QuestaoController@duplicate')->name('questoes.duplicar');
        Route::resource('questoes.alternativas','AlternativaController')->except(['index', 'show']);
    });
    Route::resource('atividades','Atividades\AtividadeController')->except('show');
    Route::resource('atividades.designar','Atividades\DesignarAtividadeController')->except(['index', 'show']);
    Route::resource('anotacoes-aula','AnotacoesAula\AnotacaoAulaController')->except('show');
});

/**
 * Rotas de gerenciamento do tipo "Geral"
 */
Route::namespace('Dashboard\Geral')->middleware('verified')->prefix('/geral')->group(function () {
    Route::resource('termos-aceite', 'TermosAceite\TermoAceiteController')->middleware(['role:administrador|professor']);
});

/**
 * Rotas de gerenciamento do tipo "Minhas Atividades"
 */
Route::namespace('Dashboard\MinhasAtividades')->middleware('verified')->group(function () {
    Route::resource('atividades-individuais','AtividadesIndividuaisController')->only('index', 'show');
    Route::resource('atividades-equipes','AtividadesEquipesController')->only('index', 'show');
    Route::resource('atividades-turmas','AtividadesTurmasController')->only('index', 'show');
    Route::post('atividades/respostas/{atividade}','ResponderAtividadeController@store')->name('atividades.respostas');
});

/**
 * Rotas de gerenciamento do tipo "Jogos Externos"
 */
Route::namespace('Dashboard\Jogos')->middleware('verified')->group(function () {
    Route::get('/jogos/main-world','JogosExternosController@mainWorld')->name('jogos.main-world');
});