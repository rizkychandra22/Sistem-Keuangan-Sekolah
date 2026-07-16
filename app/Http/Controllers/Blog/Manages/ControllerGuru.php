<?php

namespace App\Http\Controllers\Blog\Manages;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ControllerGuru extends Controller
{
    public function index()
    {
        $dataGuru = Guru::with('user')->orderBy('created_at', 'desc')->get();
        if(request()->ajax()) {
            return datatables()->of($dataGuru)->make(true);   
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
        $availableUsers = User::query()
            ->where('role', 'guru')
            ->with('guru')
            ->orderBy('username')
            ->get();

        // Route dan nama halaman yang di akses
        $currentLink = route('guru.index');
        $currentTitle = 'Guru Sekolah';
        $createLink = route('guru.create');
        $createTitle = 'Create';

        return view('operator/guru.create', compact('availableUsers', 'currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where(fn ($query) => $query->where('role', 'guru')),
                'unique:gurus,user_id',
            ],
            'nip' => 'required|string|max:255|unique:gurus,nip',
            'jabatan' => 'required|string|max:255',
            'kontak' => 'nullable|string',
            'motivasi' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'user_id.required' => 'Akun user guru harus dipilih',
            'user_id.unique' => 'Akun user guru ini sudah terhubung dengan data guru lain',
            'nip.required' => 'NIP guru harus diisi',
            'nip.unique' => 'NIP guru sudah digunakan',
            'jabatan.required' => 'Jabatan guru harus diisi',
            'motivasi.required' => 'Motivasi guru harus diisi',
            'gambar.required' => 'Foto guru harus diisi'
        ]);

        $selectedUser = User::query()
            ->where('role', 'guru')
            ->findOrFail($validated['user_id']);

        $nama = $selectedUser->name;
        $tanggal = now()->format('Ymd_His');
        $extension = $request->file('gambar')->extension();
        $imageName = $nama . '_' . $tanggal . '.' . $extension;
        $request->file('gambar')->move(public_path('images/guru'), $imageName);

        Guru::create([
            'nama' => $nama,
            'user_id' => $validated['user_id'],
            'nip' => $validated['nip'],
            'jabatan' => $validated['jabatan'],
            'kontak' => $validated['kontak'],
            'motivasi' => $validated['motivasi'],
            'gambar' => $imageName,
        ]);

        return redirect()->route('guru.index')->with('success','Data guru dengan nama ' . $nama . ' berhasil ditambahkan.');
    }

    public function show(Guru $guru)
    {
        return view('operator/guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        $availableUsers = User::query()
            ->where('role', 'guru')
            ->with('guru')
            ->orderBy('username')
            ->get();

        // Route dan nama halaman yang di akses
        $currentLink = route('guru.index');
        $currentTitle = 'Guru Sekolah';
        $editLink = route('guru.edit', $guru->id);
        $editTitle = 'Edit';

        return view('operator/guru.edit', compact('guru', 'availableUsers', 'currentLink', 'currentTitle', 'editLink', 'editTitle'));
    }

    public function update(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where(fn ($query) => $query->where('role', 'guru')),
                Rule::unique('gurus', 'user_id')->ignore($guru->id),
            ],
            'nip' => [
                'required',
                'string',
                'max:255',
                Rule::unique('gurus', 'nip')->ignore($guru->id),
            ],
            'jabatan' => 'required|string|max:255',
            'kontak' => 'nullable|string',
            'motivasi' => 'required|string|max:255',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'user_id.required' => 'Akun user guru harus dipilih',
            'user_id.unique' => 'Akun user guru ini sudah terhubung dengan data guru lain',
            'nip.required' => 'NIP guru harus diisi',
            'nip.unique' => 'NIP guru sudah digunakan',
            'jabatan.required' => 'Jabatan guru harus diisi',
            'motivasi.required' => 'Motivasi guru harus diisi'
        ]);

        $selectedUser = User::query()
            ->where('role', 'guru')
            ->findOrFail($validated['user_id']);

        $nama = $selectedUser->name;

        if ($request->hasFile('gambar')) {
            $tanggal = now()->format('Ymd_His');
            $extension = $request->file('gambar')->extension();
            $imageName = $nama . '_' . $tanggal . '.' . $extension;
            
            // Pindahkan file ke direktori public_path dengan nama file baru
            $request->file('gambar')->move(public_path('images/guru'), $imageName);

            // Hapus gambar lama jika ada gambar baru
            if ($guru->gambar && file_exists(public_path('images/guru/' . $guru->gambar))) {
                unlink(public_path('images/guru/' . $guru->gambar));
            }

            // Simpan nama file gambar baru di database
            $guru->gambar = $imageName;
        }

        // Memperbarui dan simpan data baru dari guru
        $guru->nama = $nama;
        $guru->user_id = $validated['user_id'];
        $guru->nip = $validated['nip'];
        $guru->jabatan = $validated['jabatan'];
        $guru->kontak = $validated['kontak'];
        $guru->motivasi = $validated['motivasi'];
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
