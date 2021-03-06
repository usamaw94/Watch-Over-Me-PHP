<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/testConnection','ApiController@testConnection')->name('test.connection');
Route::post('/wearerLoginProcessing','ApiController@wearerLoginProcessing')->name('wearer.login.processing');
Route::post('/setLoginStatus','ApiController@setLoginStatus')->name('set.login.status');
Route::post('/checkLoginStatus','ApiController@checkLoginStatus')->name('check.login.status');
Route::post('/getWatchers','ApiController@getWatchers')->name('get.watchers');
Route::post('/wearerNotification','ApiController@wearerNotification')->name('wearer.notification');
Route::post('/helpMeRequestInitiate','ApiController@helpMeRequestInitiate')->name('help.me.request.initiate');
Route::post('/updateDeviceToken','ApiController@updateDeviceToken')->name('update.device.token');
Route::get('/testConnection','ApiController@testConnection')->name('api.test.connection');
Route::post('/wearerLoginProcessing','ApiController@wearerLoginProcessing')->name('wearer.login.processing');
Route::post('/deactivateHelpMeRequest','ApiController@deactivateHelpMeRequest')->name('deactivate.help.me.request');
Route::post('/regularLog','ApiController@regularLog')->name('regular.log');
Route::post('/sendLocation', 'ApiController@sendLocation')->name('send.location');
Route::post('/contactWatcher', 'ApiController@contactWatcher')->name('contact.watcher');

