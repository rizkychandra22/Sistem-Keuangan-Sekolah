@extends('layouts.keuanganApp')

@section('title', 'Rekapitulasi Transaksi Keuangan Pemasukan dan Pengeluaran Sekolah')

@section('content')
    <div class="container">
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label for="selectData">Pilih Data Transaksi:</label>
                        <select id="selectData" class="form-control">
                            <option value="">-- Jenis Transaksi --</option>
                            <option value="pemasukan">Pemasukan</option>
                            <option value="pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <h4 class="card-title mt-2">Pilih Rekapitulasi Transaksi Pemasukan Dan Pengeluaran Berdasarkan Periode</h4>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-stats mt-2 bg-light card-item">
                            <h5 class="card-title ml-3 mt-3">Pilih Bulan dan Tahun</h5>
                            <div class="card-body">
                                <form action="{{ route('keuangan.rekapTransaksi') }}" method="GET">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="bulan">Bulan:</label>
                                                <select name="bulan" id="bulan" class="form-control form-control-sm">
                                                    @foreach (range(1, 12) as $bulanOption)
                                                        <option value="{{ $bulanOption }}" {{ $bulanOption == $bulanDipilih ? 'selected' : '' }}>
                                                            {{ Carbon\Carbon::parse("$tahunDipilih-$bulanOption-01")->translatedFormat('F') }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tahun">Tahun:</label>
                                                <select name="tahun" id="tahun" class="form-control form-control-sm">
                                                    @foreach ($tahunList as $tahunOption)
                                                        <option value="{{ $tahunOption }}" {{ $tahunOption == $tahunDipilih ? 'selected' : '' }}>
                                                            {{ $tahunOption }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-outline-primary btn-secoundary btn-sm btn-block">Tampilkan</button> 
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table detail pemasukan bulanan berdasarkan tahun --}}
        <div class="row mb-4" id="dataPemasukan" style="display: none;">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-2">Detail Pemasukan Bulan {{ Carbon\Carbon::parse("$tahunDipilih-$bulanDipilih-01")->translatedFormat('F') }} Tahun {{ $tahunDipilih }}</h4>
                            <!-- Add show entries dropdown -->
                            <form action="{{ route('keuangan.rekapTransaksi') }}" method="GET" class="form-inline mb-2">
                                <input type="hidden" name="tahun" value="{{ $tahunDipilih }}">
                                <input type="hidden" name="bulan" value="{{ $bulanDipilih }}">
                                <input type="hidden" name="request-pengeluaran-page" value="{{ request()->get('request-pengeluaran-page', 10) }}">
                                <div class="form-group d-flex align-items-center">
                                    <label for="request-pemasukan-page" class="mr-2 mb-0">Show entries:</label>
                                    <select name="request-pemasukan-page" id="request-pemasukan-page" class="form-control form-control-sm" onchange="this.form.submit()">
                                        <option value="10" {{ request()->get('request-pemasukan-page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ request()->get('request-pemasukan-page') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request()->get('request-pemasukan-page') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="75" {{ request()->get('request-pemasukan-page') == 75 ? 'selected' : '' }}>75</option>
                                        <option value="100" {{ request()->get('request-pemasukan-page') == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead style="background-color: #66aaff" class="text-center">
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Sumber</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kategoriPemasukan as $index => $pemasukan)
                                        <tr>
                                            <td>{{ $kategoriPemasukan->firstItem() + $index }}</td>
                                            <td>{{ $pemasukan->sumber }}</td>
                                            <td>{{ $pemasukan->keterangan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pemasukan->tanggal)->format('d-m-Y') }}</td>
                                            <td class="text-right">Rp{{ number_format($pemasukan->total, 2, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada transaksi dibulan ini</td>
                                        </tr>
                                    @endforelse 
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">Total Pemasukan</th>
                                        <th class="text-right">Rp{{ number_format($totalPemasukanKategori, 2, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div>
                            {{ $kategoriPemasukan->appends([
                                'request-pemasukan-page' => request()->get('request-pemasukan-page', 10),
                                'request-pengeluaran-page' => request()->get('request-pengeluaran-page', 10)
                            ])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table detail pengeluaran bulanan berdasarkan tahun --}}
        <div class="row mb-4" id="dataPengeluaran" style="display: none;">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-2">Detail Pengeluaran Bulan {{ Carbon\Carbon::parse("$tahunDipilih-$bulanDipilih-01")->translatedFormat('F') }} Tahun {{ $tahunDipilih }}</h4>
                            <!-- Add show entries dropdown -->
                            <form action="{{ route('keuangan.rekapTransaksi') }}" method="GET" class="form-inline mb-2">
                                <input type="hidden" name="tahun" value="{{ $tahunDipilih }}">
                                <input type="hidden" name="bulan" value="{{ $bulanDipilih }}">
                                <input type="hidden" name="request-pemasukan-page" value="{{ request()->get('request-pemasukan-page', 10) }}">
                                <div class="form-group d-flex align-items-center">
                                    <label for="request-pengeluaran-page" class="mr-2 mb-0">Show entries:</label>
                                    <select name="request-pengeluaran-page" id="request-pengeluaran-page" class="form-control form-control-sm" onchange="this.form.submit()">
                                        <option value="10" {{ request()->get('request-pengeluaran-page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ request()->get('request-pengeluaran-page') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request()->get('request-pengeluaran-page') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="75" {{ request()->get('request-pengeluaran-page') == 75 ? 'selected' : '' }}>75</option>
                                        <option value="100" {{ request()->get('request-pengeluaran-page') == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead style="background-color: #66aaff" class="text-center">
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Kebutuhan</th>
                                        <th>Keterangan</th>
                                        <th width="100">Tanggal</th>
                                        <th>Sumber</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kategoriPengeluaran as $index => $pengeluaran)
                                        <tr>
                                            <td>{{ $kategoriPengeluaran->firstItem() + $index }}</td>
                                            <td>{{ $pengeluaran->kebutuhan }}</td>
                                            <td>{{ $pengeluaran->keterangan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pengeluaran->tanggal)->format('d-m-Y') }}</td>
                                            <td>{{ $pengeluaran->sumber }}</td>
                                            <td class="text-right">Rp{{ number_format($pengeluaran->total, 2, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada transaksi dibulan ini</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5">Total Pengeluaran</th>
                                        <th class="text-right">Rp{{ number_format($totalPengeluaranKategori, 2, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div>
                            {{ $kategoriPengeluaran->appends([
                                'request-pemasukan-page' => request()->get('request-pemasukan-page', 10),
                                'request-pengeluaran-page' => request()->get('request-pengeluaran-page', 10)
                            ])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Pemasukan dan Pengeluaran Berdasarkan Tahun --}}
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-2">Daftar Transaksi Pemasukan dan Pengeluaran Tahun {{ $tahunDipilih }}</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead style="background-color: #66aaff" class="text-center">
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Pemasukan</th>
                                        <th>Pengeluaran</th>
                                        <th>Sisa Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bulanLabels as $index => $bulan)
                                    <tr>
                                        <td>{{ $bulan }}</td>
                                        <td class="text-right">Rp{{ number_format($pemasukanBulanan[$index], 2, ',', '.') }}</td>
                                        <td class="text-right">Rp{{ number_format($pengeluaranBulanan[$index], 2, ',', '.') }}</td>
                                        <td class="text-right">
                                            {{-- Cek jika bulan saat ini belum berjalan --}}
                                            @if ($index + 1 > \Carbon\Carbon::now()->month)
                                                {{-- Jangan tampilkan saldo untuk bulan yang belum berjalan --}}
                                                Rp0,00
                                            @elseif ($index + 1 == $bulanDipilih && $pemasukanBulanan[$index] == 0 && $pengeluaranBulanan[$index] == 0 && $index > 0)
                                                {{-- Tampilkan saldo bulan sebelumnya jika bulan saat ini belum memiliki pemasukan dan pengeluaran --}}
                                                Rp{{ number_format($saldoBulanan[$index - 1], 2, ',', '.') }}
                                            @else
                                                {{-- Tampilkan saldo bulan ini --}}
                                                Rp{{ number_format($saldoBulanan[$index], 2, ',', '.') }}
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th class="text-right">Rp{{ number_format($totalPemasukanTahunIni, 2, ',', '.') }}</th>
                                        <th class="text-right">Rp{{ number_format($totalPengeluaranTahunIni, 2, ',', '.') }}</th>
                                        <th class="text-right">Rp{{ number_format($saldoAkhirTahunIni, 2, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>                                                                    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* .text-end {
            text-align: end;
        } */

        .card-link {
            text-decoration: none;
        }

        .card-item {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var selectData = document.getElementById('selectData');
            var savedValue = localStorage.getItem('selectedData');
            if (savedValue) {
                selectData.value = savedValue;
                displayData(savedValue);
            }

            selectData.addEventListener('change', function() {
                var selectedValue = this.value;
                localStorage.setItem('selectedData', selectedValue);
                displayData(selectedValue);
            });

            function displayData(selectedValue) {
                document.getElementById('dataPemasukan').style.display = 'none';
                document.getElementById('dataPengeluaran').style.display = 'none';
                if (selectedValue === 'pemasukan') {
                    document.getElementById('dataPemasukan').style.display = 'block';
                } else if (selectedValue === 'pengeluaran') {
                    document.getElementById('dataPengeluaran').style.display = 'block';
                }
            }
        });
    </script>
@endsection
