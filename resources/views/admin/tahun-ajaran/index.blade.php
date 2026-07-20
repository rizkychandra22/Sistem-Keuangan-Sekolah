@extends('layouts.adminApp')

@section('title', 'Tahun Ajaran SDN Caringin Ngumbang')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <div class="table-responsive">
            <table id="tableTahunAjaran" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Tahun</th>
                        <th>Semester</th>
                        <th>Status Aktif</th>
                        <th>Status Kunci</th>
                        <th width="115">Create</th>
                        <th width="115">Update</th>
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
                $('#tableTahunAjaran').DataTable({
                    serverSide: true,
                    responsive: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('tahun-ajaran.index') }}",
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
                        {data: 'tahun', name: 'tahun'},
                        {
                            data: 'semester',
                            name: 'semester',
                            render: function (data) {
                                return data.charAt(0).toUpperCase() + data.slice(1);
                            }
                        },
                        {
                            data: 'status_aktif',
                            name: 'status_aktif',
                            render: function (data) {
                                const badgeClass = data === 'Aktif' ? 'badge badge-success' : 'badge badge-secondary';
                                return `<span class="${badgeClass}">${data}</span>`;
                            }
                        },
                        {
                            data: 'status_kunci',
                            name: 'status_kunci',
                            render: function (data) {
                                const badgeClass = data === 'Terkunci' ? 'badge badge-danger' : 'badge badge-info';
                                return `<span class="${badgeClass}">${data}</span>`;
                            }
                        },
                        {
                            data: 'created_at',
                            render: function (data) {
                                const date = new Date(data);
                                const day = date.getDate().toString().padStart(2, '0');
                                const month = (date.getMonth() + 1).toString().padStart(2, '0');
                                const year = date.getFullYear();
                                const hours = date.getHours().toString().padStart(2, '0');
                                const minutes = date.getMinutes().toString().padStart(2, '0');
                                const seconds = date.getSeconds().toString().padStart(2, '0');
                                return `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;
                            },
                            name: 'created_at'
                        },
                        {
                            data: 'updated_at',
                            render: function (data) {
                                const date = new Date(data);
                                const day = date.getDate().toString().padStart(2, '0');
                                const month = (date.getMonth() + 1).toString().padStart(2, '0');
                                const year = date.getFullYear();
                                const hours = date.getHours().toString().padStart(2, '0');
                                const minutes = date.getMinutes().toString().padStart(2, '0');
                                const seconds = date.getSeconds().toString().padStart(2, '0');
                                return `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;
                            },
                            name: 'updated_at'
                        },
                        {
                            data: null,
                            render: function (data, type, row) {
                                let editUrl = `{{ route('tahun-ajaran.edit', ':id') }}`.replace(':id', row.id);
                                let deleteUrl = `{{ route('tahun-ajaran.destroy', ':id') }}`.replace(':id', row.id);

                                return `
                                    <a href="${editUrl}" class="btn btn-outline-warning btn-secoundary btn-sm mt-1 mr-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger btn-secoundary btn-sm mt-1"
                                            onclick="confirmDelete('${row.tahun}', '${row.semester}', '${deleteUrl}')">
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
            function confirmDelete(tahun, semester, deleteUrl) {
                const semesterLabel = semester.charAt(0).toUpperCase() + semester.slice(1);

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Data tahun ajaran ${tahun} semester ${semesterLabel} akan dihapus.`,
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
                                    text: `Data tahun ajaran ${tahun} semester ${semesterLabel} berhasil dihapus.`,
                                    icon: 'success',
                                    confirmButtonColor: '#28a745',
                                    confirmButtonText: 'Oke'
                                }).then(() => {
                                    $('#tableTahunAjaran').DataTable().ajax.reload();
                                });
                            },
                            error: function(xhr) {
                                const message = xhr.responseJSON?.message ?? `Terjadi kesalahan saat menghapus data tahun ajaran ${tahun} semester ${semesterLabel}.`;

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
