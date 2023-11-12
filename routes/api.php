<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\task\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




// public route
Route::post('login',[AuthController::class,'login']);
Route::post("register",[AuthController::class,'register']);

// protected route

Route::group(['middleware'=>['auth:sanctum']], function(){
    Route::post("logout",[AuthController::class,'logout']);
   Route::resource('/task',TaskController::class);

});
