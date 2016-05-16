<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::controller('auth', 'Auth\AuthController');
});

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/', 'GameController@index');

    Route::get('/test', function(){
        $q = Session::get('q',0);
        $q++;
        Session::put('q',$q);
        echo $q;
    });

    Route::get('/update/{id}', 'GameController@edit');
    Route::post('/update/{id}', 'GameController@store');

    Route::get('/update/{id}/lineup/{team}', 'LineupController@edit')->where('team','(home)|(visitor)');
    Route::post('/update/{id}/lineup/{team}', 'LineupController@store')->where('team','(home)|(visitor)');

    Route::get('/update/{id}/statistics/stats/{team}/{period}/{type}', 'StatisticController@stats')
        ->where(['team'=>'(home)|(visitor)', 'period'=>'(season)|(game)', 'type'=>'(batting)|(fielding)|(pitching)']);
    Route::get('/update/{id}/statistics/roster/{team}', 'StatisticController@roster')
        ->where(['team'=>'(home)|(visitor)', 'period'=>'(season)|(game)']);
    Route::get('/update/{id}/statistics/player/{player}/{period}', 'StatisticController@player')
        ->where(['period'=>'(season)|(game)']);

    Route::get('/update/{id}/scorepad/{team}', 'ScorePadController@index')->where('team','(home)|(visitor)');
    Route::get('/update/{id}/atbat', 'AtBatController@index');
});

Route::group(['middleware' => ['web', 'auth', 'ajax']], function () {
    Route::get('/ajax/atbat/gamestatus', 'AtBatApiController@getGameStatus');
    Route::post('/ajax/atbat/gamestatus', 'AtBatApiController@postGameStatus');
    Route::get('/ajax/atbat/storage', 'AtBatApiController@getStorage');
    Route::post('/ajax/atbat/storage', 'AtBatApiController@postStorage');
    Route::post('/ajax/atbat/lastinning', 'AtBatApiController@postLastInning');
});








