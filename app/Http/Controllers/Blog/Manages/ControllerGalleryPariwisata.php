<?php

namespace App\Http\Controllers\Blog\Manages;

use App\Http\Controllers\Controller;
use App\Models\GalleryPariwisata;
use Illuminate\Http\Request;

class ControllerGalleryPariwisata extends Controller
{
    public function index()
    {
        $dataPariwisata = GalleryPariwisata::orderBy('created_at', 'desc')->get();
        if(request()->ajax()) {
            return datatables()->of($dataPariwisata)
            ->make(true);
        }

        // Route dan nama halaman yang di akses
        $currentLink = route('gallery-pariwisata.index');
        $currentTitle = 'Gallery Study Tour';
        $createLink = route('gallery-pariwisata.create');
        $createTitle = 'Create';

        return view('operator/gallery/studytour.index', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function create()
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('gallery-pariwisata.index');
        $currentTitle = 'Gallery Study Tour';
        $createLink = route('gallery-pariwisata.create');
        $createTitle = 'Create';

        return view('operator/gallery/studytour.create', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'title.required' => 'Tema kegiatan study tour harus diisi',
            'subtitle.required' => 'Deskripsi kegiatan study tour harus diisi',
            'gambar.required' => 'Foto kegiatan study tour harus diisi'
        ]);

        $nama = $request->title;
        $tanggal = now()->format('Ymd_His');
        $extension = $request->gambar->extension();
        $imageName = $nama . '_' . $tanggal . '.' . $extension;
        $request->gambar->move(public_path('images/gallery/studytour'), $imageName);

        GalleryPariwisata::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'gambar' => $imageName,
        ]);

        return redirect()->route('gallery-pariwisata.index')->with('success','Data kegiatan study tour sekolah ' . $request->title . ' berhasil ditambahkan.');
    }

    public function show(GalleryPariwisata $gallery_pariwisatum)
    {
        return view('operator/gallery/studytour.show', compact('gallery_pariwisatum'));
    }

    public function edit(GalleryPariwisata $gallery_pariwisatum)
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('gallery-pariwisata.index');
        $currentTitle = 'Gallery Study Tour';
        $editLink = route('gallery-pariwisata.edit', $gallery_pariwisatum->id);
        $editTitle = 'Edit';

        return view('operator/gallery/studytour.edit', compact('gallery_pariwisatum', 'currentLink', 'currentTitle', 'editLink', 'editTitle'));
    }

    public function update(Request $request, GalleryPariwisata $gallery_pariwisatum)
    {
        $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'title.required' => 'Tema kegiatan study tour harus diisi',
            'subtitle.required' => 'Deskripsi kegiatan study tour harus diisi'
        ]);

        if ($request->hasFile('gambar')) {
            $nama = $request->title;
            $tanggal = now()->format('Ymd_His');
            $extension = $request->gambar->extension();
            $imageName = $nama . '_' . $tanggal . '.' . $extension;
            
            // Pindahkan file ke direktori public_path dengan nama file baru
            $request->gambar->move(public_path('images/gallery/studytour'), $imageName);

            // Hapus gambar lama jika ada gambar baru
            if ($gallery_pariwisatum->gambar && file_exists(public_path('images/gallery/studytour/' . $gallery_pariwisatum->gambar))) {
                unlink(public_path('images/gallery/studytour/' . $gallery_pariwisatum->gambar));
            }

            // Simpan nama file gambar baru di database
            $gallery_pariwisatum->gambar = $imageName;
        }

        // Memperbarui dan simpan data baru dari title
        $gallery_pariwisatum->title = $request->title;
        $gallery_pariwisatum->subtitle = $request->subtitle;
        $gallery_pariwisatum->save();
        
        return redirect()->route('gallery-pariwisata.index')->with('success', 'Data kegiatan study tour sekolah ' . $gallery_pariwisatum->title . ' berhasil diupdate.');
    }

    public function destroy(GalleryPariwisata $gallery_pariwisatum)
    {
        if ($gallery_pariwisatum->gambar && file_exists(public_path('images/gallery/studytour/' . $gallery_pariwisatum->gambar))) {
            unlink(public_path('images/gallery/studytour/' . $gallery_pariwisatum->gambar));
        }
        $gallery_pariwisatum->delete();
        return redirect()->route('gallery-pariwisata.index')->with('danger','Data kegiatan study tour sekolah ' . $gallery_pariwisatum->title . ' berhasil dihapus.');          
    }
}
