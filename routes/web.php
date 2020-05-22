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


Route::get('/', 'UserController@index');

Route::get('/logout', 'UserController@logout');
Route::get('/login',function(){
	return redirect('/');
});
Route::post('/loginpost','UserController@loginPost');


Route::group(['middleware' => ['forLogin']], function () {  
	Route::get('/home', function () {
	    // return view('welcome');
		return view('home/home');
	});

	Route::get('/absen', function () {
	    // return view('welcome');
		return view('home/absen');
	});

	Route::get('/laporan_absen', function () {
	    // return view('welcome');
		return view('home/laporan_absen');
	});



	Route::get('/masteruser','UserController@masteruser');
	Route::get('/catatsuratmasuk','SuratMasukController@catatsuratmasuk');
	Route::get('/list_disposisi',function(){
		return view('home/list_disposisi');
	});

	Route::get('getlistuser','UserController@getListUser');
	Route::post('/adduserpost', 'UserController@addUserPost');
	Route::post('/deleteuser', 'UserController@deleteUser');
	Route::get('getlistjabatan','UserController@getListJabatan');

	Route::get('/catatsuratkeluar','SuratKeluarController@catatsuratkeluar');
	Route::get('/catatnotadinas','NotaDinasController@catatnotadinas');

});
