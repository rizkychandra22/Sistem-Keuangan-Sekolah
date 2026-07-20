<?php

namespace Database\Seeders;

use App\Models\Kurikulum;
use Illuminate\Database\Seeder;

class KurikulumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kurikulums = [
            [
                'nama' => 'Kurikulum 2013',
                'tahun' => '2013',
                'deskripsi' => 'Kurikulum nasional yang menekankan keseimbangan sikap, pengetahuan, dan keterampilan.',
            ],
            [
                'nama' => 'Kurikulum Merdeka',
                'tahun' => '2022',
                'deskripsi' => 'Kurikulum dengan pembelajaran yang lebih fleksibel dan berfokus pada penguatan kompetensi serta karakter.',
            ],
            [
                'nama' => 'KTSP',
                'tahun' => '2006',
                'deskripsi' => 'Kurikulum Tingkat Satuan Pendidikan yang memberi keleluasaan sekolah menyusun pembelajaran.',
            ],
        ];

        foreach ($kurikulums as $kurikulum) {
            Kurikulum::updateOrCreate(
                [
                    'nama' => $kurikulum['nama'],
                    'tahun' => $kurikulum['tahun'],
                ],
                $kurikulum
            );
        }
    }
}
