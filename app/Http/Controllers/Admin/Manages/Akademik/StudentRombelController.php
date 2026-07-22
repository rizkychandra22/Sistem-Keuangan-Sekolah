<?php

namespace App\Http\Controllers\Admin\Manages\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Rombel;
use App\Models\Siswa;
use App\Models\SiswaRombel;
use App\Models\TahunAjaran;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentRombelController extends Controller
{
    public function index(): View|JsonResponse
    {
        $dataSiswaRombel = SiswaRombel::query()
            ->with([
                'siswa',
                'rombel.tahunAjaran',
                'rombel.kelas',
                'rombel.waliKelas',
                'asalRombel.tahunAjaran',
            ])
            ->orderByDesc('is_active')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        if (request()->ajax()) {
            return datatables()->of($dataSiswaRombel)
                ->addColumn('siswa', fn (SiswaRombel $siswaRombel) => $siswaRombel->siswa?->nama ?? '-')
                ->addColumn('nisn', fn (SiswaRombel $siswaRombel) => $siswaRombel->siswa?->nisn ?? '-')
                ->addColumn('tahun_ajaran', fn (SiswaRombel $siswaRombel) => $this->formatTahunAjaran($siswaRombel->rombel?->tahunAjaran))
                ->addColumn('rombel', fn (SiswaRombel $siswaRombel) => $siswaRombel->rombel?->nama ?? '-')
                ->addColumn('wali_kelas', fn (SiswaRombel $siswaRombel) => $siswaRombel->rombel?->waliKelas?->nama ?? '-')
                ->addColumn('status', fn (SiswaRombel $siswaRombel) => $this->formatLabel($siswaRombel->status))
                ->addColumn('hasil_akhir', fn (SiswaRombel $siswaRombel) => $this->formatLabel($siswaRombel->hasil_akhir))
                ->addColumn('asal_rombel', function (SiswaRombel $siswaRombel) {
                    if (! $siswaRombel->asalRombel) {
                        return '-';
                    }

                    $namaRombel = $siswaRombel->asalRombel->nama ?? 'Rombel';
                    $tahunAjaran = $this->formatTahunAjaran($siswaRombel->asalRombel->tahunAjaran);

                    return $namaRombel . ' - ' . $tahunAjaran;
                })
                ->addColumn('catatan', fn (SiswaRombel $siswaRombel) => $siswaRombel->catatan ?: '-')
                ->addColumn('status_aktif', fn (SiswaRombel $siswaRombel) => $siswaRombel->is_active ? 'Aktif' : 'Nonaktif')
                ->make(true);
        }

        $currentLink = route('siswa-rombel.index');
        $currentTitle = 'Siswa Rombel';
        $createLink = route('siswa-rombel.create');
        $createTitle = 'Tambah';

        return view('admin/manages/akademik/student-rombel.index', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function create(): View
    {
        $siswas = Siswa::query()->orderBy('nama')->get();
        $rombels = $this->selectableRombelQuery()
            ->with(['kelas', 'tahunAjaran', 'waliKelas'])
            ->orderByDesc('is_active')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();
        $asalRombels = $this->selectableRombelQuery()
            ->with(['tahunAjaran', 'waliKelas'])
            ->orderByDesc('is_active')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        $currentLink = route('siswa-rombel.index');
        $currentTitle = 'Siswa Rombel';
        $createLink = route('siswa-rombel.create');
        $createTitle = 'Tambah';

        return view('admin/manages/akademik/student-rombel.create', compact(
            'siswas',
            'rombels',
            'asalRombels',
            'currentLink',
            'currentTitle',
            'createLink',
            'createTitle'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateSiswaRombel($request);

        DB::transaction(function () use ($validated) {
            if ($validated['is_active']) {
                SiswaRombel::query()
                    ->where('siswa_id', $validated['siswa_id'])
                    ->update(['is_active' => false]);
            }

            SiswaRombel::create($validated);
        });

        return redirect()->route('siswa-rombel.index')->with('success', 'Data siswa rombel berhasil ditambahkan.');
    }

    public function show(SiswaRombel $siswa_rombel): RedirectResponse
    {
        return redirect()->route('siswa-rombel.edit', $siswa_rombel->id);
    }

    public function edit(SiswaRombel $siswa_rombel): View
    {
        $siswas = Siswa::query()->orderBy('nama')->get();
        $rombels = $this->selectableRombelQuery([$siswa_rombel->rombel_id])
            ->with(['kelas', 'tahunAjaran', 'waliKelas'])
            ->orderByDesc('is_active')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();
        $asalRombels = $this->selectableRombelQuery([$siswa_rombel->asal_rombel_id])
            ->with(['tahunAjaran', 'waliKelas'])
            ->whereKeyNot($siswa_rombel->rombel_id)
            ->orderByDesc('is_active')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        $currentLink = route('siswa-rombel.index');
        $currentTitle = 'Siswa Rombel';
        $editLink = route('siswa-rombel.edit', $siswa_rombel->id);
        $editTitle = 'Edit';

        return view('admin/manages/akademik/student-rombel.edit', compact(
            'siswa_rombel',
            'siswas',
            'rombels',
            'asalRombels',
            'currentLink',
            'currentTitle',
            'editLink',
            'editTitle'
        ));
    }

    public function update(Request $request, SiswaRombel $siswa_rombel): RedirectResponse
    {
        $validated = $this->validateSiswaRombel($request, $siswa_rombel);

        DB::transaction(function () use ($validated, $siswa_rombel) {
            if ($validated['is_active']) {
                SiswaRombel::query()
                    ->where('siswa_id', $validated['siswa_id'])
                    ->whereKeyNot($siswa_rombel->id)
                    ->update(['is_active' => false]);
            }

            $siswa_rombel->update($validated);
        });

        return redirect()->route('siswa-rombel.index')->with('success', 'Data siswa rombel berhasil diupdate.');
    }

    public function destroy(SiswaRombel $siswa_rombel): JsonResponse
    {
        if ($siswa_rombel->nilais()->exists()) {
            return response()->json([
                'message' => 'Data siswa rombel masih digunakan oleh data nilai.',
            ], 422);
        }

        if ($siswa_rombel->absensis()->exists()) {
            return response()->json([
                'message' => 'Data siswa rombel masih digunakan oleh data absensi.',
            ], 422);
        }

        $namaSiswa = $siswa_rombel->siswa?->nama ?? 'siswa';
        $namaRombel = $siswa_rombel->rombel?->nama ?? 'rombel';
        $siswa_rombel->delete();

        return response()->json([
            'message' => 'Data siswa rombel ' . $namaSiswa . ' pada ' . $namaRombel . ' berhasil dihapus.',
        ]);
    }

    private function validateSiswaRombel(Request $request, ?SiswaRombel $siswaRombel = null): array
    {
        $siswaRombelId = $siswaRombel?->id;

        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'rombel_id' => [
                'required',
                'exists:rombels,id',
                fn ($attribute, $value, $fail) => $this->validateSelectableRombel($value, $fail, $siswaRombel, 'rombel'),
                Rule::unique('siswa_rombels')
                    ->ignore($siswaRombelId)
                    ->where(fn ($query) => $query->where('siswa_id', $request->siswa_id)),
            ],
            'status' => ['required', Rule::in(['aktif', 'lulus', 'mengulang', 'pindah', 'keluar'])],
            'hasil_akhir' => ['required', Rule::in(['proses_pembelajaran', 'naik_kelas', 'tinggal_kelas', 'lulus', 'tidak_lulus'])],
            'is_active' => 'required|boolean',
            'asal_rombel_id' => [
                'nullable',
                'exists:rombels,id',
                fn ($attribute, $value, $fail) => $this->validateSelectableRombel($value, $fail, $siswaRombel, 'asal_rombel'),
                Rule::notIn(array_filter([$request->rombel_id, $siswaRombel?->rombel_id])),
            ],
            'tanggal_masuk' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_masuk',
            'catatan' => 'nullable|string',
        ], [
            'siswa_id.required' => 'Siswa harus dipilih',
            'siswa_id.exists' => 'Siswa yang dipilih tidak valid',
            'rombel_id.required' => 'Rombel harus dipilih',
            'rombel_id.exists' => 'Rombel yang dipilih tidak valid',
            'rombel_id.unique' => 'Siswa tersebut sudah terdaftar pada rombel yang dipilih',
            'status.required' => 'Status siswa rombel harus dipilih',
            'hasil_akhir.required' => 'Hasil akhir harus dipilih',
            'is_active.required' => 'Status aktif harus dipilih',
            'asal_rombel_id.exists' => 'Asal siswa rombel yang dipilih tidak valid',
            'asal_rombel_id.not_in' => 'Asal siswa rombel tidak boleh memilih rombel yang sama',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal masuk',
        ]);

        return $validated;
    }

    private function selectableRombelQuery(array $includeIds = [])
    {
        $includeIds = array_values(array_filter(array_map('intval', $includeIds)));

        return Rombel::query()
            ->where(function ($query) use ($includeIds) {
                $query->openPeriod();

                if ($includeIds !== []) {
                    $query->orWhereIn('id', $includeIds);
                }
            });
    }

    private function validateSelectableRombel(
        mixed $value,
        callable $fail,
        ?SiswaRombel $siswaRombel = null,
        string $field = 'rombel'
    ): void {
        if (! $value) {
            return;
        }

        $rombel = Rombel::query()->with('tahunAjaran')->find($value);

        if (! $rombel) {
            return;
        }

        $currentId = match ($field) {
            'asal_rombel' => $siswaRombel?->asal_rombel_id,
            default => $siswaRombel?->rombel_id,
        };

        if ($currentId && (int) $currentId === (int) $rombel->id) {
            return;
        }

        if ($rombel->tahunAjaran?->is_locked) {
            $label = $field === 'asal_rombel' ? 'Asal siswa rombel' : 'Rombel';
            $fail($label . ' yang dipilih harus berasal dari tahun ajaran yang terbuka.');
        }
    }

    private function formatTahunAjaran(?TahunAjaran $tahunAjaran): string
    {
        if (! $tahunAjaran) {
            return '-';
        }

        return $tahunAjaran->tahun . ' - ' . ucfirst($tahunAjaran->semester);
    }

    private function formatLabel(string $value): string
    {
        return ucwords(str_replace('_', ' ', $value));
    }
}
