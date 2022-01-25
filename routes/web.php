<?php

use App\Http\Controllers\InquiriesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use \App\Http\Controllers\Scholars\HomeController;
use \App\Http\Controllers\CuztomizationSettingsController;
use \App\Http\Controllers\NotificationSettingControler;
use \App\Http\Controllers\ReminderController;
use \App\Http\Controllers\NotificationController;


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


Route::get('/docs', function () {
    return view('documentation');
});

Route::get('/help', function () {
    return view('help');
});

Route::post('send_inquiries',[InquiriesController::class,'send']);

Route::middleware(['PreventBackHistory'])->group(function(){

    Route::middleware(['auth:scholars'])->group(function(){
        Route::get('scholars', [HomeController::class,'index'])->name('scholar.name');
        Route::get('getScholarImport', [HomeController::class, 'getImport'])->name('scholar.getImport');
        Route::get('getScholarReport', [HomeController::class, 'getScholarReport'])->name('scholar.getScholarReport');
        Route::post('updateRoninWallet', [HomeController::class, 'updateRoninWallet'])->name('scholar.updateRoninWallet');
        Route::get('getScholarGraph', [HomeController::class, 'getScholarGraph'])->name('scholar.getScholarGraph');
        Route::get('getScholarPayrollHistory', 'GlobalController@getScholarPayrollHistory');
        Route::get('getScholarNotification', [HomeController::class, 'getScholarNotification']);
        Route::post('changeStatusNotificationScholar', [HomeController::class, 'changeStatusNotification']);
        Route::post('changeStatusReminders', [HomeController::class, 'changeStatusReminders']);
    });

    Route::middleware(['auth:admins'])->group(function(){

        Route::post('saveCuztomizationSettings', [CuztomizationSettingsController::class,'save'])->name('cuztomization.save');
        Route::get('getCuztomizationSettings', [CuztomizationSettingsController::class,'get'])->name('cuztomization.get');
        Route::post('saveNotificationSettings', [NotificationSettingControler::class,'save'])->name('notification_settings.save');
        Route::get('getNotificationSettings', [NotificationSettingControler::class,'get'])->name('notification_settings.get');
        Route::get('allNotificationSettings', [NotificationSettingControler::class,'getAllNotificationSettings'])->name('notification.all');
        Route::post('uploadQRCode', 'PlayerController@uploadQR');

        Route::get('/getGraph', 'FileController@getGraph');
        Route::get('/getReport', 'FileController@getReport');
        Route::get('/getTotalSLPs', 'FileController@getTotalSLPs');
        Route::post('/importFile', 'FileController@import');
        Route::get('/getTotalReport', 'FileController@getTotalReport');
        Route::get('/getImportedReport', 'FileController@getImportedReport');
        Route::get('/getTotalReportbyDate', 'FileController@getTotalReportbyDate');

        Route::get('/getNotification', 'FileController@getNotification');
        Route::post('/changeStatusNotification', 'FileController@changeStatusNotification');
        Route::post('/updateAccountInfo', 'GlobalController@updateAccountInfo');

        Route::get('/getPlayers', 'PlayerController@getPlayers');
        Route::get('/getAllPlayers', 'PlayerController@getAllPlayers');
        Route::get('/getListPlayers', 'PlayerController@getListOfPlayers');
        Route::post('/deleteScholar', [HomeController::class,'delete'])->name('scholar.delete');
        Route::post('/importPlayer', 'PlayerController@import');

        Route::post('/savePlayer', 'PlayerController@savePlayer');
        Route::post('/deletePlayer', 'PlayerController@deletePlayer');

        Route::post('/importPlayerScholarHistory', [HomeController::class, 'import_history'])->name('scholar.import_history');
        Route::post('/importScholar', [HomeController::class,'import'])->name('scholar.import');
        Route::get('/getScholars', [HomeController::class,'getScholars'])->name('scholar.getScholars');
        Route::post('/saveScholar', [HomeController::class,'save'])->name('scholar.save');

        Route::get('/getStatuses', 'GlobalController@getStatuses');

        Route::get('/getType', 'GlobalController@getType');
        Route::post('/deleteType', 'GlobalController@deleteType');
        Route::post('/restoreType', 'GlobalController@restoreType');
        Route::post('/updateType', 'GlobalController@updateType');
        Route::post('/saveNewType', 'GlobalController@saveNewType');

        Route::get('/getUsers', 'GlobalController@getUsers');
        Route::post('/updateUser', 'GlobalController@updateUser');
        Route::post('/deleteUser', 'GlobalController@deleteUser');
        Route::post('/restoreUser', 'GlobalController@restoreUser');
        Route::post('/changePassword', 'GlobalController@changePassword');

        Route::get('penalty-count/{type?}', 'PlayerController@getPenaltyCount');
        Route::get('getLowestMMR', 'PlayerController@getLowestMMR');

        Route::resource('reminders', 'ReminderController');
        Route::post('newReminder',[ReminderController::class,'store']);
        Route::post('updateReminder/{reminder}',[ReminderController::class,'update']);
        Route::get('reminders/{reminder}/destroy',[ReminderController::class,'destroy']);
        Route::get('getReminder',[ReminderController::class,'index']);

        Route::get('getPayrollHistory/{status}', 'GlobalController@getPayrollHistory');
        Route::post('updatePayrollHistory', 'GlobalController@updatePayrollHistory');
        Route::post('updatePendingPayrollHistory', 'GlobalController@updatePendingPayrollHistory');

        Route::post('importPayroll', 'FileController@importPayroll');
        Route::post('importZipQR', 'FileController@importZipQR');
    });


    //put here route that was accessed by both admin and scholars

    Route::middleware(['auth:admins,scholars'])->group(function(){
        Route::get('/notifications/{account_type}', [NotificationController::class,'index'])->name('index');

        Route::get('/getAccountInfo/{type}', 'GlobalController@getAccountInfo');

        Route::get('/','GlobalController@redirectMain');

        Route::get('/getScholarHistories','GlobalController@getScholarPlayingHistories');

        Route::get('/getListOfAccounts','GlobalController@getListAccounts');

        Route::get('/listOfCategory','GlobalController@getListofCategoryforPenalty');

        Route::match(['GET', 'POST'], '/logout', 'Auth\LoginController@logout');

        Route::middleware(['vue.components'])->group(function(){
            Route::get('/{route}', 'GlobalController@index'); //
        });
    });

});