<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\AdditionalDocumentTypeController;
use App\Http\Controllers\Documents\AdditionalDocumentController;

// Additional Document Routes
Route::prefix('documents')->name('documents.')->group(function () {
    // Import routes should come before the {document} parameter routes
    Route::get('/import', [AdditionalDocumentController::class, 'import'])->name('import');
    Route::post('/import', [AdditionalDocumentController::class, 'importStore'])->name('import.store');
    
    // Other routes
    Route::get('/data', [AdditionalDocumentController::class, 'data'])->name('data');
    Route::get('/', [AdditionalDocumentController::class, 'index'])->name('index');
    Route::get('/create', [AdditionalDocumentController::class, 'create'])->name('create');
    Route::post('/', [AdditionalDocumentController::class, 'store'])->name('store');
    Route::get('/{document}', [AdditionalDocumentController::class, 'show'])->name('show');
    Route::get('/{document}/edit', [AdditionalDocumentController::class, 'edit'])->name('edit');
    Route::put('/{document}', [AdditionalDocumentController::class, 'update'])->name('update');
    Route::delete('/{document}', [AdditionalDocumentController::class, 'destroy'])->name('destroy');
}); 