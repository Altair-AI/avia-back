<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MalfunctionCauseRuleController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\OperationRuleController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RealTimeTechnicalSystemController;
use App\Http\Controllers\RuleBasedKnowledgeBaseController;
use App\Http\Controllers\RuleEngineController;
use App\Http\Controllers\TechnicalSystemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkSessionController;
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
    Route::post('me', [AuthController::class, 'me']);
});

Route::group(['middleware' => ['cors', 'api', 'jwt.auth'], 'prefix' => 'v1/admin/'], function () {
    Route::apiResource('organizations', OrganizationController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('technical-systems', TechnicalSystemController::class);
    Route::apiResource('real-time-technical-systems', RealTimeTechnicalSystemController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('documents', DocumentController::class);
    Route::apiResource('operations', OperationController::class);
    Route::apiResource('rule-based-knowledge-bases', RuleBasedKnowledgeBaseController::class);
    Route::apiResource('malfunction-cause-rules', MalfunctionCauseRuleController::class);
    Route::apiResource('operation-rules', OperationRuleController::class);
    Route::apiResource('work-sessions', WorkSessionController::class);
    Route::post('define-malfunction-causes', [RuleEngineController::class, 'defineMalfunctionCauses']);
    Route::post('troubleshooting', [RuleEngineController::class, 'troubleshooting']);
});

Route::group(['middleware' => ['cors', 'api', 'jwt.auth'], 'prefix' => 'v1/tech/'], function () {
    Route::post('define-malfunction-causes', [RuleEngineController::class, 'defineMalfunctionCauses']);
    Route::post('troubleshooting', [RuleEngineController::class, 'troubleshooting']);
});
