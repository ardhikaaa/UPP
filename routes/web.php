<?php

use App\Http\Controllers\SiswaController;
use App\Http\Controllers\halaman_obatController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('obat', halaman_obatController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::resource('siswa', SiswaController::class);

Route::resource('guru', GuruController::class)->middleware(['auth', 'verified']);

Route::resource('unit', UnitController::class)->middleware(['auth', 'verified']);


Route::get('/kunjungan_uks', function () {
    return view('kunjungan_uks');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

