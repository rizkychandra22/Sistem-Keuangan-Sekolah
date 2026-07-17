@extends('layouts.keuanganApp')

@section('title', 'Dashboard Keuangan Sekolah')

@section('content')
    <div class="container">
        <!-- Dashboard Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card card-saldo card-stats bg-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <a href="{{ route('detail.pemasukan') }}">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-arrow-down nav-icon icon-hover icon-hover-yellow dashboard-icon-lg"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="col-7 d-flex align-items-center">
                                <div class="numbers">
                                    <p class="card-category ket head">Pemasukan Bulan {{ Carbon\Carbon::parse("$tahunIni-$bulanIni-01")->translatedFormat('F') }} {{ $tahunIni }}</p>
                                    <hr class="dashboard-card-divider">
                                    <h4 class="card-title ket total">Rp{{ number_format($totalPemasukanBulanIni, 2, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-saldo card-stats bg-danger">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <a href="{{ route('detail.pengeluaran') }}">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-arrow-up nav-icon icon-hover icon-hover-yellow dashboard-icon-lg"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="col-7 d-flex align-items-center">
                                <div class="numbers">
                                    <p class="card-category ket head">Pengeluaran Bulan {{ Carbon\Carbon::parse("$tahunIni-$bulanIni-01")->translatedFormat('F') }} {{ $tahunIni }}</p>
                                    <hr class="dashboard-card-divider">
                                    <h4 class="card-title ket total">Rp{{ number_format($totalPengeluaranBulanIni, 2, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-saldo card-stats bg-success">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <a href="{{ route('keuangan.rekapTransaksi') }}">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-wallet ikon icon-hover icon-hover-yellow dashboard-icon-lg"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="col-7 d-flex align-items-center">
                                <div class="numbers">
                                    <p class="card-category ket head">Sisa Saldo Bulan {{ Carbon\Carbon::parse("$tahunIni-$bulanIni-01")->translatedFormat('F') }} {{ $tahunIni }}</p>
                                    <hr class="dashboard-card-divider">
                                    <h4 class="card-title ket total">Rp{{ number_format($saldoBulanIni, 2, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pie Charts Row -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Diagram Kategori Pemasukan</h5>
                <canvas id="pemasukanChart" class="chart-canvas"></canvas>
            </div>
            <div class="col-md-6">
                <h5>Diagram Kategori Pengeluaran</h5>
                <canvas id="pengeluaranChart" class="chart-canvas"></canvas>
            </div>
        </div>

        <!-- Bar Chart Row -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h5>Pemasukan vs Pengeluaran</h5>
                        <canvas id="myChart"></canvas>
                    </div>
                    <div class="col-md-6">
                        <h5>Pemasukan vs Pengeluaran</h5>
                        <canvas id="selisihChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Charts Row -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Pemasukan Bulanan</h5>
                <canvas id="pemasukanBulanan"></canvas>
            </div>
            <div class="col-md-6">
                <h5>Pengeluaran Bulanan</h5>
                <canvas id="pengeluaranBulanan"></canvas>
            </div>
        </div>

        <!-- Yearly Charts Row -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Pemasukan Tahunan</h5>
                <canvas id="pemasukanTahunan"></canvas>
            </div>
            <div class="col-md-6">
                <h5>Pengeluaran Tahunan</h5>
                <canvas id="pengeluaranTahunan"></canvas>
            </div>
        </div>
    </div>

    {{-- Script untuk diagram --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Chart Pemasukan
            var pemasukanLabels = @json($pemasukanLabels);
            var pemasukanValues = @json($pemasukanValues);
            var pengeluaranLabels = @json($pengeluaranLabels);
            var pengeluaranValues = @json($pengeluaranValues);

            function generateBrightColors(numColors) {
                let colors = [
                    'rgba(255, 99, 132, 0.8)',  // Bright Red
                    'rgba(54, 162, 235, 0.8)',  // Bright Blue
                    'rgba(255, 206, 86, 0.8)',  // Bright Yellow
                    'rgba(75, 192, 192, 0.8)',  // Bright Teal
                    'rgba(153, 102, 255, 0.8)', // Bright Purple
                    'rgba(255, 159, 64, 0.8)',  // Bright Orange
                    'rgba(255, 99, 71, 0.8)',   // Bright Tomato
                    'rgba(173, 255, 47, 0.8)',  // Bright GreenYellow
                    'rgba(240, 128, 128, 0.8)', // Bright LightCoral
                    'rgba(255, 165, 0, 0.8)',   // Bright Orange
                    'rgba(135, 206, 250, 0.8)', // Bright LightSkyBlue
                    'rgba(152, 251, 152, 0.8)'  // Bright PaleGreen
                ];
                let brightColors = [];
                for (let i = 0; i < numColors; i++) {
                    brightColors.push(colors[i % colors.length]);
                }
                return brightColors;
            }

            var pemasukanColors = generateBrightColors(pemasukanLabels.length);
            var pengeluaranColors = generateBrightColors(pengeluaranLabels.length);

            // Chart Pemasukan
            var ctxPemasukan = document.getElementById('pemasukanChart').getContext('2d');
            new Chart(ctxPemasukan, {
                type: 'pie',
                data: {
                    labels: pemasukanLabels,
                    datasets: [{
                        data: pemasukanValues,
                        backgroundColor: pemasukanColors,
                        borderColor: pemasukanColors.map(color => color.replace('0.8', '1')),
                        borderWidth: 1
                    }]
                }
            });

            // Chart Pengeluaran
            var ctxPengeluaran = document.getElementById('pengeluaranChart').getContext('2d');
            new Chart(ctxPengeluaran, {
                type: 'pie',
                data: {
                    labels: pengeluaranLabels,
                    datasets: [{
                        data: pengeluaranValues,
                        backgroundColor: pengeluaranColors,
                        borderColor: pengeluaranColors.map(color => color.replace('0.8', '1')),
                        borderWidth: 1
                    }]
                }
            });

            // Diagram table pemasukan vs pengeluaran
            var ctxBar = document.getElementById('myChart').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: ['Pemasukan', 'Pengeluaran'],
                    datasets: [{
                        label: 'Rp', 
                        data: [{{ $totalPemasukanBulanIni }}, {{ $totalPengeluaranBulanIni }}],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 99, 132, 0.2)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return 'Rp' + tooltipItem.raw.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                            }
                        }
                    }
                }
            });

            // Chart Selisih Pemasukan dan Pengeluaran
            var ctxSelisih = document.getElementById('selisihChart').getContext('2d');
            new Chart(ctxSelisih, {
                type: 'bar',
                data: {
                    labels: ['Selisih Pemasukan dan Pengeluaran'],
                    datasets: [{
                        label: 'Selisih',
                        data: [{{ $saldoBulanIni }}],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.8)',  // Bright Teal
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',    // Bright Teal
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return 'Rp' + tooltipItem.raw.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                            }
                        }
                    }
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Diagram pemasukan bulanan
            var pemasukanBulananCtx = document.getElementById('pemasukanBulanan').getContext('2d');
            var pemasukanBulananChart = new Chart(pemasukanBulananCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($bulanLabels) !!},
                    datasets: [{
                        label: 'Pemasukan Bulanan',
                        data: {!! json_encode($pemasukanBulanan) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return 'Rp' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                            }
                        }
                    }
                }
            });

            // Diagram pengeluaran bulanan
            var pengeluaranBulananCtx = document.getElementById('pengeluaranBulanan').getContext('2d');
            var pengeluaranBulananChart = new Chart(pengeluaranBulananCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($bulanLabels) !!},
                    datasets: [{
                        label: 'Pengeluaran Bulanan',
                        data: {!! json_encode($pengeluaranBulanan) !!},
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return 'Rp' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                            }
                        }
                    }
                }
            });

            // Diagram pemasukan tahunan
            var pemasukanTahunanCtx = document.getElementById('pemasukanTahunan').getContext('2d');
            var pemasukanTahunanChart = new Chart(pemasukanTahunanCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($tahunLabels) !!},
                    datasets: [{
                        label: 'Pemasukan Tahunan',
                        data: {!! json_encode($pemasukanTahunan) !!},
                        fill: false,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return 'Rp' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                            }
                        }
                    }
                }
            });

            // Diagram pengeluaran tahunan
            var pengeluaranTahunanCtx = document.getElementById('pengeluaranTahunan').getContext('2d');
            var pengeluaranTahunanChart = new Chart(pengeluaranTahunanCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($tahunLabels) !!},
                    datasets: [{
                        label: 'Pengeluaran Tahunan',
                        data: {!! json_encode($pengeluaranTahunan) !!},
                        fill: false,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return 'Rp' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
