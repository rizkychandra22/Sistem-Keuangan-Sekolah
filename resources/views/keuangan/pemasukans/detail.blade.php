@extends('layouts.keuanganApp')

@section('title', 'Detail Pemasukan Keuangan Sekolah')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Card untuk total pemasukan bulan ini -->
            <div class="col-md-4">
                <div class="card card-item card-stats bg-primary card-item">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <a href="{{ route('pemasukan.index') }}">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-arrow-down nav-icon icon-hover" style="font-size: 3rem;"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="col-7 d-flex align-items-center">
                                <div class="numbers">
                                    <p class="card-category ket head">Total Pemasukan Bulan {{ Carbon\Carbon::parse("$tahun-$bulan-01")->translatedFormat('F') }} {{ $tahun }}</p>
                                    <hr style="border-width: 3px;">
                                    <h4 class="card-title ket total">Rp{{ number_format($totalPemasukanBulanIni, 2, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Form untuk memilih bulan -->
                <div class="card card-item card-stats bg-light card-item">
                    <h5 class="card-title ml-4 mt-4">Pilih Bulan dan Tahun</h5>
                    <div class="card-body">
                        <form action="{{ route('detail.pemasukan') }}" method="GET">
                            <div class="form-group">
                                <label for="bulan">Bulan:</label>
                                <select name="bulan" id="bulan" class="form-control form-control-sm">
                                    @foreach (range(1, 12) as $bulanOption)
                                        <option value="{{ $bulanOption }}" {{ $bulanOption == $bulan ? 'selected' : '' }}>
                                            {{ Carbon\Carbon::parse("$tahun-$bulanOption-01")->translatedFormat('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tahun">Tahun:</label>
                                <select name="tahun" id="tahun" class="form-control form-control-sm">
                                    @foreach ($tahunList as $tahunOption)
                                        <option value="{{ $tahunOption }}" {{ $tahunOption == $tahun ? 'selected' : '' }}>
                                            {{ $tahunOption }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-outline-primary btn-secoundary btn-sm btn-block">Tampilkan</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Diagram Bar untuk pemasukan berdasarkan kebutuhan --}}
            <div class="col-md-8">
                <canvas id="pemasukanChart"></canvas>
            </div>

            {{-- Tabel untuk detail pemasukan keuangan berdasarkan bulan yang dipilih --}}
            <div class="card card-stats bg-light mt-2 col-md-12">
                <div class="card-body">
                    <h4 class="card-title mb-2">Total Pemasukan Berdasarkan Kategori Sumber</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead style="background-color: #66aaff" class="text-center">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Sumber</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pemasukansBulanIni as $pemasukan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pemasukan->sumber }}</td>
                                        <td class="text-right">Rp{{ number_format($pemasukan->total, 2, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada transaksi di bulan ini</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2">Total Pemasukan Bulan Ini:</th>
                                    <th class="text-right">Rp{{ number_format($totalPemasukanBulanIni, 2, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Tabel selisih pemasukan dan pengeluaran sumber dari bulan dan tahun yang di pilih --}}
            <div class="card card-stats bg-light mt-2 col-md-12">
                <div class="card-body">
                    <h4 class="card-title mb-2">Selisih Pemasukan dan Pengeluaran Berdasarkan Sumber</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead style="background-color: #66aaff" class="text-center">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Sumber Pemasukan</th>
                                    <th>Sumber Pengeluaran</th>
                                    <th>Jumlah Selisih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sumberSelisihBulanan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item['sumberPemasukan'] }}</td>
                                        <td>{{ $item['sumberPengeluaran'] }}</td>
                                        <td class="text-right">Rp{{ number_format($item['selisih'], 2, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada transaksi di bulan ini</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th class="text-right">Rp{{ number_format($totalPemasukanBulanIni, 2, ',', '.') }}</th>
                                    <th class="text-right">Rp{{ number_format($totalPengeluaranBulanIni, 2, ',', '.') }}</th>
                                    <th class="text-right">Rp{{ number_format($sisaSaldoBulanan, 2, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
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

        .icon-hover {
            transition: color 0.2s, transform 0.2s;
            color: white; /* Warna ikon awal putih */
        }

        .icon-hover:hover {
            cursor: pointer;
            color: yellow; /* Warna ikon saat di-hover menjadi kuning */
        }

        .icon-hover:hover:before {
            content: "\f06e"; /* Kode unicode untuk ikon mata (eye) */
            font-family: "Font Awesome 5 Free"; /* Pastikan font-family sesuai */
            font-weight: 900; /* Pastikan font-weight sesuai */
            color: yellow; /* Warna ikon mata saat di-hover menjadi kuning */
        }

        .icon-hover {
            position: relative;
            z-index: 1;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('pemasukanChart').getContext('2d');
        const pemasukanChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($pemasukansBulanIni->pluck('sumber')),
                datasets: [{
                    label: 'Total Pemasukan',
                    data: @json($pemasukansBulanIni->pluck('total')),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', 
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>    
@endsection
