<?php

namespace App\Http\Controllers;

use App\Models\GalleryEvent;
use Illuminate\Http\Request;

class ControllerGalleryEvent extends Controller
{
    public function index()
    {
        $dataEvent = GalleryEvent::orderBy('created_at', 'desc')->get();
        if(request()->ajax()) {
            return datatables()->of($dataEvent)
            ->make(true);
        }

        // Route dan nama halaman yang di akses
        $currentLink = route('gallery-event.index');
        $currentTitle = 'Gallery Event';
        $createLink = route('gallery-event.create');
        $createTitle = 'Create';

        return view('operator/gallery/event.index', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function create()
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('gallery-event.index');
        $currentTitle = 'Gallery Event';
        $createLink = route('gallery-event.create');
        $createTitle = 'Create';

        return view('operator/gallery/event.create', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'title.required' => 'Nama event harus diisi',
            'subtitle.required' => 'Deskripsi event harus diisi',
            'gambar.required' => 'Foto event harus diisi'
        ]);

        $nama = $request->title;
        $tanggal = now()->format('Ymd_His');
        $extension = $request->gambar->extension();
        $imageName = $nama . '_' . $tanggal . '.' . $extension;
        $request->gambar->move(public_path('images/gallery/event'), $imageName);

        GalleryEvent::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'gambar' => $imageName,
        ]);

        return redirect()->route('gallery-event.index')->with('success', 'Data event ' . $request->title . ' berhasil ditambahkan.');
    }

    public function show(GalleryEvent $galleryEvent)
    {
        return view('operator/gallery/event.show', compact('galleryEvent'));
    }

    public function edit(GalleryEvent $galleryEvent)
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('gallery-event.index');
        $currentTitle = 'Gallery Event';
        $editLink = route('gallery-event.edit', $galleryEvent->id);
        $editTitle = 'Edit';
        
        return view('operator/gallery/event.edit', compact('galleryEvent', 'currentLink', 'currentTitle', 'editLink', 'editTitle'));
    }

    public function update(Request $request, GalleryEvent $galleryEvent)
    {
        $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'title.required' => 'Nama event harus diisi',
            'subtitle.required' => 'Deskripsi event harus diisi'
        ]);

        if ($request->hasFile('gambar')) {
            $nama = $request->title;
            $tanggal = now()->format('Ymd_His');
            $extension = $request->gambar->extension();
            $imageName = $nama . '_' . $tanggal . '.' . $extension;
            
            // Pindahkan file ke direktori public_path dengan nama file baru
            $request->gambar->move(public_path('images/gallery/event'), $imageName);

            // Hapus gambar lama jika ada gambar baru
            if ($galleryEvent->gambar && file_exists(public_path('images/gallery/event/' . $galleryEvent->gambar))) {
                unlink(public_path('images/gallery/event/' . $galleryEvent->gambar));
            }

            // Simpan nama file gambar baru di database
            $galleryEvent->gambar = $imageName;
        }

        // Memperbarui dan simpan data baru dari title
        $galleryEvent->title = $request->title;
        $galleryEvent->subtitle = $request->subtitle;
        $galleryEvent->save();
        
        return redirect()->route('gallery-event.index')->with('success', 'Data event ' . $galleryEvent->title . ' berhasil diupdate.');
    }

    public function destroy(GalleryEvent $galleryEvent)
    {
        if ($galleryEvent->gambar && file_exists(public_path('images/gallery/event/' . $galleryEvent->gambar))) {
            unlink(public_path('images/gallery/event/' . $galleryEvent->gambar));
        }
        $galleryEvent->delete();
        return redirect()->route('gallery-event.index')->with('danger','Data event ' . $galleryEvent->title . ' berhasil dihapus.');          
    }
}
