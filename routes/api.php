<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{AuthController,ProductController,OrderController};

Route::post('login',[AuthController::class,'login']);

Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::apiResource('products', ProductController::class);
    Route::apiResource('orders', OrderController::class);
});
