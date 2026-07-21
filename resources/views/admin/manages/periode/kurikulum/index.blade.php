@extends('layouts.adminApp')

@section('title', 'Data Kurikulum Sekolah')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <div class="table-responsive">
            <table id="tableKurikulum" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama</th>
                        <th>Tahun</th>
                        <th>Deskripsi</th>
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
                $('#tableKurikulum').DataTable({
                    serverSide: true,
                    responsive: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('kurikulum.index') }}",
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
                        {data: 'tahun', name: 'tahun'},
                        {
                            data: 'deskripsi',
                            name: 'deskripsi',
                            render: function (data) {
                                return data ?? '-';
                            }
                        },
                        {
                            data: null,
                            render: function (data, type, row) {
                                let editUrl = `{{ route('kurikulum.edit', ':id') }}`.replace(':id', row.id);
                                let deleteUrl = `{{ route('kurikulum.destroy', ':id') }}`.replace(':id', row.id);

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
            });
        </script>

        <script>
            function confirmDelete(nama, deleteUrl) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Data kurikulum ${nama} akan dihapus.`,
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
                                    text: `Data kurikulum ${nama} berhasil dihapus.`,
                                    icon: 'success',
                                    confirmButtonColor: '#28a745',
                                    confirmButtonText: 'Oke'
                                }).then(() => {
                                    $('#tableKurikulum').DataTable().ajax.reload();
                                });
                            },
                            error: function(xhr) {
                                const message = xhr.responseJSON?.message ?? `Terjadi kesalahan saat menghapus data kurikulum ${nama}.`;

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
