<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
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
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function admin()
    {
        // Menghitung total data dari database
        $totalGuru = Guru::count();

        // Route dan nama halaman yang di akses
        $currentLink = "/dashboard/admin";
        $currentTitle = 'Dashboard';

        return view('admin.index', compact('totalGuru', 'currentLink', 'currentTitle'));
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
    
    public function operator()
    {
        // Menghitung total data postingan website dari database
        $totalPrestasi = Prestasi::count();
        $totalLomba = GalleryLomba::count();
        $totalEvent = GalleryEvent::count();
        $totalTour = GalleryPariwisata::count();
        $totalPerpisahan = GalleryPerpisahan::count();
        $totalProgram = Programkerja::count();
        $totalBerita = BeritaSekolah::count();

        // Route dan nama halaman yang di akses
        $currentLink = "/dashboard/operator";
        $currentTitle = 'Dashboard';

        return view('operator.index', compact(
            'totalPrestasi',
            'totalLomba',
            'totalEvent',
            'totalTour',
            'totalPerpisahan',
            'totalProgram',
            'totalBerita',
            'currentLink',
            'currentTitle'
        ));
    }
    
    public function guru()
    {
        // Route dan nama halaman yang di akses
        $currentLink = "/teacher/home";
        $currentTitle = 'Dashboard';

        return view('guru.index', compact('currentLink', 'currentTitle'));
    }

    public function siswa()
    {
        // Route dan nama halaman yang di akses
        $currentLink = "/student/home";
        $currentTitle = 'Dashboard';

        return view('siswa.index', compact('currentLink', 'currentTitle'));
    }
}
