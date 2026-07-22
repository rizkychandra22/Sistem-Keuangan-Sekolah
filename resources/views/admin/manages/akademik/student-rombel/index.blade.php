@extends('layouts.adminApp')

@section('title', 'Data Siswa Rombel Sekolah')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <div class="table-responsive">
            <table id="tableSiswaRombel" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Siswa</th>
                        <th>NISN</th>
                        <th>Periode</th>
                        <th>Kelas</th>
                        <th>Wali Kelas</th>
                        <th>Status Akademik</th>
                        <th>Status Pembelajaran</th>
                        <th>Status Siswa</th>
                        <th>Asal Siswa Rombel</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Selesai</th>
                        <th>Catatan</th>
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
                $('#tableSiswaRombel').DataTable({
                    serverSide: true,
                    responsive: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('siswa-rombel.index') }}",
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
                        {data: 'siswa', name: 'siswa'},
                        {data: 'nisn', name: 'nisn'},
                        {data: 'tahun_ajaran', name: 'tahun_ajaran'},
                        {data: 'rombel', name: 'rombel'},
                        {data: 'wali_kelas', name: 'wali_kelas'},
                        {data: 'status', name: 'status'},
                        {data: 'hasil_akhir', name: 'hasil_akhir'},
                        {data: 'status_aktif', name: 'status_aktif'},
                        {data: 'asal_rombel', name: 'asal_rombel'},
                        {
                            data: 'tanggal_masuk',
                            name: 'tanggal_masuk',
                            render: function (data) {
                                if (!data) return '-';
                                const date = new Date(data);
                                const day = date.getDate().toString().padStart(2, '0');
                                const month = (date.getMonth() + 1).toString().padStart(2, '0');
                                const year = date.getFullYear();
                                return `${day}-${month}-${year}`;
                            }
                        },
                        {
                            data: 'tanggal_selesai',
                            name: 'tanggal_selesai',
                            render: function (data) {
                                if (!data) return '-';
                                const date = new Date(data);
                                const day = date.getDate().toString().padStart(2, '0');
                                const month = (date.getMonth() + 1).toString().padStart(2, '0');
                                const year = date.getFullYear();
                                return `${day}-${month}-${year}`;
                            }
                        },
                        {data: 'catatan', name: 'catatan'},
                        {
                            data: null,
                            render: function (data, type, row) {
                                let editUrl = `{{ route('siswa-rombel.edit', ':id') }}`.replace(':id', row.id);
                                let deleteUrl = `{{ route('siswa-rombel.destroy', ':id') }}`.replace(':id', row.id);

                                return `
                                    <a href="${editUrl}" class="btn btn-outline-warning btn-secoundary btn-sm mt-1 mr-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger btn-secoundary btn-sm mt-1"
                                            onclick="confirmDelete('${row.siswa}', '${row.rombel}', '${deleteUrl}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                `;
                            }
                        }
                    ]
                });
            });
        </script>

        <script>
            function confirmDelete(siswa, rombel, deleteUrl) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Data siswa rombel ${siswa} pada ${rombel} akan dihapus.`,
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
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonColor: '#28a745',
                                    confirmButtonText: 'Oke'
                                }).then(() => {
                                    $('#tableSiswaRombel').DataTable().ajax.reload();
                                });
                            },
                            error: function(xhr) {
                                const message = xhr.responseJSON?.message ?? `Terjadi kesalahan saat menghapus data siswa rombel ${siswa}.`;

                                Swal.fire({
                                    title: 'Error!',
                                    text: message,
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
