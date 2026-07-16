<?php

namespace Database\Seeders;

use App\Models\Sambutan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SambutanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sambutan::create([
            'nama' => 'Paiman Raechamt Afandi M.PD',
            'deskripsi' => 'Assalamualaikum bapak ibu wali murid saya mengucapkan terima kasih atas kepercayaan anda untuk mendidik anak anda di sekolah SDN 1 Caringin Ngumbang',
            'gambar' => 'user-1752719006.jpg'
        ]);
    }
}
