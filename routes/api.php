<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;






Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    /* Route::get('user-profile', [AuthController::class, 'userProfile']); */
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('users', [AuthController::class, 'allUsers']);
    Route::get('user-profile', [AuthController::class, 'userProfile']);
    /*  Route::put('/user/{id}', [AuthController::class, 'upd']);
    Route::delete('/user/{id}', [AuthController::class, 'del']);
    Route::post('users', [AuthController::class, 'register']); */
});

Route::get('/user/{id}', [UserController::class, 'show']);
Route::put('/user/{id}', [UserController::class, 'update']);
Route::delete('/user/{id}', [AuthController::class, 'del']);
Route::get('users', [AuthController::class, 'allUsers']);
