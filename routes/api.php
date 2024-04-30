<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('/auth/login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::post('/auth/register', [\App\Http\Controllers\Auth\AuthController::class, 'register']);
Route::post('/auth/logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout']);
Route::get('/auth/verifyUserByEmail/{email}', [\App\Http\Controllers\Auth\AuthController::class, 'verifyUserByEmail']);


Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::resource('task', \App\Http\Controllers\TaskController::class);
});
