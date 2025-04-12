<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\AdditionalDocumentTypeController;

/*
|--------------------------------------------------------------------------
| Additional Documents Routes
|--------------------------------------------------------------------------
|
| All routes related to additional documents management are defined here.
|
*/

// Additional Document Type Routes
Route::resource('document-types', AdditionalDocumentTypeController::class);

// Additional Document Routes
Route::prefix('documents')->group(function () {
    Route::get('/', function () { 
        return view('documents.index'); 
    })->name('documents.index');
    // Add other document routes here
}); 