<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/userLogout', 'Auth\LoginController@userLogout')->name('user.logout');


Route::get('/adminLogin', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/adminLoginSubmit', 'Auth\AdminLoginController@login')->name('admin.login.submit');
Route::get('/adminLogout', 'Auth\AdminLoginController@logout')->name('admin.logout');



Route::get('/admin', 'AdminController@index')->name('admin');
Route::get('/adminServices', 'AdminController@services')->name('admin.services');
Route::get('/adminCreateService', 'AdminController@createService')->name('admin.create.service');
Route::get('/adminCheckWearerPhone/{phone}', 'AdminController@checkWearerPhone')->name('admin.check.wearer.phone');
Route::get('/adminCheckWatcherPhone/{phone}', 'AdminController@checkWatcherPhone')->name('admin.check.watcher.phone');

