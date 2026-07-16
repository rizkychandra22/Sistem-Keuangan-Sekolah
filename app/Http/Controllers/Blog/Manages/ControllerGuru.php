<?php

namespace App\Http\Controllers\Blog\Manages;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;

class ControllerGuru extends Controller
{
    public function index()
    {
        $dataGuru = Guru::orderBy('created_at', 'desc')->get();
        if(request()->ajax()) {
            return datatables()->of($dataGuru)
            ->make(true);   
        }

        // Route dan nama halaman yang di akses
        $currentLink = route('guru.index');
        $currentTitle = 'Guru Sekolah';
        $createLink = route('guru.create');
        $createTitle = 'Create';

        return view('operator/guru.index', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function create()
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('guru.index');
        $currentTitle = 'Guru Sekolah';
        $createLink = route('guru.create');
        $createTitle = 'Create';

        return view('operator/guru.create', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'motivasi' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'nama.required' => 'Nama guru harus diisi',
            'jabatan.required' => 'Jabatan guru harus diisi',
            'motivasi.required' => 'Motivasi guru harus diisi',
            'gambar.required' => 'Foto guru harus diisi'
        ]);

        $nama = $request->nama;
        $tanggal = now()->format('Ymd_His');
        $extension = $request->gambar->extension();
        $imageName = $nama . '_' . $tanggal . '.' . $extension;
        $request->gambar->move(public_path('images/guru'), $imageName);

        Guru::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'motivasi' => $request->motivasi,
            'gambar' => $imageName,
        ]);

        return redirect()->route('guru.index')->with('success','Data guru dengan nama ' . $request->nama . ' berhasil ditambahkan.');
    }

    public function show(Guru $guru)
    {
        return view('operator/guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('guru.index');
        $currentTitle = 'Guru Sekolah';
        $editLink = route('guru.edit', $guru->id);
        $editTitle = 'Edit';

        return view('operator/guru.edit', compact('guru', 'currentLink', 'currentTitle', 'editLink', 'editTitle'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'motivasi' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'nama.required' => 'Nama guru harus diisi',
            'jabatan.required' => 'Jabatan guru harus diisi',
            'motivasi.required' => 'Motivasi guru harus diisi'
        ]);

        if ($request->hasFile('gambar')) {
            $nama = $request->nama;
            $tanggal = now()->format('Ymd_His');
            $extension = $request->gambar->extension();
            $imageName = $nama . '_' . $tanggal . '.' . $extension;
            
            // Pindahkan file ke direktori public_path dengan nama file baru
            $request->gambar->move(public_path('images/guru'), $imageName);

            // Hapus gambar lama jika ada gambar baru
            if ($guru->gambar && file_exists(public_path('images/guru/' . $guru->gambar))) {
                unlink(public_path('images/guru/' . $guru->gambar));
            }

            // Simpan nama file gambar baru di database
            $guru->gambar = $imageName;
        }

        // Memperbarui dan simpan data baru dari guru
        $guru->nama = $request->nama;
        $guru->jabatan = $request->jabatan;
        $guru->motivasi = $request->motivasi;
        $guru->save();
        
        return redirect()->route('guru.index')->with('success', 'Data guru dengan nama ' . $guru->nama . ' berhasil diupdate.');
    }

    public function destroy(Guru $guru)
    {
        if ($guru->gambar && file_exists(public_path('images/guru/' . $guru->gambar))) {
            unlink(public_path('images/guru/' . $guru->gambar));
        }
        $guru->delete();
        return redirect()->route('guru.index')->with('danger','Data guru dengan nama ' . $guru->nama . ' berhasil dihapus.');          
    }
}
