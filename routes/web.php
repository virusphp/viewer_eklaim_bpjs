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
    Route::group(['namespace' => 'Sep'], function() {
        // autocompleted
        Route::get('/bpjs/diagnosa','BpjsController@getDiagnosa')->name('bpjs.diagnosa');
        Route::get('/bpjs/poli','BpjsController@getPoli')->name('bpjs.poli');
        Route::get('/bpjs/dpjp','BpjsController@getDpjp')->name('bpjs.dpjp');
        Route::get('/rujukan/internal','RujukanController@getRujukanInternal')->name('rujukan.internal');

        Route::get('/bpjs/provinsi','BpjsController@getProvinsi')->name('bpjs.provinsi');
        Route::get('/bpjs/kabupaten','BpjsController@getKabupaten')->name('bpjs.kabupaten');
        Route::get('/bpjs/kecamatan','BpjsController@getKecamatan')->name('bpjs.kecamatan');
        Route::get('/bpjs/rujukan','BpjsController@getRujukan')->name('bpjs.rujukan');
        Route::get('/bpjs/peserta','BpjsController@getPeserta')->name('bpjs.peserta');
        Route::get('/bpjs/ppkrujukan','BpjsController@getPpkRujukan')->name('bpjs.ppkrujukan');
        
        Route::get('/sep/pembuatan','SepController@index')->name('sep.index');
        Route::post('/sep/pembuatan','SepController@buatSep')->name('sep.buat');
        Route::post('/sep/insert','SepController@sepInsert')->name('sep.insert');
        Route::post('/sep/simpansep','SepController@simpanSep')->name('sep.simpan');
        Route::get('/sep/search','SepController@search')->name('sep.search');
    });

    // Group Route Transaksi
    Route::group(['namespace' => 'transaksi', 'prefix' => 'transksi'], function() {
        Route::get('kwitansi', 'KwitansiController@index')->name('kwitansi');
        Route::get('kwitansi/search', 'KwitansiController@search')->name('kwitansi.search');
        Route::post('kwitansi', 'KwitansiController@getKwitansi')->name('kwitansi.get');
    });

});