<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class RombelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $strukturRombel = AcademicSeederData::strukturRombel();
        $guruIds = Guru::query()->orderBy('id')->pluck('id')->values();

        $maksimalRombel = collect($strukturRombel)
            ->map(fn (array $tahun) => collect($tahun)->sum(fn (array $paralels) => count($paralels)))
            ->max();

        if ($guruIds->count() < $maksimalRombel) {
            throw new \RuntimeException('Jumlah guru tidak cukup untuk mengisi wali kelas unik per tahun ajaran.');
        }

        foreach ($strukturRombel as $tahun => $tingkatParalels) {
            $waliPerRombel = $this->buildWaliMapping($tingkatParalels, $guruIds->all());

            foreach (['ganjil', 'genap'] as $semester) {
                $tahunAjaran = TahunAjaran::query()
                    ->where('tahun', $tahun)
                    ->where('semester', $semester)
                    ->firstOrFail();

                foreach ($tingkatParalels as $tingkat => $paralels) {
                    $kelas = Kelas::query()->where('tingkat', $tingkat)->firstOrFail();

                    foreach ($paralels as $paralel) {
                        Rombel::updateOrCreate(
                            [
                                'tahun_ajaran_id' => $tahunAjaran->id,
                                'kelas_id' => $kelas->id,
                                'paralel' => $paralel,
                            ],
                            [
                                'nama' => sprintf('Kelas %d%s', $tingkat, $paralel),
                                'kode' => $this->buildKodeRombel($tahun, $semester, $tingkat, $paralel),
                                'guru_id' => $waliPerRombel[$tingkat . $paralel],
                                'kapasitas' => 32,
                                'is_active' => $tahun === '2025/2026' && $semester === 'genap',
                            ]
                        );
                    }
                }
            }
        }
    }

    private function buildWaliMapping(array $tingkatParalels, array $guruIds): array
    {
        $waliPerRombel = [];
        $guruIndex = 0;

        foreach ($tingkatParalels as $tingkat => $paralels) {
            foreach ($paralels as $paralel) {
                $waliPerRombel[$tingkat . $paralel] = $guruIds[$guruIndex];
                $guruIndex++;
            }
        }

        return $waliPerRombel;
    }

    private function buildKodeRombel(string $tahun, string $semester, int $tingkat, string $paralel): string
    {
        $kodeSemester = $semester === 'ganjil' ? 'GJ' : 'GP';

        return sprintf(
            'SDK%d%s-%s%s',
            $tingkat,
            $paralel,
            substr($tahun, 2, 2),
            $kodeSemester
        );
    }
}
