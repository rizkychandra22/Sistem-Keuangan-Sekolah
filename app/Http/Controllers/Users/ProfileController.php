<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function profileAdmin(): View
    {
        $currentLink = "/dashboard/admin/profile";
        $currentTitle = 'Profile User';
        $user = Auth::user();

        return view('admin.profile', compact('currentLink', 'currentTitle', 'user'));
    }

    public function editProfileAdmin(User $user): View
    {
        $currentLink = "/dashboard/admin/profile";
        $currentTitle = 'Profile User';

        return view('admin.edit-profile', compact('user', 'currentLink', 'currentTitle'));
    }

    public function updateProfileAdmin(Request $request, User $user): RedirectResponse
    {
        return $this->updateCoreUserProfile($request, $user, 'profile.admin');
    }

    public function profileOperator(): View
    {
        $currentLink = "/dashboard/operator/profile";
        $currentTitle = 'Profile User';
        $user = Auth::user();

        return view('operator.profile', compact('currentLink', 'currentTitle', 'user'));
    }

    public function editProfileOperator(User $user): View
    {
        $currentLink = "/dashboard/operator/profile";
        $currentTitle = 'Profile User';

        return view('operator.edit-profile', compact('user', 'currentLink', 'currentTitle'));
    }

    public function updateProfileOperator(Request $request, User $user): RedirectResponse
    {
        return $this->updateCoreUserProfile($request, $user, 'profile.operator');
    }

    public function profileKeuangan(): View
    {
        $currentLink = "/dashboard/keuangan/profile";
        $currentTitle = 'Profile User';
        $user = Auth::user();

        return view('keuangan.profile', compact('currentLink', 'currentTitle', 'user'));
    }

    public function editProfileKeuangan(User $user): View
    {
        $currentLink = "/dashboard/keuangan/profile";
        $currentTitle = 'Profile User';

        return view('keuangan.edit-profile', compact('user', 'currentLink', 'currentTitle'));
    }

    public function updateProfileKeuangan(Request $request, User $user): RedirectResponse
    {
        return $this->updateCoreUserProfile($request, $user, 'profile.keuangan');
    }

    public function profileGuru(): View
    {
        // Route dan nama halaman yang di akses
        $currentLink = "/teacher/home/profile";
        $currentTitle = 'Profile User';

        // Mengambil data pengguna guru yang sedang login
        $user = Auth::user();

        return view('guru.profile', compact('currentLink', 'currentTitle', 'user'));
    }

    public function editProfileGuru(User $user): View
    {
        // Route dan nama halaman yang di akses
        $currentLink = "/teacher/home/profile";
        $currentTitle = 'Profile User';

        return view('guru.edit-profile', compact('user', 'currentLink', 'currentTitle'));
    }

    public function updateProfileGuru(Request $request, User $user): RedirectResponse
    {
        return $this->updateGuruLikeProfile($request, $user, 'profile.guru');
    }

    public function profileSiswa()
    {
        // Route dan nama halaman yang di akses
        $currentLink = "/student/home/profile";
        $currentTitle = 'Profile User';

        // Mengambil data pengguna siswa yang sedang login
        $user = Auth::user();

        return view('siswa.profile', compact('currentLink', 'currentTitle', 'user'));
    }

    public function editProfileSiswa(User $user)
    {
        // Route dan nama halaman yang di akses
        $currentLink = "/student/home/profile";
        $currentTitle = 'Profile User';

        return view('siswa.edit-profile', compact('user', 'currentLink', 'currentTitle'));
    }

    public function updateProfileSiswa(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8',
            'password_confirmation' => 'nullable|string|min:8',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'nisn' => 'nullable|string|max:50',
            'tgl_lhr' => 'nullable|date',
            'alamat' => 'nullable|string',
            'orang_tua' => 'nullable|string|max:255',
            'kontak_orang_tua' => 'nullable|string|max:20',
        ],[
            'name.required' => 'Nama user pengguna tidak boleh kosong',
            'username.required' => 'Username login pengguna tidak boleh kosong',
            'email.required' => 'Email pengguna tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        if ($request->hasFile('gambar')) {
            $name = $request->name;
            $tanggal = now()->format('Ymd_His');
            $extension = $request->gambar->extension();
            $imageName = $name . '_' . $tanggal . '.' . $extension;

            $request->gambar->move(public_path('images/user/siswa'), $imageName);

            if ($user->gambar && file_exists(public_path('images/user/siswa/' . $user->gambar))) {
                unlink(public_path('images/user/siswa/' . $user->gambar));
            }

            $user->gambar = $imageName;
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        if ($user->siswa) {
            $user->siswa->update([
                'nama' => $request->name,
                'nisn' => $request->nisn,
                'tgl_lhr' => $request->tgl_lhr,
                'alamat' => $request->alamat,
                'orang_tua' => $request->orang_tua,
                'kontak_orang_tua' => $request->kontak_orang_tua,
            ]);
        } else {
            Siswa::create([
                'user_id' => $user->id,
                'nama' => $request->name,
                'nisn' => $request->nisn,
                'tgl_lhr' => $request->tgl_lhr,
                'alamat' => $request->alamat,
                'orang_tua' => $request->orang_tua,
                'kontak_orang_tua' => $request->kontak_orang_tua,
            ]);
        }

        return redirect()->route('profile.siswa')->with('success', 'Profile berhasil diperbarui');
    }

    private function updateCoreUserProfile(Request $request, User $user, string $redirectRoute): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'password_confirmation' => 'nullable|required_with:password|same:password',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ], [
            'name.required' => 'Nama user pengguna tidak boleh kosong',
            'username.required' => 'Username login pengguna tidak boleh kosong',
            'email.required' => 'Email pengguna tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'password.min' => 'Password minimal 8 karakter',
            'password_confirmation.required_with' => 'Konfirmasi password harus diisi jika password diubah',
            'password_confirmation.same' => 'Konfirmasi password harus sama dengan password baru',
        ]);

        if ($request->hasFile('gambar')) {
            $name = $request->name;
            $tanggal = now()->format('Ymd_His');
            $extension = $request->gambar->extension();
            $imageName = $name . '_' . $tanggal . '.' . $extension;

            $request->gambar->move(public_path('images/user'), $imageName);

            if ($user->gambar && file_exists(public_path('images/user/' . $user->gambar))) {
                unlink(public_path('images/user/' . $user->gambar));
            }

            $user->gambar = $imageName;
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        return redirect()->route($redirectRoute)->with('success', 'Profile berhasil diperbarui');
    }

    private function updateGuruLikeProfile(Request $request, User $user, string $redirectRoute): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'password_confirmation' => 'nullable|string|min:8|same:password',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'kontak' => 'nullable|string|max:20',
            'motivasi' => 'nullable|string',
        ], [
            'name.required' => 'Nama user pengguna tidak boleh kosong',
            'username.required' => 'Username login pengguna tidak boleh kosong',
            'email.required' => 'Email pengguna tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'password.min' => 'Password minimal 8 karakter',
            'password_confirmation.same' => 'Konfirmasi password harus sama dengan password baru',
        ]);

        if ($request->hasFile('gambar')) {
            $name = $request->name;
            $tanggal = now()->format('Ymd_His');
            $extension = $request->gambar->extension();
            $imageName = $name . '_' . $tanggal . '.' . $extension;

            $request->gambar->move(public_path('images/user'), $imageName);

            if ($user->gambar && file_exists(public_path('images/user/' . $user->gambar))) {
                unlink(public_path('images/user/' . $user->gambar));
            }

            $user->gambar = $imageName;
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        if ($user->guru) {
            $user->guru->update([
                'nama' => $request->name,
                'nip' => $request->nip,
                'jabatan' => $request->jabatan,
                'kontak' => $request->kontak,
                'motivasi' => $request->motivasi,
                'gambar' => $user->gambar,
            ]);
        } else {
            Guru::create([
                'user_id' => $user->id,
                'nama' => $request->name,
                'nip' => $request->nip,
                'jabatan' => $request->jabatan,
                'kontak' => $request->kontak,
                'motivasi' => $request->motivasi,
                'gambar' => $user->gambar,
            ]);
        }

        return redirect()->route($redirectRoute)->with('success', 'Profile berhasil diperbarui');
    }
}
