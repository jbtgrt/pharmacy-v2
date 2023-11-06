<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth-user', [UserController::class, 'authUser']); 
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/send-sms', [NotificationController::class, 'sendSmsNotificaition']);

    Route::put('/lock/{id}', [UserController::class, 'lockUser']); 
    Route::put('/profile/{id}', [UserController::class, 'profile']); 
    Route::put('/change-password/{id}', [UserController::class, 'changePassword']); 
    Route::resource('/user', UserController::class); 

    Route::resource('/category', CategoryController::class); 


});

    Route::post('/login', [AuthController::class, 'login']);
