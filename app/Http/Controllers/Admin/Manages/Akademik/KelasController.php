<?php

namespace App\Http\Controllers\Admin\Manages\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        $dataKelas = Kelas::query()
            ->orderBy('tingkat')
            ->get();

        if (request()->ajax()) {
            return datatables()->of($dataKelas)->make(true);
        }

        $currentLink = route('kelas.index');
        $currentTitle = 'Data Kelas';
        $createLink = route('kelas.create');
        $createTitle = 'Tambah';

        return view('admin/manages/akademik/kelas.index', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $currentLink = route('kelas.index');
        $currentTitle = 'Data Kelas';
        $createLink = route('kelas.create');
        $createTitle = 'Tambah';

        return view('admin/manages/akademik/kelas.create', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tingkat' => 'required|integer|min:1|max:6|unique:kelas,tingkat',
            'nama' => 'required|string|max:255|unique:kelas,nama',
            'deskripsi' => 'nullable|string|max:255',
        ], [
            'tingkat.required' => 'Tingkat kelas harus diisi',
            'tingkat.integer' => 'Tingkat kelas harus berupa angka',
            'tingkat.min' => 'Tingkat kelas minimal 1',
            'tingkat.max' => 'Tingkat kelas maksimal 6',
            'tingkat.unique' => 'Tingkat kelas sudah digunakan',
            'nama.required' => 'Nama kelas harus diisi',
            'nama.unique' => 'Nama kelas sudah digunakan',
        ]);

        Kelas::create($validated);

        return redirect()->route('kelas.index')->with('success', 'Data tingkat kelas ' . $validated['nama'] . ' berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelas $kelas): RedirectResponse
    {
        return redirect()->route('kelas.edit', $kelas->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kelas): View
    {
        $currentLink = route('kelas.index');
        $currentTitle = 'Data Kelas';
        $editLink = route('kelas.edit', $kelas->id);
        $editTitle = 'Edit';

        return view('admin/manages/akademik/kelas.edit', compact('kelas', 'currentLink', 'currentTitle', 'editLink', 'editTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kelas): RedirectResponse
    {
        $validated = $request->validate([
            'tingkat' => [
                'required',
                'integer',
                'min:1',
                'max:6',
                Rule::unique('kelas', 'tingkat')->ignore($kelas->id),
            ],
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kelas', 'nama')->ignore($kelas->id),
            ],
            'deskripsi' => 'nullable|string|max:255',
        ], [
            'tingkat.required' => 'Tingkat kelas harus diisi',
            'tingkat.integer' => 'Tingkat kelas harus berupa angka',
            'tingkat.min' => 'Tingkat kelas minimal 1',
            'tingkat.max' => 'Tingkat kelas maksimal 6',
            'tingkat.unique' => 'Tingkat kelas sudah digunakan',
            'nama.required' => 'Nama kelas harus diisi',
            'nama.unique' => 'Nama kelas sudah digunakan',
        ]);

        $kelas->update($validated);

        return redirect()->route('kelas.index')->with('success', 'Data tingkat kelas ' . $validated['nama'] . ' berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas): JsonResponse
    {
        if ($kelas->rombels()->exists()) {
            return response()->json([
                'message' => 'Data kelas masih digunakan oleh rombel.',
            ], 422);
        }

        $namaKelas = $kelas->nama;
        $kelas->delete();

        return response()->json([
            'message' => 'Data kelas ' . $namaKelas . ' berhasil dihapus.',
        ]);
    }
}
