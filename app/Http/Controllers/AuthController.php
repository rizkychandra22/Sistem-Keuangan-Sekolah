<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function indexLogin()
    {
        return view('auth.login');
    }

    public function indexRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ], [
            'name.required' => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak sesuai'
        ]);

        $imageName = null;
        if ($request->hasFile('gambar')) {
            $name = $request->name;
            $tanggal = now()->format('Ymd_His');
            $extension = $request->gambar->extension();
            $imageName = $name . '_' . $tanggal . '.' . $extension;

            $request->gambar->move(public_path('images/user/siswa'), $imageName);
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'gambar' => $imageName,
            'role' => 'siswa'
        ]);

        return redirect('/login')->with('success', 'Registrasi telah berhasil. Silakan login untuk mengakses halaman selanjutnya.');
    }

    function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ],[
            'username.required' => 'Username harus diisi',
            'password.required' => 'Password harus diisi'
        ]);

        $datalogin = $request->only('username', 'password');

        if (Auth::attempt($datalogin)) {
            if (Auth::user()->role == 'keuangan') {
            return redirect('dashboard/keuangan');
            } elseif (Auth::user()->role == 'admin') {
                return redirect('dashboard/admin');
            } elseif (Auth::user()->role == 'operator') {
                return redirect('dashboard/operator');
            } elseif (Auth::user()->role == 'siswa') {
                return redirect('student/home');
            }
        }
        return redirect()->back()->withErrors([
            'loginError' => 'Username atau Password yang dimasukan tidak sesuai'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
