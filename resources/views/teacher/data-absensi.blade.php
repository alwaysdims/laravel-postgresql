@extends('teacher.layouts.main',['title' => 'Teacher Absensi Siswa'])
@section('content')

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <input type="date" name="date" class="form-control" value="{{ request('date', now()->toDateString()) }}">
    </div>

    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">-- Semua Status --</option>
            <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
            <option value="alfa" {{ request('status') == 'alfa' ? 'selected' : '' }}>Alfa</option>
            <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
            <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary w-100">
            <i class="bx bx-filter"></i> Filter
        </button>
    </div>
</form>


<div class="table-responsive text-nowrap">
    <table id="dataTable" class="table table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Jam Absen Masuk</th>
                <th>Tempat Absen Masuk</th>
                <th>Jam Absen Pulang</th>
                <th>Tempat Absen Keluar</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @php $no = 1; @endphp

            @forelse ($attendances as $attendance)
            <tr>
                <td>{{ $no++ }}</td>

                <td>
                    <strong>{{ $attendance->student->nis }}</strong>
                </td>

                <td>{{ $attendance->student->nama }}</td>

                <td>
                    <span class="badge bg-label-info">
                        {{ $attendance->student->classes?->name ?? 'Belum Ada Kelas' }}
                    </span>
                </td>

                <td>
                    <span class="badge bg-label-secondary">
                        {{ $attendance->student->classes?->major->name ?? '-' }}
                    </span>
                </td>

                {{-- Jam Absen Masuk --}}
                <td>
                    @if ($attendance->check_in_time)
                    <span class="text-success fw-semibold">
                        {{ $attendance->check_in_time->format('H:i') }}
                    </span>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </td>
                {{-- Tempat Absen Masuk --}}
                <td>
                    <!-- 7 -->
                    @if ($attendance->check_in_latitude && $attendance->check_in_longitude)
                    <a href="https://www.google.com/maps?q={{ $attendance->check_in_latitude }},{{ $attendance->check_in_longitude }}"
                        target="_blank" class="text-success fw-semibold">
                        <i class="bx bx-map"></i> Lihat Lokasi
                    </a>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </td>
                {{-- Jam Absen Pulang --}}
                <td>
                    @if ($attendance->check_out_time)
                    <span class="text-primary fw-semibold">
                        {{ $attendance->check_out_time->format('H:i') }}
                    </span>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </td>
                {{-- Tempat Absen Keluar --}}
                <td>
                    <!-- 9 -->
                    @if ($attendance->check_out_latitude && $attendance->check_out_longitude)
                    <a href="https://www.google.com/maps?q={{ $attendance->check_out_latitude }},{{ $attendance->check_out_longitude }}"
                        target="_blank" class="text-primary fw-semibold">
                        <i class="bx bx-map"></i> Lihat Lokasi
                    </a>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </td>
                {{-- Status --}}
                <td>
                    @php
                    $statusColor = match($attendance->status) {
                    'hadir' => 'success',
                    'izin' => 'warning',
                    'sakit' => 'primary',
                    'alfa' => 'danger',
                    default => 'secondary',
                    };
                    @endphp

                    <span class="badge bg-label-{{ $statusColor }}">
                        {{ strtoupper($attendance->status) }}
                    </span>
                </td>

                {{-- Actions --}}
                <td>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>

                        <div class="dropdown-menu dropdown-menu-end">

                            {{-- FOTO ABSEN MASUK --}}
                            <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                data-bs-target="#absenMasuk{{ $attendance->id }}">
                                <i class="bx bx-camera me-1"></i> Foto absen masuk
                            </button>

                            {{-- FOTO ABSEN PULANG --}}
                            <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                data-bs-target="#absenPulang{{ $attendance->id }}">
                                <i class="bx bx-camera me-1"></i> Foto absen pulang
                            </button>

                        </div>
                    </div>

                    {{-- MODAL FOTO ABSEN MASUK --}}
                    <div class="modal fade" id="absenMasuk{{ $attendance->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Foto Absen Masuk – {{ $attendance->student->nama }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body text-center">
                                    @if ($attendance->check_in_photo)
                                    <img src="{{ asset('storage/'.$attendance->check_in_photo) }}"
                                        class="img-fluid rounded" alt="Foto Absen Masuk">
                                    @else
                                    <p class="text-muted mb-0">Belum ada foto absen masuk.</p>
                                    @endif
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MODAL FOTO ABSEN PULANG --}}
                    <div class="modal fade" id="absenPulang{{ $attendance->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Foto Absen Pulang – {{ $attendance->student->nama }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body text-center">
                                    @if ($attendance->check_out_photo)
                                    <img src="{{ asset('storage/'.$attendance->check_out_photo) }}"
                                        class="img-fluid rounded" alt="Foto Absen Pulang">
                                    @else
                                    <p class="text-muted mb-0">Belum ada foto absen pulang.</p>
                                    @endif
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>

            </tr>

            @empty

            @endforelse
        </tbody>
    </table>
</div>


<style>
    .swal2-container {
        z-index: 20000 !important;
    }

    .swal2-backdrop-show {
        z-index: 20000 !important;
    }

    .swal2-popup {
        z-index: 21000 !important;
    }

</style>


<script>
    new DataTable('#dataTable');

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;

            Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    backdrop: 'rgba(0,0,0,0.55)', // background hitam redup
                    customClass: {
                        popup: 'glow-alert' // glow khusus alert
                    }
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });

        });
    });

</script>

@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css">

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.js"></script>
