<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('sneat') }}/assets/vendor/libs/jquery/jquery.js"></script>
<script src="{{ asset('sneat') }}/assets/vendor/libs/popper/popper.js"></script>
<script src="{{ asset('sneat') }}/assets/vendor/js/bootstrap.js"></script>
<script src="{{ asset('sneat') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="{{ asset('sneat') }}/assets/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('sneat') }}/assets/vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="{{ asset('sneat') }}/assets/js/main.js"></script>

<!-- Page JS -->
<script src="{{ asset('sneat') }}/assets/js/dashboards-analytics.js"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



@stack('scripts')

<script>
    document.getElementById('btnLogout').addEventListener('click', function (event) {
        Swal.fire({
            title: "Konfirmasi Logout",
            text: "Apakah kamu yakin ingin keluar?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Logout",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    });

</script>

<script>
    // =========================
    // Sweet Alert Flash Message
    // =========================
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session("success") }}',
        timer: 1800,
        showConfirmButton: false
    });
    @endif

    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session("error") }}',
        timer: 2000,
        showConfirmButton: false
    });
    @endif

    @if(session('warning'))
    Swal.fire({
        icon: 'warning',
        title: 'Peringatan!',
        text: '{{ session("warning") }}',
        timer: 2000,
        showConfirmButton: false
    });
    @endif

</script>
