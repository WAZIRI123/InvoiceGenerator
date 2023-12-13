<?php

use App\Http\Controllers\Invoice;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProfileController;
use App\Livewire\ExamCreate\ExamCreate;
use App\Livewire\TestCrud;
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

        Route::namespace('Exam')->name('exam.')->group(function () {
            Route::get('/exam', Table::class)->name('index');
        });

        Route::namespace('Teacher')->name('teacher.')->group(function () {
            Route::get('/teacher', Table::class)->name('index');
        });

        Route::namespace('ExamRule')->name('ExamRule.')->group(function () {
            Route::get('/exam-rule', Table::class)->name('index');
        });

        Route::namespace('Stream')->name('stream.')->group(function () {
            Route::get('/stream', Table::class)->name('index');
        });

        Route::namespace('Admin')->name('admin.')->group(function () {
            Route::get('/admin', Table::class)->name('index');
        });

        Route::namespace('Subject')->name('subject.')->group(function () {
            Route::get('/subjects', Table::class)->name('index');
        });

        Route::namespace('Student')->name('student.')->group(function () {
            Route::get('/students', Table::class)->name('index');
        });

        Route::namespace('Semester')->name('semester.')->group(function () {
            Route::get('/semesters', Table::class)->name('index');
        });
        Route::namespace('ExamMark')->name('marking.')->group(function () {
            Route::get('/exam-marking', Table::class)->name('index');
        });

        Route::namespace('GradeSystem')->name('grading.')->group(function () {
            Route::get('/grade-system', Table::class)->name('index');
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
