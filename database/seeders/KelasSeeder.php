<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guruIds = Guru::query()->pluck('id')->shuffle()->take(18)->values();
        $index = 0;

        for ($tingkat = 1; $tingkat <= 6; $tingkat++) {
            foreach (['A', 'B', 'C'] as $rombel) {
                Kelas::updateOrCreate(
                    ['kode' => sprintf('SDK%d%s', $tingkat, $rombel)],
                    [
                        'nama' => sprintf('Kelas %d%s', $tingkat, $rombel),
                        'kode' => sprintf('SDK%d%s', $tingkat, $rombel),
                        'guru_id' => $guruIds[$index],
                    ]
                );

                $index++;
            }
        }
    }
}
