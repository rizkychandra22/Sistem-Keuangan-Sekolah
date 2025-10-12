<?php

namespace App\Http\Controllers;

use App\Models\BeritaSekolah;
use Illuminate\Http\Request;

class ControllerBeritaSekolah extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataBerita = BeritaSekolah::orderBy('created_at', 'desc')->get();
        if(request()->ajax()) {
            return datatables()->of($dataBerita)
            ->make(true);
        }

        // Route dan nama halaman yang di akses
        $currentLink = route('berita-sekolah.index');
        $currentTitle = 'Berita Sekolah';
        $createLink = route('berita-sekolah.create');
        $createTitle = 'Create';

        return view('operator/berita.index', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('berita-sekolah.index');
        $currentTitle = 'Berita Sekolah';
        $createLink = route('berita-sekolah.create');
        $createTitle = 'Create';
        
        return view('operator/berita.create', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'judul.required' => 'Judul berita harus diisi',
            'deskripsi.required' => 'Deskripsi berita harus diisi',
            'gambar.required' => 'Foto berita harus diisi'
        ]);

        $nama = $request->judul;
        $tanggal = now()->format('Ymd_His');
        $extension = $request->gambar->extension();
        $imageName = $nama . '_' . $tanggal . '.' . $extension;
        $request->gambar->move(public_path('images/berita'), $imageName);

        BeritaSekolah::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $imageName,
        ]);

        return redirect()->route('berita-sekolah.index')->with('success','Data berita sekolah dengan judul ' . $request->judul . ' berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BeritaSekolah $beritaSekolah)
    {
        return view('operator/berita.edit', compact('beritaSekolah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BeritaSekolah $beritaSekolah)
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('berita-sekolah.index');
        $currentTitle = 'Berita Sekolah';
        $editLink = route('berita-sekolah.edit', $beritaSekolah->id);
        $editTitle = 'Edit';

        return view('operator/berita.edit', compact('beritaSekolah', 'currentLink', 'currentTitle', 'editLink', 'editTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BeritaSekolah $beritaSekolah)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'judul.required' => 'Judul berita harus diisi',
            'deskripsi.required' => 'Deskripsi berita harus diisi'
        ]);

        if ($request->hasFile('gambar')) {
            $nama = $request->judul;
            $tanggal = now()->format('Ymd_His');
            $extension = $request->gambar->extension();
            $imageName = $nama . '_' . $tanggal . '.' . $extension;
            
            // Pindahkan file ke direktori public_path dengan nama file baru
            $request->gambar->move(public_path('images/berita'), $imageName);

            // Hapus gambar lama jika ada gambar baru
            if ($beritaSekolah->gambar && file_exists(public_path('images/berita/' . $beritaSekolah->gambar))) {
                unlink(public_path('images/berita/' . $beritaSekolah->gambar));
            }

            // Simpan nama file gambar baru di database
            $beritaSekolah->gambar = $imageName;
        }

        // Memperbarui dan simpan data baru dari berita
        $beritaSekolah->judul = $request->judul;
        $beritaSekolah->deskripsi = $request->deskripsi;
        $beritaSekolah->save();
        
        return redirect()->route('berita-sekolah.index')->with('success', 'Data berita sekolah ' . $beritaSekolah->judul . ' berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BeritaSekolah $beritaSekolah)
    {
        if ($beritaSekolah->gambar && file_exists(public_path('images/berita/' . $beritaSekolah->gambar))) {
            unlink(public_path('images/berita/' . $beritaSekolah->gambar));
        }
        $beritaSekolah->delete();

        return redirect()->route('berita-sekolah.index')->with('danger', 'Data berita sekolah ' . $beritaSekolah->judul . ' berhasil dihapus.');
    }
}
