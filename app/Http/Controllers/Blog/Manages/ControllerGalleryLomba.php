<?php

namespace App\Http\Controllers\Blog\Manages;

use App\Http\Controllers\Controller;
use App\Models\GalleryLomba;
use Illuminate\Http\Request;

class ControllerGalleryLomba extends Controller
{
    public function index()
    {
        $dataLomba = GalleryLomba::orderBy('created_at', 'desc')->get();
        if(request()->ajax()) {
            return datatables()->of($dataLomba)
            ->make(true);
        }

        // Route dan nama halaman yang di akses
        $currentLink = route('gallery-lomba.index');
        $currentTitle = 'Gallery Lomba';
        $createLink = route('gallery-lomba.create');
        $createTitle = 'Tambah';

        return view('operator/gallery/lomba.index', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function create()
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('gallery-lomba.index');
        $currentTitle = 'Gallery Lomba';
        $createLink = route('gallery-lomba.create');
        $createTitle = 'Tambah';

        return view('operator/gallery/lomba.create', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'title.required' => 'Nama kegiatan lomba harus diisi',
            'subtitle.required' => 'Deskripsi kegiatan lomba harus diisi',
            'gambar.required' => 'Foto kegiatan lomba harus diisi'
        ]);

        $nama = $request->title;
        $tanggal = now()->format('Ymd_His');
        $extension = $request->gambar->extension();
        $imageName = $nama . '_' . $tanggal . '.' . $extension;
        $request->gambar->move(public_path('images/gallery/lomba'), $imageName);

        GalleryLomba::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'gambar' => $imageName,
        ]);

        return redirect()->route('gallery-lomba.index')->with('success','Data kegiatan lomba ' . $request->title . ' berhasil ditambahkan.');
    }

    public function show(GalleryLomba $galleryLomba)
    {
        return view('operator/gallery/lomba.show', compact('galleryLomba'));
    }

    public function edit(GalleryLomba $galleryLomba)
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('gallery-lomba.index');
        $currentTitle = 'Gallery Lomba';
        $editLink = route('gallery-lomba.edit', $galleryLomba->id);
        $editTitle = 'Edit';

        return view('operator/gallery/lomba.edit', compact('galleryLomba', 'currentLink', 'currentTitle', 'editLink', 'editTitle'));
    }

    public function update(Request $request, GalleryLomba $galleryLomba)
    {
        $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'title.required' => 'Nama kegiatan lomba harus diisi',
            'subtitle.required' => 'Deskripsi kegiatan lomba harus diisi'
        ]);

        if ($request->hasFile('gambar')) {
            $nama = $request->title;
            $tanggal = now()->format('Ymd_His');
            $extension = $request->gambar->extension();
            $imageName = $nama . '_' . $tanggal . '.' . $extension;
            
            // Pindahkan file ke direktori public_path dengan nama file baru
            $request->gambar->move(public_path('images/gallery/lomba'), $imageName);

            // Hapus gambar lama jika ada gambar baru
            if ($galleryLomba->gambar && file_exists(public_path('images/gallery/lomba/' . $galleryLomba->gambar))) {
                unlink(public_path('images/gallery/lomba/' . $galleryLomba->gambar));
            }

            // Simpan nama file gambar baru di database
            $galleryLomba->gambar = $imageName;
        }

        // Memperbarui dan simpan data baru dari title
        $galleryLomba->title = $request->title;
        $galleryLomba->subtitle = $request->subtitle;
        $galleryLomba->save();
        
        return redirect()->route('gallery-lomba.index')->with('success', 'Data kegiatan lomba ' . $galleryLomba->title . ' berhasil diupdate.');
    }

    public function destroy(GalleryLomba $galleryLomba)
    {
        if ($galleryLomba->gambar && file_exists(public_path('images/gallery/lomba/' . $galleryLomba->gambar))) {
            unlink(public_path('images/gallery/lomba/' . $galleryLomba->gambar));
        }
        $galleryLomba->delete();
        return redirect()->route('gallery-lomba.index')->with('danger','Data kegiatan lomba ' . $galleryLomba->title . ' berhasil dihapus.');          
    }
}
