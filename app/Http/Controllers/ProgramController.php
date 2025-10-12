<?php

namespace App\Http\Controllers;

use App\Models\Programkerja;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataProgram = Programkerja::orderBy('created_at', 'desc')->get();
        if(request()->ajax()) {
            return datatables()->of($dataProgram)
            ->make(true);
        }

        // Route dan nama halaman yang di akses
        $currentLink = route('program-kerja.index');
        $currentTitle = 'Program Kerja';
        $createLink = route('program-kerja.create');
        $createTitle = 'Create';

        return view ('operator/program.index', compact('currentLink', 'currentTitle', 'createLink', 'createTitle')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('program-kerja.index');
        $currentTitle = 'Program Kerja';
        $createLink = route('program-kerja.create');
        $createTitle = 'Create';

        return view ('operator/program.create', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required'
        ],[
            'judul.required' => 'Judul program kerja harus diisi',
            'deskripsi.required' => 'Deskripsi program kerja harus diisi',
        ]);

        Programkerja::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('program-kerja.index')->with('success','Data program kerja ' . $request->judul . ' berhasil ditambahkan.');
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
    public function edit(Programkerja $programKerja)
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('program-kerja.index');
        $currentTitle = 'Program Kerja';
        $editLink = route('program-kerja.edit', $programKerja->id);
        $editTitle = 'Edit';

        return view('operator/program.edit', compact('programKerja', 'currentLink', 'currentTitle', 'editLink', 'editTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Programkerja $programKerja)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required'
        ],[
            'judul.required' => 'Judul program kerja harus diisi',
            'deskripsi.required' => 'Deskripsi program kerja harus diisi',
        ]);

        $programKerja->judul = $request->judul;
        $programKerja->deskripsi = $request->deskripsi;
        $programKerja->save();
        
        return redirect()->route('program-kerja.index')->with('success', 'Data program kerja ' . $programKerja->judul . ' berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Programkerja $programKerja)
    {
        $programKerja->delete();
        return redirect()->route('program-kerja.index')->with('danger','Data program kerja ' . $programKerja->title . ' berhasil dihapus.');          
    }
}
