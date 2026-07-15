<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ControllerBeritaSekolah;
use App\Http\Controllers\ControllerContact;
use App\Http\Controllers\ControllerGalleryEvent;
use App\Http\Controllers\ControllerGalleryLomba;
use App\Http\Controllers\ControllerGalleryPariwisata;
use App\Http\Controllers\ControllerGalleryPerpisahan;
use App\Http\Controllers\ControllerGuru;
use App\Http\Controllers\ControllerPrestasi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\SambutanController;
    
// Blog
Route::get('/', [HomeController::class, 'index']);
Route::get('/informasi-sekolah', [HomeController::class, 'info']);
Route::get('/search', [HomeController::class, 'search'])->name('search');


// Guest Route
Route::middleware(['guest'])->group(function() {
    // Login
    Route::get('/login', [AuthController::class, 'indexLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    // Register
    Route::get('/register', [AuthController::class, 'indexRegister']);
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});
Route::get('/admin', function() {
    return redirect('/dashboard/admin');
});
Route::get('/operator', function() {
    return redirect('/dashboard/operator');
});

Route::get('/keuangan', function() {
    return redirect('/dashboard/keuangan');
});

Route::get('/home', function() {
    return redirect('/student/home');
});

// Pembatasan Akses Login Setiap Role
Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard/keuangan', [LoginController::class, 'keuangan'])->middleware('userAkses:keuangan');
    Route::get('/dashboard/admin', [LoginController::class, 'admin'])->middleware('userAkses:admin');
    Route::get('/dashboard/operator', [LoginController::class, 'operator'])->middleware('userAkses:operator');
    Route::get('/student/home', [LoginController::class, 'siswa'])->middleware('userAkses:siswa');
    Route::get('/logout', [AuthController::class, 'logout']);
});

// Profile User Siswa
Route::get('/student/home/profile', [LoginController::class, 'profileSiswa'])->middleware('userAkses:siswa')->name('profile.siswa');
Route::get('/student/home/profile/{user}/edit', [LoginController::class, 'editProfileSiswa'])->middleware('userAkses:siswa')->name('profile.edit.siswa');
Route::put('/student/home/profile/{user}', [LoginController::class, 'updateProfileSiswa'])->middleware('userAkses:siswa')->name('profile.update.siswa');

// Profile User Admin
Route::get('/dashboard/admin/profile', [LoginController::class, 'profileAdmin'])->middleware('userAkses:admin')->name('profile.admin');
Route::get('/dashboard/admin/profile/{user}/edit', [LoginController::class, 'editProfileAdmin'])->middleware('userAkses:admin')->name('profile.edit.admin');
Route::put('/dashboard/admin/profile/{user}', [LoginController::class, 'updateProfileAdmin'])->middleware('userAkses:admin')->name('profile.update.admin');

// Profile User Keuangan
Route::get('/dashboard/keuangan/profile', [LoginController::class, 'profileKeuangan'])->middleware('userAkses:keuangan')->name('profile.keuangan');
Route::get('/dashboard/keuangan/profile/{user}/edit', [LoginController::class, 'editProfileKeuangan'])->middleware('userAkses:keuangan')->name('profile.edit.keuangan');
Route::put('/dashboard/keuangan/profile/{user}', [LoginController::class, 'updateProfileKeuangan'])->middleware('userAkses:keuangan')->name('profile.update.keuangan');

// Profile User Operator
Route::get('/dashboard/operator/profile', [LoginController::class, 'profileOperator'])->middleware('userAkses:operator')->name('profile.operator');
Route::get('/dashboard/operator/profile/{user}/edit', [LoginController::class, 'editProfileOperator'])->middleware('userAkses:operator')->name('profile.edit.operator');
Route::put('/dashboard/operator/profile/{user}', [LoginController::class, 'updateProfileOperator'])->middleware('userAkses:operator')->name('profile.update.operator');

// Kirim Pesan 
Route::get('/dashboard/operator/notifikasi', [MessageController::class, 'index'])->name('read')->middleware('userAkses:operator');
Route::post('/', [MessageController::class, 'storeHome'])->name('message.home');
Route::post('/informasi-sekolah', [MessageController::class, 'storeInfo'])->name('message.info');
Route::post('/dashboard/operator/notifikasi/{id}/read', [MessageController::class, 'markAsRead'])->name('messages.read');
Route::delete('/dashboard/operator/notifikasi/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');

// Contact Sekolah
Route::resource('/dashboard/operator/contact-sekolah', ControllerContact::class)->middleware('userAkses:operator');

// Route Resource Keuangan Pemasukan dan Pengeluaran
Route::resource('/dashboard/keuangan/pemasukan', PemasukanController::class)->middleware('userAkses:keuangan');
Route::resource('/dashboard/keuangan/pengeluaran', PengeluaranController::class)->middleware('userAkses:keuangan');
Route::get('/dashboard/keuangan/detail/pemasukan', [PemasukanController::class, 'detail'])->middleware('userAkses:keuangan')->name('detail.pemasukan');
Route::get('/dashboard/keuangan/detail/pengeluaran', [PengeluaranController::class, 'detail'])->middleware('userAkses:keuangan')->name('detail.pengeluaran');

// Rekap Keuangan
Route::get('/dashboard/keuangan/rekap/pemasukan', [RekapController::class, 'indexPemasukan'])->middleware('userAkses:keuangan')->name('rekap.pemasukan');
Route::get('/dashboard/keuangan/rekap/pengeluaran', [RekapController::class, 'indexPengeluaran'])->middleware('userAkses:keuangan')->name('rekap.pengeluaran');
Route::get('/dashboard/keuangan/rekap/transaksi', [RekapController::class, 'rekapTransaksi'])->middleware('userAkses:keuangan')->name('keuangan.rekapTransaksi');

// Ekspor Pemasukan PDF, Excel dan Print
Route::get('/dashboard/keuangan/pemasukan/export/excel', [PemasukanController::class, 'exportExcel'])->name('pemasukan.export.excel');
Route::get('/dashboard/keuangan/pemasukan/export/pdf', [PemasukanController::class, 'exportPDF'])->name('pemasukan.export.pdf');
// Route::get('/dashboard/keuangan/pemasukan/print', [PemasukanController::class, 'print'])->name('pemasukan.print');

// Ekspor Pengeluaran PDF dan Excel
Route::get('/dashboard/keuangan/pengeluaran/export/excel', [PengeluaranController::class, 'exportExcel'])->name('pengeluaran.export.excel');
Route::get('/dashboard/keuangan/pengeluaran/export/pdf', [PengeluaranController::class, 'exportPDF'])->name('pengeluaran.export.pdf');
// Route::get('/dashboard/keuangan/pengeluaran/print', [PengeluaranController::class, 'print'])->name('pengeluaran.print');

// Operator Resource CRUD Data Website
Route::resource('/dashboard/operator/guru', ControllerGuru::class)->middleware('userAkses:operator');
Route::resource('/dashboard/operator/prestasi', ControllerPrestasi::class)->middleware('userAkses:operator');
Route::resource('/dashboard/operator/gallery-lomba', ControllerGalleryLomba::class)->middleware('userAkses:operator');
Route::resource('/dashboard/operator/gallery-event', ControllerGalleryEvent::class)->middleware('userAkses:operator');
Route::resource('/dashboard/operator/gallery-pariwisata', ControllerGalleryPariwisata::class)->middleware('userAkses:operator');
Route::resource('/dashboard/operator/gallery-perpisahan', ControllerGalleryPerpisahan::class)->middleware('userAkses:operator');
Route::resource('/dashboard/operator/sambutan', SambutanController::class)->middleware('userAkses:operator');
Route::resource('/dashboard/operator/program-kerja', ProgramController::class)->middleware('userAkses:operator');
Route::resource('/dashboard/operator/berita-sekolah', ControllerBeritaSekolah::class)->middleware('userAkses:operator');

