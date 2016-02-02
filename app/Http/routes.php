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

Route::group(['middleware' => ['web']], function () {


//Tasks routes
    Route::post('add-task', 'TasksController@add');
    Route::post('update-task', 'TasksController@updateTaskName');
    Route::post('complete-task', 'TasksController@completeTask');
    Route::post('favorite-task', 'TasksController@favoriteTask');
    Route::post('delete-all', 'TasksController@deleteAll');
    Route::post('delete-selected', 'TasksController@deleteSelected');
    Route::post('delete', 'TasksController@deleteTask');


    Route::get('/', 'TasksController@showTasks');


// Authentication routes...
    Route::get('auth/login', 'Auth\AuthController@getLogin');
    Route::post('auth/login', 'Auth\AuthController@postLogin');
    Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
    Route::get('auth/register', 'Auth\AuthController@getRegister');
    Route::post('auth/register', 'Auth\AuthController@postRegister');



});