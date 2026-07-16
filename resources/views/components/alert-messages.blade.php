@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'Form Tidak Lengkap!',
                text: "Pastikan semua field terisi dengan benar.",
                icon: 'error',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Tutup'
            });
        });
    </script>
@endif

@if (session('danger'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'Saldo Tidak Cukup!',
                text: "{{ session('danger') }}",
                icon: 'error',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Tutup'
            });
        });
    </script>
@endif

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#28a745',
                confirmButtonText: 'Oke'
            });
        });
    </script>
@endif