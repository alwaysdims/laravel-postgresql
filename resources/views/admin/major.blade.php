@extends('admin.layouts.main',['title' => 'DATA MAJORS'])
@section('content')

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h5>Data Jurusan</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#insertModal">
                Tambah Jurusan
            </button>
        </div>
    </div>
    <div class="table-responsive text-nowrap">
        <table id="dataTable" class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Jurusan</th>
                    <th>Kode Jurusan</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @php $no = 1; @endphp
                @forelse ($majors as $major)
                @php
                    $color = match(strtoupper($major->code_major)) {
                        'RPL' => 'bg-label-success',   // hijau
                        'TPK' => 'bg-label-warning',   // orange
                        'TM'  => 'bg-label-primary',   // biru
                        'OT'  => 'bg-label-danger',    // merah
                        default => 'bg-label-secondary', // warna default
                    };
                @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td><strong>{{ $major->name }}</strong></td>
                        <td>
                            <span class="badge {{ $color }}">{{ strtoupper($major->code_major) }}</span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button type="button" class="dropdown-item text-success" data-bs-toggle="modal"
                                            data-bs-target="#updateModal{{ $major->id }}">
                                            <i class="bx bx-edit-alt me-1 text-success"></i> Edit
                                        </button>
                                    </li>
                                    <li>
                                        <form id="delete-form-{{ $major->id }}"
                                            action="{{ route('data.majors.destroy', $major->id) }}"
                                            method="POST" class="d-inline form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button data-id="{{ $major->id }}" type="button"
                                                class="dropdown-item text-danger btn-delete">
                                                <i class="bx bx-trash me-1 text-danger"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                    <!-- Update Modal -->
                    <div class="modal fade" id="updateModal{{ $major->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{ route('data.majors.update', $major->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Jurusan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Jurusan</label>
                                            <input name="name" type="text" class="form-control"
                                                value="{{ $major->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Kode Jurusan</label>
                                            <input name="code_major" type="text" class="form-control"
                                                value="{{ $major->code_major }}" required placeholder="Contoh: RPL">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data jurusan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Insert Modal -->
<div class="modal fade" id="insertModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('data.majors.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jurusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Jurusan</label>
                        <input name="name" type="text" class="form-control" placeholder="Contoh: Rekayasa Perangkat Lunak" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kode Jurusan</label>
                        <input name="code_major" type="text" class="form-control" placeholder="Contoh: RPL" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
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

    // =========================
    // Sweet Alert Delete Confirm
    // =========================
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
