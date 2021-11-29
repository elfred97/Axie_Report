<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Scholars\HomeController;
use \App\Http\Controllers\NotificationSettingControler;
use \App\Http\Controllers\ReminderController;

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



//put dedicated scholars route here

//Route::middleware('auth')->group(function () {
//    Route::match(['GET', 'POST'], '/logout', 'Auth\LoginController@logout');
//});
//

//Route::get('',function () {
//    if(Auth::id()) {
//        if(Auth::guard('admins')->check()) {
//            return redirect(url('home'));
//        } else {
//            return redirect(url('scholars'));
//        }
//
//    } else {
//        return redirect(url('login'));
//    }
//});
//
Route::middleware(['auth:scholars'])->group(function(){
    Route::get('scholars', [HomeController::class,'index'])->name('scholar.name');
    Route::get('getScholarImport', [HomeController::class, 'getImport'])->name('scholar.getImport');
    Route::get('getScholarReport', [HomeController::class, 'getScholarReport'])->name('scholar.getScholarReport');
    Route::get('getScholarInformation', [HomeController::class, 'getScholarInformation'])->name('scholar.getScholarInformation');
    Route::post('updateRoninWallet', [HomeController::class, 'updateRoninWallet'])->name('scholar.updateRoninWallet');
    Route::get('getScholarGraph', [HomeController::class, 'getScholarGraph'])->name('scholar.getScholarGraph');
});

Route::middleware(['auth:admins'])->group(function(){

    Route::post('saveNotificationSettings', [NotificationSettingControler::class,'save'])->name('notifications.save');
    Route::get('getNotificationSettings', [NotificationSettingControler::class,'get'])->name('notification.get');
    Route::post('uploadQRCode', 'PlayerController@uploadQR');

    Route::get('/getGraph', 'FileController@getGraph');
    Route::get('/getReport', 'FileController@getReport');
    Route::post('/importFile', 'FileController@import');
    Route::get('/getTotalReport', 'FileController@getTotalReport');
    Route::get('/getImportedReport', 'FileController@getImportedReport');
    Route::get('/getTotalReportbyDate', 'FileController@getTotalReportbyDate');

    Route::get('/getAccountInfo', 'GlobalController@getAccountInfo');
    Route::get('/getNotification', 'FileController@getNotification');
    Route::post('/updateAccountInfo', 'GlobalController@updateAccountInfo');

    Route::get('/getPlayers', 'PlayerController@getPlayers');
    Route::get('/getAllPlayers', 'PlayerController@getAllPlayers');
    Route::post('/deleteScholar', [HomeController::class,'delete'])->name('scholar.delete');
    Route::post('/importPlayer', 'PlayerController@import');

    Route::post('/savePlayer', 'PlayerController@savePlayer');
    Route::post('/deletePlayer', 'PlayerController@deletePlayer');

    Route::post('/importScholar', [HomeController::class,'import'])->name('scholar.import');
    Route::get('/getScholars', [HomeController::class,'getScholars'])->name('scholar.getScholars');
    Route::post('/saveScholar', [HomeController::class,'save'])->name('scholar.save');

    Route::get('/getType', 'GlobalController@getType');
    Route::post('/deleteType', 'GlobalController@deleteType');
    Route::post('/updateType', 'GlobalController@updateType');
    Route::post('/saveNewType', 'GlobalController@saveNewType');

    Route::get('/getUsers', 'GlobalController@getUsers');
    Route::post('/updateUser', 'GlobalController@updateUser');
    Route::post('/deleteUser', 'GlobalController@deleteUser');
    Route::post('/changePassword', 'GlobalController@changePassword');

    Route::get('penalty-count/{type?}', 'PlayerController@getPenaltyCount');
    Route::get('getLowestMMR', 'PlayerController@getLowestMMR');

    Route::resource('reminders', 'ReminderController');
    Route::post('reminders/{reminder}',[ReminderController::class,'update']);
    Route::get('reminders/{reminder}/destroy',[ReminderController::class,'destroy']);
});


//put here route that was accessed by both admin and scholars

Route::middleware(['auth:admins,scholars'])->group(function(){
    Route::get('src/{file_name}', 'FileController@showFile');

    Route::get('/','GlobalController@redirectMain');
    Route::match(['GET', 'POST'], '/logout', 'Auth\LoginController@logout');

    Route::middleware(['vue.components'])->group(function(){
        Route::get('/{route}', 'GlobalController@index'); //
    });
});
