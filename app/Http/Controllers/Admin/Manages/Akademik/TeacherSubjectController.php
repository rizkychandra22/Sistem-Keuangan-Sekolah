<?php

namespace App\Http\Controllers\Admin\Manages\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\GuruMapel;
use App\Models\Mapel;
use App\Models\Rombel;
use App\Models\TahunAjaran;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TeacherSubjectController extends Controller
{
    public function index(): View|JsonResponse
    {
        $dataGuruMapel = GuruMapel::query()
            ->with(['guru', 'rombel.tahunAjaran', 'mapel'])
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        if (request()->ajax()) {
            return datatables()->of($dataGuruMapel)
                ->addColumn('guru', fn (GuruMapel $guruMapel) => $guruMapel->guru?->nama ?? '-')
                ->addColumn('rombel', fn (GuruMapel $guruMapel) => $guruMapel->rombel?->nama ?? '-')
                ->addColumn('mapel', fn (GuruMapel $guruMapel) => $guruMapel->mapel?->nama ?? '-')
                ->addColumn('tahun_ajaran', fn (GuruMapel $guruMapel) => $this->formatTahunAjaran($guruMapel->rombel?->tahunAjaran))
                ->make(true);
        }

        $currentLink = route('guru-mapel.index');
        $currentTitle = 'Guru Mata Pelajaran';
        $createLink = route('guru-mapel.create');
        $createTitle = 'Tambah';

        return view('admin/manages/akademik/guru-mapel.index', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function create(): View
    {
        $gurus = Guru::query()->orderBy('nama')->get();
        $rombels = Rombel::query()
            ->with(['tahunAjaran', 'waliKelas'])
            ->orderByDesc('is_active')
            ->orderByDesc('created_at')
            ->get();
        $mapels = Mapel::query()->orderBy('nama')->get();

        $currentLink = route('guru-mapel.index');
        $currentTitle = 'Guru Mata Pelajaran';
        $createLink = route('guru-mapel.create');
        $createTitle = 'Tambah';

        return view('admin/manages/akademik/guru-mapel.create', compact(
            'gurus',
            'rombels',
            'mapels',
            'currentLink',
            'currentTitle',
            'createLink',
            'createTitle'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateGuruMapel($request);

        GuruMapel::create($validated);

        return redirect()->route('guru-mapel.index')->with('success', 'Data guru mapel berhasil ditambahkan.');
    }

    public function show(GuruMapel $guru_mapel): RedirectResponse
    {
        return redirect()->route('guru-mapel.edit', $guru_mapel->id);
    }

    public function edit(GuruMapel $guru_mapel): View
    {
        $gurus = Guru::query()->orderBy('nama')->get();
        $rombels = Rombel::query()
            ->with(['tahunAjaran', 'waliKelas'])
            ->orderByDesc('is_active')
            ->orderByDesc('created_at')
            ->get();
        $mapels = Mapel::query()->orderBy('nama')->get();

        $currentLink = route('guru-mapel.index');
        $currentTitle = 'Guru Mata Pelajaran';
        $editLink = route('guru-mapel.edit', $guru_mapel->id);
        $editTitle = 'Edit';

        return view('admin/manages/akademik/guru-mapel.edit', compact(
            'guru_mapel',
            'gurus',
            'rombels',
            'mapels',
            'currentLink',
            'currentTitle',
            'editLink',
            'editTitle'
        ));
    }

    public function update(Request $request, GuruMapel $guru_mapel): RedirectResponse
    {
        $validated = $this->validateGuruMapel($request, $guru_mapel);

        $guru_mapel->update($validated);

        return redirect()->route('guru-mapel.index')->with('success', 'Data guru mapel berhasil diupdate.');
    }

    public function destroy(GuruMapel $guru_mapel): JsonResponse
    {
        if ($guru_mapel->nilais()->exists()) {
            return response()->json([
                'message' => 'Data guru mapel masih digunakan oleh data nilai.',
            ], 422);
        }

        $namaGuru = $guru_mapel->guru?->nama ?? 'guru';
        $namaMapel = $guru_mapel->mapel?->nama ?? 'mata pelajaran';
        $guru_mapel->delete();

        return response()->json([
            'message' => 'Data guru mapel ' . $namaGuru . ' - ' . $namaMapel . ' berhasil dihapus.',
        ]);
    }

    private function validateGuruMapel(Request $request, ?GuruMapel $guruMapel = null): array
    {
        $guruMapelId = $guruMapel?->id;

        return $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'rombel_id' => 'required|exists:rombels,id',
            'mapel_id' => [
                'required',
                'exists:mapels,id',
                Rule::unique('guru_mapels')
                    ->ignore($guruMapelId)
                    ->where(fn ($query) => $query
                        ->where('guru_id', $request->guru_id)
                        ->where('rombel_id', $request->rombel_id)),
            ],
        ], [
            'guru_id.required' => 'Guru harus dipilih',
            'guru_id.exists' => 'Guru yang dipilih tidak valid',
            'rombel_id.required' => 'Rombel harus dipilih',
            'rombel_id.exists' => 'Rombel yang dipilih tidak valid',
            'mapel_id.required' => 'Mata pelajaran harus dipilih',
            'mapel_id.exists' => 'Mata pelajaran yang dipilih tidak valid',
            'mapel_id.unique' => 'Data guru, rombel, dan mata pelajaran tersebut sudah terdaftar',
        ]);
    }

    private function formatTahunAjaran(?TahunAjaran $tahunAjaran): string
    {
        if (! $tahunAjaran) {
            return '-';
        }

        return $tahunAjaran->tahun . ' - ' . ucfirst($tahunAjaran->semester);
    }
}
