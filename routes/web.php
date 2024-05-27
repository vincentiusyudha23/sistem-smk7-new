<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\SiswaController;
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


Route::middleware('guest')->group(function(){

    Route::view('/', 'firstpage')->name('homepage');
    
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
    Route::get('/generate-qr',[AdminController::class, 'generate_qr_code'])->name('generate-qr');
    Route::post('/update_qr_code',[AdminController::class, 'update_qr_code'])->name('generate-qr.update');
    Route::get('/download_qr_code/{id}',[AdminController::class, 'download_qrcode'])->name('generate-qr.download');
    Route::get('/kelas-jurusan',[AdminController::class, 'kelas_jurusan'])->name('kelas_jurusan');
    Route::post('/kelas-jurusan-store',[AdminController::class, 'store_kelas'])->name('store_kelas');
    Route::post('/kelas-jurusan-update',[AdminController::class, 'update_kelas'])->name('update_kelas');
    Route::post('/import_kelas',[AdminController::class, 'import_kelas'])->name('kelas.import');
    Route::get('/delete_kelas',[AdminController::class, 'delete_kelas'])->name('kelas.delete');
    Route::get('/detail_presensi/{id}',[AdminController::class, 'detail_presensi'])->name('detail_presensi');

    // DataController
    Route::get('/get-data-kelas',[DataController::class, 'getDataKelas'])->name('getDataKelas');
    Route::get('/get-data-siswa',[DataController::class, 'getDataSiswa'])->name('getDataSiswa');
    Route::get('/get-data-mapel',[DataController::class, 'getDataMapel'])->name('getDataMapel');
    Route::get('/template_kelas',[DataController::class, 'template_kelas'])->name('download.template.kelas');
    Route::get('/template_siswa',[DataController::class, 'template_siswa'])->name('download.template.siswa');
    Route::get('/data_siswa',[DataController::class, 'data_siswa'])->name('download.data.siswa');
    Route::get('/get-data-presensi',[DataController::class, 'getDataPresensi'])->name('getDataPresensi');
});
    
Route::middleware(['web','mapel'])->prefix('mapel')->as('mapel.')->group(function(){
    Route::get('/dashboard',[MapelController::class,'index'])->name('dashboard');
    Route::get('/sesiujian',[MapelController::class,'sesi_ujian'])->name('sesi-ujian');
    Route::post('/sesiujian',[MapelController::class,'store_sesiujian'])->name('sesi-ujian.store');
    Route::post('/sesiujian-edit',[MapelController::class,'update_sesi_ujian'])->name('sesi-ujian.update');
    Route::get('/sesiujian-delete',[MapelController::class,'delete_sesi'])->name('sesi-ujian.delete');
    Route::post('/update-status',[MapelController::class,'update_status'])->name('sesi_ujian.update.status');
    Route::get('/soal-ujian/{id}',[MapelController::class,'soal_ujian'])->name('soal-ujian');
    Route::post('/soal-ujian',[MapelController::class,'store_soal_ujian'])->name('soal-ujian.store');
    Route::get('/hasil-ujian',[MapelController::class,'hasil_ujian'])->name('hasil-ujian');
    Route::get('/hasil-ujian-siswa/{id}',[MapelController::class,'hasil_ujian_siswa'])->name('hasil-ujian-siswa');
    Route::get('/get-data-sesi/{id_mapel}', [DataController::class, 'getDataSesi'])->name('getDataSesi');
    Route::get('/get-data-hasil-ujian/{id}', [DataController::class, 'getHasilUjianSiswa'])->name('getHasilUjianSiswa');
});

Route::middleware(['web','siswa'])->prefix('siswa')->as('siswa.')->group(function(){
    Route::get('/dashboard',[SiswaController::class, 'index'])->name('dashboard');
    Route::get('/ujian',[SiswaController::class, 'ujian'])->name('ujian');
    Route::get('/soal-ujian/{id}',[SiswaController::class, 'soal_ujian'])->name('soal-ujian');
    Route::post('/submit-jawaban', [SiswaController::class,'submit_jawaban'])->name('submit.jawaban');
    Route::get('/submit-ujian/{mapel}', [SiswaController::class,'submit_ujian'])->name('submit.ujian');
    Route::get('/presensi',[SiswaController::class,'presensi'])->name('presensi');
    Route::post('/submit-presensi',[SiswaController::class,'submit_presensi'])->name('submit.presensi');
    Route::get('/riwayat-presensi',[SiswaController::class,'riwayat_presensi'])->name('riwayat-presensi');
    Route::get('/sesi-ujian', [DataController::class, 'getSesiUjian'])->name('getSesiUjian');
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
