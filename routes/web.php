<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CoreBusinessController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\VendorController;
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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/classifications/getByCoreBusiness', [ClassificationController::class, 'getByCoreBusiness'])->name('classifications.getByCoreBusiness');
Route::put('/vendors/{vendor}/blacklist', [VendorController::class, 'blacklist'])->name('vendors.blacklist');
Route::post('/vendors/upload', [VendorController::class, 'upload'])->name('vendors.upload');
Route::get('/vendors/data', [VendorController::class, 'data'])->name('vendors.data');
Route::delete('/vendors/file/{fileId}', [VendorController::class, 'fileDelete'])->name('vendors.file-delete');
Route::put('/vendors/file/{id}', [VendorController::class, 'fileUpdate'])->name('vendors.file-update');

Route::resource('core-business', CoreBusinessController::class);
Route::resource('classifications', ClassificationController::class);
Route::resource('vendors', VendorController::class);


Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
