<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/signin', 'ApiController@signin');
Route::get('/profile/{id}', 'ApiController@profile');
Route::post('/send_notif', 'ApiController@sendNotif');
Route::get('/notifications/{user_id}', 'ApiController@getMail');
Route::get('/notifications/unread/{user_id}', 'ApiController@getMailUnread');
Route::post('/status_read/{id}', 'ApiController@updateStatusRead');
Route::get('/detail_surat_masuk/{id}', 'ApiController@detailSuratMasuk');
Route::get('/detail_surat_keluar/{id}', 'ApiController@detailSuratKeluar');
Route::get('/list_instruksi_camat', 'ApiController@instruksiCamat');
Route::post('/post/instruksi', 'ApiController@postInstruksi');
Route::get('/list_under/{leader_id}', 'ApiController@organisasi');
Route::get('/list_disposisi', 'ApiController@listdisposisi');
Route::get('/checkrole/{id}', 'ApiController@checkRole');
Route::post('/post_absen', 'ApiController@postAbsen');
Route::get('/status_absen/{user_id}', 'ApiController@statusabsen');
Route::get('/riwayat_absen/{user_id}', 'ApiController@riwayatabsen');

Route::get('getlistnotifdisposisi','ApiController@getListNotifDisposisi');
Route::get('getlistdisposisi/{id}','ApiController@getListDisposisi');
Route::post('/readdisposisi', 'ApiController@readDisposisi');

Route::get('getlistuser','UserController@getListUser');
Route::get('getlistsuratmasuk','SuratMasukController@getListSuratMasuk');
Route::get('getsuratmasuk/{id}','SuratMasukController@getSuratMasuk');
Route::post('/addsuratmasuk', 'SuratMasukController@addSuratMasuk');
Route::post('/deletesuratmasuk', 'SuratMasukController@deleteSuratMasuk');
Route::get('getlistcamat','SuratMasukController@getListCamat');

Route::get('/getdistinctdatesuratmasuk','SuratMasukController@getDistinctDateSuratMasuk'); //arsip
Route::get('/getlistsuratmasukbydate/{date}','SuratMasukController@getListSuratMasukByDate'); //arsip

// surat keluar
Route::get('getlistsuratkeluar','SuratKeluarController@getListSuratKeluar');
Route::get('getsuratkeluar/{id}','SuratKeluarController@getSuratKeluar');
Route::post('/addsuratkeluar', 'SuratKeluarController@addSuratKeluar');
Route::post('/deletesuratkeluar', 'SuratKeluarController@deleteSuratKeluar');
Route::get('getlistkasikasubag','SuratKeluarController@getListKasiKasubag');
Route::get('getlistsekcam','SuratKeluarController@getListSekcam');
Route::get('getlistcamat','SuratKeluarController@getListCamat');
Route::get('/getdistinctdatesuratkeluar','SuratKeluarController@getDistinctDateSuratKeluar'); //arsip
Route::get('/getlistsuratkeluarbydate/{date}','SuratKeluarController@getListSuratKeluarByDate'); //arsip

// nota dinas
Route::get('getlistnotadinas','NotaDinasController@getListNotaDinas');
Route::get('getnotadinas/{id}','NotaDinasController@getNotaDinas');
Route::post('/addnotadinas', 'NotaDinasController@addNotaDinas');
Route::post('/deletenotadinas', 'NotaDinasController@deleteNotaDinas');
Route::get('/getdistinctdatenotadinas','NotaDinasController@getDistinctDateNotaDinas'); //arsip
Route::get('/getlistnotadinasbydate/{date}','NotaDinasController@getListNotaDinasByDate'); //arsip

Route::get('getlistabsen','UserController@getListAbsen');