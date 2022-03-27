<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('task/complate' , '\App\Http\Controllers\TaskController@complate');
Route::get('task/incomplate' , '\App\Http\Controllers\TaskController@incomplate');
Route::post('task' , '\App\Http\Controllers\TaskController@create');

Route::get('task/delete/all' , '\App\Http\Controllers\TaskController@destroy');
Route::post('task/delete' , '\App\Http\Controllers\TaskController@deletetask');
Route::post('task/update' , '\App\Http\Controllers\TaskController@update');
Route::post('task/update' , '\App\Http\Controllers\TaskController@update');




