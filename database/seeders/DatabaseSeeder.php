<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CoreAccountSeeder::class,
            MultiUserSeeder::class,
            KurikulumSeeder::class,
            KelasSeeder::class,
            TahunAjaranSeeder::class,
            RombelSeeder::class,
            SiswaRombelSeeder::class,
            ContactSeeder::class,
            SambutanSeeder::class,
        ]);
    }
}
