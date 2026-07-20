<?php

namespace App\Http\Controllers\Admin\Manages\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kurikulum;
use App\Models\Mapel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MapelController extends Controller
{
    public function index(): View|JsonResponse
    {
        $dataMapel = Mapel::with(['guru.user', 'kurikulum'])->latest()->get();
        if (request()->ajax()) {
            return datatables()->of($dataMapel)
                ->addColumn('kurikulum_nama', function (Mapel $mapel) {
                    if (! $mapel->kurikulum) {
                        return '-';
                    }

                    return $mapel->kurikulum->nama . ' - ' . $mapel->kurikulum->tahun;
                })
                ->addColumn('guru_pengampu', function (Mapel $mapel) {
                    if (! $mapel->guru) {
                        return '-';
                    }

                    return $mapel->guru->nama;
                })
                ->make(true);
        }

        $currentLink = route('mapel.index');
        $currentTitle = 'Mata Pelajaran';
        $createLink = route('mapel.create');
        $createTitle = 'Tambah';

        return view('admin/manages/akademik/mapel.index', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function create(): View
    {
        $gurus = Guru::with('user')->orderBy('nama')->get();
        $kurikulums = Kurikulum::orderBy('nama')->orderBy('tahun')->get();

        $currentLink = route('mapel.index');
        $currentTitle = 'Mata Pelajaran';
        $createLink = route('mapel.create');
        $createTitle = 'Tambah';

        return view('admin/manages/akademik/mapel.create', compact('gurus', 'kurikulums', 'currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:mapels,kode',
            'kurikulum_id' => [
                'required',
                'integer',
                Rule::exists('kurikulums', 'id'),
            ],
            'guru_id' => [
                'required',
                'integer',
                Rule::exists('gurus', 'id'),
            ],
        ], [
            'nama.required' => 'Nama mata pelajaran harus diisi',
            'kode.required' => 'Kode mata pelajaran harus diisi',
            'kode.unique' => 'Kode mata pelajaran sudah digunakan',
            'kurikulum_id.required' => 'Kurikulum mata pelajaran harus dipilih',
            'kurikulum_id.exists' => 'Kurikulum yang dipilih tidak valid',
            'guru_id.required' => 'Guru pengampu mata pelajaran harus dipilih',
            'guru_id.exists' => 'Guru pengampu yang dipilih tidak valid',
        ]);

        Mapel::create($validated);

        return redirect()->route('mapel.index')->with('success', 'Data mata pelajaran ' . $validated['nama'] . ' berhasil ditambahkan.');
    }

    public function show(Mapel $mapel): RedirectResponse
    {
        return redirect()->route('mapel.edit', $mapel->id);
    }

    public function edit(Mapel $mapel): View
    {
        $gurus = Guru::with('user')->orderBy('nama')->get();
        $kurikulums = Kurikulum::orderBy('nama')->orderBy('tahun')->get();

        $currentLink = route('mapel.index');
        $currentTitle = 'Mata Pelajaran';
        $editLink = route('mapel.edit', $mapel->id);
        $editTitle = 'Edit';

        return view('admin/manages/akademik/mapel.edit', compact('mapel', 'gurus', 'kurikulums', 'currentLink', 'currentTitle', 'editLink', 'editTitle'));
    }

    public function update(Request $request, Mapel $mapel): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => [
                'required',
                'string',
                'max:50',
                Rule::unique('mapels', 'kode')->ignore($mapel->id),
            ],
            'kurikulum_id' => [
                'required',
                'integer',
                Rule::exists('kurikulums', 'id'),
            ],
            'guru_id' => [
                'required',
                'integer',
                Rule::exists('gurus', 'id'),
            ],
        ], [
            'nama.required' => 'Nama mata pelajaran harus diisi',
            'kode.required' => 'Kode mata pelajaran harus diisi',
            'kode.unique' => 'Kode mata pelajaran sudah digunakan',
            'kurikulum_id.required' => 'Kurikulum mata pelajaran harus dipilih',
            'kurikulum_id.exists' => 'Kurikulum yang dipilih tidak valid',
            'guru_id.required' => 'Guru pengampu mata pelajaran harus dipilih',
            'guru_id.exists' => 'Guru pengampu yang dipilih tidak valid',
        ]);

        $mapel->update($validated);

        return redirect()->route('mapel.index')->with('success', 'Data mata pelajaran ' . $mapel->nama . ' berhasil diupdate.');
    }

    public function destroy(Mapel $mapel): JsonResponse
    {
        $nama = $mapel->nama;
        $mapel->delete();

        return response()->json([
            'message' => 'Data mata pelajaran ' . $nama . ' berhasil dihapus.',
        ]);
    }
}
