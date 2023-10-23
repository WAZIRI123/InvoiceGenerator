<?php

use App\Http\Controllers\Invoice;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProfileController;
use App\Livewire\UserComponent;
use App\Livewire\Wert;
use App\Services\print\PrintService;
use Illuminate\Support\Facades\Route;
use WAZIRITALLCRUDGENERATOR\Http\Livewire\TallCrudGenerator;

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

Route::get('/tall-crud-generator', TallCrudGenerator::class)->name('tall-crud-generator');

Route::get('/test', UserComponent::class)->name('wert');
Route::get('/print-pdf', [PdfController::class, 'printPdf'])->name('sale-reports');

Route::namespace('App\Livewire')->group(function () {
    //? Routes that can be accessed only when logging in
    Route::middleware(['auth', 'verified'])->group(function () {

        Route::name('dashboard.')->group(function () {
            Route::get('/', Index::class)->name('index');
        });

        Route::namespace('Class')->name('class.')->group(function () {
            Route::get('/classes', Table::class)->name('index');
        });

        Route::namespace('Subject')->name('subject.')->group(function () {
            Route::get('/subjects', Table::class)->name('index');
        });
        Route::namespace('AcademicPerformance')->name('Reports.')->group(function () {
            Route::get('/exam-result', ExamResult::class)->name('ExamResult');
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
