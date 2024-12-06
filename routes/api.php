<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Middleware\UserAccessPermissionChecker;

// Routes for user login and registration without any middleware verification
Route::post('/login', [AuthenticationController::class, 'userLogin']);
Route::post('/register', [AuthenticationController::class, 'userRegistration']);

// Protected routes for API authentication
Route::middleware('auth:api')->group(function () {
    // CRUD routes for users with permission middleware
    // Ensures only users with 'manage users' permission can access these endpoints
    Route::apiResource('users', UserController::class)->middleware(UserAccessPermissionChecker::class.':manage users');

    // CRUD routes for roles with permission middleware
    // Ensures only users with 'manage roles' permission can access these endpoints
    Route::apiResource('roles', RoleController::class)->middleware(UserAccessPermissionChecker::class.':manage roles');

    // CRUD routes for permissions with permission middleware
    // Ensures only users with 'manage permission' permission can access these endpoints
    Route::apiResource('permissions', PermissionController::class)->middleware(UserAccessPermissionChecker::class.':manage permission');

    // Assigning roles and permissions to users and roles
    Route::post('/roles/assign-to-user', [RoleController::class, 'assignRoleToUser']);
    Route::post('/permissions/assign-to-user', [PermissionController::class, 'assignPermissionToUser']);
    Route::post('/permissions/assign-to-role', [PermissionController::class, 'assignPermissionToRole']);
});
