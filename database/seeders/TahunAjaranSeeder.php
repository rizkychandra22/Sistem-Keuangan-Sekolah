<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (array_keys(AcademicSeederData::strukturRombel()) as $tahun) {
            foreach (['ganjil', 'genap'] as $semester) {
                TahunAjaran::updateOrCreate(
                    ['tahun' => $tahun, 'semester' => $semester],
                    [
                        'is_active' => $tahun === '2025/2026' && $semester === 'genap',
                        'is_locked' => $tahun === '2024/2025',
                    ]
                );
            }
        }
    }
}
