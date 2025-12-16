@extends('student.layouts.main',['title' => 'Student dashboard'])
@section('content')

<div class="card mb-4">
    <div class="d-flex align-items-end row">
        <div class="col-sm-7">
            <div class="card-body">
                <h5 class="card-title text-primary">Welcome to skanda present {{ Auth::user()->username }}! 🎉</h5>
                <p class="mb-4">
                    You have done <span class="fw-bold">72%</span> more sales today. Check your new badge in
                    your profile.
                </p>
                <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
            </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-4">
                <img src="{{ asset('sneat') }}/assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="{{ asset('sneat') }}/illustrations/man-with-laptop-dark.png" data-app-light-img="{{ asset('sneat') }}/illustrations/man-with-laptop-light.png">
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0">Kontrol Absensi Harian 🕒</h5>
        <span class="badge bg-label-info p-2">
            <span id="current-date-day" class="fw-bold me-1"></span> |
            <span id="current-time-clock"></span>
        </span>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="border p-3 rounded-2 h-100">
                    <p class="text-secondary mb-1">Status Absensi:</p>
                    <h4 class="fw-bold text-success">Sudah Absen Masuk</h4>
                    <small class="text-muted">Absen Masuk Tercatat: 07:30 WIB</small>
                    <hr>
                    <p class="text-secondary mb-1">Status Absensi Pulang:</p>
                    <h4 class="fw-bold text-warning">Belum Absen Pulang</h4>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-grid gap-2">

                    @php
                        // Menggunakan waktu server untuk logika, disetel ke WIB
                        $currentTime = now()->setTimezone('Asia/Jakarta');
                        $isMasukTime = $currentTime->between(now()->setTime(5, 0, 0), now()->setTime(8, 0, 0));
                    @endphp

                    @if($isMasukTime)
                        <a href="{{ route('absen.masuk') }}" class="btn btn-success btn-lg">
                            <i class="bx bx-log-in me-1"></i> Absen Masuk Sekarang
                        </a>
                    @else
                        <button class="btn btn-success btn-lg" disabled>
                            <i class="bx bx-log-in me-1"></i> Absen Masuk (05:00 - 08:00 WIB)
                        </button>
                    @endif


                    @php
                        $isPulangTime = $currentTime->between(now()->setTime(15, 0, 0), now()->setTime(20, 0, 0));
                    @endphp

                    @if($isPulangTime)
                        <a href="{{ route('absen.pulang') }}" class="btn btn-danger btn-lg">
                            <i class="bx bx-log-out me-1"></i> Absen Pulang Sekarang
                        </a>
                    @else
                        <button class="btn btn-danger btn-lg" disabled>
                            <i class="bx bx-log-out me-1"></i> Absen Pulang (15:00 - 20:00 WIB)
                        </button>
                    @endif

                    <hr class="my-2">

                    <a href="{{ route('izin.show') }}" class="btn btn-warning btn-outline-warning">
                        <i class="bx bx-message-square-error me-1"></i> Ajukan Izin/Sakit
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/fonts/boxicons.css" />

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.js"></script>

<script>
    // Script untuk menampilkan Hari, Tanggal, dan Waktu (WIB) yang selalu diperbarui
    function updateDateTime() {
        const now = new Date();

        // Opsi untuk format Tanggal dan Hari (misal: Rabu, 03 Desember 2025)
        const dateOptions = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            timeZone: 'Asia/Jakarta'
        };
        const dateString = now.toLocaleDateString('id-ID', dateOptions);

        // Opsi untuk format Waktu (misal: 10:31:00 WIB)
        const timeOptions = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            timeZone: 'Asia/Jakarta'
        };
        const timeString = now.toLocaleTimeString('id-ID', timeOptions) + ' WIB';

        // Update elemen di UI
        document.getElementById('current-date-day').textContent = dateString;
        document.getElementById('current-time-clock').textContent = timeString;
    }

    // Panggil fungsi sekali saat load, lalu ulangi setiap detik
    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>
