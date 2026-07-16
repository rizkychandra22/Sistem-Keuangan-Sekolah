<?php

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
use App\Http\Controllers\Users\DashboardController;
use App\Http\Controllers\Users\ProfileController;

// Guest Route Web
Route::middleware(['guest'])->group(function() {

    // Blog Website Sekolah
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/informasi-sekolah', [HomeController::class, 'info']);
    Route::get('/search', [HomeController::class, 'search'])->name('search');
    Route::post('/', [MessageController::class, 'storeHome'])->name('message.home');
    Route::post('/informasi-sekolah', [MessageController::class, 'storeInfo'])->name('message.info');

    // Login
    Route::get('/login', [AuthController::class, 'indexLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'indexRegister']);
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Route Redirect User
Route::get('/admin', function() {
    return redirect('/dashboard/admin');
});
Route::get('/operator', function() {
    return redirect('/dashboard/operator');
});
Route::get('/keuangan', function() {
    return redirect('/dashboard/keuangan');
});
Route::get('/guru', function() {
    return redirect('/teacher/home');
});
Route::get('/home', function() {
    return redirect('/student/home');
});

// Index Dashboard Setiap Role User 
Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->middleware('userAkses:admin');
    Route::get('/dashboard/keuangan', [DashboardController::class, 'keuangan'])->middleware('userAkses:keuangan');
    Route::get('/dashboard/operator', [DashboardController::class, 'operator'])->middleware('userAkses:operator');
    Route::get('/teacher/home', [DashboardController::class, 'guru'])->middleware('userAkses:guru');
    Route::get('/student/home', [DashboardController::class, 'siswa'])->middleware('userAkses:siswa');
    Route::get('/logout', [AuthController::class, 'logout']);
});

// Route Role User Admin
Route::middleware(['userAkses:admin'])->group(function() {

    // Profile User Admin
    Route::get('/dashboard/admin/profile', [ProfileController::class, 'profileAdmin'])->name('profile.admin');
    Route::get('/dashboard/admin/profile/{user}/edit', [ProfileController::class, 'editProfileAdmin'])->name('profile.edit.admin');
    Route::put('/dashboard/admin/profile/{user}', [ProfileController::class, 'updateProfileAdmin'])->name('profile.update.admin');
});

// Route Role User Keuangan
Route::middleware(['userAkses:keuangan'])->group(function() {
    
    // Profile User Keuangan
    Route::get('/dashboard/keuangan/profile', [ProfileController::class, 'profileKeuangan'])->name('profile.keuangan');
    Route::get('/dashboard/keuangan/profile/{user}/edit', [ProfileController::class, 'editProfileKeuangan'])->name('profile.edit.keuangan');
    Route::put('/dashboard/keuangan/profile/{user}', [ProfileController::class, 'updateProfileKeuangan'])->name('profile.update.keuangan');

    // Route CRUD Resource Keuangan Pemasukan dan Pengeluaran
    Route::resource('/dashboard/keuangan/pemasukan', PemasukanController::class)->middleware('userAkses:keuangan');
    Route::resource('/dashboard/keuangan/pengeluaran', PengeluaranController::class)->middleware('userAkses:keuangan');

    // Rekap Keuangan
    Route::get('/dashboard/keuangan/detail/pemasukan', [PemasukanController::class, 'detail'])->middleware('userAkses:keuangan')->name('detail.pemasukan');
    Route::get('/dashboard/keuangan/detail/pengeluaran', [PengeluaranController::class, 'detail'])->middleware('userAkses:keuangan')->name('detail.pengeluaran');
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
});

// Route Role User Operator
Route::middleware(['userAkses:operator'])->group(function() {

    // Profile User Operator
    Route::get('/dashboard/operator/profile', [ProfileController::class, 'profileOperator'])->name('profile.operator');
    Route::get('/dashboard/operator/profile/{user}/edit', [ProfileController::class, 'editProfileOperator'])->name('profile.edit.operator');
    Route::put('/dashboard/operator/profile/{user}', [ProfileController::class, 'updateProfileOperator'])->name('profile.update.operator');

    // Notifikasi Kirim Pesan 
    Route::get('/dashboard/operator/notifikasi', [MessageController::class, 'index'])->name('read');
    Route::post('/dashboard/operator/notifikasi/{id}/read', [MessageController::class, 'markAsRead'])->name('messages.read');
    Route::delete('/dashboard/operator/notifikasi/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // Operator Resource CRUD Data Website
    Route::resource('/dashboard/operator/guru', ControllerGuru::class);
    Route::resource('/dashboard/operator/prestasi', ControllerPrestasi::class);
    Route::resource('/dashboard/operator/gallery-lomba', ControllerGalleryLomba::class);
    Route::resource('/dashboard/operator/gallery-event', ControllerGalleryEvent::class);
    Route::resource('/dashboard/operator/gallery-pariwisata', ControllerGalleryPariwisata::class);
    Route::resource('/dashboard/operator/gallery-perpisahan', ControllerGalleryPerpisahan::class);
    Route::resource('/dashboard/operator/sambutan', SambutanController::class);
    Route::resource('/dashboard/operator/program-kerja', ProgramController::class);
    Route::resource('/dashboard/operator/berita-sekolah', ControllerBeritaSekolah::class);

    // Informasi Contact Sekolah
    Route::resource('/dashboard/operator/contact-sekolah', ControllerContact::class);
});

// Route Role User Guru
Route::middleware(['userAkses:guru'])->group(function() {

    // Profile User Guru
    Route::get('/teacher/home/profile', [ProfileController::class, 'profileGuru'])->name('profile.guru');
    Route::get('/teacher/home/profile/{user}/edit', [ProfileController::class, 'editProfileGuru'])->name('profile.edit.guru');
    Route::put('/teacher/home/profile/{user}', [ProfileController::class, 'updateProfileGuru'])->name('profile.update.guru');
});

// Route Role User Siswa
Route::middleware(['userAkses:siswa'])->group(function() {

    // Profile User Siswa
    Route::get('/student/home/profile', [ProfileController::class, 'profileSiswa'])->name('profile.siswa');
    Route::get('/student/home/profile/{user}/edit', [ProfileController::class, 'editProfileSiswa'])->name('profile.edit.siswa');
    Route::put('/student/home/profile/{user}', [ProfileController::class, 'updateProfileSiswa'])->name('profile.update.siswa');
});

