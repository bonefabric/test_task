<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('token/get', [\App\Http\Controllers\Api\AuthController::class, 'getToken']);

Route::group(['middleware' => 'auth:sanctum'], function () {
	Route::apiResource('users', \App\Http\Controllers\Api\UsersController::class, [
		'except' => ['update']
	]);
	Route::get('users/{id}/payments/test', [\App\Http\Controllers\Api\PaymentsController::class, 'testPayment']);
	Route::get('users/{id}/payments', [\App\Http\Controllers\Api\PaymentsController::class, 'list']);
});
