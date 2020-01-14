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
Route::get('/','AuthController@login');
Route::post('/login','AuthController@doLogin');
Route::get('/logout','AuthController@doLogout');

Route::group(['middleware' => ['authLogin']], function () {
    Route::get('/home','DashboardController@index');

    //Menu
    Route::get('menu','MenuController@index');
    Route::get('menu/load','MenuController@loadData');
    Route::post('menu/insert','MenuController@insert');
    Route::get('menu/edit/{id}','MenuController@edit');
    Route::post('menu/update/{id}','MenuController@update');
    Route::get('menu/delete/{id}','MenuController@destroy');

    //Role
    Route::get('role','RoleController@index');
    Route::get('role/load','RoleController@loadData');
    Route::post('role/insert','RoleController@insert');
    Route::get('role/edit/{id}','RoleController@edit');
    Route::post('role/update/{id}','RoleController@update');
    Route::get('role/delete/{id}','RoleController@destroy');
    //Access
    Route::get('role/access/{id}','RoleController@access');
    Route::get('role/access/change/{menu}/{role}','RoleController@changeAccess');

    //User
    Route::get('user','UserController@index');
    Route::get('user/load','UserController@loadData');
    Route::post('user/insert','UserController@insert');
    Route::get('user/edit/{id}','UserController@edit');
    Route::post('user/update/{id}','UserController@update');
    Route::get('user/change/{id}/{status}','UserController@changeStatus');
    Route::get('user/change/password','UserController@changePassword');
    Route::post('user/change/password/do','UserController@doChangePassword');
    Route::get('user/change/password/reset/{id}','UserController@resetPassword');
    //Master
        //Layanan
        Route::get('layanan','MasterController@indexLayanan');
        Route::get('layanan/load','MasterController@loadDataLayanan');
        Route::post('layanan/insert','MasterController@insertLayanan');
        Route::get('layanan/edit/{id}','MasterController@editLayanan');
        Route::post('layanan/update/{id}','MasterController@updateLayanan');
        Route::get('layanan/delete/{id}','MasterController@destroyLayanan');

        //ONT
        Route::get('ont','MasterController@indexOnt');
        Route::get('ont/load','MasterController@loadDataOnt');
        Route::post('ont/insert','MasterController@insertOnt');
        Route::get('ont/edit/{id}','MasterController@editOnt');
        Route::post('ont/update/{id}','MasterController@updateOnt');
        Route::get('ont/delete/{id}','MasterController@destroyOnt');

        //Paket Tambahan
        Route::get('tambahan','MasterController@indexTambahan');
        Route::get('tambahan/load','MasterController@loadDataTambahan');
        Route::post('tambahan/insert','MasterController@insertTambahan');
        Route::get('tambahan/edit/{id}','MasterController@editTambahan');
        Route::post('tambahan/update/{id}','MasterController@updateTambahan');
        Route::get('tambahan/delete/{id}','MasterController@destroyTambahan');

        //Jenis Transaksi
        Route::get('transaksi/jenis','MasterController@indexJenisTransaksi');
        Route::get('transaksi/jenis/load','MasterController@loadDataJenisTransaksi');
        Route::post('transaksi/jenis/insert','MasterController@insertJenisTransaksi');
        Route::get('transaksi/jenis/edit/{id}','MasterController@editJenisTransaksi');
        Route::post('transaksi/jenis/update/{id}','MasterController@updateJenisTransaksi');
        Route::get('transaksi/jenis/delete/{id}','MasterController@destroyJenisTransaksi');

        //Plasa
        Route::get('plasa','PlasaController@index');
        Route::get('plasa/load','PlasaController@loadData');
        Route::post('plasa/import','PlasaController@import');
        Route::post('plasa/insert','PlasaController@insert');
        Route::get('plasa/edit/{id}','PlasaController@edit');
        Route::post('plasa/update/{id}','PlasaController@update');
        Route::get('plasa/delete/{id}','PlasaController@destroy');
        Route::get('plasa/name/{nama}','PlasaController@getPlasa');

});
