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
Route::get('/', 'HomeController@index');

Route::get('auth','AuthController@showLoginForm')->name('login');
Route::post('auth','AuthController@loginproses')->name('login.post');
Route::post('logout','AuthController@logout')->name('logout');


// group route prefix admin
Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function()
{
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('verifikasi/chart/eklaim', 'HomeController@chartAjax')->name('chart.eklaim');
    // Group Route Masteear
    Route::group(['namespace' => 'Klaim'], function() {
        // autocompleted
        Route::get('/bpjs/kelas','BpjsController@getKelas')->name('bpjs.kelas');
        Route::get('/bpjs/diagnosa','BpjsController@getDiagnosa')->name('bpjs.diagnosa');
        Route::get('/bpjs/poli','BpjsController@getPoli')->name('bpjs.poli');
        Route::get('/bpjs/dpjp','BpjsController@getDpjp')->name('bpjs.dpjp');
        Route::get('/bpjs/dpjp/dokter','BpjsController@getListDpjp')->name('bpjs.dpjp.dokter');
        Route::get('/bpjs/faskes','BpjsController@getFaskes')->name('bpjs.faskes');

        Route::get('/bpjs/listrujukan','BpjsController@getListRujukan')->name('bpjs.listrujukan');
        Route::get('/bpjs/listrujukan/rs','BpjsController@getListRujukanRS')->name('bpjs.listrujukan.rs');

        Route::get('/bpjs/cekrujukan','BpjsController@getCekRujukan')->name('bpjs.cek.rujukan');
        Route::get('/bpjs/cekrujukanrs','BpjsController@getCekRujukanRS')->name('bpjs.cek.rujukan.rs');
        Route::get('/bpjs/rujukan','BpjsController@getRujukan')->name('bpjs.rujukan');
        Route::get('/bpjs/rujukan/rs','BpjsController@getRujukanRS')->name('bpjs.rujukan.rs');

        Route::get('/bpjs/history','BpjsController@getHistory')->name('bpjs.history');
        Route::get('/bpjs/history/peserta','BpjsController@getHistoryPeserta')->name('bpjs.history.peserta');
        Route::get('/bpjs/cekhistory','BpjsController@getcekHistory')->name('bpjs.cekhistory');
        Route::get('/bpjs/provinsi','BpjsController@getProvinsi')->name('bpjs.provinsi');
        Route::get('/bpjs/kabupaten','BpjsController@getKabupaten')->name('bpjs.kabupaten');
        Route::get('/bpjs/kecamatan','BpjsController@getKecamatan')->name('bpjs.kecamatan');

        Route::get('/bpjs/peserta','BpjsController@getPeserta')->name('bpjs.peserta');
        Route::get('/bpjs/ppkrujukan','BpjsController@getPpkRujukan')->name('bpjs.ppkrujukan');
        Route::get('/bpjs/sep','BpjsController@getSep')->name('bpjs.sep'); 
        
        // VERIFIKASI OKE BEROH
        Route::get('/viewer','KlaimBpjsController@index')->name('viewer.index');
        Route::get('/viewer/search','KlaimBpjsController@search')->name('viewer.search');
        Route::get('/viewer/catatan','KlaimBpjsController@catatan')->name('viewer.catatan');
        Route::post('/viewer/verified/petugas', 'KlaimBpjsController@verified')->name('viewer.verified');
        Route::post('/viewer/checked/petugas', 'KlaimBpjsController@checked')->name('viewer.checked');
        Route::post('/viewer/verified/all/petugas', 'KlaimBpjsController@verifiedall')->name('viewer.all.verified');
        Route::post('/viewer/download', 'KlaimBpjsController@download')->name('viewer.download');
        Route::post('/viewer/export', 'KlaimBpjsController@Export')->name('viewer.export');

        Route::get('/verifikasi/peserta/{peserta}', 'VerifikasiController@detailPeserta')->name('detail.peserta');
        Route::get('/verifikasi/suratkontrol', 'VerifikasiController@getSuratInternal')->name('surat.kontrol');
        Route::get('/verifikasi/surat/print/{tgl}/{surat}/{rujukan}','VerifikasiController@printSurat')->name('surat.print');

        Route::get('/getnas', 'KlaimBpjsController@getNas');
        Route::get('/getupdates', 'KlaimBpjsController@getupdates');
    });

    // Group Route Registrasi
    Route::group(['namespace' => 'User'], function() {
        Route::get('user', 'UserController@index')->name('user.index');
        Route::get('user/pegawai/foto', 'UserController@getFoto')->name('user.foto');
        Route::get('user/pegawai/edit/{pegawai}', 'UserController@getEdit')->name('user.edit.profil');
        Route::put('user/pegawai/update/{pegawai}', 'UserController@getUpdate')->name('user.update.profil');
        Route::get('user/search', 'UserController@search')->name('user.search');
        Route::get('user/pegawai','UserController@pegawai')->name('user.pegawai');
        Route::post('user/simpan','UserController@simpanUser')->name('user.simpan');
        Route::delete('user/delete','UserController@deleteUser')->name('user.delete');
    });

    // Rujukan
    // Route::get('/cobatanggal', function() {
    //     $dt1 = strtotime("2018/09/20");
    //     $dt2 = strtotime("2018/12/19");
    //     $diff = abs($dt2-$dt1);
    //     $telat = $diff/86400; // 86400 detik sehari
    //     echo $telat;
    // });

});