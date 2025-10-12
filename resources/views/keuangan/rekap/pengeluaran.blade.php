@extends('layouts.keuanganApp')

@section('title', 'Rekapitulasi Pengeluaran Sekolah')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="infoButton" class="alert alert-danger" style="background: rgba(255, 255, 0, 0.8); display: none;">
                    <span class="text-dark">
                        <i class="fas fa-info-circle"></i>
                        <strong>Informasi:</strong> Untuk mengakses eksport data keuangan, silahkan pilih rentan tanggal yang diinginkan.
                    </span>
                </div>
                <div class="row mb-3">
                    <div class="col-md">
                        <form id="filterForm" class="form-inline d-flex" style="width: 100%;">
                            <div class="form-group" style="flex: 1; margin-right: 10px;">
                                <label for="start-date">Tanggal Mulai:</label>
                                <input type="date" id="start_date" name="start_date" class="mt-1 form-control form-control-sm {{ $errors->has('start_date') ? 'is-invalid' : '' }}" style="width: 100%;">
                            </div>

                            <div class="form-group" style="flex: 1; margin-right: 10px;">
                                <label for="end-date">Tanggal Akhir:</label>
                                <input type="date" id="end_date" name="end_date" class="mt-1 form-control form-control-sm {{ $errors->has('end_date') ? 'is-invalid' : '' }}" style="width: 100%;">
                            </div>

                            <div class="align-items-end" style="flex: 0; margin-top:28px;">
                                <button type="button" id="filterButton" class="btn btn-secoundary btn-outline-primary btn-sm">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
                <a id="exportExcel" class="btn btn-success btn-sm mb-1 mr-2 disabled" href="#">Eksport pengeluaran (Excel)</a>
                <a id="exportPdf" class="btn btn-danger btn-sm mb-1 disabled mr-2" href="#">Eksport pengeluaran (PDF)</a>
            </div>
        </div>
        
        <div class="table-responsive">
            <table id="laporanPengeluaran" class="table table-bordered table-hover table-striped"></table>
        </div>
    </div>

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>

        {{-- Class Informasi --}}
        <script>
            window.onload = function() {
                const alertInfo = document.getElementById('infoButton');
                alertInfo.style.display = 'block';
                
                setTimeout(function() {
                    alertInfo.style.display = 'none';
                }, 5000);
            }
        </script>

        <script>
            $(document).ready(function () {
                // Inisialisasi DataTables dan simpan di variabel `table`
                var table = $('#laporanPengeluaran').DataTable({
                    serverSide: true,
                    responsive: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('rekap.pengeluaran') }}",  
                        type: 'GET',
                        data: function(d) {
                            d.start_date = $('#start_date').val();
                            d.end_date = $('#end_date').val();
                        }
                    },
                    columns: [
                        {
                            "data": null,
                            "sortable": false,
                            "searchable": false, 
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
                            title: 'No',
                        },
                        {data: 'kebutuhan', name: 'kebutuhan', title: 'Kebutuhan'},
                        {data: 'keterangan', name: 'keterangan', title: 'Keterangan'},
                        {
                            data: 'tanggal',
                            render: function (data, type, row) {
                                const date = new Date(data);
                                const day = date.getDate().toString().padStart(2, '0');
                                const month = (date.getMonth() + 1).toString().padStart(2, '0');
                                const year = date.getFullYear();
                                return `${day}-${month}-${year}`;
                            },
                            name: 'tanggal',
                            title: 'Tanggal'
                        },
                        {
                            data: 'jumlah',
                            render: function (data, type, row) {
                                return 'Rp' + new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }).format(data).replace('Rp', '').trim();
                            },
                            name: 'jumlah',
                            title: 'Jumlah'
                        },
                        {data: 'sumber', name: 'sumber', title: 'Sumber'},
                    ]
                });
        
                // Event klik tombol filter untuk memuat ulang DataTables dengan filter tanggal
                $('#filterButton').on('click', function() {
                    // Kosongkan pesan error sebelum melakukan validasi baru
                    $('.text-danger').remove();
                    $('.is-invalid').removeClass('is-invalid');

                    var startDate = $('#start_date').val();
                    var endDate = $('#end_date').val();
                    var isValid = true;

                    // Validasi input tanggal
                    if (!startDate) {
                        $('#start_date').addClass('is-invalid');
                        $('#start_date').after('<small class="text-danger">Tanggal mulai harus diisi.</small>');
                        isValid = false;
                    }

                    if (!endDate) {
                        $('#end_date').addClass('is-invalid');
                        $('#end_date').after('<small class="text-danger">Tanggal akhir harus diisi.</small>');
                        isValid = false;
                    }

                    if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
                        $('#end_date').addClass('is-invalid');
                        $('#end_date').after('<small class="text-danger">Tanggal mulai tidak boleh lebih besar dari tanggal akhir.</small>');
                        isValid = false;
                    }

                    if (isValid) {
                        table.ajax.reload();

                        // Perbarui href tombol eksport PDF dengan tanggal yang dipilih
                        var pdfUrl = "{{ route('pengeluaran.export.pdf') }}?start_date=" + startDate + "&end_date=" + endDate;
                        var excelUrl = "{{ route('pengeluaran.export.excel') }}?start_date=" + startDate + "&end_date=" + endDate;

                        // Aktifkan tombol jika ada data
                        table.on('xhr', function() {
                            var json = table.ajax.json();
                            if (json.data.length > 0) {
                                $('#exportPdf').removeClass('disabled').attr('href', pdfUrl);
                                $('#exportExcel').removeClass('disabled').attr('href', excelUrl);
                            } else {
                                $('#exportPdf').addClass('disabled').attr('href', '#');
                                $('#exportExcel').addClass('disabled').attr('href', '#');
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection