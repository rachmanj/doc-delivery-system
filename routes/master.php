<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\DepartmentController;
use App\Http\Controllers\Master\SupplierController;
use App\Http\Controllers\Master\ProjectController;

/*
|--------------------------------------------------------------------------
| Master Data Routes
|--------------------------------------------------------------------------
|
| All routes related to master data management are defined here.
| This includes departments, projects, suppliers, etc.
|
*/

// Department Routes
Route::resource('departments', DepartmentController::class);

// Supplier Routes
Route::resource('suppliers', SupplierController::class);

// Project Routes
Route::resource('projects', ProjectController::class); 