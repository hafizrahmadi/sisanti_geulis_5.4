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
Route::get('/list_instruksi_camat', 'ApiController@instruksiCamat');


Route::get('getlistuser','UserController@getListUser');
Route::get('getlistsuratmasuk','SuratMasukController@getListSuratMasuk');
Route::post('/addsuratmasuk', 'SuratMasukController@addSuratMasuk');
Route::post('/deletesuratmasuk', 'SuratMasukController@deleteSuratMasuk');
Route::get('getlistcamat','SuratMasukController@getListCamat');
