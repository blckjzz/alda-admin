<?php
use App\Http\Middleware\CheckConselheiro;
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
    return redirect('/admin');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

});

Route::group([
    'prefix' => 'admin',
    'middleware' => ['checkConselheiro']
], function() {
    Route::GET('conselheiro/pauta','ConselheiroController@index');
    Route::POST('conselheiro/pauta','ConselheiroController@storePauta');

    Route::GET('conselheiro/ccs','ConselheiroController@viewCCS');
    Route::POST('conselheiro/ccs','ConselheiroController@storeDiretoria');

    route::GET('diretoria/{id}', 'DiretoriaController@findDiretoriaById');

});