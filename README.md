# Sistem Informasi Sekolah

Project ini adalah aplikasi web berbasis Laravel untuk kebutuhan operasional sekolah yang mencakup:

- manajemen akun pengguna
- manajemen data guru dan siswa
- manajemen akademik berbasis rombel
- dashboard multi role
- manajemen konten website sekolah
- pencatatan dan rekap keuangan sekolah

Saat ini aplikasi tidak lagi hanya berfokus pada keuangan, tetapi sudah berkembang menjadi sistem sekolah yang menggabungkan modul administrasi, akademik, website profil sekolah, dan keuangan dalam satu project.

## Fitur Utama

### 1. Manajemen Pengguna

- CRUD akun user oleh admin
- role akun: `admin`, `operator`, `finance`, `teacher`, `student`
- password default akun yang dibuat admin: `sekolah`
- akun `admin`, `operator`, dan `finance` diperlakukan sebagai akun inti sistem

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

## Role dan Akses

### Admin

Admin mengelola data inti sistem:

- akun user
- guru
- siswa
- kurikulum
- mapel
- kelas
- tahun ajaran
- rombel
- siswa rombel
- guru mapel

### Operator

Operator mengelola konten website sekolah:

- sambutan
- program kerja
- berita
- galeri
- prestasi
- contact sekolah
- pesan masuk dari website

### Finance

Finance mengelola modul keuangan:

- pemasukan
- pengeluaran
- rekap transaksi
- export laporan

### Teacher

Teacher menggunakan dashboard guru. Secara struktur data, guru dapat memiliki:

- relasi wali kelas melalui `rombels.guru_id`
- relasi pengampu mata pelajaran melalui tabel `guru_mapels`

### Student

Student menggunakan dashboard siswa dan data profil siswa.

## Konsep Data Akademik

Struktur akademik project saat ini sudah menggunakan pendekatan yang lebih dinamis:

- `kelas` menyimpan master tingkat kelas, misalnya Kelas 1 sampai Kelas 6
- `tahun_ajarans` menyimpan periode akademik berdasarkan `tahun` dan `semester`
- `rombels` menyimpan kelas operasional per periode, misalnya Kelas 3A pada semester tertentu
- `siswa_rombels` menyimpan riwayat penempatan siswa ke rombel
- `guru_mapels` menyimpan penugasan guru mengajar mapel pada rombel tertentu

Keuntungan pendekatan ini:

- histori siswa per semester tetap tersimpan
- rombel bisa berubah setiap periode tanpa mengubah master kelas
- guru bisa mengampu lebih dari satu mapel dan lebih dari satu rombel
- wali kelas terikat pada rombel, bukan pada master kelas

## Seeder Data Dummy

Seeder bawaan project saat ini akan membuat data awal berikut:

- 1 akun `admin`
- 1 akun `operator`
- 1 akun `finance`
- 30 akun `teacher` beserta data guru
- 180 akun `student` beserta data siswa
- master kelas 1 sampai 6
- tahun ajaran `2024/2025` dan `2025/2026`
- semester `ganjil` dan `genap`
- rombel sesuai struktur di `AcademicSeederData`
- relasi siswa ke rombel aktif dan riwayat semester
- data awal `contact sekolah` dan `sambutan`

## Akun Default Seeder

### Akun inti sistem

- Admin
  - username: `admincore`
  - email: `admin@sekolah.com`
  - password: `sekolah`
- Operator
  - username: `operatorcore`
  - email: `operator@sekolah.com`
  - password: `sekolah`
- Finance
  - username: `financecore`
  - email: `finance@sekolah.com`
  - password: `sekolah`

### Contoh akun guru

- username: `guru01`
- password: `sekolah`

### Contoh akun siswa

- username: `siswa001`
- password: `sekolah`

## Teknologi yang Digunakan

| Komponen | Teknologi |
| --- | --- |
| Backend | Laravel 11 |
| PHP | 8.2 atau 8.3 |
| Frontend | Blade, Bootstrap 4, AdminLTE |
| Build Tool | Vite |
| Database | MySQL atau SQLite |
| Alert | realrashid/sweet-alert |
| Table | yajra/laravel-datatables |
| Export Excel | maatwebsite/excel |
| Export PDF | barryvdh/laravel-dompdf |

## Instalasi Project

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

Jika Anda memakai Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

### 4. Atur koneksi database

Project bisa dijalankan dengan MySQL atau SQLite.

Jika memakai SQLite:

```bash
type nul > database/database.sqlite
```

Lalu sesuaikan `.env`, misalnya:

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Jika memakai MySQL, ubah kredensial database di `.env` sesuai server lokal Anda.

### 5. Generate app key

```bash
php artisan key:generate
```

### 6. Jalankan migrasi dan seeder

```bash
php artisan migrate:fresh --seed
```

### 7. Jalankan Vite dan server Laravel

Terminal 1:

```bash
npm run dev
```

Terminal 2:

```bash
php artisan serve
```

## Perintah Yang Sering Dipakai

### Menjalankan seeder inti sistem saja

```bash
php artisan db:seed --class=CoreAccountSeeder
```

### Menjalankan seluruh seeder

```bash
php artisan db:seed
```

### Reset database lalu isi ulang data dummy

```bash
php artisan migrate:fresh --seed
```

### Melihat daftar route

```bash
php artisan route:list
```

## Alur Login

Setelah login, user akan diarahkan otomatis sesuai role:

- `admin` -> `/dashboard/admin`
- `operator` -> `/dashboard/operator`
- `finance` -> `/dashboard/keuangan`
- `teacher` -> `/teacher/home`
- `student` -> `/student/home`

## Catatan Implementasi Saat Ini

- modul akademik sudah memakai pendekatan `kelas -> rombel -> siswa_rombel`
- pengampu mata pelajaran dikelola melalui tabel `guru_mapels`, bukan lagi langsung di tabel `mapels`
- kolom wali kelas berada pada tabel `rombels`
- histori perpindahan siswa antar rombel disimpan di `siswa_rombels`
- halaman register publik saat ini membuat akun baru dengan role `student`

## Struktur Folder Penting

- `app/Http/Controllers` : controller aplikasi
- `app/Models` : model Eloquent
- `database/migrations` : struktur database
- `database/seeders` : data awal project
- `resources/views` : Blade views
- `resources/css` : stylesheet utama
- `routes/web.php` : route aplikasi web

## Pengembang

Project ini dikembangkan oleh:

- Rizky Chandra Khusuma

Jika README ini akan dipakai untuk presentasi, portfolio, atau repository publik, Anda masih bisa menambahkan:

- screenshot dashboard
- ERD atau diagram relasi database
- daftar fitur yang sedang dikembangkan
- panduan deployment ke shared hosting atau VPS
