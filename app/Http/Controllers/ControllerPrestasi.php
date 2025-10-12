<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;

class ControllerPrestasi extends Controller
{
    public function index()
    {
        $dataPrestasi = Prestasi::orderBy('created_at', 'desc')->get();
        if(request()->ajax()) {
            return datatables()->of($dataPrestasi)
            ->make(true);
        }

        // Route dan nama halaman yang di akses
        $currentLink = route('prestasi.index');
        $currentTitle = 'Prestasi Sekolah';
        $createLink = route('prestasi.create');
        $createTitle = 'Create';

        return view('operator/prestasi.index', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function create()
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('prestasi.index');
        $currentTitle = 'Prestasi Sekolah';
        $createLink = route('prestasi.create');
        $createTitle = 'Create';

        return view('operator/prestasi.create', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'judul.required' => 'Nama prestasi harus diisi',
            'deskripsi.required' => 'Deskripsi prestasi harus diisi',
            'gambar.required' => 'Foto prestasi harus diisi'
        ]);

        $nama = $request->judul;
        $tanggal = now()->format('Ymd_His');
        $extension = $request->gambar->extension();
        $imageName = $nama . '_' . $tanggal . '.' . $extension;
        $request->gambar->move(public_path('images/prestasi'), $imageName);

        Prestasi::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $imageName,
        ]);

        return redirect()->route('prestasi.index')->with('success','Data prestasi sekolah ' . $request->judul . ' berhasil ditambahkan.');
    }

    public function show(Prestasi $prestasi)
    {
        return view('operator/prestasi.show', compact('prestasi'));
    }

    public function edit(Prestasi $prestasi)
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('prestasi.index');
        $currentTitle = 'Prestasi Sekolah';
        $editLink = route('prestasi.edit', $prestasi->id);
        $editTitle = 'Edit';

        return view('operator/prestasi.edit', compact('prestasi', 'currentLink', 'currentTitle', 'editLink', 'editTitle'));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'judul.required' => 'Nama prestasi harus diisi',
            'deskripsi.required' => 'Deskripsi prestasi harus diisi'
        ]);

        if ($request->hasFile('gambar')) {
            $nama = $request->judul;
            $tanggal = now()->format('Ymd_His');
            $extension = $request->gambar->extension();
            $imageName = $nama . '_' . $tanggal . '.' . $extension;
            
            // Pindahkan file ke direktori public_path dengan nama file baru
            $request->gambar->move(public_path('images/prestasi'), $imageName);

            // Hapus gambar lama jika ada gambar baru
            if ($prestasi->gambar && file_exists(public_path('images/prestasi/' . $prestasi->gambar))) {
                unlink(public_path('images/prestasi/' . $prestasi->gambar));
            }

            // Simpan nama file gambar baru di database
            $prestasi->gambar = $imageName;
        }

        // Memperbarui dan simpan data baru dari prestasi
        $prestasi->judul = $request->judul;
        $prestasi->deskripsi = $request->deskripsi;
        $prestasi->save();
        
        return redirect()->route('prestasi.index')->with('success', 'Data prestasi sekolah ' . $prestasi->judul . ' berhasil diupdate.');
    }

    public function destroy(Prestasi $prestasi)
    {
        if ($prestasi->gambar && file_exists(public_path('images/prestasi/' . $prestasi->gambar))) {
            unlink(public_path('images/prestasi/' . $prestasi->gambar));
        }
        $prestasi->delete();

        return redirect()->route('prestasi.index')->with('danger', 'Data prestasi sekolah ' . $prestasi->judul . ' berhasil dihapus.');
    }
}
