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

// Route::get('/', function () {
//     return view('main');
// });

Auth::routes();

//Route::middleware(['guest'])->group(function(){
//    Route::get('login', 'GlobalController@showLogin')->name('login');
//    Route::post('login', 'GlobalController@login');
//
//    Route::get('registration', function () { return view('registration'); });
//    Route::post('registration', 'GlobalController@registration');
//});

Route::middleware(['auth'])->group(function(){
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
