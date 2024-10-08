<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/request-verification/{user}', [AuthController::class, 'requestVerificationEmail']);
Route::get('/verify/{id}/{hash}', [AuthController::class, 'verify'])->name('verification.verify');


// Protected routes
Route::group(["middleware"=> ["auth:sanctum"]], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('/tasks', TaskController::class);
});