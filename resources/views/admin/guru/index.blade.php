@extends('layouts.adminApp')

@section('title', 'Data Guru Sekolah')

@section('content')
    <div class="container">
        @include('components.alert-messages')
        
        <div class="table-responsive">
            <table id="tableGuru" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Jabatan</th>
                        <th>Kontak</th>
                        <th>Motivasi</th>
                        <th>Gambar</th>
                        <th width="95">Aksi</th>
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
                dataGuru();
            });
        
            function dataGuru() {
                $('#tableGuru').DataTable({
                    serverSide: true,
                    responsive: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('guru.index') }}",
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
                        {data: 'nama', name: 'nama'},
                        {data: 'nip', name: 'nip'},
                        {data: 'jabatan', name: 'jabatan'},
                        {
                            data: 'kontak',
                            name: 'kontak',
                            render: function (data) {
                                return data ?? '-';
                            }
                        },
                        {data: 'motivasi', name: 'motivasi'},
                        {
                            data: 'gambar', 
                            name: 'gambar',
                            render: function (data, type, row) {
                                let photoUrl = `/images/guru/${data}`;
                                return `<img src="${photoUrl}" alt="Foto" class="img-fluid" style="width: 150px; height: 170px;">`;
                            }
                        },
                        {
                            data: null,
                            render: function (data, type, row) {
                                let editUrl = `{{ route('guru.edit', ':id') }}`.replace(':id', row.id);
                                let deleteUrl = `{{ route('guru.destroy', ':id') }}`.replace(':id', row.id);

                                return `
                                    <a href="${editUrl}" class="btn btn-outline-warning btn-secoundary btn-sm mt-1 mr-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger btn-secoundary btn-sm mt-1" 
                                            onclick="confirmDelete(${row.id}, '${row.nama}', '${row.jabatan}', '${row.motivasi}', '${deleteUrl}')">
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
            function confirmDelete(id, nama, jabatan, motivasi, deleteUrl) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Data guru dengan nama ${nama} sebagai ${jabatan} akan dihapus.`,
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
                                    text: `Data guru dengan nama ${nama} sebagai ${jabatan} berhasil dihapus.`,
                                    icon: 'success',
                                    confirmButtonColor: '#28a745',
                                    confirmButtonText: 'Oke'
                                }).then(() => {
                                    $('#tableGuru').DataTable().ajax.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: `Terjadi kesalahan saat menghapus data guru ${nama}.`,
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
