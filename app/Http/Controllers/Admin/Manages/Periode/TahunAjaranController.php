<?php

namespace App\Http\Controllers\Admin\Manages\Periode;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TahunAjaranController extends Controller
{
    public function index(): View|JsonResponse
    {
        $dataTahunAjaran = TahunAjaran::query()
            ->orderByDesc('tahun')
            ->orderByRaw("CASE WHEN semester = 'ganjil' THEN 1 ELSE 2 END")
            ->get();

        if (request()->ajax()) {
            return datatables()->of($dataTahunAjaran)
                ->addColumn('status_aktif', fn (TahunAjaran $tahunAjaran) => $tahunAjaran->is_active ? 'Aktif' : 'Tidak Aktif')
                ->addColumn('status_kunci', fn (TahunAjaran $tahunAjaran) => $tahunAjaran->is_locked ? 'Terkunci' : 'Terbuka')
                ->make(true);
        }

        $currentLink = route('tahun-ajaran.index');
        $currentTitle = 'Tahun Ajaran';
        $createLink = route('tahun-ajaran.create');
        $createTitle = 'Tambah';

        return view('admin/manages/periode/tahun-ajaran.index', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function create(): View
    {
        $currentLink = route('tahun-ajaran.index');
        $currentTitle = 'Tahun Ajaran';
        $createLink = route('tahun-ajaran.create');
        $createTitle = 'Tambah';

        return view('admin/manages/periode/tahun-ajaran.create', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tahun' => [
                'required',
                'string',
                'max:20',
                'regex:/^\d{4}\/\d{4}$/',
                Rule::unique('tahun_ajarans')->where(fn ($query) => $query->where('semester', $request->semester)),
            ],
            'semester' => 'required|in:ganjil,genap',
            'is_active' => 'required|boolean',
            'is_locked' => 'required|boolean',
        ], [
            'tahun.required' => 'Tahun ajaran harus diisi',
            'tahun.regex' => 'Format tahun ajaran harus seperti 2025/2026',
            'tahun.unique' => 'Tahun ajaran dan semester ini sudah ada',
            'semester.required' => 'Semester harus dipilih',
            'semester.in' => 'Semester yang dipilih tidak valid',
        ]);

        if ($validated['is_active']) {
            TahunAjaran::query()->update(['is_active' => false]);
        }

        TahunAjaran::create($validated);

        return redirect()->route('tahun-ajaran.index')->with(
            'success',
            'Data tahun ajaran ' . $validated['tahun'] . ' semester ' . ucfirst($validated['semester']) . ' berhasil ditambahkan.'
        );
    }

    public function show(TahunAjaran $tahunAjaran): RedirectResponse
    {
        return redirect()->route('tahun-ajaran.edit', $tahunAjaran->id);
    }

    public function edit(TahunAjaran $tahunAjaran): View
    {
        $currentLink = route('tahun-ajaran.index');
        $currentTitle = 'Tahun Ajaran';
        $editLink = route('tahun-ajaran.edit', $tahunAjaran->id);
        $editTitle = 'Edit';

        return view('admin/manages/periode/tahun-ajaran.edit', compact('tahunAjaran', 'currentLink', 'currentTitle', 'editLink', 'editTitle'));
    }

    public function update(Request $request, TahunAjaran $tahunAjaran): RedirectResponse
    {
        $validated = $request->validate([
            'tahun' => [
                'required',
                'string',
                'max:20',
                'regex:/^\d{4}\/\d{4}$/',
                Rule::unique('tahun_ajarans')
                    ->ignore($tahunAjaran->id)
                    ->where(fn ($query) => $query->where('semester', $request->semester)),
            ],
            'semester' => 'required|in:ganjil,genap',
            'is_active' => 'required|boolean',
            'is_locked' => 'required|boolean',
        ], [
            'tahun.required' => 'Tahun ajaran harus diisi',
            'tahun.regex' => 'Format tahun ajaran harus seperti 2025/2026',
            'tahun.unique' => 'Tahun ajaran dan semester ini sudah ada',
            'semester.required' => 'Semester harus dipilih',
            'semester.in' => 'Semester yang dipilih tidak valid',
        ]);

        if ($validated['is_active']) {
            TahunAjaran::query()
                ->whereKeyNot($tahunAjaran->id)
                ->update(['is_active' => false]);
        }

        $tahunAjaran->update($validated);

        return redirect()->route('tahun-ajaran.index')->with(
            'success',
            'Data tahun ajaran ' . $tahunAjaran->tahun . ' semester ' . ucfirst($tahunAjaran->semester) . ' berhasil diupdate.'
        );
    }

    public function destroy(TahunAjaran $tahunAjaran): JsonResponse
    {
        if ($tahunAjaran->rombels()->exists()) {
            return response()->json([
                'message' => 'Tahun ajaran masih digunakan oleh data rombel.',
            ], 422);
        }

        $tahun = $tahunAjaran->tahun;
        $semester = ucfirst($tahunAjaran->semester);
        $tahunAjaran->delete();

        return response()->json([
            'message' => 'Data tahun ajaran ' . $tahun . ' semester ' . $semester . ' berhasil dihapus.',
        ]);
    }
}
