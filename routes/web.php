<?php

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

Route::get('/', function () {
    return redirect('/painel/login');
});

/**
 */
Route::group(['prefix' => 'painel', 'middleware' => 'checkPanel'], function () {
    Voyager::routes();
    // Your overwrites here
    Route::post('login', ['uses' => 'LoginController@novoLogin', 'as' => 'custom.login.logic']);

});

/**
 * Moderação
 */

Route::group(['prefix' => 'painel', 'middleware' => ['checkModerador']], function () {
    route::GET('moderacao/resultados', 'ModeracaoController@listaPautas');
    route::GET('moderacao/resultado/{id}/visualizar', 'ModeracaoController@showPauta');
    route::POST('moderacao/resultado', 'ModeracaoController@storeResultado');

});

Route::group([
    'prefix' => 'painel',
    'middleware' => ['checkConselheiro', 'checkPanel']
], function () {


    Route::GET('conselheiro/ata', 'ConselheiroController@viewPauta');
    Route::POST('conselheiro/ata', 'ConselheiroController@storePauta');

    Route::GET('conselheiro', ['uses' => 'ConselheiroController@dashboard', 'as' => 'conselheiro.dashboard']);

    Route::GET('conselheiro/pauta', 'ConselheiroController@viewPauta');
    Route::POST('conselheiro/pauta', 'ConselheiroController@storePauta');

    Route::GET('conselheiro/ccs', 'ConselheiroController@viewCCS');
    Route::POST('conselheiro/ccs', 'ConselheiroController@storeDiretoria');

    Route::GET('conselheiro/membrosnato', 'ConselheiroController@viewMembrosNato');

    route::get('conselheiro/logout', 'LoginController@logout');

    route::GET('diretoria/{id}', 'DiretoriaController@findDiretoriaById');

    /**
     * Resultados
     */

    route::GET('resultado/{id}', 'ResultadoController@findResultadoById');
    route::GET('resultado/{id}/assuntos', 'ResultadoController@findAssuntosByResultadoId');
    route::GET('resultado/view/{id}', 'ResultadoController@show');

    /***
     * Agenda
     */
    route::GET('agenda/{id}/resultado/', 'AgendaController@findResultadoById');

    /**
     * Presença
     */

    route::GET('presenca/{agendaId}', 'PresencaController@findPresencaByAgendaId');




});