<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CoreAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'Admin',
                'email' => 'admin@sekolah.com',
                'username' => 'adminsekolah',
                'role' => 'admin',
                'password' => Hash::make('sekolah'),
            ],
            [
                'name' => 'Operator',
                'email' => 'operator@sekolah.com',
                'username' => 'operatorweb',
                'role' => 'operator',
                'password' => Hash::make('sekolah'),
            ],
            [
                'name' => 'Keuangan',
                'email' => 'keuangan@sekolah.com',
                'username' => 'bendahara123',
                'role' => 'keuangan',
                'password' => Hash::make('sekolah'),
            ],
        ];

        foreach ($userData as $val) {
            User::updateOrCreate(
                ['username' => $val['username']],
                $val
            );
        }
    }
}
