<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\SupplierController;
use App\Http\Controllers\Master\ProjectController;
use App\Http\Controllers\Master\DepartmentController;
use App\Http\Controllers\Master\AdditionalDocumentTypeController;
use App\Http\Controllers\Master\InvoiceTypeController;

/*
|--------------------------------------------------------------------------
| Master Data Routes
|--------------------------------------------------------------------------
|
| All routes related to master data management are defined here.
| This includes departments, projects, suppliers, etc.
|
*/

Route::prefix('master')->name('master.')->group(function () {
    // Supplier Routes
    Route::resource('suppliers', SupplierController::class);
    
    // Project Routes
    Route::resource('projects', ProjectController::class);
    
    // Department Routes
    Route::resource('departments', DepartmentController::class);

    // Additional Document Types Routes
    Route::resource('additional-document-types', AdditionalDocumentTypeController::class, ['except' => ['show']]);
    Route::get('additional-document-types/data', [AdditionalDocumentTypeController::class, 'data'])->name('additional-document-types.data');
    
    // Invoice Types Routes
    Route::resource('invoice-types', InvoiceTypeController::class, ['except' => ['show']]);
    Route::get('invoice-types/data', [InvoiceTypeController::class, 'data'])->name('invoice-types.data');
}); 