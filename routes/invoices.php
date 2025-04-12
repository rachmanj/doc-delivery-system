<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\InvoiceTypeController;

/*
|--------------------------------------------------------------------------
| Invoice Routes
|--------------------------------------------------------------------------
|
| All routes related to invoices management are defined here.
|
*/

// Invoice Type Routes
Route::resource('invoice-types', InvoiceTypeController::class);

// Invoice Routes
Route::prefix('invoices')->group(function () {
    Route::get('/', function () { 
        return view('invoices.index'); 
    })->name('invoices.index');
    // Add other invoice routes here
});

// Invoice Attachment Routes
Route::prefix('invoice-attachments')->group(function () {
    Route::get('/', function () { 
        return view('invoices.attachments.index'); 
    })->name('invoice-attachments.index');
    // Add other invoice attachment routes here
}); 