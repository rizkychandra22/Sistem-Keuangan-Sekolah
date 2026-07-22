<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 6) as $tingkat) {
            Kelas::updateOrCreate(
                ['tingkat' => $tingkat],
                [
                    'nama' => sprintf('Kelas %d', $tingkat),
                    'deskripsi' => sprintf('Master tingkat kelas %d', $tingkat),
                ]
            );
        }
    }
}
