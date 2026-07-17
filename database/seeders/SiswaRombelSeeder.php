<?php

namespace Database\Seeders;

use App\Models\Rombel;
use App\Models\Siswa;
use App\Models\SiswaRombel;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SiswaRombelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $periodeGanjil = TahunAjaran::query()
            ->where('tahun', '2025/2026')
            ->where('semester', 'ganjil')
            ->first();

        $periodeGenap = TahunAjaran::query()
            ->where('tahun', '2025/2026')
            ->where('semester', 'genap')
            ->first();

        if (! $periodeGanjil || ! $periodeGenap) {
            return;
        }

        $rombelsGanjil = Rombel::query()
            ->with('kelas')
            ->where('tahun_ajaran_id', $periodeGanjil->id)
            ->orderBy('kelas_id')
            ->orderBy('paralel')
            ->get()
            ->values();

        $rombelsGenap = Rombel::query()
            ->with('kelas')
            ->where('tahun_ajaran_id', $periodeGenap->id)
            ->orderBy('kelas_id')
            ->orderBy('paralel')
            ->get()
            ->keyBy(fn (Rombel $rombel) => $rombel->kelas->tingkat . $rombel->paralel);

        $jumlahRombel = $rombelsGanjil->count();

        if ($jumlahRombel === 0) {
            return;
        }

        foreach (Siswa::query()->orderBy('id')->get() as $index => $siswa) {
            $rombelGanjil = $rombelsGanjil[$index % $jumlahRombel];
            $kunciRombel = $rombelGanjil->kelas->tingkat . $rombelGanjil->paralel;
            $rombelGenap = $rombelsGenap[$kunciRombel] ?? null;

            if (! $rombelGenap) {
                continue;
            }

            $riwayatGanjil = SiswaRombel::updateOrCreate(
                [
                    'siswa_id' => $siswa->id,
                    'rombel_id' => $rombelGanjil->id,
                ],
                [
                    'status' => 'aktif',
                    'hasil_akhir' => 'belum_dievaluasi',
                    'is_active' => false,
                    'tanggal_masuk' => Carbon::create(2025, 7, 14)->toDateString(),
                    'tanggal_selesai' => Carbon::create(2025, 12, 20)->toDateString(),
                    'catatan' => 'Riwayat semester ganjil.',
                ]
            );

            SiswaRombel::updateOrCreate(
                [
                    'siswa_id' => $siswa->id,
                    'rombel_id' => $rombelGenap->id,
                ],
                [
                    'status' => 'aktif',
                    'hasil_akhir' => 'belum_dievaluasi',
                    'is_active' => true,
                    'asal_siswa_rombel_id' => $riwayatGanjil->id,
                    'tanggal_masuk' => Carbon::create(2026, 1, 5)->toDateString(),
                    'catatan' => 'Posisi aktif semester genap.',
                ]
            );
        }
    }
}
