<?php

/* Dashboard routes */
include 'dashboard.php';

Route::get('/', function () {
    return redirect('dashboard');
});
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

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout')->name('logout');


Route::get('{client}/{parameter}', 'MainController@getCasePage')->name('case.index');
Route::get('case/files/{parameter}', 'MainController@getFilesForCase')->name('case.files');
