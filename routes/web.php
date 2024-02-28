<?php

use App\Http\Controllers\DokterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PerawatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('');
// });
Route::get('/home', [HomeController::class, 'index']);
Route::get('/', [HomeController::class, 'depan']);

// pasien
Route::get('pasien/index', [PasienController::class, 'index'])->name('pasien.index');
Route::post('pasien/store', [PasienController::class, 'store']);
Route::delete('pasien/hapus/{id}', [PasienController::class, 'destroy'])->name('perawat.delete');

// perawat
Route::get('perawat/index', [PerawatController::class, 'index'])->name('perawat.index');
Route::post('perawat/store/{id}', [PerawatController::class, 'store']);

// isian perawat

Route::post('/modal1/store', [PerawatController::class, 'storeModal1'])->name('modal1.store');
Route::post('/modal2/store', [PerawatController::class, 'storeModal2'])->name('modal2.store');

// Route untuk mendapatkan konten modal berikutnya
Route::get('/getNextModalContent', [PerawatController::class, 'getNextModalContent']);
// Route::delete('perawat/hapus/{id}', [PerawatController::class, 'destroy'])->name('perawat.delete');

// dokter
Route::get('dokter/index', [DokterController::class, 'index'])->name('dokter.index');
Route::get('dokter/soap/{id}', [DokterController::class, 'soap'])->name('dokter.soap');
Route::post('dokter/store/{id}', [DokterController::class, 'store'])->name('dokter.store');

Route::get('/get-diagnosa', [DokterController::class, 'getDiagnosa'])->name('get-diagnosa');