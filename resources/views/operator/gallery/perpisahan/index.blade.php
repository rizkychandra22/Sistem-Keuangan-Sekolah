@extends('layouts.operatorApp')

@section('title', 'Data Album Perpisahan SDN Caringin Ngumbang')

@section('content')
    <div class="container">
        @include('components.alert-messages')

        <div class="table-responsive">
            <table id="tablePerpisahan" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th width="115">Post</th>
                        <th width="115">Update</th>
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
                dataPerpisahan();
            });
        
            function dataPerpisahan() {
                $('#tablePerpisahan').DataTable({
                    serverSide: true,
                    responsive: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('gallery-perpisahan.index') }}",
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
                        {data: 'title', name: 'title'},
                        {data: 'subtitle', name: 'subtitle'},
                        {
                            data: 'created_at',
                            render: function (data, type, row) {
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
                            render: function (data, type, row) {
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
                            data: 'gambar', 
                            name: 'gambar',
                            render: function (data, type, row) {
                                let photoUrl = `/images/gallery/perpisahan/${data}`;
                                return `<img src="${photoUrl}" alt="Foto" class="img-fluid" style="width: 150px; height: 170px;">`;
                            }
                        },
                        {
                            data: null,
                            render: function (data, type, row) {
                                let editUrl = `{{ route('gallery-perpisahan.edit', ':id') }}`.replace(':id', row.id);
                                let deleteUrl = `{{ route('gallery-perpisahan.destroy', ':id') }}`.replace(':id', row.id);

                                return `
                                    <a href="${editUrl}" class="btn btn-outline-warning btn-secoundary btn-sm mt-1 mr-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger btn-secoundary btn-sm mt-1" 
                                            onclick="confirmDelete(${row.id}, '${row.title}', '${row.subtitle}', '${deleteUrl}')">
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
            function confirmDelete(id, title, subtitle, deleteUrl) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Data kegiatan dengan nama ${title} akan dihapus.`,
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
                                    text: `Data kegiatan dengan nama ${title} berhasil dihapus.`,
                                    icon: 'success',
                                    confirmButtonColor: '#28a745',
                                    confirmButtonText: 'Oke'
                                }).then(() => {
                                    $('#tablePerpisahan').DataTable().ajax.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: `Terjadi kesalahan saat menghapus data kegiatan ${judul}.`,
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
