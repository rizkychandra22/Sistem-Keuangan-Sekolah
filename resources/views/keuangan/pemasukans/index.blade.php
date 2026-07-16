@extends('layouts.keuanganApp')

@section('title', 'Data Pemasukan Sekolah')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <div class="table-responsive">
            <table id="pemasukanTable" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Sumber</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>

        {{-- Script Data Pemasukan --}}
        <script>
            $(document).ready(function () {
                dataPemasukan();
            });
        
            function dataPemasukan() {
                $('#pemasukanTable').DataTable({
                    serverSide: true,
                    responsive: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('pemasukan.index') }}",
                        type: 'GET'
                    },
                    columns: [
                        {
                            "data": null,
                            "sortable": false,
                            "searchable": false, 
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {data: 'sumber', name: 'sumber'},
                        {data: 'keterangan', name: 'keterangan'},
                        {
                            data: 'tanggal',
                            render: function (data, type, row) {
                                const date = new Date(data);
                                const day = date.getDate().toString().padStart(2, '0');
                                const month = (date.getMonth() + 1).toString().padStart(2, '0');
                                const year = date.getFullYear();
                                return `${day}-${month}-${year}`;
                            },
                            name: 'tanggal'
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
                            name: 'jumlah'
                        },
                        {
                            data: null,
                            render: function (data, type, row) {
                                let editUrl = `{{ route('pemasukan.edit', ':id') }}`.replace(':id', row.id);
                                let deleteUrl = `{{ route('pemasukan.destroy', ':id') }}`.replace(':id', row.id);

                                return `
                                    <a href="${editUrl}" class="btn btn-outline-warning btn-secoundary btn-sm mt-1 mr-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger btn-secoundary btn-sm mt-1" 
                                            onclick="confirmDelete(${row.id}, '${row.sumber}', '${row.jumlah}', '${deleteUrl}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                `;
                            }
                        }
                    ]
                });
            }
        </script>   

        {{-- Script SweetAlert --}}
        <script>
            function confirmDelete(id, sumber, jumlah, deleteUrl) {
                const formatter = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                const formattedJumlah = formatter.format(jumlah);

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Data pemasukan sekolah dari sumber ${sumber} dengan total saldo sebesar ${formattedJumlah} akan dihapus.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteUrl,
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Dihapus!',
                                    text: `Data pemasukan sekolah dari sumber ${sumber} berhasil dihapus.`,
                                    icon: 'success',
                                    confirmButtonColor: '#28a745',
                                    confirmButtonText: 'Oke'
                                }).then(() => {
                                    $('#pemasukanTable').DataTable().ajax.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: `Terjadi kesalahan saat menghapus data keuangan dari sumber ${sumber}.`,
                                    icon: 'error',
                                    confirmButtonColor: '#d33',
                                    confirmButtonText: 'Oke'
                                });
                            }
                        });
                    }
                });
            }
        </script> 
    @endpush
@endsection
