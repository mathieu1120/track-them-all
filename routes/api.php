<?php

use Illuminate\Http\Request;

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
Route::post('register', 'Auth\RegisterController@register');

// list of groups for a user first, if no user, get public group sorted by favorites
Route::get('/groups', [
    'uses' => 'GroupController@getGroups'
])->middleware('auth:api');

//create a group
Route::post('/groups', [
    'uses' => 'GroupController@postGroups'
])->middleware('auth:api');

Route::post('/groups/{group_id}/join', [
    'uses' => 'GroupController@joinGroup'
])->middleware('auth:api');

//get a group
Route::get('/groups/{group_id}', [
    'uses' => 'GroupController@getGroup'
])->middleware('auth:api');





//edit a group
Route::post('/groups/{group_id}', [
    'uses' => 'GroupController@postGroup'
])->middleware('auth:api');

//delete a group
Route::delete('/groups/{group_id}', [
    'uses' => 'GroupController@unsubscribeGroup'
])->middleware('auth.basic.once');


/*\Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
    var_dump($query->sql);
    var_dump($query->bindings);
});*/