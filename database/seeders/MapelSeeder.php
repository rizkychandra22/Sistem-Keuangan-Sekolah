<?php

namespace Database\Seeders;

use App\Models\Kurikulum;
use App\Models\Mapel;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    public function run(): void
    {
        $kurikulumMerdeka = Kurikulum::query()
            ->where('nama', 'Kurikulum Merdeka')
            ->where('tahun', '2022')
            ->firstOrFail();

        $kurikulumK13 = Kurikulum::query()
            ->where('nama', 'Kuritilas')
            ->where('tahun', '2013')
            ->firstOrFail();

        $kurikulumKtsp = Kurikulum::query()
            ->where('nama', 'KTSP')
            ->where('tahun', '2006')
            ->firstOrFail();

        $daftarMapel = [
            ['nama' => 'Ilmu Pengetahuan Sosial', 'kode' => 'IPS', 'kurikulum_id' => $kurikulumK13->id],
            ['nama' => 'Ilmu Pengetahuan Alam', 'kode' => 'IPA', 'kurikulum_id' => $kurikulumK13->id],
            ['nama' => 'Pendidikan Agama Islam', 'kode' => 'PAI', 'kurikulum_id' => $kurikulumKtsp->id],
            ['nama' => 'Pendidikan Jasmani', 'kode' => 'PJK', 'kurikulum_id' => $kurikulumKtsp->id],
            ['nama' => 'Bahasa Inggris', 'kode' => 'BEN', 'kurikulum_id' => $kurikulumMerdeka->id],
            ['nama' => 'Bahasa Indonesia', 'kode' => 'BIN', 'kurikulum_id' => $kurikulumMerdeka->id],
            ['nama' => 'Matematika', 'kode' => 'MTK', 'kurikulum_id' => $kurikulumK13->id],
            ['nama' => 'Seni Budaya', 'kode' => 'SBD', 'kurikulum_id' => $kurikulumKtsp->id],
        ];

        foreach (range(1, 6) as $tingkat) {
            foreach ($daftarMapel as $mapel) {
                Mapel::updateOrCreate(
                    ['kode' => $mapel['kode'] . $tingkat],
                    [
                        'nama' => $mapel['nama'] . ' ' . $tingkat,
                        'kode' => $mapel['kode'] . $tingkat,
                        'kurikulum_id' => $mapel['kurikulum_id'],
                    ]
                );
            }
        }
    }
}
