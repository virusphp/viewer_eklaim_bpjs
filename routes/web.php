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
// URL AWAL
Route::get('/', function () {
    return redirect('/admin/home');
});

Route::get('auth','AuthController@showLoginForm')->name('login');
Route::post('auth','AuthController@loginproses')->name('login.post');
Route::post('logout','AuthController@logout')->name('logout');

// group route prefix admin
Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function()
{
    Route::get('/home', 'HomeController@index')->name('home');

    // Group Route Master
    Route::group(['namespace' => 'master'], function() {
        Route::get('/akun/perkiraan','AkunPerkiraanController@index')->name('akun.perkiraan');
    });

    // Group Route Transaksi
    Route::group(['namespace' => 'transaksi', 'prefix' => 'transksi'], function() {
        Route::get('kwitansi', 'KwitansiController@index')->name('kwitansi');
        Route::get('kwitansi/search', 'KwitansiController@search')->name('kwitansi.search');
        Route::get('kwitansi/{no_kwitansi}', 'KwitansiController@getKwitansi')->name('kwitansi.get');
    });

});