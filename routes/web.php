<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Import Routing Master Data
use App\Http\Controllers\Admin\Manages\ControllerGuru;
use App\Http\Controllers\Admin\Manages\ControllerUser;
// Import Routing Web Profile Sekolah
use App\Http\Controllers\Blog\HomeController;
use App\Http\Controllers\Blog\Manages\ControllerBeritaSekolah;
use App\Http\Controllers\Blog\Manages\ControllerContact;
use App\Http\Controllers\Blog\Manages\ControllerGalleryEvent;
use App\Http\Controllers\Blog\Manages\ControllerGalleryLomba;
use App\Http\Controllers\Blog\Manages\ControllerGalleryPariwisata;
use App\Http\Controllers\Blog\Manages\ControllerGalleryPerpisahan;
use App\Http\Controllers\Blog\Manages\ControllerPrestasi;
use App\Http\Controllers\Blog\Manages\MessageController;
use App\Http\Controllers\Blog\Manages\ProgramController;
use App\Http\Controllers\Blog\Manages\SambutanController;

// Import Routing Finance
use App\Http\Controllers\Finance\PemasukanController;
use App\Http\Controllers\Finance\PengeluaranController;
use App\Http\Controllers\Finance\RekapController;

// Import Routing User
use App\Http\Controllers\Users\DashboardController;
use App\Http\Controllers\Users\ProfileController;

// Route Blog Website Sekolah
Route::get('/', [HomeController::class, 'index']);
Route::get('/informasi-sekolah', [HomeController::class, 'info']);
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::post('/', [MessageController::class, 'storeHome'])->name('message.home');
Route::post('/informasi-sekolah', [MessageController::class, 'storeInfo'])->name('message.info');

// Route Guest
Route::middleware(['guest'])->group(function() {
    // Route Login
    Route::get('/login', [AuthController::class, 'indexLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Route Register
    Route::get('/register', [AuthController::class, 'indexRegister']);
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Route Logout
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth' );

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

// Route Role User Admin
Route::middleware(['userAkses:admin'])->group(function() {
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');

    // Profile User Admin
    Route::get('/dashboard/admin/profile', [ProfileController::class, 'profileAdmin'])->name('profile.admin');
    Route::get('/dashboard/admin/profile/{user}/edit', [ProfileController::class, 'editProfileAdmin'])->name('profile.edit.admin');
    Route::put('/dashboard/admin/profile/{user}', [ProfileController::class, 'updateProfileAdmin'])->name('profile.update.admin');

    // Route CRUD Data User
    Route::get('/dashboard/admin/data/users', [ControllerUser::class, 'index'])->name('dataUser.index');
    Route::get('/dashboard/admin/data/users/create', [ControllerUser::class, 'create'])->name('dataUser.create');
    Route::post('/dashboard/admin/data/users', [ControllerUser::class, 'store'])->name('dataUser.store');
    Route::get('/dashboard/admin/data/users/{user}/edit', [ControllerUser::class, 'edit'])->name('dataUser.edit');
    Route::put('/dashboard/admin/data/users/{user}', [ControllerUser::class, 'update'])->name('dataUser.update');
    Route::delete('/dashboard/admin/data/users/{user}', [ControllerUser::class, 'destroy'])->name('dataUser.destroy');

    // Admin Resource CRUD Master Data
    Route::resource('/dashboard/admin/guru', ControllerGuru::class);
});

// Route Role User Keuangan
Route::middleware(['userAkses:keuangan'])->group(function() {
    Route::get('/dashboard/keuangan', [DashboardController::class, 'keuangan'])->name('dashboard.keuangan');
    
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
    Route::get('/dashboard/operator', [DashboardController::class, 'operator'])->name('dashboard.operator');

    // Profile User Operator
    Route::get('/dashboard/operator/profile', [ProfileController::class, 'profileOperator'])->name('profile.operator');
    Route::get('/dashboard/operator/profile/{user}/edit', [ProfileController::class, 'editProfileOperator'])->name('profile.edit.operator');
    Route::put('/dashboard/operator/profile/{user}', [ProfileController::class, 'updateProfileOperator'])->name('profile.update.operator');

    // Notifikasi Kirim Pesan 
    Route::get('/dashboard/operator/notifikasi', [MessageController::class, 'index'])->name('read');
    Route::post('/dashboard/operator/notifikasi/{id}/read', [MessageController::class, 'markAsRead'])->name('messages.read');
    Route::delete('/dashboard/operator/notifikasi/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // Operator Resource CRUD Data Website
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
    Route::get('/teacher/home', [DashboardController::class, 'guru']);

    // Profile User Guru
    Route::get('/teacher/home/profile', [ProfileController::class, 'profileGuru'])->name('profile.guru');
    Route::get('/teacher/home/profile/{user}/edit', [ProfileController::class, 'editProfileGuru'])->name('profile.edit.guru');
    Route::put('/teacher/home/profile/{user}', [ProfileController::class, 'updateProfileGuru'])->name('profile.update.guru');
});

// Route Role User Siswa
Route::middleware(['userAkses:siswa'])->group(function() {
    Route::get('/student/home', [DashboardController::class, 'siswa']);
    
    // Profile User Siswa
    Route::get('/student/home/profile', [ProfileController::class, 'profileSiswa'])->name('profile.siswa');
    Route::get('/student/home/profile/{user}/edit', [ProfileController::class, 'editProfileSiswa'])->name('profile.edit.siswa');
    Route::put('/student/home/profile/{user}', [ProfileController::class, 'updateProfileSiswa'])->name('profile.update.siswa');
});
