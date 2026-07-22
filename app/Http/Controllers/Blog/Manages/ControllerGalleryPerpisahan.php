<?php

namespace App\Http\Controllers\Blog\Manages;

use App\Http\Controllers\Controller;
use App\Models\GalleryPerpisahan;
use Illuminate\Http\Request;

class ControllerGalleryPerpisahan extends Controller
{
    public function index()
    {
        $dataPerpisahan = GalleryPerpisahan::orderBy('created_at', 'desc')->get();
        if(request()->ajax()) {
            return datatables()->of($dataPerpisahan)
            ->make(true);
        }

        // Route dan nama halaman yang di akses
        $currentLink = route('gallery-perpisahan.index');
        $currentTitle = 'Gallery Perpisahan';
        $createLink = route('gallery-perpisahan.create');
        $createTitle = 'Tambah';

        return view('operator/gallery/perpisahan.index', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function create()
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('gallery-perpisahan.index');
        $currentTitle = 'Gallery Perpisahan';
        $createLink = route('gallery-perpisahan.create');
        $createTitle = 'Tambah';

        return view('operator/gallery/perpisahan.create', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'title.required' => 'Tema kegiatan perpisahan harus diisi',
            'subtitle.required' => 'Deskripsi kegiatan perpisahan harus diisi',
            'gambar.required' => 'Foto kegiatan perpisahan harus diisi'
        ]);

        $nama = $request->title;
        $tanggal = now()->format('Ymd_His');
        $extension = $request->gambar->extension();
        $imageName = $nama . '_' . $tanggal . '.' . $extension;
        $request->gambar->move(public_path('images/gallery/perpisahan'), $imageName);

        GalleryPerpisahan::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'gambar' => $imageName,
        ]);

        return redirect()->route('gallery-perpisahan.index')->with('success','Data kegiatan ' . $request->title . ' sekolah berhasil ditambahkan.');
    }

    public function show(GalleryPerpisahan $galleryPerpisahan)
    {
        return view('operator/gallery/perpisahan.show', compact('galleryPerpisahan'));
    }

    public function edit(GalleryPerpisahan $galleryPerpisahan)
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('gallery-perpisahan.index');
        $currentTitle = 'Gallery Perpisahan';
        $editLink = route('gallery-perpisahan.edit', $galleryPerpisahan->id);
        $editTitle = 'Edit';

        return view('operator/gallery/perpisahan.edit', compact('galleryPerpisahan', 'currentLink', 'currentTitle', 'editLink', 'editTitle'));
    }

    public function update(Request $request, GalleryPerpisahan $galleryPerpisahan)
    {
        $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'title.required' => 'Nama kegiatan perpisahan harus diisi',
            'subtitle.required' => 'Deskripsi kegiatan perpisahan harus diisi'
        ]);

        if ($request->hasFile('gambar')) {
            $nama = $request->title;
            $tanggal = now()->format('Ymd_His');
            $extension = $request->gambar->extension();
            $imageName = $nama . '_' . $tanggal . '.' . $extension;
            
            // Pindahkan file ke direktori public_path dengan nama file baru
            $request->gambar->move(public_path('images/gallery/perpisahan'), $imageName);

            // Hapus gambar lama jika ada gambar baru
            if ($galleryPerpisahan->gambar && file_exists(public_path('images/gallery/perpisahan/' . $galleryPerpisahan->gambar))) {
                unlink(public_path('images/gallery/perpisahan/' . $galleryPerpisahan->gambar));
            }

            // Simpan nama file gambar baru di database
            $galleryPerpisahan->gambar = $imageName;
        }

        // Memperbarui dan simpan data baru dari title
        $galleryPerpisahan->title = $request->title;
        $galleryPerpisahan->subtitle = $request->subtitle;
        $galleryPerpisahan->save();
        
        return redirect()->route('gallery-perpisahan.index')->with('success', 'Data kegiatan ' . $galleryPerpisahan->title . ' sekolah berhasil diupdate.');
    }

    public function destroy(GalleryPerpisahan $galleryPerpisahan)
    {
        if ($galleryPerpisahan->gambar && file_exists(public_path('images/gallery/perpisahan/' . $galleryPerpisahan->gambar))) {
            unlink(public_path('images/gallery/perpisahan/' . $galleryPerpisahan->gambar));
        }
        $galleryPerpisahan->delete();
        return redirect()->route('gallery-perpisahan.index')->with('danger','Data kegiatan ' . $galleryPerpisahan->title . ' sekolah berhasil dihapus.');          
    }
}
