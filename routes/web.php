<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Scholars\HomeController;
use \App\Http\Controllers\NotificationSettingControler;

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
Route::middleware(['auth:scholars'])->prefix('scholars')->group(function(){
    Route::get('/', [HomeController::class,'index'])->name('scholar.name');
    Route::match(['GET', 'POST'], '/logout', 'Auth\LoginController@logout'); //
//    Route::middleware(['vue.components'])->group(function(){
//        Route::get('/{route}', 'GlobalController@index'); //
//    });
});




Route::middleware(['auth:admins'])->group(function(){
    Route::redirect('/', '/home')->name('home');
    Route::post('saveNotificationSettings', [NotificationSettingControler::class,'save'])->name('notifications.save');
    Route::get('getNotificationSettings', [NotificationSettingControler::class,'get'])->name('notification.get');

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
    Route::post('/deleteScholar', 'PlayerController@deleteScholar');
    Route::post('/importPlayer', 'PlayerController@import');

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

    Route::match(['GET', 'POST'], '/logout', 'Auth\LoginController@logout'); //

    /********************** VUE COMPONENTS *************************/
    Route::middleware(['vue.components'])->group(function(){
        Route::get('/{route}', 'GlobalController@index'); //
    });
});

