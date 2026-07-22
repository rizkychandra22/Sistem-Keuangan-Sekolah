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
                'name' => 'Admin System',
                'email' => 'admin@sekolah.com',
                'username' => 'admincore',
                'role' => 'admin',
                'password' => Hash::make('sekolah'),
            ],
            [
                'name' => 'Operator System',
                'email' => 'operator@sekolah.com',
                'username' => 'operatorcore',
                'role' => 'operator',
                'password' => Hash::make('sekolah'),
            ],
            [
                'name' => 'Keuangan System',
                'email' => 'finance@sekolah.com',
                'username' => 'financecore',
                'role' => 'finance',
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
