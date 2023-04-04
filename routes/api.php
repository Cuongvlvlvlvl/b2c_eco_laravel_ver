<?php

use App\Http\Controllers\AimTypeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeptController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\SpendingController;
use App\Http\Controllers\TargetController;
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
    Route::get('users/user', 'getUser');
});

Route::controller(DeptController::class)->group(function(){
    Route::get('dept/', 'getAllDepts');
    Route::get('dept/{id}', 'getDept');
    Route::post('dept/', 'createDept');
    Route::put('dept/{id}/{uid}', 'changeDept');
    Route::delete('dept/{id}/{uid}', 'deleteDept');
});

Route::controller(RevenueController::class)->group(function(){
    Route::get('revenue/calc/', 'getRevenueCalc');
    Route::get('revenue/', 'getAllRevenues');
    Route::get('revenue/{id}', 'getRevenue');
    Route::post('revenue/', 'createRevenue');
    Route::put('revenue/{id}/{uid}', 'changeRevenue');
    Route::delete('revenue/{id}/{uid}', 'deleteRevenue');
});

Route::controller(SpendingController::class)->group(function(){
    Route::get('spending/calc/', 'getSpendingCalc');
    Route::get('spending/calcsv', 'getTopSpending');
    Route::get('spending/', 'getAllSpendings');
    Route::get('spending/{id}', 'getSpending');
    Route::post('spending/', 'createSpending');
    Route::put('spending/{id}/{uid}', 'changeSpending');
    Route::delete('spending/{id}/{uid}', 'deleteSpending');
});

Route::controller(TargetController::class)->group(function(){
    Route::get('target/', 'getAllTargets');
    Route::get('target/{id}', 'getTarget');
    Route::post('target/', 'createTarget');
    Route::put('target/{id}/{uid}', 'changeTarget');
    Route::delete('target/{id}/{uid}', 'deleteTarget');
});

Route::controller(CategoryController::class)->group(function(){
    Route::get('category/', 'getAllCates');
    Route::get('category/{id}', 'getCateName');
});

Route::controller(AimTypeController::class)->group(function(){
    Route::get('type/', 'getAllTypes');
    Route::get('type/{id}', 'getTypeName');
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
