<?php

use App\Http\Controllers\Invoice;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProfileController;
use App\Services\print\PrintService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/print-pdf', [PdfController::class, 'printPdf'])->name('sale-reports');

Route::namespace('App\Livewire')->group(function () {
    //? Routes that can be accessed only when logging in
    Route::middleware(['auth', 'verified'])->group(function () {

        Route::name('dashboard.')->group(function () {
            Route::get('/', Index::class)->name('index');
        });

        //Employee
        Route::namespace('Employee')->group(function () {

            Route::get('/employee', Table::class)->name('employee');
        });
          //Category
          Route::namespace('Category')->group(function () {

            Route::get('/category', Table::class)->name('category');
        });

          //Category
          Route::namespace('Car')->group(function () {

            Route::get('/car', Table::class)->name('car');
        });

          //Category
          Route::namespace('CareRental')->group(function () {

            Route::get('/car-reservation', Table::class)->name('car-reservation');
        });
         

          //Item
          Route::namespace('Invoice')->group(function () {

            Route::get('/create-invoice', Create::class)->name('create-invoice');
        });

        
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
    ->name('profile.edit');
    Route::get('/print-invoice', [InvoiceController::class, 'printInvoice'])->name('print-Invoice');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
