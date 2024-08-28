<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TasksController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\PasswordResetController;
use App\Http\Controllers\Api\V1\CompleteTaskController;



Route::prefix('v1')->group(function(){
    Route::apiResource('/tasks', TasksController::class);
    Route::patch('/tasks/{task}/complete', CompleteTaskController::class);
    Route::post('/tasks/truncate', [TasksController::class, 'truncate']);
});

Route::post('/login', LoginController::class)->middleware('guest');
Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');
Route::post('/register', RegisterController::class)->middleware('guest');
Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->middleware('guest');
Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.reset')->middleware('signed');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
