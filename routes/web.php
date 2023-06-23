<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\CoreBusinessController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\LogActivityController;

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
    //dashboard
    Route::get('/dashboard/vendor-count', [DashboardController::class, 'getVendorCount'])->name('dashboard.vendor-count');
    Route::get('/dashboard/procurement-count', [DashboardController::class, 'getProcurementCount'])->name('dashboard.procurement-count');
    Route::get('/dashboard/table-data-vendor', [DashboardController::class, 'getDataTableVendor'])->name('dashboard.table-data-vendor');
    Route::get('/dashboard/table-data-procurement', [DashboardController::class, 'getDataTableProcurement'])->name('dashboard.table-data-procurement');
    //chained corebusiness to classification
    Route::get('/classifications/getByCoreBusiness', [ClassificationController::class, 'getByCoreBusiness'])->name('classifications.getByCoreBusiness');
    //vendors
    Route::get('/vendors/data', [VendorController::class, 'data'])->name('vendors.data');
    Route::put('/vendors/{vendor}/blacklist', [VendorController::class, 'blacklist'])->name('vendors.blacklist');
    Route::post('/vendors/upload', [VendorController::class, 'upload'])->name('vendors.upload');
    Route::delete('/vendors/file/{fileId}', [VendorController::class, 'fileDelete'])->name('vendors.file-delete');
    Route::get('/vendors/file/fetch/{fileId}', [VendorController::class, 'fetchData'])->name('vendors.file-fetch');
    Route::put('/vendors/file/{fileId}', [VendorController::class, 'fileUpdate'])->name('vendors.file-update');
    //procurement
    Route::get('/procurement/{id}/print', [ProcurementController::class, 'print'])->name('procurement.print');
    Route::put('/procurement/{procurement}/cancel', [ProcurementController::class, 'cancel'])->name('procurement.cancel');
    Route::put('/procurement/{procurement}/repeat', [ProcurementController::class, 'repeat'])->name('procurement.repeat');
    Route::get('/procurement/{procurementId}/vendors', [ProcurementController::class, 'vendors'])->name('procurement.vendors');
    Route::post('/procurement/upload', [ProcurementController::class, 'upload'])->name('procurement.upload');
    Route::post('/procurement/update-selected-vendor', [ProcurementController::class, 'updateSelectedVendor'])->name('procurement.update_selected_vendor');
    Route::get('/procurement/{id}/evaluation', [ProcurementController::class, 'evaluation'])->name('procurement.evaluation');
    Route::get('/procurement/{id}/view', [ProcurementController::class, 'view'])->name('procurement.view');
    Route::get('/procurement/data', [ProcurementController::class, 'data'])->name('procurement.data');
    Route::post('/procurement/evaluation-company', [ProcurementController::class, 'saveEvaluationCompany'])->name('procurement.evaluation-company');
    Route::post('/procurement/evaluation-vendor', [ProcurementController::class, 'saveEvaluationVendor'])->name('procurement.evaluation-vendor');
    Route::get('procurement-files/{procurementId}', [ProcurementController::class, 'getProcurementFile'])
        ->name('procurement.get-file');
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
