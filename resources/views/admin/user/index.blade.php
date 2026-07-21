@extends('layouts.adminApp')

@section('title', 'Data Akun User SDN Caringin Ngumbang')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <div class="table-responsive">
            <table id="tableUser" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
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
            const currentUserId = {{ auth()->id() }};
            const protectedRoles = ['admin', 'operator', 'finance'];

            $(document).ready(function () {
                $('#tableUser').DataTable({
                    serverSide: true,
                    responsive: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('dataUser.index') }}",
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
                        {data: 'name', name: 'name'},
                        {data: 'username', name: 'username'},
                        {data: 'email', name: 'email'},
                        {
                            data: 'role',
                            name: 'role',
                            render: function (data) {
                                return `<span class="badge badge-info text-uppercase">${data}</span>`;
                            }
                        },
                        {
                            data: null,
                            render: function (data, type, row) {
                                const editUrl = `{{ route('dataUser.edit', ':id') }}`.replace(':id', row.id);
                                const deleteUrl = `{{ route('dataUser.destroy', ':id') }}`.replace(':id', row.id);
                                const canDelete = !protectedRoles.includes(row.role) && row.id !== currentUserId;

                                const editButton = `
                                    <a href="${editUrl}" class="btn btn-outline-warning btn-sm mt-1 mr-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                `;

                                if (!canDelete) {
                                    return editButton;
                                }

                                return `
                                    ${editButton}
                                    <button type="button" class="btn btn-outline-danger btn-sm mt-1"
                                            onclick="confirmDeleteUser(${row.id}, '${row.username}', '${row.role}', '${deleteUrl}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                `;
                            }
                        }
                    ]
                });
            });

            function confirmDeleteUser(id, username, role, deleteUrl) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Akun user ${username} dengan role ${role} akan dihapus.`,
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
                                    $('#tableUser').DataTable().ajax.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: xhr.responseJSON?.message ?? 'Terjadi kesalahan saat menghapus akun user.',
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
