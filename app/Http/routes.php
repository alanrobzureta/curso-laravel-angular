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

Route::group(['middleware'=>'oauth'],function(){
    
    /*
    * ClientController
    */
    Route::resource('client','ClientController',['except'=>['create','edit']]);  
    
    /*Route::group(['middleware'=>'CheckProjectOwner'],function(){
        Route::resource('project','ProjectController',['except'=>['create','edit']]);
    });*/
    Route::resource('project','ProjectController',['except'=>['create','edit']]);
    
    Route::group(['prefix'=>'project'],function(){
        
        /*
        * ProjectNoteController
        */
        Route::get('{id}/note','ProjectNoteController@index'); //ProjectNoteController
        Route::post('{id}/note','ProjectNoteController@store'); //ProjectNoteController
        Route::get('{id}/note/{noteId}','ProjectNoteController@show'); //ProjectNoteController
        Route::put('{id}/note/{noteId}','ProjectNoteController@update'); //ProjectNoteController
        Route::delete('{id}/note/{noteId}','ProjectNoteController@destroy'); //ProjectNoteController
        /*
         * ProjectTaskController
         */
        Route::get('{id}/task','ProjectTaskController@index'); //ProjectTaskController
        Route::post('{id}/task','ProjectTaskController@store'); //ProjectTaskController
        Route::get('{id}/task/{taskId}','ProjectTaskController@show'); //ProjectTaskController
        Route::put('{id}/task/{taskId}','ProjectTaskController@update'); //ProjectTaskController
        Route::delete('{id}/task/{taskId}','ProjectTaskController@destroy'); //ProjectTaskController

        /*
         * ProjectMembersController
         */
        Route::get('{id}/members','ProjectMembersController@show'); //ProjectMembersController
        Route::post('{id}/members/{memberId}','ProjectMembersController@create'); //ProjectMembersController
        Route::delete('{id}/members/{memberId}','ProjectMembersController@destroy'); //ProjectMembersController
        Route::get('{id}/members/{memberId}','ProjectMembersController@is'); //ProjectMembersController
        
        Route::post('{id}/file','ProjectFileController@store');
    });
   
});


