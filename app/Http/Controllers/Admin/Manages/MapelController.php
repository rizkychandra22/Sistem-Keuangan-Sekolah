<?php

namespace App\Http\Controllers\Admin\Manages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('mapel.index');
        $currentTitle = 'Mata Pelajaran';
        $createLink = route('mapel.create');
        $createTitle = 'Tambah';

        return view('admin/mapel.index', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('mapel.index');
        $currentTitle = 'Mata Pelajaran';
        $createLink = route('mapel.create');
        $createTitle = 'Tambah';

        return view('admin/mapel.create', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
