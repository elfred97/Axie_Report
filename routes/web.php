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

Route::middleware(['guest'])->group(function(){
    Route::get('login', 'GlobalController@showLogin')->name('login');
    Route::post('login', 'GlobalController@login');

    Route::get('registration', function () { return view('registration'); });
    Route::post('registration', 'GlobalController@registration');
});

Route::middleware(['auth'])->group(function(){
    Route::redirect('/', '/home')->name('home');

    
    Route::get('/getGraph', 'FileController@getGraph');
    Route::get('/getReport', 'FileController@getReport');
    Route::post('/importFile', 'FileController@import');
    Route::get('/getTotalReport', 'FileController@getTotalReport');
    Route::get('/getImportedReport', 'FileController@getImportedReport');
    Route::get('/getTotalReportbyDate', 'FileController@getTotalReportbyDate');
    
    Route::get('/getAccountInfo', 'GlobalController@getAccountInfo');
    Route::post('/updateAccountInfo', 'GlobalController@updateAccountInfo');
    Route::get('/getNotification', 'FileController@getNotification');

    Route::get('/getPlayers', 'PlayerController@getPlayers');
    Route::post('/saveScholar', 'PlayerController@saveScholar');
    Route::post('/deleteScholar', 'PlayerController@deleteScholar');

    Route::post('/importScholar', 'PlayerController@importScholar');

    Route::post('/saveNewType', 'GlobalController@saveNewType');
    Route::get('/getType', 'GlobalController@getType');

    Route::get('/getUsers', 'GlobalController@getUsers');


    Route::match(['GET', 'POST'], '/logout', 'GlobalController@logout'); //

    /********************** VUE COMPONENTS *************************/
    Route::middleware(['vue.components'])->group(function(){
        Route::get('/{route}', 'GlobalController@index'); //
    });
});
