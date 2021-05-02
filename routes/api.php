<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MatrixCalculator;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/auth'], function (){

    Route::post('/sign-up', [AuthController::class, 'signUp']);
    Route::post('/sign-in', [AuthController::class, 'signIn']);
    Route::post('sign-out',[AuthController::class, 'signOut'])->middleware('auth:sanctum');
});

Route::group(['prefix' => '/matrix', 'middleware' => 'auth:sanctum'], function (){
    Route::get('multiply', [MatrixCalculator::class, 'multiply']);
});
