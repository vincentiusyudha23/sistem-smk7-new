<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\ProfileController;

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
    return view('firstpage');
})->middleware('guest');

Route::middleware('guest')->prefix('admin')->as('admin.')->group(function(){
    Route::get('/login',[AdminController::class, 'login'])->name('login');
    Route::get('/register',[AdminController::class, 'register'])->name('register');
});

Route::middleware('auth')->prefix('admin')->as('admin.')->group(function(){
    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/siswa',[AdminController::class, 'akun_siswa'])->name('siswa');
    Route::get('/mapel',[AdminController::class, 'akun_mapel'])->name('mapel');
    Route::get('/presensi',[AdminController::class, 'presensi'])->name('presensi');
});
    
Route::prefix('mapel')->as('mapel.')->group(function(){
    Route::get('/',[MapelController::class,'login'])->name('login');
    Route::get('/dashboard',[MapelController::class,'index'])->name('dashboard');
    Route::get('/sesiujian',[MapelController::class,'sesi_ujian'])->name('sesi-ujian');
    Route::get('/soal-ujian',[MapelController::class,'soal_ujian'])->name('soal-ujian');
    Route::get('/hasil-ujian',[MapelController::class,'hasil_ujian'])->name('hasil-ujian');
});

Route::prefix('siswa')->as('siswa.')->group(function(){
    Route::view('/','siswa.page.login')->name('login');
    Route::view('/dashboard','siswa.page.dashboard.dashboard')->name('dashboard');
    Route::view('/ujian','siswa.page.ujian.ujian')->name('ujian');
    Route::view('/presensi','siswa.page.presensi.presensi')->name('presensi');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
