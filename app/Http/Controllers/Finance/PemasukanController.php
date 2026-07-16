<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PemasukanExport;
use App\Models\Enums\SumberDana;
use App\Models\Pengeluaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PemasukanController extends Controller
{
    public function exportExcel(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        return Excel::download(new PemasukanExport($startDate, $endDate), 'pemasukan keuangan sekolah.xlsx');
    }

    public function exportPDF(Request $request)
    {
        // Default bulan dan tahun saat ini
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $pemasukans = Pemasukan::whereBetween('tanggal', [$startDate, $endDate])->orderBy('created_at', 'desc')->get();    
        $totalPemasukan = $pemasukans->sum('jumlah');

        // Menghitung sumber pemasukan berdasarkan bulan yang dipilih
        $sumbermasukBulanIni = Pemasukan::whereBetween('tanggal', [$startDate, $endDate])
            ->select('sumber', Pemasukan::raw('SUM(jumlah) as total'))
            ->groupBy('sumber')
            ->get();

        $pdf = Pdf::loadView('keuangan/pemasukans.pemasukanPDF', compact('pemasukans', 'totalPemasukan', 'sumbermasukBulanIni', 'startDate', 'endDate'));
        return $pdf->download('pemasukan keuangan sekolah.pdf');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataPemasukan = Pemasukan::orderBy('created_at', 'desc')->get();
        if(request()->ajax()) {
            return datatables()->of($dataPemasukan)
            ->make(true);
        }

        $currentLink = route('pemasukan.index');
        $currentTitle = 'Pemasukan';

        return view('keuangan.pemasukans.index', compact('currentLink', 'currentTitle'));
    }

    public function detail(Request $request)
    {
        // Default bulan dan tahun saat ini
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        // Mengambil data pemasukan dari database
        $pemasukans = Pemasukan::all();
        $pengeluaras = Pengeluaran::all();

        // Menghitung pemasukan berdasarkan bulan yang dipilih
        $pemasukansBulanIni = Pemasukan::whereMonth('tanggal', $bulan)
                                ->whereYear('tanggal', $tahun)
                                ->select('sumber', Pemasukan::raw('SUM(jumlah) as total'))
                                ->groupBy('sumber')
                                ->get();

        // Menghitung total pemasukan bulan ini
        $totalPemasukanBulanIni = $pemasukansBulanIni->sum('total');

        // Menghitung pengeluaran berdasarkan sumber dari bulan yang dipilih
        $sumberkeluarBulanIni = Pengeluaran::whereMonth('tanggal', $bulan)
                                ->whereYear('tanggal', $tahun)
                                ->select('sumber', Pengeluaran::raw('SUM(jumlah) as total'))
                                ->groupBy('sumber')
                                ->get();

        // Menghitung total pengeluaran bulan ini
        $totalPengeluaranBulanIni = $sumberkeluarBulanIni->sum('total');

        // Menghitung sisa saldo bulan ini
        $sisaSaldoBulanan = $totalPemasukanBulanIni - $totalPengeluaranBulanIni;

        $sumberSelisihBulanan = [];
        // Menghitung selisih antara pemasukan dan pengeluaran berdasarkan sumber
        foreach ($pemasukansBulanIni as $pemasukan) {
            $pengeluaran = $sumberkeluarBulanIni->firstWhere('sumber', $pemasukan->sumber);
            $selisih = $pemasukan->total - ($pengeluaran ? $pengeluaran->total : 0);
            $sumberSelisihBulanan[] = [
                'sumberPemasukan' => $pemasukan->sumber,
                'totalPemasukan' => $pemasukan->total,
                'sumberPengeluaran' => $pengeluaran ? $pengeluaran->sumber : '-',
                'totalPengeluaran' => $pengeluaran ? $pengeluaran->total : 0,
                'selisih' => $selisih
            ];
        }

        foreach ($sumberkeluarBulanIni as $pengeluaran) {
            if (!$pemasukansBulanIni->firstWhere('sumber', $pengeluaran->sumber)) {
                $sumberSelisihBulanan[] = [
                    'sumberPemasukan' => '-',
                    'totalPemasukan' => 0,
                    'sumberPengeluaran' => $pengeluaran->sumber,
                    'totalPengeluaran' => $pengeluaran->total,
                    'selisih' => -$pengeluaran->total
                ];
            }
        }

        // Mengambil semua tahun yang ada di database untuk pilihan dropdown
        $tahunList = Pemasukan::select('tanggal')
            ->get()
            ->map(function ($item) {
                return Carbon::parse($item->tanggal)->year;
            })
            ->unique()
            ->values();

        if ($tahunList->isEmpty()) {
            $tahunList->push(Carbon::now()->year);
        }

        // Route dan nama halaman yang di akses
        $currentLink = route('pemasukan.index');
        $currentTitle = 'Pemasukan';
        $detailLink = route('detail.pemasukan');
        $detailTitle = 'Detail';

        return view('keuangan.pemasukans.detail', compact('pemasukans', 'bulan', 'tahun', 'pemasukansBulanIni', 'totalPemasukanBulanIni', 'totalPengeluaranBulanIni', 'sumberSelisihBulanan', 'sisaSaldoBulanan', 'tahunList', 'currentLink', 'currentTitle', 'detailLink', 'detailTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bulan = Carbon::now()->month;

        // Ambil sumber pemasukan yang sudah ada di database
        $pemasukans = Pemasukan::select('sumber')->distinct()->get();

        // Ambil daftar sumber dana
        $sumberValues = [
            'Dana Bos',
            'Dana Pemerintah',
            'Ketua Yayasan',
            'SPP',
            'Koperasi',
            'Dan Lain-Lain',
        ];

        // Hitung saldo pemasukan bulan ini berdasarkan sumber
        $saldoPemasukan = Pemasukan::whereMonth('tanggal', $bulan)
            ->select('sumber', Pemasukan::raw('SUM(jumlah) as total'))
            ->groupBy('sumber')
            ->get()
            ->pluck('total', 'sumber')
            ->toArray();

        // Hitung saldo pengeluaran bulan ini berdasarkan sumber
        $saldoPengeluaran = Pengeluaran::whereMonth('tanggal', $bulan)
            ->select('sumber', Pengeluaran::raw('SUM(jumlah) as total'))
            ->groupBy('sumber')
            ->get()
            ->pluck('total', 'sumber')
            ->toArray();

        // Hitung saldo yang tersedia bulan ini
        $saldoTersedia = [];
        foreach ($sumberValues as $sumber) {
            $totalPemasukan = $saldoPemasukan[$sumber] ?? 0;
            $totalPengeluaran = $saldoPengeluaran[$sumber] ?? 0;
            $saldoTersedia[$sumber] = $totalPemasukan - $totalPengeluaran;
        }

        // Route dan nama halaman yang diakses
        $currentLink = route('pemasukan.index');
        $currentTitle = 'Pemasukan';
        $createLink = route('pemasukan.create');
        $createTitle = 'Create';

        return view('keuangan/pemasukans.create', compact(
            'sumberValues',
            'saldoTersedia',
            'currentLink',
            'currentTitle',
            'createLink',
            'createTitle'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'sumber' => 'required',
            'keterangan' => 'required',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
        ], [
            'sumber.required' => 'Sumber pemasukan dana harus diisi',
            'keterangan.required' => 'Keterangan pemasukan dana harus diisi',
            'jumlah.required' => 'Nominal pemasukan dana harus diisi dengan angka tanpa menggunakan tanda titik dan koma',
            'tanggal.required' => 'Tanggal pemasukan dana harus diisi'
        ]);

        Pemasukan::create($request->all());
        $formatRupiah = 'Rp ' . number_format($request->jumlah, 2, ',', '.');
        return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan sekolah dari sumber ' . $request->sumber . ' dengan nominal sebesar ' . $formatRupiah . ' berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function show(Pemasukan $pemasukan)
    {
        return view('pemasukan.show', compact('pemasukan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pemasukan $pemasukan)
    {
        $bulan = Carbon::now()->month;

        // Ambil semua sumber pemasukan
        $sumberPemasukan = Pemasukan::select('sumber')->distinct()->get();

        // Ambil daftar sumber dana
        $sumberValues = [
            'Dana Bos',
            'Dana Pemerintah',
            'Ketua Yayasan',
            'SPP',
            'Koperasi',
            'Dan Lain-Lain',
        ];

        // Hitung saldo pemasukan bulan ini berdasarkan sumber
        $saldoPemasukan = Pemasukan::whereMonth('tanggal', $bulan)
            ->select('sumber', Pemasukan::raw('SUM(jumlah) as total'))
            ->groupBy('sumber')
            ->get()
            ->pluck('total', 'sumber')
            ->toArray();

        // Hitung saldo pengeluaran bulan ini berdasarkan sumber
        $saldoPengeluaran = Pengeluaran::whereMonth('tanggal', $bulan)
            ->select('sumber', Pengeluaran::raw('SUM(jumlah) as total'))
            ->groupBy('sumber')
            ->get()
            ->pluck('total', 'sumber')
            ->toArray();

        // Hitung saldo yang tersedia bulan ini
        $saldoTersedia = [];
        foreach ($sumberValues as $sumber) {
            $totalPemasukan = $saldoPemasukan[$sumber] ?? 0;
            $totalPengeluaran = $saldoPengeluaran[$sumber] ?? 0;
            $saldoTersedia[$sumber] = $totalPemasukan - $totalPengeluaran;
        }

        // Route dan nama halaman yang diakses
        $currentLink = route('pemasukan.index');
        $currentTitle = 'Pemasukan';
        $editLink = route('pemasukan.edit', $pemasukan->id);
        $editTitle = 'Edit';

        return view('keuangan/pemasukans.edit', compact('sumberValues', 'pemasukan', 'saldoTersedia', 'currentLink', 'currentTitle', 'editLink', 'editTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pemasukan $pemasukan)
    {
        $request->validate([
            'sumber' => 'required',
            'keterangan' => 'required',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
        ],[
            'sumber.required' => 'Sumber pemasukan dana harus diisi',
            'keterangan.required' => 'Keterangan pemasukan dana harus diisi',
            'jumlah.required' => 'Nominal pemasukan dana harus diisi dengan angka tanpa menggunakan tanda titik dan koma',
            'tanggal.required' => 'Tanggal pemasukan dana harus diisi'
        ]);

        $pemasukan->update($request->all());
        return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan sekolah dari sumber ' . $pemasukan->sumber . ' berhasil diedit.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pemasukan $pemasukan)
    {
        $pemasukan->delete();
        return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan dari sumber ' . $pemasukan->sumber . ' berhasil dihapus.');
    }
}
