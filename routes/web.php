<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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
Route::view('/', 'firstpage')->name('homepage');

Route::middleware('guest')->group(function(){
    
    Route::prefix('admin')->as('admin.')->group(function(){
        Route::get('/login',[AdminController::class, 'login'])->name('login');
        Route::get('/register',[AdminController::class, 'register'])->name('register');
    });

    Route::prefix('mapel')->as('mapel.')->group(function(){
        Route::get('/login',[MapelController::class,'login'])->name('login');
        Route::post('/login', [AuthenticatedSessionController::class, 'loginMapel']);
    });
    Route::prefix('siswa')->as('siswa.')->group(function(){
        Route::view('/siswa/login','siswa.page.login')->name('login');
        Route::post('/siswa/login', [AuthenticatedSessionController::class, 'loginSiswa']);
    });
});

Route::middleware(['web','admin'])->prefix('admin')->as('admin.')->group(function(){
    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/siswa',[AdminController::class, 'akun_siswa'])->name('siswa');
    Route::post('/store_siswa',[AdminController::class, 'store_siswa'])->name('siswa.store');
    Route::post('/import_siswa',[AdminController::class, 'import_siswa'])->name('siswa.import');
    Route::post('/update_siswa',[AdminController::class, 'update_siswa'])->name('siswa.update');
    Route::get('/delete_siswa',[AdminController::class, 'delete_siswa'])->name('siswa.delete');
    Route::post('/store_mapel',[AdminController::class, 'store_mapel'])->name('mapel.store');
    Route::get('/mapel',[AdminController::class, 'akun_mapel'])->name('mapel');
    Route::post('/mapel-update',[AdminController::class, 'update_mapel'])->name('mapel.update');
    Route::get('/mapel-delete',[AdminController::class, 'mapel_delete'])->name('mapel.delete');
    Route::get('/presensi',[AdminController::class, 'presensi'])->name('presensi');
});
    
Route::middleware(['web','mapel'])->prefix('mapel')->as('mapel.')->group(function(){
    Route::get('/dashboard',[MapelController::class,'index'])->name('dashboard');
    Route::get('/sesiujian',[MapelController::class,'sesi_ujian'])->name('sesi-ujian');
    Route::post('/sesiujian',[MapelController::class,'store_sesiujian'])->name('sesi-ujian.store');
    Route::post('/sesiujian-edit',[MapelController::class,'update_sesi_ujian'])->name('sesi-ujian.update');
    Route::get('/soal-ujian/{id}',[MapelController::class,'soal_ujian'])->name('soal-ujian');
    Route::post('/soal-ujian',[MapelController::class,'store_soal_ujian'])->name('soal-ujian.store');
    Route::get('/hasil-ujian',[MapelController::class,'hasil_ujian'])->name('hasil-ujian');
});

Route::middleware(['web','siswa'])->prefix('siswa')->as('siswa.')->group(function(){
    Route::view('/dashboard','siswa.page.dashboard.dashboard')->name('dashboard');
    Route::view('/ujian','siswa.page.ujian.ujian')->name('ujian');
    Route::view('/soal-ujian','siswa.page.ujian.soal-ujian')->name('soal-ujian');
    Route::view('/presensi','siswa.page.presensi.presensi')->name('presensi');
    Route::view('/riwayat-presensi','siswa.page.presensi.riwayat-presensi')->name('riwayat-presensi');
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
