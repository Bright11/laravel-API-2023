<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\task\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login',[AuthController::class,'login']);
Route::post("register",[AuthController::class,'register']);
Route::post("logout",[AuthController::class,'logout']);

Route::resource('/task',TaskController::class);

