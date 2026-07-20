<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MultiUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 30; $i++) {
            $user = User::updateOrCreate(
                ['username' => sprintf('guru%02d', $i)],
                [
                    'name' => sprintf('Guru %02d', $i),
                    'email' => sprintf('guru%02d@sekolah.com', $i),
                    'username' => sprintf('guru%02d', $i),
                    'role' => 'guru',
                    'password' => Hash::make('sekolah'),
                ]
            );

            Guru::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nama' => sprintf('Guru %02d', $i),
                    'user_id' => $user->id,
                    'nip' => sprintf('198700000000%04d', $i),
                    'jabatan' => 'Guru Kelas',
                    'kontak' => sprintf('081200000%04d', $i),
                    'motivasi' => sprintf('Guru %02d siap membimbing siswa untuk terus berkembang.', $i),
                    'gambar' => 'default-guru.png',
                ]
            );
        }

        for ($i = 1; $i <= 180; $i++) {
            $user = User::updateOrCreate(
                ['username' => sprintf('siswa%03d', $i)],
                [
                    'name' => sprintf('Siswa %03d', $i),
                    'email' => sprintf('siswa%03d@sekolah.com', $i),
                    'username' => sprintf('siswa%03d', $i),
                    'role' => 'siswa',
                    'password' => Hash::make('sekolah'),
                ]
            );

            Siswa::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'user_id' => $user->id,
                    'nisn' => sprintf('202600000%03d', $i),
                    'nama' => sprintf('Siswa %03d', $i),
                    'tgl_lhr' => now()->subYears(10)->subDays($i)->toDateString(),
                    'alamat' => sprintf('Alamat siswa %03d', $i),
                    'orang_tua' => sprintf('Orang Tua Siswa %03d', $i),
                    'kontak_orang_tua' => sprintf('081300000%04d', $i),
                    'status_akademik' => 'aktif',
                    'is_active' => true,
                ]
            );
        }
    }
}
