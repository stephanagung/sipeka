<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SipekaPlantController;
use App\Http\Controllers\SipekaKategoriAbsensiController;
use App\Http\Controllers\SipekaDepartemenController;
use App\Http\Controllers\SipekaPenggunaController;
use App\Http\Controllers\SipekaJatahAbsensiController;
use App\Http\Controllers\SipekaAbsensiController;
use App\Http\Controllers\SipekaDashboardQP3Controller;
use App\Http\Controllers\SipekaRekapKaizenController;
use App\Http\Controllers\SipekaDataKaizenController;
use App\Http\Controllers\SipekaRekapOvertimeController;
use App\Http\Controllers\SipekaDataOvertimeController;
use App\Http\Controllers\SipekaDataAsesmenPrdController;
use App\Http\Controllers\SipekaRekapAsesmenPrdController;
use App\Http\Controllers\SipekaRekapKecelakaanController;
use App\Http\Controllers\SipekaDataKecelakaanController;
use App\Http\Controllers\SipekaRekapPelatihanController;
use App\Http\Controllers\SipekaDataPelatihanController;
use App\Http\Controllers\SipekaRekapPemenuhanTKController;
use App\Http\Controllers\SipekaDataPemenuhanTKController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Models\SipekaPengguna;

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

Route::get('/cek-username', function (Request $request) {
    $username = $request->query('username');

    // Cek apakah username sudah ada di database
    $exists = SipekaPengguna::where('username', $username)->exists();

    return response()->json(['available' => !$exists]); // True jika tersedia, false jika sudah ada
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard-qp-3', [SipekaDashboardQP3Controller::class, 'index'])
    ->middleware('check.level:Admin')
    ->name('dashboard.dashboard-qp-3');


// Rute untuk Plant
Route::get('/index-plant', [SipekaPlantController::class, 'index'])->name('plant.index');
Route::post('/store-plant', [SipekaPlantController::class, 'store'])->name('plant.store');
Route::put('/update-plant/{id_plant}', [SipekaPlantController::class, 'update'])->name('plant.update');
Route::delete('/delete-plant/{id_plant}', [SipekaPlantController::class, 'destroy'])->name('plant.destroy');

// Rute untuk Departemen
Route::get('/index-departemen', [SipekaDepartemenController::class, 'index'])->name('departemen.index');
Route::post('/store-departemen', [SipekaDepartemenController::class, 'store'])->name('departemen.store');
Route::put('/update-departemen/{id_departemen}', [SipekaDepartemenController::class, 'update'])->name('departemen.update');
Route::delete('/delete-departemen/{id_departemen}', [SipekaDepartemenController::class, 'destroy'])->name('departemen.destroy');

// Rute untuk Kategori Absensi
Route::get('/index-kategori-absensi', [SipekaKategoriAbsensiController::class, 'index'])->name('kategoriAbsensi.index');
Route::post('/store-kategori-absensi', [SipekaKategoriAbsensiController::class, 'store'])->name('kategoriAbsensi.store');
Route::put('/update-kategori-absensi/{id_kategori_absensi}', [SipekaKategoriAbsensiController::class, 'update'])->name('kategoriAbsensi.update');
Route::delete('/delete-kategori-absensi/{id_kategori_absensi}', [SipekaKategoriAbsensiController::class, 'destroy'])->name('kategoriAbsensi.destroy');

// Route untuk Pengguna
Route::get('/index-pengguna', [SipekaPenggunaController::class, 'index'])->name('pengguna.index');
Route::post('/import-pengguna', [SipekaPenggunaController::class, 'import'])->name('pengguna.import');
Route::post('/store-pengguna', [SipekaPenggunaController::class, 'store'])->name('pengguna.store');
Route::put('/update-pengguna/{id_pengguna}', [SipekaPenggunaController::class, 'update'])->name('pengguna.update');
Route::delete('/delete-pengguna/{id_pengguna}', [SipekaPenggunaController::class, 'destroy'])->name('pengguna.destroy');
Route::get('/detail-pengguna/{id_pengguna}', [SipekaPenggunaController::class, 'show'])->name('pengguna.show');

// Rute untuk Jatah Absensi
Route::get('/index-jatah-absensi', [SipekaJatahAbsensiController::class, 'index'])->name('jatah.index');
Route::post('/store-jatah-absensi', [SipekaJatahAbsensiController::class, 'store'])->name('jatah.store');
Route::put('/update-jatah-absensi/{id_jatah_absensi}', [SipekaJatahAbsensiController::class, 'update'])->name('jatah.update');
Route::get('/index-list-absensi/{id_jatah_absensi}', [SipekaJatahAbsensiController::class, 'showDetail'])->name('absensi.detail');

// Route untuk Absensi
Route::get('/index-absensi', [SipekaAbsensiController::class, 'index'])->name('absensi.index');
Route::post('/store-absensi', [SipekaAbsensiController::class, 'store'])->name('absensi.store');
Route::put('/update-absensi/{id_absensi}', [SipekaAbsensiController::class, 'update'])->name('absensi.update');
Route::delete('/delete-absensi/{id_absensi}', [SipekaAbsensiController::class, 'destroy'])->name('absensi.destroy');
Route::get('/index-info-absensi/{id_absensi}', [SipekaAbsensiController::class, 'show'])->name('absensi.show');

// Rute untuk Rekap Kaizen
Route::get('/index-rekap-kaizen', [SipekaRekapKaizenController::class, 'index'])->name('rekapKaizen.index');
Route::post('/store-rekap-kaizen', [SipekaRekapKaizenController::class, 'store'])->name('rekapKaizen.store');
Route::put('/update-rekap-kaizen/{id_rekap_kaizen}', [SipekaRekapKaizenController::class, 'update'])->name('rekapKaizen.update');
Route::delete('/delete-rekap-kaizen/{id_rekap_kaizen}', [SipekaRekapKaizenController::class, 'destroy'])->name('rekapKaizen.destroy');

// Rute untuk Data Kaizen
Route::get('/index-data-kaizen/{id_rekap_kaizen}', [SipekaDataKaizenController::class, 'index'])->name('dataKaizen.index');
Route::post('/store-data-kaizen', [SipekaDataKaizenController::class, 'store'])->name('dataKaizen.store');
Route::put('/update-data-kaizen/{id_data_kaizen}', [SipekaDataKaizenController::class, 'update'])->name('dataKaizen.update');
Route::delete('/delete-data-kaizen/{id_data_kaizen}', [SipekaDataKaizenController::class, 'destroy'])->name('dataKaizen.destroy');

// Rute untuk Rekap Overtime
Route::get('/index-rekap-overtime', [SipekaRekapOvertimeController::class, 'index'])->name('rekapOvertime.index');
Route::post('/store-rekap-overtime', [SipekaRekapOvertimeController::class, 'store'])->name('rekapOvertime.store');
Route::put('/update-rekap-overtime/{id_rekap_overtime}', [SipekaRekapOvertimeController::class, 'update'])->name('rekapOvertime.update');
Route::delete('/delete-rekap-overtime/{id_rekap_overtime}', [SipekaRekapOvertimeController::class, 'destroy'])->name('rekapOvertime.destroy');

// Rute untuk Data Overtime
Route::get('/index-data-overtime/{id_rekap_overtime}', [SipekaDataOvertimeController::class, 'index'])->name('dataOvertime.index');
Route::post('/store-data-overtime', [SipekaDataOvertimeController::class, 'store'])->name('dataOvertime.store');
Route::put('/update-data-overtime/{id_data_overtime}', [SipekaDataOvertimeController::class, 'update'])->name('dataOvertime.update');
Route::delete('/delete-data-overtime/{id_data_overtime}', [SipekaDataOvertimeController::class, 'destroy'])->name('dataOvertime.destroy');

// Rute untuk Rekap Asesmen Produksi
Route::get('/index-rekap-asesmen-prd', [SipekaRekapAsesmenPrdController::class, 'index'])->name('rekapAsesmenPrd.index');
Route::post('/store-rekap-asesmen-prd', [SipekaRekapAsesmenPrdController::class, 'store'])->name('rekapAsesmenPrd.store');
Route::put('/update-rekap-asesmen-prd/{id_rekap_asesmen_prd}', [SipekaRekapAsesmenPrdController::class, 'update'])->name('rekapAsesmenPrd.update');
Route::delete('/delete-rekap-asesmen-prd/{id_rekap_asesmen_prd}', [SipekaRekapAsesmenPrdController::class, 'destroy'])->name('rekapAsesmenPrd.destroy');

// Rute untuk Data Asesmen Produksi
Route::get('/index-data-asesmen-prd/{id_rekap_asesmen_prd}', [SipekaDataAsesmenPrdController::class, 'index'])->name('dataAsesmenPrd.index');
Route::post('/store-data-asesmen-prd', [SipekaDataAsesmenPrdController::class, 'store'])->name('dataAsesmenPrd.store');
Route::put('/update-data-asesmen-prd/{id_data_asesmen_prd}', [SipekaDataAsesmenPrdController::class, 'update'])->name('dataAsesmenPrd.update');
Route::delete('/delete-data-asesmen-prd/{id_data_asesmen_prd}', [SipekaDataAsesmenPrdController::class, 'destroy'])->name('dataAsesmenPrd.destroy');

// Rute untuk Rekap Kecelakaan
Route::get('/index-rekap-kecelakaan', [SipekaRekapKecelakaanController::class, 'index'])->name('rekapKecelakaan.index');
Route::post('/store-rekap-kecelakaan', [SipekaRekapKecelakaanController::class, 'store'])->name('rekapKecelakaan.store');
Route::put('/update-rekap-kecelakaan/{id_rekap_kecelakaan}', [SipekaRekapKecelakaanController::class, 'update'])->name('rekapKecelakaan.update');
Route::delete('/delete-rekap-kecelakaan/{id_rekap_kecelakaan}', [SipekaRekapKecelakaanController::class, 'destroy'])->name('rekapKecelakaan.destroy');

// Rute untuk Data Kecelakaan
Route::get('/index-data-kecelakaan/{id_rekap_kecelakaan}', [SipekaDataKecelakaanController::class, 'index'])->name('dataKecelakaan.index');
Route::post('/store-data-kecelakaan', [SipekaDataKecelakaanController::class, 'store'])->name('dataKecelakaan.store');
Route::put('/update-data-kecelakaan/{id_data_kecelakaan}', [SipekaDataKecelakaanController::class, 'update'])->name('dataKecelakaan.update');
Route::delete('/delete-data-kecelakaan/{id_data_kecelakaan}', [SipekaDataKecelakaanController::class, 'destroy'])->name('dataKecelakaan.destroy');

// Rute untuk Rekap Pelatihan
Route::get('/index-rekap-pelatihan', [SipekaRekapPelatihanController::class, 'index'])->name('rekapPelatihan.index');
Route::post('/store-rekap-pelatihan', [SipekaRekapPelatihanController::class, 'store'])->name('rekapPelatihan.store');
Route::put('/update-rekap-pelatihan/{id_rekap_pelatihan}', [SipekaRekapPelatihanController::class, 'update'])->name('rekapPelatihan.update');
Route::delete('/delete-rekap-pelatihan/{id_rekap_pelatihan}', [SipekaRekapPelatihanController::class, 'destroy'])->name('rekapPelatihan.destroy');

// Rute untuk Data Pelatihan
Route::get('/index-data-pelatihan/{id_rekap_pelatihan}', [SipekaDataPelatihanController::class, 'index'])->name('dataPelatihan.index');
Route::post('/store-data-pelatihan', [SipekaDataPelatihanController::class, 'store'])->name('dataPelatihan.store');
Route::put('/update-data-pelatihan/{id_data_pelatihan}', [SipekaDataPelatihanController::class, 'update'])->name('dataPelatihan.update');
Route::delete('/delete-data-pelatihan/{id_data_pelatihan}', [SipekaDataPelatihanController::class, 'destroy'])->name('dataPelatihan.destroy');

// Rute untuk Rekap Pemenuhan TK
Route::get('/index-rekap-pemenuhan-tk', [SipekaRekapPemenuhanTKController::class, 'index'])->name('rekapPemenuhanTK.index');
Route::post('/store-rekap-pemenuhan-tk', [SipekaRekapPemenuhanTKController::class, 'store'])->name('rekapPemenuhanTK.store');
Route::put('/update-rekap-pemenuhan-tk/{id_rekap_pemenuhan_tk}', [SipekaRekapPemenuhanTKController::class, 'update'])->name('rekapPemenuhanTK.update');
Route::delete('/delete-rekap-pemenuhan-tk/{id_rekap_pemenuhan_tk}', [SipekaRekapPemenuhanTKController::class, 'destroy'])->name('rekapPemenuhanTK.destroy');

// Rute untuk Data Pemenuhan TK
Route::get('/index-data-pemenuhan-tk/{id_rekap_pemenuhan_tk}', [SipekaDataPemenuhanTKController::class, 'index'])->name('dataPemenuhanTK.index');
Route::post('/store-data-pemenuhan-tk', [SipekaDataPemenuhanTKController::class, 'store'])->name('dataPemenuhanTK.store');
Route::put('/update-data-pemenuhan-tk/{id_data_pemenuhan_tk}', [SipekaDataPemenuhanTKController::class, 'update'])->name('dataPemenuhanTK.update');
Route::delete('/delete-data-pemenuhan-tk/{id_data_pemenuhan_tk}', [SipekaDataPemenuhanTKController::class, 'destroy'])->name('dataPemenuhanTK.destroy');