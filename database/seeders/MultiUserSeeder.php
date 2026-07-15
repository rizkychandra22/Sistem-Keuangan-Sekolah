<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MultiUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData =  [
            [
                'name' => 'Admin',
                'email' => 'admin@sekolah.com',
                'username' => 'adminsekolah',
                'role' => 'admin',
                'password' => bcrypt('sekolah')
            ],
            [
                'name' => 'Operator',
                'email' => 'operator@sekolah.com',
                'username' => 'operatorweb',
                'role' => 'operator',
                'password' => bcrypt('sekolah')
            ],
            [
                'name' => 'Keuangan',
                'email' => 'keuangan@sekolah.com',
                'username' => 'bendahara123',
                'role' => 'keuangan',
                'password' => bcrypt('sekolah')
            ],
            [
                'name' => 'Siswa Pertama',
                'email' => 'siswa123@sekolah.com',
                'username' => 'siswa123',
                'role' => 'siswa',
                'password' => bcrypt('sekolah')
            ]
        ];

        foreach ($userData as $val) {
            User::firstOrCreate(
                ['username' => $val['username']],
                $val
            );
        }
    }
}
