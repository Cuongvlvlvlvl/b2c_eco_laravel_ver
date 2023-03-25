<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeptController;
use App\Http\Controllers\RevenueController;
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

Route::controller(AuthController::class)->group(function(){
    Route::post('auth/authenticate', 'login');
    Route::post('auth/register', 'register');
});

Route::controller(UserController::class)->group(function(){
    Route::get('user', 'getUser');
});

Route::controller(DeptController::class)->group(function(){
    Route::get('dept', 'getAllDepts');
    Route::get('dept/{id}', 'getDept');
    Route::post('dept', 'createDept');
    Route::put('dept/{id}/{uid}', 'changeDept');
    Route::delete('dept/{id}/{uid}', 'deleteDept');
});

Route::controller(RevenueController::class)->group(function(){
    Route::get('revenue', 'getAllRevenues');
    Route::get('revenue/{id}', 'getRevenue');
    Route::post('revenue', 'createRevenue');
    Route::put('revenue/{id}/{uid}', 'changeRevenue');
    Route::delete('revenue/{id}/{uid}', 'deleteRevenue');
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
