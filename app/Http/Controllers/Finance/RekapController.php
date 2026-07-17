<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class RekapController extends Controller
{
    public function indexPemasukan(Request $request)
    {
        // Jika request datang melalui AJAX dari filter tanggal
        if ($request->ajax()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
    
            // Jika input tanggal kosong, ambil bulan dan tahun saat ini
            if (empty($startDate) || empty($endDate)) {
                $startDate = now()->startOfMonth()->toDateString();  // Tanggal awal bulan saat ini
                $endDate = now()->endOfMonth()->toDateString();      // Tanggal akhir bulan saat ini
            }
    
            // Filter data pemasukan berdasarkan tanggal
            $filteredData = Pemasukan::whereBetween('tanggal', [$startDate, $endDate])
                ->orderBy('sumber', 'asc')
                ->get();
    
            return datatables()->of($filteredData)->make(true);
        }

        $currentLink = route('rekap.pemasukan');
        $currentTitle = 'Rekap Pemasukan';

        return view('keuangan/rekap/pemasukan', compact('currentLink', 'currentTitle'));
    }

    public function indexPengeluaran(Request $request)
    {
        // Jika request datang melalui AJAX dari filter tanggal
        if ($request->ajax()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
    
            // Jika input tanggal kosong, ambil bulan dan tahun saat ini
            if (empty($startDate) || empty($endDate)) {
                $startDate = now()->startOfMonth()->toDateString();  // Tanggal awal bulan saat ini
                $endDate = now()->endOfMonth()->toDateString();      // Tanggal akhir bulan saat ini
            }
    
            // Filter data pengeluaran berdasarkan tanggal
            $filteredData = Pengeluaran::whereBetween('tanggal', [$startDate, $endDate])
                ->orderBy('sumber', 'asc')
                ->get();
    
            return datatables()->of($filteredData)->make(true);
        }

        $currentLink = route('rekap.pengeluaran');
        $currentTitle = 'Rekap Pengeluaran';

        return view('keuangan/rekap/pengeluaran', compact('currentLink', 'currentTitle'));
    }


    public function rekapTransaksi(Request $request)
    {
        // Ambil tahun dan bulan yang dipilih dari request, jika tidak ada, gunakan tahun ini dan bulan ini
        $tahunDipilih = $request->input('tahun', Carbon::now()->year);
        $bulanDipilih = $request->input('bulan', Carbon::now()->month);

        $bulanLabels = [];
        $pemasukanBulanan = [];
        $pengeluaranBulanan = [];
        $saldoBulanan = [];

        $saldoAwal = 0;

        // Ambil bulan sekarang untuk pengecekan bulan yang sudah dijalani
        $currentMonth = Carbon::now()->month;

        // Ambil data pemasukan bulanan dengan query builder
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $totalPemasukanBulanan = Pemasukan::whereYear('tanggal', $tahunDipilih)
                                            ->whereMonth('tanggal', $bulan)
                                            ->sum('jumlah');
            $totalPengeluaranBulanan = Pengeluaran::whereYear('tanggal', $tahunDipilih)
                                                ->whereMonth('tanggal', $bulan)
                                                ->sum('jumlah');

            $bulanLabels[] = Carbon::create()->month($bulan)->monthName;

            // Jika bulan ini tidak memiliki pemasukan atau pengeluaran, gunakan sisa saldo bulan sebelumnya sebagai saldo
            if ($totalPemasukanBulanan == 0 && $totalPengeluaranBulanan == 0) {
                $pemasukanBulanan[] = 0;
                $pengeluaranBulanan[] = 0;
                $saldoBulanan[] = $saldoAwal; // Gunakan saldo bulan sebelumnya
            } else {
                $pemasukanBulanan[] = $totalPemasukanBulanan;
                $pengeluaranBulanan[] = $totalPengeluaranBulanan;
                $saldoBulanan[] = $saldoAwal + $totalPemasukanBulanan - $totalPengeluaranBulanan;
            }

            $saldoAwal = end($saldoBulanan);
        }

        // Hitung total pemasukan, pengeluaran, dan saldo akhir tahun ini
        $totalPemasukanTahunIni = array_sum($pemasukanBulanan);
        $totalPengeluaranTahunIni = array_sum($pengeluaranBulanan);
        $saldoAkhirTahunIni = end($saldoBulanan);

        // Ambil data kategori pemasukan dan pengeluaran berdasarkan bulan yang dipilih
        $pemasukanPerPage = $request->get('request-pemasukan-page', 10); // Jumlah item per halaman, default 10
        $pengeluaranPerPage = $request->get('request-pengeluaran-page', 10); // Jumlah item per halaman, default 10

        // Pagination untuk pemasukan
        $pemasukanPage = $request->query('pemasukan-page', 1);
        $kategoriPemasukan = Pemasukan::select('sumber', 'keterangan', 'tanggal', Pemasukan::raw('SUM(jumlah) as total'))
                                    ->whereYear('tanggal', $tahunDipilih)
                                    ->whereMonth('tanggal', $bulanDipilih)
                                    ->groupBy('sumber', 'keterangan', 'tanggal')
                                    ->orderBy('tanggal', 'desc')
                                    ->paginate($pemasukanPerPage, ['*'], 'pemasukan-page', $pemasukanPage);

        $totalPemasukanKategori = Pemasukan::whereYear('tanggal', $tahunDipilih)
                                        ->whereMonth('tanggal', $bulanDipilih)
                                        ->sum('jumlah');

        // Pagination untuk pengeluaran
        $pengeluaranPage = $request->query('pengeluaran-page', 1);
        $kategoriPengeluaran = Pengeluaran::select('kebutuhan', 'keterangan', 'tanggal', 'sumber', Pengeluaran::raw('SUM(jumlah) as total'))
                                        ->whereYear('tanggal', $tahunDipilih)
                                        ->whereMonth('tanggal', $bulanDipilih)
                                        ->groupBy('kebutuhan', 'keterangan', 'tanggal', 'sumber')
                                        ->orderBy('tanggal', 'desc')
                                        ->paginate($pengeluaranPerPage, ['*'], 'pengeluaran-page', $pengeluaranPage);

        $totalPengeluaranKategori = Pengeluaran::whereYear('tanggal', $tahunDipilih)
                                            ->whereMonth('tanggal', $bulanDipilih)
                                            ->sum('jumlah');

        $kategoriPemasukan->appends([
            'request-pemasukan-page' => $pemasukanPerPage,
            'request-pengeluaran-page' => $pengeluaranPerPage
        ]);

        $kategoriPengeluaran->appends([
            'request-pemasukan-page' => $pemasukanPerPage,
            'request-pengeluaran-page' => $pengeluaranPerPage
        ]);

        $tahunList = collect(range(Carbon::now()->year - 4, Carbon::now()->year));

        // Route dan nama halaman yang diakses
        $currentLink = route('rekap.transaksi');
        $currentTitle = 'Rekap Transaksi';

        return view('keuangan.rekap.transaksi', compact(
            'tahunDipilih', 'bulanDipilih', 'tahunList', 'bulanLabels', 'pemasukanBulanan', 'pengeluaranBulanan', 'saldoBulanan', 
            'totalPemasukanTahunIni', 'totalPengeluaranTahunIni', 'saldoAkhirTahunIni', 'kategoriPemasukan', 'kategoriPengeluaran',
            'totalPemasukanKategori', 'totalPengeluaranKategori', 'currentLink', 'currentTitle'
        ));
    }
}
