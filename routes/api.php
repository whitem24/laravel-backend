<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group(function() {
    //Categories Routes
    Route::post('/categories', 'App\Http\Controllers\CategoryController@store');
    Route::get('/categories','App\Http\Controllers\CategoryController@index');
    Route::get('/categories/{id}','App\Http\Controllers\CategoryController@show');
    Route::put('/categories/{id}','App\Http\Controllers\CategoryController@update');
    Route::delete('/categories/{id}','App\Http\Controllers\CategoryController@destroy');

    //Product Routes
    Route::post('/products', 'App\Http\Controllers\ProductController@store');
    Route::get('/products','App\Http\Controllers\ProductController@index');
    Route::get('/products/{id}','App\Http\Controllers\ProductController@show');
    Route::put('/products/{id}','App\Http\Controllers\ProductController@update');
    Route::delete('/products/{id}','App\Http\Controllers\ProductController@destroy');
});

Route::post('/auth/register', [UserController::class, 'createUser']);
Route::post('/auth/login', [UserController::class, 'loginUser']);
