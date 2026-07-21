<p align="center">
  <h1 align="center">Sistem Informasi Sekolah</h1>
  <p align="center">
    Aplikasi web berbasis Laravel untuk manajemen akademik, website sekolah, dan keuangan dalam satu sistem.
  </p>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-red" alt="Laravel 11">
  <img src="https://img.shields.io/badge/PHP-8.2%20%7C%208.3-blue" alt="PHP 8.2 or 8.3">
  <img src="https://img.shields.io/badge/Frontend-Blade%20%2B%20Bootstrap%204-green" alt="Blade Bootstrap 4">
  <img src="https://img.shields.io/badge/Build-Vite-646CFF" alt="Vite">
  <img src="https://img.shields.io/badge/Status-Active-success" alt="Active">
</p>

## Ringkasan

Project ini adalah sistem informasi sekolah yang menggabungkan beberapa kebutuhan operasional sekolah dalam satu aplikasi, meliputi:

- manajemen akun pengguna
- manajemen data guru dan siswa
- manajemen akademik berbasis kelas, rombel, dan penempatan siswa
- dashboard multi role
- manajemen konten website sekolah
- pencatatan dan rekap keuangan sekolah

Saat ini project sudah berkembang dari sistem pencatatan keuangan menjadi sistem sekolah yang lebih lengkap dan terintegrasi.

## Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Role dan Hak Akses](#role-dan-hak-akses)
- [Struktur Akademik](#struktur-akademik)
- [Seeder dan Data Dummy](#seeder-dan-data-dummy)
- [Akun Default](#akun-default)
- [Teknologi](#teknologi)
- [Instalasi](#instalasi)
- [Perintah Penting](#perintah-penting)
- [Alur Login](#alur-login)
- [Struktur Folder](#struktur-folder)
- [Pengembang](#pengembang)

## Fitur Utama

### 1. Manajemen Pengguna

- CRUD akun user oleh admin
- role akun: `admin`, `operator`, `finance`, `teacher`, `student`
- password default akun yang dibuat admin: `sekolah`
- pembatasan role inti sistem untuk akun tertentu

### 2. Manajemen Data Sekolah

- CRUD data guru
- CRUD data siswa
- sinkronisasi data profil dengan akun user
- upload gambar profil guru dan siswa

### 3. Manajemen Akademik

- CRUD kurikulum
- CRUD mata pelajaran
- CRUD kelas master
- CRUD tahun ajaran per semester
- CRUD rombel
- CRUD siswa rombel
- CRUD guru mapel

### 4. Website Profil Sekolah

- sambutan
- program kerja
- berita sekolah
- prestasi
- galeri lomba
- galeri event
- galeri pariwisata
- galeri perpisahan
- contact sekolah
- pesan dari halaman publik

### 5. Manajemen Keuangan

- CRUD pemasukan
- CRUD pengeluaran
- rekap pemasukan
- rekap pengeluaran
- rekap transaksi
- export Excel
- export PDF

## Role dan Hak Akses

| Role | Area Utama |
| --- | --- |
| `admin` | Mengelola akun user, guru, siswa, kurikulum, mapel, kelas, tahun ajaran, rombel, siswa rombel, dan guru mapel |
| `operator` | Mengelola konten website sekolah, contact, dan pesan dari halaman publik |
| `finance` | Mengelola pemasukan, pengeluaran, rekap transaksi, dan export laporan |
| `teacher` | Mengakses dashboard guru, data profil, dan relasi akademik sesuai penugasan |
| `student` | Mengakses dashboard siswa dan data profil siswa |

## Struktur Akademik

Project ini menggunakan struktur akademik yang lebih dinamis agar histori data tetap aman dan pengelolaan kelas lebih fleksibel.

### Entitas utama

- `kelas`
  Menyimpan master tingkat kelas, misalnya Kelas 1 sampai Kelas 6.
- `tahun_ajarans`
  Menyimpan periode akademik berdasarkan kombinasi tahun dan semester.
- `rombels`
  Menyimpan kelas operasional per periode, misalnya Kelas 3A pada semester tertentu.
- `siswa_rombels`
  Menyimpan penempatan dan riwayat siswa dalam rombel.
- `guru_mapels`
  Menyimpan penugasan guru mengajar mapel pada rombel tertentu.

### Keuntungan struktur ini

- histori siswa per semester tetap tersimpan
- rombel dapat berubah tiap periode tanpa mengubah master kelas
- guru dapat mengampu lebih dari satu mapel dan lebih dari satu rombel
- wali kelas terikat pada rombel, bukan pada master kelas
- pengampu mata pelajaran tidak lagi dobel di tabel `mapels`

## Seeder dan Data Dummy

Seeder bawaan project akan membuat data awal berikut:

- 1 akun `admin`
- 1 akun `operator`
- 1 akun `finance`
- 30 akun `teacher` beserta data guru
- 180 akun `student` beserta data siswa
- master kelas 1 sampai 6
- tahun ajaran `2024/2025` dan `2025/2026`
- semester `ganjil` dan `genap`
- rombel sesuai struktur pada `AcademicSeederData`
- riwayat dan data aktif siswa pada `siswa_rombels`
- data awal `contact sekolah` dan `sambutan`

## Akun Default

### Akun inti sistem

| Role | Username | Email | Password |
| --- | --- | --- | --- |
| Admin | `admincore` | `admin@sekolah.com` | `sekolah` |
| Operator | `operatorcore` | `operator@sekolah.com` | `sekolah` |
| Finance | `financecore` | `finance@sekolah.com` | `sekolah` |

### Contoh akun dummy

- Guru
  - username: `guru01`
  - password: `sekolah`
- Siswa
  - username: `siswa001`
  - password: `sekolah`

## Teknologi

| Komponen | Teknologi |
| --- | --- |
| Backend | Laravel 11 |
| PHP | 8.2 atau 8.3 |
| Frontend | Blade, Bootstrap 4, AdminLTE |
| Build Tool | Vite |
| Database | MySQL atau SQLite |
| Alert | `realrashid/sweet-alert` |
| Data Table | `yajra/laravel-datatables` |
| Export Excel | `maatwebsite/excel` |
| Export PDF | `barryvdh/laravel-dompdf` |

## Instalasi

### 1. Clone repository

```bash
git clone https://github.com/rizkychandra22/Sistem-Keuangan-Sekolah.git
cd Sistem-Keuangan-Sekolah
```

### 2. Install dependency

```bash
composer install
npm install
```

### 3. Siapkan file environment

```bash
cp .env.example .env
```

Untuk PowerShell:

```powershell
Copy-Item .env.example .env
```

### 4. Atur koneksi database

Project dapat dijalankan dengan MySQL atau SQLite.

Jika memakai SQLite:

```bash
type nul > database/database.sqlite
```

Contoh konfigurasi `.env`:

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Jika memakai MySQL, sesuaikan kredensial database di `.env`.

### 5. Generate application key

```bash
php artisan key:generate
```

### 6. Migrasi dan isi data awal

```bash
php artisan migrate:fresh --seed
```

### 7. Jalankan aplikasi

Terminal 1:

```bash
npm run dev
```

Terminal 2:

```bash
php artisan serve
```

## Perintah Penting

### Menjalankan seeder inti sistem saja

```bash
php artisan db:seed --class=CoreAccountSeeder
```

### Menjalankan seluruh seeder

```bash
php artisan db:seed
```

### Reset database dan isi ulang data dummy

```bash
php artisan migrate:fresh --seed
```

### Menampilkan daftar route

```bash
php artisan route:list
```

## Alur Login

Setelah login, user diarahkan otomatis sesuai role:

- `admin` -> `/dashboard/admin`
- `operator` -> `/dashboard/operator`
- `finance` -> `/dashboard/keuangan`
- `teacher` -> `/teacher/home`
- `student` -> `/student/home`

## Catatan Implementasi Saat Ini

- modul akademik sudah memakai pendekatan `kelas -> rombel -> siswa_rombel`
- pengampu mata pelajaran dikelola melalui tabel `guru_mapels`
- kolom wali kelas berada pada tabel `rombels`
- histori perpindahan siswa disimpan di `siswa_rombels`
- halaman register publik saat ini membuat akun baru dengan role `student`

## Struktur Folder

| Folder | Keterangan |
| --- | --- |
| `app/Http/Controllers` | Controller aplikasi |
| `app/Models` | Model Eloquent |
| `database/migrations` | Struktur database |
| `database/seeders` | Data awal project |
| `resources/views` | Blade views |
| `resources/css` | Stylesheet utama |
| `routes/web.php` | Route aplikasi web |

## Pengembang

Project ini dikembangkan oleh:

- Rizky Chandra Khusuma

Jika README ini ingin dibuat lebih lengkap lagi untuk repository publik, Anda masih bisa menambahkan:

- screenshot dashboard
- ERD atau diagram relasi database
- flow bisnis sistem akademik
- panduan deployment ke hosting atau VPS
