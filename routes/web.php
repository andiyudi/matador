<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\CoreBusinessController;
use App\Http\Controllers\ClassificationController;

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
});
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/vendor-count', [DashboardController::class, 'getVendorCount'])->name('dashboard.vendor-count');
    Route::get('/dashboard/procurement-count', [DashboardController::class, 'getProcurementCount'])->name('dashboard.procurement-count');
    Route::get('/dashboard/table-data-vendor', [DashboardController::class, 'getDataTableVendor'])->name('dashboard.table-data-vendor');
    Route::get('/dashboard/table-data-procurement', [DashboardController::class, 'getDataTableProcurement'])->name('dashboard.table-data-procurement');
    Route::get('/classifications/getByCoreBusiness', [ClassificationController::class, 'getByCoreBusiness'])->name('classifications.getByCoreBusiness');
    Route::put('/vendors/{vendor}/blacklist', [VendorController::class, 'blacklist'])->name('vendors.blacklist');
    Route::post('/vendors/upload', [VendorController::class, 'upload'])->name('vendors.upload');
    Route::get('/vendors/data', [VendorController::class, 'data'])->name('vendors.data');
    Route::delete('/vendors/file/{fileId}', [VendorController::class, 'fileDelete'])->name('vendors.file-delete');
    Route::get('/vendors/file/fetch/{fileId}', [VendorController::class, 'fetchData'])->name('vendors.file-fetch');
    Route::put('/vendors/file/{fileId}', [VendorController::class, 'fileUpdate'])->name('vendors.file-update');
    Route::get('/procurement/{id}/print', [ProcurementController::class, 'print'])->name('procurement.print');
    Route::put('/procurement/{procurement}/cancel', [ProcurementController::class, 'cancel'])->name('procurement.cancel');
    Route::get('/procurement/{procurementId}/vendors', [ProcurementController::class, 'vendors'])->name('procurement.vendors');
    Route::post('/procurement/upload', [ProcurementController::class, 'upload'])->name('procurement.upload');
    Route::post('/procurement/update-selected-vendor', [ProcurementController::class, 'updateSelectedVendor'])->name('procurement.update_selected_vendor');
    Route::get('/procurement/evaluation', [ProcurementController::class, 'evaluation'])->name('procurement.evaluation');
});
Route::middleware(['auth'])->group(function () {
    Route::resource('core-business', CoreBusinessController::class);
    Route::resource('classifications', ClassificationController::class);
    Route::resource('vendors', VendorController::class);
    Route::resource('procurement', ProcurementController::class);
    Route::resource('divisions', DivisionController::class);
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
