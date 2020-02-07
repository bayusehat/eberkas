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
Route::group(['middleware' => ['ifLogged']], function () {
    Route::get('/','AuthController@login');
    Route::post('/login','AuthController@doLogin');
    Route::get('/logout','AuthController@doLogout');
});
Route::get('lama/berkas/lengkap/{witel}/{bulprod}','LaporanController@berkasLengkap');
// Route::get('/','AuthController@login');
// Route::post('/login','AuthController@doLogin');
// Route::get('/logout','AuthController@doLogout');
Route::post('berkas/all/search','EditController@doCariBerkas');
// Route::get('data/witel','LaporanController@plasaWitelFormLama');
// Route::get('data/detail/{jml}/{witel}','LaporanController@transaksi');

Route::group(['middleware' => ['authLogin','web']], function () {
    Route::get('/home','DashboardController@index');
    Route::post('signature/save','DashboardController@signature');
    Route::post('signature/atasan/save','DashboardController@signatureAtasan');
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
    Route::get('user/signature','UserController@signatureLogin');
    Route::post('user/signature/insert','UserController@insertSignaturelogin');
    //Master
        //Layanan
        Route::get('layanan','MasterController@indexLayanan');
        Route::get('layanan/load','MasterController@loadDataLayanan');
        Route::post('layanan/insert','MasterController@insertLayanan');
        Route::get('layanan/edit/{id}','MasterController@editLayanan');
        Route::post('layanan/update/{id}','MasterController@updateLayanan');
        Route::get('layanan/delete/{id}','MasterController@destroyLayanan');
        Route::get('layanan/change/{id}/{role}','MasterController@changeRole');

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

        //Produk
        Route::get('produk','MasterController@indexProduk');
        Route::get('produk/load','MasterController@loadDataProduk');
        Route::post('produk/insert','MasterController@insertProduk');
        Route::get('produk/edit/{id}','MasterController@editProduk');
        Route::post('produk/update/{id}','MasterController@updateProduk');
        Route::get('produk/delete/{id}','MasterController@destroyProduk');

         //Fitur
         Route::get('fitur','MasterController@indexFitur');
         Route::get('fitur/load','MasterController@loadDataFitur');
         Route::post('fitur/insert','MasterController@insertFitur');
         Route::get('fitur/edit/{id}','MasterController@editFitur');
         Route::post('fitur/update/{id}','MasterController@updateFitur');
         Route::get('fitur/delete/{id}','MasterController@destroyFitur');

    //New Indihome Form
    Route::get('indihome','IndihomeController@index');
    Route::post('indihome/insert','IndihomeController@insert');
    Route::post('indihome/update/{id}','IndihomeController@update');

    //BNA
    Route::get('bna/1','BnaController@index');
    Route::post('bna/insert','BnaController@insert');
    Route::post('bna/update/{id}','BnaController@update');

    //GNO
    Route::get('gno/2','GnoController@index');
    Route::post('gno/insert','GnoController@insert');
    Route::post('gno/update/{id}','GnoController@update');

     //Cabut
     Route::get('cabut/3','CabutController@index');
     Route::post('cabut/insert','CabutController@insert');
     Route::post('cabut/update/{id}','CabutController@update');

     //PDA
     Route::get('pda/4','PdaController@index');
     Route::post('pda/insert','PdaController@insert');
     Route::post('pda/update/{id}','PdaController@update');

     //ISOLIR 
     Route::get('isolir/5','IsolirController@index');
     Route::post('isolir/insert','IsolirController@insert');
     Route::post('isolir/update/{id}','IsolirController@update');

     //FITUR
     Route::get('fitur/6','FiturController@index');
     Route::post('fitur/6/insert','FiturController@insert');
     Route::post('fitur/6/update/{id}','FiturController@update');

     //PENGADUAN
     Route::get('pengaduan/8','PengaduanController@index');
     Route::post('pengaduan/insert','PengaduanController@insert');
     Route::post('pengaduan/update/{id}','PengaduanController@update');

     //ALIH PAKET
     Route::get('alih/9','AlihPaketController@index');
     Route::post('alih/insert','AlihPaketController@insert');
     Route::post('alih/update/{id}','AlihPaketController@update');

     //KALIM TAGIHAN
     Route::get('claim/10','ClaimController@index');
     Route::post('claim/insert','ClaimController@insert');
     Route::post('claim/update/{id}','ClaimController@update');

     //CICILAN
     Route::get('cicilan/11','CicilanController@index');
     Route::post('cicilan/insert','CicilanController@insert');
     Route::post('cicilan/update/{id}','CicilanController@update');


     //Seacrh Berkas
     Route::get('edit/berkas','EditController@index');
     Route::post('berkas/search','EditController@searchBerkas');
     Route::get('cari/berkas','EditController@cariBerkas');
     Route::get('delete/indihome/{id}','EditController@deleteIndihome');
     Route::get('delete/lama/{id}','EditController@deleteFormLama');

     //To Halaman masing2 edit & Detail
     Route::get('edit/{jenis_transaksi}/{id_transaksi}','EditController@edit');
     Route::get('detail/{jenis_transaksi}/{id_transaksi}','EditController@detailBerkas');

     //Lampiran
     Route::get('lampiran','ManajemenController@indexTambahLampiran');
     Route::post('lampiran/search','ManajemenController@doCariBerkas');
     Route::get('lampiran/create/{id_jenis}/{id_transaksi}','ManajemenController@tambahLampiranPage');
     Route::post('lampiran/insert/{id_jenis}/{id_transaksi}','ManajemenController@insertLampiran');
     Route::get('lampiran/view/{id_jenis}/{id_transaksi}','ManajemenController@lihatLampiran');
     Route::get('lampiran/download/{id}','ManajemenController@downloadLampiran');

     //Laporan
     Route::get('laporan/lama','LaporanController@laporanFormLama');
     Route::post('laporan/lama/search','LaporanController@getLaporanFormLama');
     Route::get('laporan/lama/plasa/{witel}/{bulprod}','LaporanController@plasaFormLama');
     Route::get('laporan/lama/plasa/search/{witel}/{bulprod}','LaporanController@plasaWitelFormLama');
     Route::get('laporan/indihome','LaporanController@laporanIndihome');
     Route::post('laporan/indihome/search','LaporanController@getLaporanIndihome');
     Route::get('laporan/indihome/plasa/{witel}/{bulprod}','LaporanController@plasaFormIndihome');
     Route::get('laporan/indihome/plasa/search/{witel}/{bulprod}','LaporanController@plasaWitelIndihome');
     Route::get('laporan/indihome/admin','LaporanController@indexIndihomeAdmin');
     Route::post('laporan/indihome/admin/search','LaporanController@indihomeAdmin');
     Route::get('laporan/lama/admin','LaporanController@indexFormLamaAdmin');
     Route::post('laporan/lama/admin/search','LaporanController@formLamaAdmin');
     Route::get('plasa/get/{witel?}','LaporanController@getPlasa');

     //Log
     Route::get('log','LogController@index');
     Route::get('log/load','LogController@loadData');
});
