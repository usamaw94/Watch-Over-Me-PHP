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


Route::get('/adminLogin', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/adminLoginSubmit', 'Auth\AdminLoginController@login')->name('admin.login.submit');
Route::get('/adminLogout', 'Auth\AdminLoginController@logout')->name('admin.logout');



Route::get('/admin', 'AdminController@index')->name('admin');

Route::get('/adminServices', 'AdminController@services')->name('admin.services');

Route::get('/adminCreateService', 'AdminController@createService')->name('admin.create.service');
Route::get('/adminCheckWearerPhone/{phone}', 'AdminController@checkWearerPhone')->name('admin.check.wearer.phone');
Route::get('/adminCheckWatcherPhone/{phone}', 'AdminController@checkWatcherPhone')->name('admin.check.watcher.phone');
Route::get('/adminCheckCustomerPhone/{phone}', 'AdminController@checkCustomerPhone')->name('admin.check.customer.phone');
Route::get('/adminCheckEmail', 'AdminController@checkEmail')->name('admin.check.email');
Route::post('/adminProcessNewService', 'AdminController@processNewService')->name('admin.process.new.service');

Route::get('/adminSearchServices', 'AdminController@searchServices')->name('admin.search.services');

Route::get('/adminGetPerson', 'AdminController@getPerson')->name('admin.get.person');
Route::get('/adminGetWatchersList', 'AdminController@getWatchersList')->name('admin.get.watchers.list');
Route::get('/adminServiceDetails', 'AdminController@serviceDetails')->name('admin.service.details');
Route::get('/adminServiceLogs', 'AdminController@serviceLogs')->name('admin.service.logs');
Route::get('/adminActivateService', 'AdminController@activateService')->name('admin.activate.service');
Route::get('/adminDeactivateService', 'AdminController@deactivateService')->name('admin.deactivate.service');

Route::post('/adminVerifyServiceWatcherPhone', 'AdminController@verifyServiceWatcherPhone')->name('admin.verify.service.watcher.phone');

Route::post('/adminAddNewWatcher', 'AdminController@addNewWatcher')->name('admin.add.new.watcher');
Route::post('/adminUpdatePriorityOrder', 'AdminController@updatePriorityOrder')->name('admin.update.priority.order');

Route::get('/adminUsers', 'AdminController@users')->name('admin.users');

Route::get('/adminUserDetails', 'AdminController@userDetails')->name('admin.user.details');

Route::get('/adminSearchUsers', 'AdminController@searchUsers')->name('admin.search.users');

Route::get('/adminApplyLogFilters', 'AdminController@applyLogFilters')->name('admin.apply.log.filters');

Route::get('/adminTrackWearer', 'AdminController@trackWearer')->name('admin.track.wearer');

Route::get('/adminAlertLogDetails', 'AdminController@alertLogDetails')->name('admin.alert.log.details');

Route::get('/adminLogHistory/{serviceId}/{date}/{type}', 'AdminController@logHistory')->name('admin.log.history');

Route::get('/adminGetLastLocation/', 'AdminController@getLastLocation')->name('admin.get.last.location');


//---------------------------------------------------//

Route::get('/userLogout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/getPersonDetails', 'HomeController@personDetails')->name('user.get.person.details');

Route::get('/getWatchersList', 'HomeController@getWatchersList')->name('user.get.watchers.list');

Route::get('/userAsWearer', 'HomeController@userAsWearer')->name('user.as.wearer');

Route::get('/userAsWatcher', 'HomeController@userAsWatcher')->name('user.as.watcher');

Route::get('/userAsCustomer', 'HomeController@userAsCustomer')->name('user.as.customer');

Route::post('/verifyServiceWatcherPhone', 'HomeController@verifyServiceWatcherPhone')->name('user.as.customer');

Route::get('/checkEmail', 'HomeController@checkEmail')->name('user.check.email');

Route::post('/addNewWatcher', 'HomeController@addNewWatcher')->name('user.add.watcher');

Route::post('/updatePriorityOrder', 'HomeController@updatePriorityOrder')->name('user.update.priority.order');

Route::get('/userAsWatcherService', 'HomeController@userAsWatcherService')->name('user.as.watcher.service');

Route::get('/userAsCustomerService', 'HomeController@userAsCustomerService')->name('user.as.customer.service');

Route::get('/wrServiceLogs', 'HomeController@wearerServiceLogs')->name('user.wearer.service.logs');

Route::get('/wrServiceLogHistory/{serviceId}/{date}/{type}', 'HomeController@wearerServiceLogHistory')->name('user.wearer.service.log.history');

Route::get('/wtServiceLogHistory/{serviceId}/{date}/{type}', 'HomeController@watcherServiceLogHistory')->name('user.watcher.service.log.history');

Route::get('/crServiceLogHistory/{serviceId}/{date}/{type}', 'HomeController@customerServiceLogHistory')->name('user.customer.service.log.history');

Route::get('/alertLogDetails', 'HomeController@alertLogDetails')->name('user.alert.log.details');

Route::get('/trackWearer', 'HomeController@trackWearer')->name('user.track.wearer');

Route::get('/wtServiceLogs', 'HomeController@watcherServiceLogs')->name('user.watcher.service.logs');

Route::get('/crServiceLogs', 'HomeController@customerServiceLogs')->name('user.customer.service.logs');

Route::get('/getLastLocation', 'HomeController@getLastLocation')->name('user.get.last.location');


//---------------------------------------------------//

Route::get('/hmr/{logId}/{userId}', 'WebController@helpMeRequest')->name('help.me.request');
Route::get('/helpMeRespond', 'WebController@helpMeRespond')->name('help.me.respond');
Route::get('/userVerification/{code}', 'WebController@userVerification')->name('user.verification');

Route::get('/resendEmailVerification/', 'WebController@resendEmailVerification')->name('resend.email.verification');
