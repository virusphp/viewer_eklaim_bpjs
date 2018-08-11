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
    return redirect('/admin/home');
});

//membuat login
$this->get('panel', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('panel', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// group route prefix admin
Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function()
{
    Route::get('/home', 'HomeController@index')->name('home');

    // Group Route Master
    Route::group(['namespace' => 'master'], function() {
        Route::get('/akun/perkiraan','AkunPerkiraanController@index')->name('akun.perkiraan');
    });

});