<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard/vendor-count', [DashboardController::class, 'getVendorCount'])->name('dashboard.vendor-count');
Route::get('/dashboard/table-data-vendor', [DashboardController::class, 'getDataTableVendor'])->name('dashboard.table-data-vendor');
Route::get('/dashboard/table-data-procurement', [DashboardController::class, 'getDataTableProcurement'])->name('dashboard.table-data-procurement');
Route::get('/classifications/getByCoreBusiness', [ClassificationController::class, 'getByCoreBusiness'])->name('classifications.getByCoreBusiness');
Route::put('/vendors/{vendor}/blacklist', [VendorController::class, 'blacklist'])->name('vendors.blacklist');
Route::post('/vendors/upload', [VendorController::class, 'upload'])->name('vendors.upload');
Route::get('/vendors/data', [VendorController::class, 'data'])->name('vendors.data');
Route::delete('/vendors/file/{fileId}', [VendorController::class, 'fileDelete'])->name('vendors.file-delete');
Route::get('vendors/file/fetch/{fileId}', [VendorController::class, 'fetchData'])->name('vendors.file-fetch');
Route::put('/vendors/file/{fileId}', [VendorController::class, 'fileUpdate'])->name('vendors.file-update');

Route::resource('core-business', CoreBusinessController::class);
Route::resource('classifications', ClassificationController::class);
Route::resource('vendors', VendorController::class);
Route::resource('procurement', ProcurementController::class);


Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
