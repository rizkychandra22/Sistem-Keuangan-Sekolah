<?php

namespace App\Http\Controllers;

use App\Models\BeritaSekolah;
use App\Models\GalleryEvent;
use App\Models\GalleryLomba;
use App\Models\GalleryPariwisata;
use App\Models\GalleryPerpisahan;
use App\Models\Guru;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Prestasi;
use App\Models\Programkerja;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class LoginController extends Controller
{
    public function siswa()
    {
        // Route dan nama halaman yang di akses
        $currentLink = "/student/home";
        $currentTitle = 'Dashboard';

        return view('siswa.index', compact('currentLink', 'currentTitle'));
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

    public function admin()
    {
        // Route dan nama halaman yang di akses
        $currentLink = "/dashboard/admin";
        $currentTitle = 'Dashboard';

        return view('admin.index', compact('currentLink', 'currentTitle'));
    }

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

    public function operator()
    {
        // Mengambil postingan website dari database dengan query builder
        $gurus = Guru::all();
        $prestasis = Prestasi::all();
        $gallery_lombas = GalleryLomba::all();
        $gallery_events = GalleryEvent::all();
        $gallery_pariwisatas = GalleryPariwisata::all();
        $gallery_perpisahans = GalleryPerpisahan::all();
        $programkerjas = Programkerja::all();
        $berita_sekolahs = BeritaSekolah::all();


        // Menghitung total postingan website
        $totalGuru = $gurus->count();
        $totalPrestasi = $prestasis->count();
        $totalLomba = $gallery_lombas->count();
        $totalEvent = $gallery_events->count();
        $totalTour = $gallery_pariwisatas->count();
        $totalPerpisahan = $gallery_perpisahans->count();
        $totalProgram = $programkerjas->count();
        $totalBerita = $berita_sekolahs->count();

        // Route dan nama halaman yang di akses
        $currentLink = "/dashboard/operator";
        $currentTitle = 'Dashboard';

        return view('operator.index', compact('gurus', 'totalGuru', 'prestasis', 'totalPrestasi', 'gallery_lombas', 'totalLomba', 'gallery_events', 'totalEvent', 'gallery_pariwisatas', 'totalTour', 'gallery_perpisahans', 'totalPerpisahan', 'totalProgram', 'totalBerita', 'currentLink', 'currentTitle'));
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

    public function keuangan()
    {
        // Mengambil data pemasukan dan pengeluaran dari database dengan query builder
        $pemasukans = Pemasukan::all();
        $pengeluarans = Pengeluaran::all();

        // Menghitung total pemasukan dan pengeluaran
        $totalPemasukan = $pemasukans->sum('jumlah');
        $totalPengeluaran = $pengeluarans->sum('jumlah');

        // Menghitung pemasukan dan pengeluaran bulan ini
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $pemasukansBulanIni = Pemasukan::whereMonth('tanggal', $bulanIni)->whereYear('tanggal', $tahunIni)
                                        ->select('sumber', Pemasukan::raw('SUM(jumlah) as total'))
                                        ->groupBy('sumber')
                                        ->get();
        $pemasukanLabels = $pemasukansBulanIni->pluck('sumber');
        $pemasukanValues = $pemasukansBulanIni->pluck('total');

        $pengeluaransBulanIni = Pengeluaran::whereMonth('tanggal', $bulanIni)->whereYear('tanggal', $tahunIni)
                                            ->select('kebutuhan', Pengeluaran::raw('SUM(jumlah) as total'))
                                            ->groupBy('kebutuhan')
                                            ->get();
        $pengeluaranLabels = $pengeluaransBulanIni->pluck('kebutuhan');
        $pengeluaranValues = $pengeluaransBulanIni->pluck('total');

        // Data untuk diagram pemasukan bulanan
        $bulanLabels = [];
        $pemasukanBulanan = [];
        $pengeluaranBulanan = [];
        
        // Ambil data pemasukan dan pengeluaran bulanan dengan query builder sesuai tahun ini
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $totalPemasukanBulanan = Pemasukan::whereYear('tanggal', $tahunIni)->whereMonth('tanggal', $bulan)->sum('jumlah');
            $totalPengeluaranBulanan = Pengeluaran::whereYear('tanggal', $tahunIni)->whereMonth('tanggal', $bulan)->sum('jumlah');
        
            $bulanLabels[] = Carbon::create()->month($bulan)->monthName;
            $pemasukanBulanan[] = $totalPemasukanBulanan;
            $pengeluaranBulanan[] = $totalPengeluaranBulanan;
        }
        
        // Data untuk diagram pemasukan tahunan
        $tahunLabels = [];
        $pemasukanTahunan = [];
        $pengeluaranTahunan = [];
        
        // Ambil data pemasukan tahunan dengan query builder
        $tahunSekarang = Carbon::now()->year;
        for ($tahun = $tahunSekarang - 4; $tahun <= $tahunSekarang; $tahun++) {
            $totalPemasukanTahunan = Pemasukan::whereYear('tanggal', $tahun)->sum('jumlah');
            $totalPengeluaranTahunan = Pengeluaran::whereYear('tanggal', $tahun)->sum('jumlah');
        
            $tahunLabels[] = $tahun;
            $pemasukanTahunan[] = $totalPemasukanTahunan;
            $pengeluaranTahunan[] = $totalPengeluaranTahunan;
        }

        // Menghitung pemasukan dan pengeluaran bulan ini
        $totalPemasukanBulanIni = Pemasukan::whereMonth('tanggal', $bulanIni)->whereYear('tanggal', $tahunIni)->sum('jumlah');
        $totalPengeluaranBulanIni = Pengeluaran::whereMonth('tanggal', $bulanIni)->whereYear('tanggal', $tahunIni)->sum('jumlah');
        $saldoBulanIni = $totalPemasukanBulanIni - $totalPengeluaranBulanIni;
        
        // Route dan nama halaman yang di akses
        $currentLink = "/dashboard/keuangan";
        $currentTitle = 'Dashboard';

        return view('keuangan.index', compact('pemasukans', 'pengeluarans', 'totalPemasukan', 'totalPengeluaran', 'bulanLabels', 'pemasukanBulanan', 'pengeluaranBulanan', 'tahunLabels', 'pemasukanTahunan', 'pengeluaranTahunan', 'pemasukanLabels', 'pemasukanValues', 'pengeluaranLabels', 'pengeluaranValues', 'totalPemasukanBulanIni', 'totalPengeluaranBulanIni', 'saldoBulanIni', 'bulanIni', 'tahunIni', 'currentLink', 'currentTitle'));
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
}