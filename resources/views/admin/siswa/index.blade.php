@extends('layouts.adminApp')

@section('title', 'Data Siswa SDN Caringin Ngumbang')

@section('content')
    <div class="container">
        @include('components.alert-messages')
        
        <div class="table-responsive">
            <table id="tableSiswa" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NISN</th>
                        <th>Tanggal Lahir</th>
                        <th>Orang Tua</th>
                        <th>Kontak Orang Tua</th>
                        <th>Status Akademik</th>
                        <th>Status Aktif</th>
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

        <script>
            $(document).ready(function () {
                dataSiswa();
            });
        
            function dataSiswa() {
                $('#tableSiswa').DataTable({
                    serverSide: true,
                    responsive: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('siswa.index') }}",
                        type: 'GET'
                    },
                    columns: [
                        {
                            data: null,
                            sortable: false,
                            searchable: false,
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {data: 'nama', name: 'nama'},
                        {data: 'nisn', name: 'nisn'},
                        {
                            data: 'tgl_lhr',
                            name: 'tgl_lhr',
                            render: function (data) {
                                if (!data) return '-';
                                const date = new Date(data);
                                const day = date.getDate().toString().padStart(2, '0');
                                const month = (date.getMonth() + 1).toString().padStart(2, '0');
                                const year = date.getFullYear();
                                return `${day}-${month}-${year}`;
                            }
                        },
                        {data: 'orang_tua', name: 'orang_tua'},
                        {
                            data: 'kontak_orang_tua',
                            name: 'kontak_orang_tua',
                            render: function (data) {
                                return data ?? '-';
                            }
                        },
                        {data: 'status_akademik', name: 'status_akademik'},
                        {
                            data: 'is_active',
                            name: 'is_active',
                            render: function (data) {
                                return data ? 'Aktif' : 'Nonaktif';
                            }
                        },
                        {
                            data: null,
                            render: function (data, type, row) {
                                let editUrl = `{{ route('siswa.edit', ':id') }}`.replace(':id', row.id);
                                let deleteUrl = `{{ route('siswa.destroy', ':id') }}`.replace(':id', row.id);

                                return `
                                    <a href="${editUrl}" class="btn btn-outline-warning btn-secoundary btn-sm mt-1 mr-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger btn-secoundary btn-sm mt-1"
                                            onclick="confirmDelete('${row.nama}', '${deleteUrl}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                `;
                            }
                        }
                    ]
                });
            }
        </script>

        <script>
            function confirmDelete(nama, deleteUrl) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Data siswa dengan nama ${nama} beserta akun user-nya akan dihapus.`,
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
                            success: function() {
                                Swal.fire({
                                    title: 'Dihapus!',
                                    text: `Data siswa ${nama} berhasil dihapus.`,
                                    icon: 'success',
                                    confirmButtonColor: '#28a745',
                                    confirmButtonText: 'Oke'
                                }).then(() => {
                                    $('#tableSiswa').DataTable().ajax.reload();
                                });
                            },
                            error: function() {
                                Swal.fire({
                                    title: 'Error!',
                                    text: `Terjadi kesalahan saat menghapus data siswa ${nama}.`,
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
