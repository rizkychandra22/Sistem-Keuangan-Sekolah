<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PengeluaranExport;
use App\Models\Pemasukan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PengeluaranController extends Controller
{
    public function exportExcel(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        return Excel::download(new PengeluaranExport($startDate, $endDate), 'pengeluaran keuangan sekolah.xlsx');
    }

    public function exportPDF(Request $request)
    {
        // Default bulan dan tahun saat ini
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $pengeluarans = Pengeluaran::whereBetween('tanggal', [$startDate, $endDate])->orderBy('created_at', 'desc')->get();
        $totalPengeluaran = $pengeluarans->sum('jumlah');
        
        // Menghitung kebutuhan pengeluaran berdasarkan bulan yang dipilih
        $kebutuhanBulanIni = Pengeluaran::whereBetween('tanggal', [$startDate, $endDate])
            ->select('kebutuhan', Pengeluaran::raw('SUM(jumlah) as total'))
            ->groupBy('kebutuhan')
            ->get();

        // Menghitung sumber pengeluaran berdasarkan bulan yang dipilih
        $sumberkeluarBulanIni = Pengeluaran::whereBetween('tanggal', [$startDate, $endDate])
            ->select('sumber', Pengeluaran::raw('SUM(jumlah) as total'))
            ->groupBy('sumber')
            ->get();

        $pdf = Pdf::loadView('keuangan/pengeluarans.pengeluaranPDF', compact('pengeluarans', 'totalPengeluaran', 'kebutuhanBulanIni', 'sumberkeluarBulanIni', 'startDate', 'endDate'));
        return $pdf->download('pengeluaran keuangan sekolah.pdf');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataPengeluaran = Pengeluaran::orderBy('created_at', 'desc')->get();
        if(request()->ajax()) {
            return datatables()->of($dataPengeluaran)
            ->make(true);
        }

        $currentLink = route('pengeluaran.index');
        $currentTitle = 'Pengeluaran';

        return view('keuangan.pengeluarans.index', compact('currentLink', 'currentTitle'));
    }

    public function detail(Request $request)
    {
        // Default bulan dan tahun saat ini
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        // Mengambil data pengeluaran dari database
        $pengeluarans = Pengeluaran::all();
        $pemasukans = Pemasukan::all();

        // Menghitung pemasukan berdasarkan bulan yang dipilih
        $pemasukansBulanIni = Pemasukan::whereMonth('tanggal', $bulan)
                                ->whereYear('tanggal', $tahun)
                                ->select('sumber', Pemasukan::raw('SUM(jumlah) as total'))
                                ->groupBy('sumber')
                                ->get();

        // Menghitung total pemasukan bulan ini
        $totalPemasukanBulanIni = $pemasukansBulanIni->sum('total');

        // Menghitung pengeluaran berdasarkan kebutuhan dari bulan yang dipilih
        $kebutuhanBulanIni = Pengeluaran::whereMonth('tanggal', $bulan)
                                ->whereYear('tanggal', $tahun)
                                ->select('kebutuhan', Pengeluaran::raw('SUM(jumlah) as total'))
                                ->groupBy('kebutuhan')
                                ->get();

        // Menghitung pengeluaran berdasarkan sumber dari bulan yang dipilih
        $sumberkeluarBulanIni = Pengeluaran::whereMonth('tanggal', $bulan)
                                ->whereYear('tanggal', $tahun)
                                ->select('sumber', Pengeluaran::raw('SUM(jumlah) as total'))
                                ->groupBy('sumber')
                                ->get();

        // Menghitung total pengeluaran bulan ini
        $totalPengeluaranBulanIni = $kebutuhanBulanIni->sum('total');

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
        $tahunList = Pengeluaran::selectRaw('YEAR(tanggal) as tahun')
            ->groupBy('tahun')
            ->pluck('tahun');

        // Route dan nama halaman yang di akses
        $currentLink = route('pengeluaran.index');
        $currentTitle = 'Pengeluaran';
        $detailLink = route('detail.pengeluaran');
        $detailTitle = 'Detail';

        return view('keuangan.pengeluarans.detail', compact('bulan', 'tahun', 'pengeluarans', 'kebutuhanBulanIni', 'sumberkeluarBulanIni', 'totalPengeluaranBulanIni', 'totalPemasukanBulanIni', 'sisaSaldoBulanan', 'sumberSelisihBulanan', 'tahunList', 'currentLink', 'currentTitle', 'detailLink', 'detailTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bulan = Carbon::now()->month;

        // Ambil sumber pemasukan yang berbeda
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

        // Ambil daftar kebutuhan dana
        $kebutuhanValues = [
            'Sekolah',
            'Koperasi',
            'Sarana & Prasarana',
            'Kesehatan',
            'Pariwisata',
            'Dan Lain-Lain'
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
        $currentLink = route('pengeluaran.index');
        $currentTitle = 'Pengeluaran';
        $createLink = route('pengeluaran.create');
        $createTitle = 'Create';

        return view('keuangan.pengeluarans.create', compact('kebutuhanValues', 'sumberValues', 'saldoTersedia',  'currentLink', 'currentTitle', 'createLink', 'createTitle'));
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
            'kebutuhan' => 'required',
            'keterangan' => 'required',
            'jumlah' => 'required|numeric',
            'sumber' => 'required',
            'tanggal' => 'required|date',
        ],[
            'kebutuhan.required' => 'Kebutuhan pengeluaran dana harus diisi',
            'keterangan.required' => 'Keterangan pengeluaran dana harus diisi',
            'jumlah.required' => 'Nominal pengeluaran dana harus diisi dengan angka tanpa menggunakan tanda titik dan koma',
            'sumber.required' => 'Sumber pengeluaran dana harus diisi',
            'tanggal.required' => 'Tanggal pengeluaran dana harus diisi'
        ]);

        // Hitung saldo pemasukan dan pengeluaran berdasarkan sumber
        $bulan = Carbon::now()->month;
        $sumber = $request->sumber;

        $totalPemasukan = Pemasukan::whereMonth('tanggal', $bulan)
            ->where('sumber', $sumber)
            ->sum('jumlah');

        $totalPengeluaran = Pengeluaran::whereMonth('tanggal', $bulan)
            ->where('sumber', $sumber)
            ->sum('jumlah');

        $saldoTersedia = $totalPemasukan - $totalPengeluaran;

        // Validasi tambahan: Pastikan pemasukan ada dan mencukupi
        if ($saldoTersedia <= 0) {
            return redirect()->route('pengeluaran.create')->with('danger', 'Input pengeluaran dari sumber ' . $sumber . ' tidak dapat dilakukan karena belum ada pemasukan dari sumber tersebut di bulan ini.');
        }
    
        if ($request->jumlah > $saldoTersedia) {
            return redirect()->route('pengeluaran.create')->with('danger', 'Input pengeluaran dari sumber ' . $sumber . ' tidak dapat dilakukan karena saldo yang tersedia tidak mencukupi.');
        }

        Pengeluaran::create($request->all());
        $formatRupiah = 'Rp ' . number_format($request->jumlah, 2, ',', '.');
        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran untuk kebutuhan ' . $request->kebutuhan . ' dari sumber ' . $request->sumber . ' dengan nominal sebesar ' . $formatRupiah . ' berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function show(Pengeluaran $pengeluaran)
    {
        return view('pengeluarans.show', compact('pengeluaran'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengeluaran $pengeluaran)
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
        
        // Ambil daftar kebutuhan dana
        $kebutuhanValues = [
            'Sekolah',
            'Koperasi',
            'Sarana & Prasarana',
            'Kesehatan',
            'Pariwisata',
            'Dan Lain-Lain'
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

        // Route dan nama halaman yang di akses
        $currentLink = route('pengeluaran.index');
        $currentTitle = 'Pengeluaran';
        $editLink = route('pengeluaran.edit', $pengeluaran->id);
        $editTitle = 'Edit';

        return view('keuangan/pengeluarans.edit', compact('kebutuhanValues', 'sumberValues', 'saldoTersedia', 'pengeluaran', 'currentLink', 'currentTitle', 'editLink', 'editTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $request->validate([
            'kebutuhan' => 'required',
            'keterangan' => 'required',
            'jumlah' => 'required|numeric',
            'sumber' => 'required',
            'tanggal' => 'required|date',
        ],[
            'kebutuhan.required' => 'Kebutuhan pengeluaran dana harus diisi',
            'keterangan.required' => 'Keterangan pengeluaran dana harus diisi',
            'jumlah.required' => 'Nominal pengeluaran dana harus diisi dengan angka tanpa menggunakan tanda titik dan koma',
            'sumber.required' => 'Sumber pengeluaran dana harus diisi',
            'tanggal.required' => 'Tanggal pengeluaran dana harus diisi'
        ]);

        // Hitung saldo pemasukan dan pengeluaran berdasarkan sumber
        $bulan = Carbon::now()->month;
        $sumber = $request->sumber;

        $totalPemasukan = Pemasukan::whereMonth('tanggal', $bulan)
            ->where('sumber', $sumber)
            ->sum('jumlah');

        $totalPengeluaran = Pengeluaran::whereMonth('tanggal', $bulan)
            ->where('sumber', $sumber)
            ->sum('jumlah');

        $saldoTersedia = $totalPemasukan - $totalPengeluaran;

        // Validasi tambahan: Pastikan pemasukan ada dan mencukupi
        if ($saldoTersedia <= 0) {
            return redirect()->route('pengeluaran.edit', $pengeluaran->id)->with('danger', 'Input pengeluaran dari sumber ' . $sumber . ' tidak dapat dilakukan karena belum ada pemasukan dari sumber tersebut di bulan ini.');
        }
    
        if ($request->jumlah > $saldoTersedia) {
            return redirect()->route('pengeluaran.edit', $pengeluaran->id)->with('danger', 'Input pengeluaran dari sumber ' . $sumber . ' tidak dapat dilakukan karena saldo yang tersedia tidak mencukupi.');
        }

        $pengeluaran->update($request->all());
        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran untuk kebutuhan ' . $pengeluaran->kebutuhan . ' dari sumber ' . $pengeluaran->sumber . ' berhasil diedit.');
    }

   /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengeluaran $pengeluaran)
    {
        $pengeluaran->delete();
        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran untuk kebutuhan ' . $pengeluaran->kebutuhan . ' dari sumber ' . $pengeluaran->sumber . ' berhasil dihapus.');
    }
}
