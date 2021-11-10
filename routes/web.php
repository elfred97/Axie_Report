<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Scholars\HomeController;

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
    Route::middleware(['vue.components'])->group(function(){
        Route::get('/{route}', 'GlobalController@index'); //
    });
});


Route::middleware(['auth:admins'])->group(function(){
    Route::redirect('/', '/home')->name('home');


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
    Route::post('/saveScholar', 'PlayerController@saveScholar');
    Route::post('/deleteScholar', 'PlayerController@deleteScholar');
    Route::post('/importScholar', 'PlayerController@importScholar');

    Route::get('/getType', 'GlobalController@getType');
    Route::post('/deleteType', 'GlobalController@deleteType');
    Route::post('/updateType', 'GlobalController@updateType');
    Route::post('/saveNewType', 'GlobalController@saveNewType');

    Route::get('/getUsers', 'GlobalController@getUsers');
    Route::post('/updateUser', 'GlobalController@updateUser');
    Route::post('/deleteUser', 'GlobalController@deleteUser');

    Route::match(['GET', 'POST'], '/logout', 'Auth\LoginController@logout'); //

    /********************** VUE COMPONENTS *************************/
    Route::middleware(['vue.components'])->group(function(){
        Route::get('/{route}', 'GlobalController@index'); //
    });
});

