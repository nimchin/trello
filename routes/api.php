<?php

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

use App\Board;
use App\Http\Resources\BoardStatisticCollection;

Route::post('register', 'API\RegisterController@register');

Route::middleware('auth:api')->group( function () {
    Route::resource('boards', 'API\BoardController');
    Route::resource('tasks', 'API\TaskController');

    Route::get('statistics/boards', function(){
       return new BoardStatisticCollection(Board::paginate(config('pagination.per_page')));
    });
});
