<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MultiUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jumlahGuru = collect(AcademicSeederData::strukturRombel()['2025/2026'])
            ->sum(fn (array $paralels) => count($paralels));

        $jumlahSiswa = $jumlahGuru * 10;

        for ($i = 1; $i <= $jumlahGuru; $i++) {
            $nomorGuru = str_pad((string) $i, 2, '0', STR_PAD_LEFT);

            $user = User::updateOrCreate(
                ['username' => sprintf('guru%s', $nomorGuru)],
                [
                    'name' => sprintf('Guru %s S.Pd', $nomorGuru),
                    'email' => sprintf('guru%s@sekolah.com', $nomorGuru),
                    'username' => sprintf('guru%s', $nomorGuru),
                    'role' => 'teacher',
                    'password' => Hash::make('sekolah'),
                ]
            );

            Guru::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nama' => sprintf('Guru %s S.Pd', $nomorGuru),
                    'user_id' => $user->id,
                    'nip' => sprintf('2130511%03d', $i),
                    'jabatan' => $i % 3 === 0 ? 'Guru Wali' : 'Guru Pengajar',
                    'kontak' => sprintf('082130511%03d', $i),
                    'motivasi' => 'Saya siap mengajar siswa untuk mencerdaskan anak bangsa',
                    'gambar' => 'default-guru.png',
                ]
            );
        }

        for ($i = 1; $i <= $jumlahSiswa; $i++) {
            $nomorSiswa = str_pad((string) $i, 2, '0', STR_PAD_LEFT);

            $user = User::updateOrCreate(
                ['username' => sprintf('siswa%03d', $i)],
                [
                    'name' => sprintf('Siswa %s', $nomorSiswa),
                    'email' => sprintf('siswa%03d@sekolah.com', $i),
                    'username' => sprintf('siswa%03d', $i),
                    'role' => 'student',
                    'password' => Hash::make('sekolah'),
                ]
            );

            Siswa::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'user_id' => $user->id,
                    'nisn' => sprintf('2030511%03d', $i),
                    'nama' => sprintf('Siswa %s', $nomorSiswa),
                    'tgl_lhr' => Carbon::create(2026, 7, 1)->toDateString(),
                    'alamat' => sprintf('Alamat Siswa %s', $nomorSiswa),
                    'orang_tua' => sprintf('Orang Tua %s', $nomorSiswa),
                    'kontak_orang_tua' => sprintf('082030511%03d', $i),
                    'status_akademik' => 'aktif',
                    'is_active' => true,
                ]
            );
        }
    }
}
