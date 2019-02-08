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
    return redirect('/admin');
});

//Route::get('/db', function (){
//    try {
//        DB::connection()->getPdo();
//        return \App\Agenda::first();
//
//    } catch (\Exception $e) {
//        die("Could not connect to the database.  Please check your configuration. error:" . $e );
//    }
//});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

});

//Route::group(['prefix' => 'admin'], function(){
//    Route::resource('conselheiro', 'ConselheiroController');
//})->middleware('checkConselheiro');

Route::group([
    'prefix' => 'admin',
    'middleware' => ['checkConselheiro']
], function() {
    Route::Resource('conselheiro','ConselheiroController');
});