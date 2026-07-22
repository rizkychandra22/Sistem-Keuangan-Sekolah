<?php

namespace App\Http\Controllers\Admin\Manages\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\TahunAjaran;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RombelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        $dataRombel = Rombel::query()
            ->with(['tahunAjaran', 'kelas', 'waliKelas'])
            ->orderByDesc('is_active')
            ->orderByDesc('created_at')
            ->get();

        if (request()->ajax()) {
            return datatables()->of($dataRombel)
                ->addColumn('tahun_ajaran', function (Rombel $rombel) {
                    return $this->formatTahunAjaran($rombel->tahunAjaran);
                })
                ->addColumn('kelas', function (Rombel $rombel) {
                    return $rombel->kelas?->nama ?? '-';
                })
                ->addColumn('walikelas', function (Rombel $rombel) {
                    return $rombel->waliKelas?->nama ?? '-';
                })
                ->addColumn('status', function (Rombel $rombel) {
                    return $rombel->is_active ? 'Aktif' : 'Nonaktif';
                })
                ->make(true);
        }

        $currentLink = route('rombel.index');
        $currentTitle = 'Rombel';
        $createLink = route('rombel.create');
        $createTitle = 'Tambah';

        return view('admin/manages/akademik/rombel.index', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $dataTahunAjaran = $this->getSelectableTahunAjarans();
        $dataKelas = Kelas::query()->orderBy('tingkat')->get();
        $dataWalikelas = Guru::query()->orderBy('nama')->get();
        $currentLink = route('rombel.index');
        $currentTitle = 'Rombel';
        $createLink = route('rombel.create');
        $createTitle = 'Tambah';

        return view('admin/manages/akademik/rombel.create', compact(
            'dataTahunAjaran', 'dataKelas', 'dataWalikelas', 
            'currentLink', 'currentTitle', 'createLink', 'createTitle'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateRombel($request);
        $validated['nama'] = $this->buildNamaRombel((int) $validated['kelas_id'], $validated['paralel']);
        $validated['kode'] = $this->generateUniqueKodeRombel($validated['paralel']);

        Rombel::create($validated);

        return redirect()->route('rombel.index')->with('success', 'Data rombel ' . $validated['nama'] . ' berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rombel $rombel): RedirectResponse
    {
        return redirect()->route('rombel.edit', $rombel->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rombel $rombel): View
    {
        $dataTahunAjaran = $this->getSelectableTahunAjarans($rombel->tahun_ajaran_id);
        $dataKelas = Kelas::query()->orderBy('tingkat')->get();
        $dataWalikelas = Guru::query()->orderBy('nama')->get();
        $currentLink = route('rombel.index');
        $currentTitle = 'Rombel';
        $editLink = route('rombel.edit', $rombel->id);
        $editTitle = 'Edit';

        return view('admin/manages/akademik/rombel.edit', compact(
            'rombel', 'dataTahunAjaran', 'dataKelas', 'dataWalikelas',
            'currentLink', 'currentTitle', 'editLink', 'editTitle'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rombel $rombel): RedirectResponse
    {
        $validated = $this->validateRombel($request, $rombel);
        $validated['nama'] = $this->buildNamaRombel((int) $validated['kelas_id'], $validated['paralel']);

        if ($rombel->paralel !== $validated['paralel']) {
            $validated['kode'] = $this->generateUniqueKodeRombel($validated['paralel'], $rombel->id);
        }

        $rombel->update($validated);

        return redirect()->route('rombel.index')->with('success', 'Data rombel ' . $validated['nama'] . ' berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rombel $rombel): JsonResponse
    {
        if ($rombel->siswaRombels()->exists()) {
            return response()->json([
                'message' => 'Data rombel masih digunakan oleh siswa rombel.',
            ], 422);
        }

        if ($rombel->guruMapels()->exists()) {
            return response()->json([
                'message' => 'Data rombel masih digunakan oleh guru mapel.',
            ], 422);
        }

        if ($rombel->absensis()->exists()) {
            return response()->json([
                'message' => 'Data rombel masih digunakan oleh data absensi.',
            ], 422);
        }

        $namaRombel = $rombel->nama;
        $rombel->delete();

        return response()->json([
            'message' => 'Data rombel ' . $namaRombel . ' berhasil dihapus.',
        ]);
    }

    private function validateRombel(Request $request, ?Rombel $rombel = null): array
    {
        $rombelId = $rombel?->id;

        $request->merge([
            'paralel' => strtoupper(trim((string) $request->paralel)),
        ]);

        $validated = $request->validate([
            'tahun_ajaran_id' => [
                'required',
                'exists:tahun_ajarans,id',
                fn ($attribute, $value, $fail) => $this->validateSelectableTahunAjaran($value, $fail, $rombel),
            ],
            'kelas_id' => 'required|exists:kelas,id',
            'paralel' => [
                'required',
                'string',
                'max:5',
                Rule::unique('rombels')
                    ->ignore($rombelId)
                    ->where(fn ($query) => $query
                        ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
                        ->where('kelas_id', $request->kelas_id)),
            ],
            'guru_id' => [
                'nullable',
                'exists:gurus,id',
                Rule::unique('rombels', 'guru_id')
                    ->ignore($rombelId)
                    ->where(fn ($query) => $query->where('tahun_ajaran_id', $request->tahun_ajaran_id)),
            ],
            'kapasitas' => 'required|integer|min:0|max:999',
            'is_active' => 'required|boolean',
        ], [
            'tahun_ajaran_id.required' => 'Tahun ajaran harus dipilih',
            'tahun_ajaran_id.exists' => 'Tahun ajaran yang dipilih tidak valid',
            'kelas_id.required' => 'Kelas harus dipilih',
            'kelas_id.exists' => 'Kelas yang dipilih tidak valid',
            'paralel.required' => 'Paralel kelas harus diisi',
            'paralel.unique' => 'Rombel untuk tahun ajaran, kelas, dan paralel tersebut sudah ada',
            'guru_id.exists' => 'Wali kelas yang dipilih tidak valid',
            'guru_id.unique' => 'Guru tersebut sudah menjadi wali kelas pada tahun ajaran yang dipilih',
            'kapasitas.required' => 'Kapasitas rombel harus diisi',
            'kapasitas.integer' => 'Kapasitas rombel harus berupa angka',
            'kapasitas.min' => 'Kapasitas rombel minimal 0',
            'is_active.required' => 'Status aktif rombel harus dipilih',
        ]);

        return $validated;
    }

    private function getSelectableTahunAjarans(?int $includeId = null)
    {
        return TahunAjaran::query()
            ->where(function ($query) use ($includeId) {
                $query->open();

                if ($includeId) {
                    $query->orWhere('id', $includeId);
                }
            })
            ->orderByDesc('is_active')
            ->orderByDesc('tahun')
            ->get();
    }

    private function validateSelectableTahunAjaran(mixed $value, callable $fail, ?Rombel $rombel = null): void
    {
        $tahunAjaran = TahunAjaran::query()->find($value);

        if (! $tahunAjaran) {
            return;
        }

        if ($rombel && (int) $rombel->tahun_ajaran_id === (int) $tahunAjaran->id) {
            return;
        }

        if ($tahunAjaran->is_locked) {
            $fail('Tahun ajaran yang dipilih harus berstatus terbuka.');
        }
    }

    private function formatTahunAjaran(?TahunAjaran $tahunAjaran): string
    {
        if (! $tahunAjaran) {
            return '-';
        }

        return $tahunAjaran->tahun . ' - ' . ucfirst($tahunAjaran->semester);
    }

    private function buildNamaRombel(int $kelasId, string $paralel): string
    {
        $kelas = Kelas::query()->findOrFail($kelasId);

        return $kelas->nama . $paralel;
    }

    private function generateUniqueKodeRombel(string $paralel, ?int $ignoreId = null): string
    {
        $prefix = strtoupper(substr(trim($paralel), 0, 1));

        do {
            $kode = $prefix . random_int(10, 99);

            $exists = Rombel::query()
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->where('kode', $kode)
                ->exists();
        } while ($exists);

        return $kode;
    }
}
