<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profileAdmin()
    {
        // Route dan nama halaman yang di akses
        $currentLink = "/dashboard/admin/profile";
        $currentTitle = 'Profile User';

        // Mengambil data pengguna dengan role 'admin' dari database
        $users = User::where('role', 'admin')->get();

        return view('admin.profile', compact('currentLink', 'currentTitle', 'users'));
    }

    public function editProfileAdmin(User $user)
    {
        // Route dan nama halaman yang di akses
        $currentLink = "/dashboard/admin/profile";
        $currentTitle = 'Profile User';

        return view('admin.edit-profile', compact('user', 'currentLink', 'currentTitle'));
    }

    public function updateProfileAdmin(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'password' => 'required|nullable|string|min:8',
            'password_confirmation' => 'required|nullable|string|min:8',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'name.required' => 'Nama user pengguna tidak boleh kosong',
            'username.required' => 'Username login pengguna tidak boleh kosong',
            'password.required' => 'Password minimal 8 karakter dan harus menggunakan simbol',
            'password_confirmation.required' => 'Konfirmasi password tidak sesuai',
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
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        return redirect()->route('profile.admin')->with('success', 'Profile berhasil diperbarui');
    }

    public function profileOperator()
    {
        // Route dan nama halaman yang di akses
        $currentLink = "/dashboard/operator/profile";
        $currentTitle = 'Profile User';

        // Mengambil data pengguna dengan role 'operator' dari database
        $users = User::where('role', 'operator')->get();

        return view('operator.profile', compact('currentLink', 'currentTitle', 'users'));
    }

    public function editProfileOperator(User $user)
    {
        // Route dan nama halaman yang di akses
        $currentLink = "/dashboard/operator/profile";
        $currentTitle = 'Profile User';
        $editLink = route('profile.edit.operator', $user->id);
        $editTitle = 'Edit Profile';

        return view('operator.edit-profile', compact('user', 'editLink', 'editTitle', 'currentLink', 'currentTitle'));
    }

    public function updateProfileOperator(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'password' => 'required|nullable|string|min:8',
            'password_confirmation' => 'required|nullable|string|min:8',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'name.required' => 'Nama user pengguna tidak boleh kosong',
            'username.required' => 'Username login pengguna tidak boleh kosong',
            'password.required' => 'Password minimal 8 karakter dan harus menggunakan simbol',
            'password_confirmation.required' => 'Konfirmasi password tidak sesuai',
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
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        return redirect()->route('profile.operator')->with('success', 'Profile berhasil diperbarui');
    }

    public function profileKeuangan()
    {
        
        // Mengambil data pengguna dengan role 'keuangan' dari database
        $users = User::where('role', 'keuangan')->get();
        
        // Route dan nama halaman yang di akses
        $currentLink = "/dashboard/keuangan/profile";
        $currentTitle = 'Profile User';

        return view('keuangan.profile', compact('currentLink', 'currentTitle', 'users'));
    }

    public function editProfileKeuangan(User $user)
    {
        // Route dan nama halaman yang di akses
        $currentLink = "/dashboard/keuangan/profile";
        $currentTitle = 'Profile User';
        $editLink = route('profile.edit.keuangan', $user->id);
        $editTitle = 'Edit Profile';

        return view('keuangan.edit-profile', compact('user', 'editLink', 'editTitle', 'currentLink', 'currentTitle'));
    }

    public function updateProfileKeuangan(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'password' => 'required|nullable|string|min:8',
            'password_confirmation' => 'required|nullable|string|min:8',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'name.required' => 'Nama user pengguna tidak boleh kosong',
            'username.required' => 'Username login pengguna tidak boleh kosong',
            'password.required' => 'Password minimal 8 karakter dan harus menggunakan simbol',
            'password_confirmation.required' => 'Konfirmasi password tidak sesuai',
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
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        return redirect()->route('profile.keuangan')->with('success', 'Profile berhasil diperbarui');
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
            'password' => 'required|nullable|string|min:8',
            'password_confirmation' => 'required|nullable|string|min:8',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ],[
            'name.required' => 'Nama user pengguna tidak boleh kosong',
            'username.required' => 'Username login pengguna tidak boleh kosong',
            'password.required' => 'Password minimal 8 karakter dan harus menggunakan simbol',
            'password_confirmation.required' => 'Konfirmasi password tidak sesuai',
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
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        return redirect()->route('profile.siswa')->with('success', 'Profile berhasil diperbarui');
    }
}