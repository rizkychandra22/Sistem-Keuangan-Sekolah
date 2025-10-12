<?php

namespace App\Http\Controllers;

use App\Models\ContactSekolah;
use Illuminate\Http\Request;

class ControllerContact extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('contact-sekolah.index');
        $currentTitle = 'Contact';

        $contact_sekolahs = ContactSekolah::all();
        return view('operator/contact.index', compact('contact_sekolahs', 'currentLink', 'currentTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactSekolah $contactSekolah)
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('contact-sekolah.index');
        $currentTitle = 'Contact';
        $editLink = route('contact-sekolah.edit', $contactSekolah->id);
        $editTitle = 'Edit';

        return view('operator/contact.edit', compact('contactSekolah', 'currentLink', 'currentTitle', 'editLink', 'editTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactSekolah $contactSekolah)
    {
        $request->validate([
            'icon' => 'required',
            'name' => 'required',
            'link' => 'required',
        ],[
            'icon.required' => 'Icon sosial media harus diisi',
            'name.required' => 'Nama sosial media harus diisi',
            'link.required' => 'URL sosial media harus diisi'
        ]);

        // Memperbarui dan simpan data baru
        $contactSekolah->icon = $request->icon;
        $contactSekolah->name = $request->name;
        $contactSekolah->link = $request->link;
        $contactSekolah->save();
        
        return redirect()->route('contact-sekolah.index')->with('success', 'Data contact sekolah dengan nama ' . $contactSekolah->name . ' berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
