<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Invoices_Report;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\Customers_ReportController;
use App\Http\Controllers\InvoicesAttachmentsControlle;
use App\Http\Controllers\InvoicesAttachmentsController;
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

Route::get('/', function () {
    return view('auth.login');
})->name('home');


Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified', 'check_status'])->name('dashboard');
 
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::resource('/product', ProductsController::class);
Route::resource('/section', SectionsController::class);

Route::resource('/invoice', InvoicesController::class);
Route::get('/invoice_paid', [InvoicesController::class, 'invoice_paid'])->name('invoice_paid');
Route::get('/invoice_unpaid', [InvoicesController::class, 'invoice_unpaid'])->name('invoice_unpaid');
Route::get('/invoice_partial', [InvoicesController::class, 'invoice_partial'])->name('invoice_partial');

Route::post('/status_update/{id}', [InvoicesController::class, 'status_update'])->name('status_update');
Route::get('/sections/{id}', [InvoicesController::class, 'getprodecteds']);

Route::delete('/archef', [InvoicesController::class, 'archef'])->name('invoice.archef');
Route::get('/archef/archef_show', [InvoicesController::class, 'archef_show'])->name('invoice.archef_show');
Route::post('/archef/restore', [InvoicesController::class, 'restore'])->name('invoice.restore');
Route::get('/invoice/print/{id}', [InvoicesController::class, 'print'])->name('invoice.print');

Route::get('/invoice_details/{id}', [InvoicesDetailsController::class, 'invoice_details'])->name('invoice.details');
Route::get('/view_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'open_file'])->name('view_file');
Route::get('/download/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'get_file'])->name('download');
Route::post('/delete', [InvoicesDetailsController::class, 'destroy'])->name('delete');
Route::delete('/invoice_softdelete/{id}', [InvoicesDetailsController::class, 'softdelete'])->name('invoice.softdelete');

Route::resource('/atte', InvoicesAttachmentsController::class);

Route::get('invoices_report', [Invoices_Report::class, 'index'])->name('invoices_report');
Route::post('search_invoices', [Invoices_Report::class, 'search_invoices'])->name('search_invoices');

Route::get('customers_report', [Customers_ReportController::class, 'index'])->name('customers_report');
Route::post('Search_customers', [Customers_ReportController::class, 'Search_customers'])->name('Search_customers');


Route::resource('/roles', RoleController::class);
Route::resource('/users', UserController::class)->middleware(['auth']);

Route::get('MarkAsRead_all', [InvoicesController::class, 'MarkAsRead_all'])->name('MarkAsRead_all');
Route::get('/details_not/{id}', [InvoicesDetailsController::class, 'details_not'])->name('invoice.details_not');


require __DIR__.'/auth.php';




Route::get('/{page}', [AdminController::class, 'index']);