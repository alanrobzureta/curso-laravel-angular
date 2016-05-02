<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::post('oauth/access_token',function(){
    return Response::json(Authorizer::issueAccessToken());
});
/*
 * ClientController
 */
Route::get('client',['middleware'=>'oauth','users'=>'ClientController@index']);
Route::post('client','ClientController@store');
Route::put('client/{id}','ClientController@update');
Route::get('client/{id}','ClientController@show');
Route::delete('client/{id}','ClientController@destroy');


/*
 * ProjectNoteController
 */
Route::get('project/{id}/note','ProjectNoteController@index'); //ProjectNoteController
Route::post('project/{id}/note','ProjectNoteController@store'); //ProjectNoteController
Route::get('project/{id}/note/{noteId}','ProjectNoteController@show'); //ProjectNoteController
Route::put('project/{id}/note/{noteId}','ProjectNoteController@update'); //ProjectNoteController
Route::delete('project/{id}/note/{noteId}','ProjectNoteController@destroy'); //ProjectNoteController
/*
 * ProjectTaskController
 */
Route::get('project/{id}/task','ProjectTaskController@index'); //ProjectTaskController
Route::post('project/{id}/task','ProjectTaskController@store'); //ProjectTaskController
Route::get('project/{id}/task/{taskId}','ProjectTaskController@show'); //ProjectTaskController
Route::put('project/{id}/task/{taskId}','ProjectTaskController@update'); //ProjectTaskController
Route::delete('project/{id}/task/{taskId}','ProjectTaskController@destroy'); //ProjectTaskController

/*
 * ProjectMembersController
 */
Route::get('project/{id}/members','ProjectMembersController@show'); //ProjectMembersController
Route::post('project/{id}/members/{memberId}','ProjectMembersController@create'); //ProjectMembersController
Route::delete('project/{id}/members/{memberId}','ProjectMembersController@destroy'); //ProjectMembersController
Route::get('project/{id}/members/{memberId}','ProjectMembersController@is'); //ProjectMembersController



/*
 * ProjectController
 */
Route::get('project','ProjectController@index');
Route::post('project','ProjectController@store');
Route::put('project/{id}','ProjectController@update');
Route::get('project/{id}','ProjectController@show');
Route::delete('project/{id}','ProjectController@destroy');


