<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\rolesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\UsersInfoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    
    Route::apiResource('users', usersController::class);
    Route::apiResource('departments', DepartmentsController::class);
    Route::apiResource('roles', rolesController::class);
    Route::apiResource('user_info', UsersInfoController::class);
    Route::apiResource('attendance', AttendanceController::class);
    Route::get('search', [SearchController::class, 'search']);

    Route::get('search_user', [SearchController::class, 'search_user']);
    
    Route::post('logout', [AuthController::class, 'logout']);
});
