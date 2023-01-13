<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PautasInternetController;






Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('users', [AuthController::class, 'allUsers']);
    Route::get('user-profile', [AuthController::class, 'userProfile']);

    Route::get('pautas_internet', [PautasInternetController::class, 'index']);
    Route::post('pautas_internet', [PautasInternetController::class, 'store']);
    Route::get('pautas_internet/{id}', [PautasInternetController::class, 'show']);
    Route::put('pautas_internet/{id}', [PautasInternetController::class, 'update']);
    Route::delete('pautas_internet/{id}', [PautasInternetController::class, 'delete']);
    Route::get('pautas_internet/pagination/{per_page}', [PautasInternetController::class, 'pagination']);

});

Route::get('/user/{id}', [UserController::class, 'show']);
Route::put('/user/{id}', [UserController::class, 'update']);
Route::delete('/user/{id}', [AuthController::class, 'del']);
Route::get('users', [AuthController::class, 'allUsers']);


