<?php

namespace App\Http\Controllers;

use App\Models\Sambutan;
use Illuminate\Http\Request;

class SambutanController extends Controller
{
    public function index()
    {
        $sambutans = Sambutan::all();

        // Route dan nama halaman yang diakses
        $currentLink = route('sambutan.index');
        $currentTitle = 'Sambutan';

        return view('operator/sambutan.index', compact('sambutans', 'currentLink', 'currentTitle'));
    }

    // public function create()
    // {
    //     return view('operator/sambutan.create');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama' => 'required',
    //         'deskripsi' => 'required',
    //         'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
    //     ],[
    //         'nama.required' => 'Nama kegiatan lomba harus diisi',
    //         'deskripsi.required' => 'Deskripsi kegiatan lomba harus diisi',
    //         'gambar.required' => 'Foto kegiatan lomba harus diisi'
    //     ]);

    //     $nama = $request->nama;
    //     $tanggal = now()->format('Ymd_His');
    //     $extension = $request->gambar->extension();
    //     $imageName = $nama . '_' . $tanggal . '.' . $extension;
    //     $request->gambar->move(public_path('images/sambutan'), $imageName);

    //     Sambutan::create([
    //         'nama' => $request->nama,
    //         'deskripsi' => $request->deskripsi,
    //         'gambar' => $imageName,
    //     ]);

    //     return redirect()->route('sambutan.index')->with('success','Data kegiatan lomba sekolah berhasil ditambahkan.');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Sambutan $sambutan)
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('sambutan.index');
        $currentTitle = 'Sambutan';

        return view('operator/sambutan.edit', compact('sambutan', 'currentLink', 'currentTitle'));
    }

    public function update(Request $request, Sambutan $sambutan)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'nama.required' => 'Nama kegiatan lomba harus diisi',
            'deskripsi.required' => 'Deskripsi kegiatan lomba harus diisi'
        ]);

        if ($request->hasFile('gambar')) {
            $nama = $request->nama;
            $tanggal = now()->format('Ymd_His');
            $extension = $request->gambar->extension();
            $imageName = $nama . '_' . $tanggal . '.' . $extension;
            
            // Pindahkan file ke direktori public_path dengan nama file baru
            $request->gambar->move(public_path('images/sambutan'), $imageName);

            // Hapus gambar lama jika ada gambar baru
            if ($sambutan->gambar && file_exists(public_path('images/sambutan/' . $sambutan->gambar))) {
                unlink(public_path('images/sambutan/' . $sambutan->gambar));
            }

            // Simpan nama file gambar baru di database
            $sambutan->gambar = $imageName;
        }

        // Memperbarui dan simpan data baru dari title
        $sambutan->nama = $request->nama;
        $sambutan->deskripsi = $request->deskripsi;
        $sambutan->save();
        
        return redirect()->route('sambutan.index')->with('success', 'Data sambutan kepala sekolah berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
