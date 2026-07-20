<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ControllerSiswa extends Controller
{
    private const SISWA_IMAGE_PATH = 'images/user/siswa';

    public function index()
    {
        $dataSiswa = Siswa::query()->orderBy('created_at', 'desc')->get();

        if (request()->ajax()) {
            return datatables()->of($dataSiswa)->make(true);
        }

        $currentLink = route('siswa.index');
        $currentTitle = 'Siswa Sekolah';
        $createLink = route('siswa.create');
        $createTitle = 'Tambah';

        return view('admin.siswa.index', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function create()
    {
        $currentLink = route('siswa.index');
        $currentTitle = 'Siswa Sekolah';
        $createLink = route('siswa.create');
        $createTitle = 'Tambah';

        return view('admin.siswa.create', compact('currentLink', 'currentTitle', 'createLink', 'createTitle'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'nisn' => 'required|string|max:50|unique:siswas,nisn',
            'tgl_lhr' => 'required|date',
            'alamat' => 'nullable|string',
            'orang_tua' => 'required|string|max:255',
            'kontak_orang_tua' => 'nullable|string|max:20',
            'status_akademik' => ['required', Rule::in(['aktif', 'lulus', 'keluar', 'pindah'])],
            'is_active' => 'required|boolean',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ], [
            'name.required' => 'Nama siswa harus diisi',
            'username.required' => 'Username akun siswa harus diisi',
            'username.unique' => 'Username akun siswa sudah digunakan',
            'email.required' => 'Email akun siswa harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email akun siswa sudah digunakan',
            'nisn.required' => 'NISN siswa harus diisi',
            'nisn.unique' => 'NISN siswa sudah digunakan',
            'tgl_lhr.required' => 'Tanggal lahir siswa harus diisi',
            'orang_tua.required' => 'Nama orang tua harus diisi',
            'status_akademik.required' => 'Status akademik siswa harus dipilih',
            'is_active.required' => 'Status aktif siswa harus dipilih',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $imageName = $this->storeSiswaImage($request, $validated['name']);

            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'role' => 'student',
                'password' => Hash::make('sekolah'),
            ]);

            Siswa::create([
                'user_id' => $user->id,
                'nisn' => $validated['nisn'],
                'nama' => $validated['name'],
                'tgl_lhr' => $validated['tgl_lhr'],
                'alamat' => $validated['alamat'],
                'orang_tua' => $validated['orang_tua'],
                'kontak_orang_tua' => $validated['kontak_orang_tua'],
                'status_akademik' => $validated['status_akademik'],
                'is_active' => (bool) $validated['is_active'],
                'gambar' => $imageName,
            ]);
        });

        return redirect()->route('siswa.index')->with('success', 'Data siswa dan akun user ' . $validated['username'] . ' berhasil ditambahkan dengan password default sekolah.');
    }

    public function edit(Siswa $siswa)
    {
        $siswa->load('user');

        $currentLink = route('siswa.index');
        $currentTitle = 'Siswa Sekolah';
        $editLink = route('siswa.edit', $siswa->id);
        $editTitle = 'Edit';

        return view('admin.siswa.edit', compact('siswa', 'currentLink', 'currentTitle', 'editLink', 'editTitle'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($siswa->user_id),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($siswa->user_id),
            ],
            'nisn' => [
                'required',
                'string',
                'max:50',
                Rule::unique('siswas', 'nisn')->ignore($siswa->id),
            ],
            'tgl_lhr' => 'required|date',
            'alamat' => 'nullable|string',
            'orang_tua' => 'required|string|max:255',
            'kontak_orang_tua' => 'nullable|string|max:20',
            'status_akademik' => ['required', Rule::in(['aktif', 'lulus', 'keluar', 'pindah'])],
            'is_active' => 'required|boolean',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ], [
            'name.required' => 'Nama siswa harus diisi',
            'username.required' => 'Username akun siswa harus diisi',
            'username.unique' => 'Username akun siswa sudah digunakan',
            'email.required' => 'Email akun siswa harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email akun siswa sudah digunakan',
            'nisn.required' => 'NISN siswa harus diisi',
            'nisn.unique' => 'NISN siswa sudah digunakan',
            'tgl_lhr.required' => 'Tanggal lahir siswa harus diisi',
            'orang_tua.required' => 'Nama orang tua harus diisi',
            'status_akademik.required' => 'Status akademik siswa harus dipilih',
            'is_active.required' => 'Status aktif siswa harus dipilih',
        ]);

        DB::transaction(function () use ($validated, $siswa, $request) {
            $imageName = $this->storeSiswaImage($request, $validated['name']);

            $siswa->user->update([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
            ]);

            $siswa->update([
                'nisn' => $validated['nisn'],
                'nama' => $validated['name'],
                'tgl_lhr' => $validated['tgl_lhr'],
                'alamat' => $validated['alamat'],
                'orang_tua' => $validated['orang_tua'],
                'kontak_orang_tua' => $validated['kontak_orang_tua'],
                'status_akademik' => $validated['status_akademik'],
                'is_active' => (bool) $validated['is_active'],
                'gambar' => $imageName ?: $siswa->gambar,
            ]);

            if ($imageName) {
                $this->deleteSiswaImageIfNeeded($siswa->getOriginal('gambar'));
            }
        });

        return redirect()->route('siswa.index')->with('success', 'Data siswa ' . $validated['name'] . ' berhasil diupdate.');
    }

    public function destroy(Siswa $siswa)
    {
        $nama = $siswa->nama;

        DB::transaction(function () use ($siswa) {
            $this->deleteSiswaImageIfNeeded($siswa->gambar);
            $user = $siswa->user;
            $siswa->delete();

            if ($user) {
                $user->delete();
            }
        });

        return response()->json([
            'message' => 'Data siswa ' . $nama . ' berhasil dihapus.',
        ]);
    }

    private function storeSiswaImage(Request $request, string $nama): ?string
    {
        if (! $request->hasFile('gambar')) {
            return null;
        }

        $tanggal = now()->format('Ymd_His');
        $extension = $request->file('gambar')->extension();
        $imageName = $nama . '_' . $tanggal . '.' . $extension;
        $request->file('gambar')->move(public_path(self::SISWA_IMAGE_PATH), $imageName);

        return $imageName;
    }

    private function deleteSiswaImageIfNeeded(?string $gambar): void
    {
        if (! $gambar) {
            return;
        }

        $imagePath = public_path(self::SISWA_IMAGE_PATH . '/' . $gambar);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
}
