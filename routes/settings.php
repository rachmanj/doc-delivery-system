<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Settings\UserController;
use App\Http\Controllers\Settings\RoleController;
use App\Http\Controllers\Settings\PermissionController;
use App\Http\Controllers\Settings\DocumentNumberingController;

/*
|--------------------------------------------------------------------------
| Settings Routes
|--------------------------------------------------------------------------
|
| All routes related to system settings and user management are defined here.
|
*/

// User Management Routes
Route::resource('users', UserController::class);

// Roles Management Routes
Route::resource('roles', RoleController::class);

// Permissions Management Routes
Route::resource('permissions', PermissionController::class);

// Activity Logs Routes
Route::prefix('activity-logs')->group(function () {
    Route::get('/', function () { 
        return view('settings.activity-logs.index'); 
    })->name('activity-logs.index');
    // Add other activity log routes here
});

// Document Numbering Routes
Route::resource('document-numbering', DocumentNumberingController::class);

// System Settings Routes
Route::prefix('system-settings')->group(function () {
    Route::get('/', function () { 
        return view('settings.system.index'); 
    })->name('system-settings.index');
    // Add other system settings routes here
}); 