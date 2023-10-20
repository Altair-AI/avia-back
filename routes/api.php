<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TechnicalSystemController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::group(['middleware' => ['cors', 'api'], 'prefix' => 'auth/'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

Route::group(['middleware' => ['cors', 'api'], 'prefix' => 'v1/admin/'], function () {
    Route::post('users/register-technician', [UserController::class, 'registerTechnician'])
        ->middleware('jwt.auth');
    Route::apiResource('users', UserController::class)->middleware('jwt.auth');
    Route::apiResource('projects', ProjectController::class)->middleware('jwt.auth');
    Route::apiResource('technical-systems', TechnicalSystemController::class)
        ->middleware('jwt.auth');
    Route::apiResource('operations', OperationController::class)->middleware('jwt.auth');
    Route::apiResource('documents', DocumentController::class)->middleware('jwt.auth');
});
