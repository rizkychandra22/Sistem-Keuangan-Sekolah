<?php

namespace App\Http\Controllers\Admin\Manages;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KurikulumController extends Controller
{
    public function index(): View|JsonResponse
    {
        $dataKurikulum = Kurikulum::latest()->get();
        if (request()->ajax()) {
            return datatables()->of($dataKurikulum)->make(true);
        }

        $currentLink = route('kurikulum.index');
        $currentTitle = 'Kurikulum';
        $createLink = route('kurikulum.create');
        $createTitle = 'Tambah';

        return view('admin.kurikulum.index', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function create(): View
    {
        $currentLink = route('kurikulum.index');
        $currentTitle = 'Kurikulum';
        $createLink = route('kurikulum.create');
        $createTitle = 'Tambah';

        return view('admin.kurikulum.create', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tahun' => 'required|string|max:20',
            'deskripsi' => 'nullable|string',
        ], [
            'nama.required' => 'Nama kurikulum harus diisi',
            'tahun.required' => 'Tahun kurikulum harus diisi',
        ]);

        Kurikulum::create($validated);

        return redirect()->route('kurikulum.index')->with('success', 'Data kurikulum ' . $validated['nama'] . ' berhasil ditambahkan.');
    }

    public function show(Kurikulum $kurikulum): RedirectResponse
    {
        return redirect()->route('kurikulum.edit', $kurikulum->id);
    }

    public function edit(Kurikulum $kurikulum): View
    {
        $currentLink = route('kurikulum.index');
        $currentTitle = 'Kurikulum';
        $editLink = route('kurikulum.edit', $kurikulum->id);
        $editTitle = 'Edit';

        return view('admin.kurikulum.edit', compact('kurikulum', 'currentLink', 'currentTitle', 'editLink', 'editTitle'));
    }

    public function update(Request $request, Kurikulum $kurikulum): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tahun' => 'required|string|max:20',
            'deskripsi' => 'nullable|string',
        ], [
            'nama.required' => 'Nama kurikulum harus diisi',
            'tahun.required' => 'Tahun kurikulum harus diisi',
        ]);

        $kurikulum->update($validated);

        return redirect()->route('kurikulum.index')->with('success', 'Data kurikulum ' . $kurikulum->nama . ' berhasil diupdate.');
    }

    public function destroy(Kurikulum $kurikulum): JsonResponse
    {
        if ($kurikulum->mapels()->exists()) {
            return response()->json([
                'message' => 'Kurikulum masih digunakan oleh data mapel.',
            ], 422);
        }

        $nama = $kurikulum->nama;
        $kurikulum->delete();

        return response()->json([
            'message' => 'Data kurikulum ' . $nama . ' berhasil dihapus.',
        ]);
    }
}
