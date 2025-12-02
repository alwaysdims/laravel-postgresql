@extends('admin.layouts.main',['title' => 'DATA CLASSES'])
@section('content')

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h5>Data Kelas</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#insertModal">
                Tambah Kelas
            </button>
        </div>
    </div>
    <div class="table-responsive text-nowrap">
        <table id="dataTable" class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kelas</th>
                    <th>Jurusan</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @php $no = 1; @endphp
                @forelse ($classes as $class)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td><strong>{{ $class->name }}</strong></td>
                        <td>
                            <span class="badge bg-label-info">
                                {{ $class->major->name ?? 'Jurusan Dihapus' }}
                            </span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button type="button" class="dropdown-item text-success" data-bs-toggle="modal"
                                            data-bs-target="#updateModal{{ $class->id }}">
                                            <i class="bx bx-edit-alt me-1 text-success"></i> Edit
                                        </button>
                                    </li>
                                    <li>
                                        <form id="delete-form-{{ $class->id }}"
                                            action="{{ route('data.classes.destroy', $class->id) }}"
                                            method="POST" class="d-inline form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button data-id="{{ $class->id }}" type="button"
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
                    <div class="modal fade" id="updateModal{{ $class->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{ route('data.classes.update', $class->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Kelas</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Kelas</label>
                                            <input name="name" type="text" class="form-control"
                                                value="{{ $class->name }}" required placeholder="Contoh: XII RPL 1">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Jurusan</label>
                                            <select name="major_id" class="form-select" required>
                                                <option value="">-- Pilih Jurusan --</option>
                                                @foreach($majors as $id => $name)
                                                    <option value="{{ $id }}" {{ $class->major_id == $id ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
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
                        <td colspan="4" class="text-center">Belum ada data kelas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Insert Modal -->
<div class="modal fade" id="insertModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('data.classes.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kelas</label>
                        <input name="name" type="text" class="form-control" placeholder="Contoh: X RPL 1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jurusan</label>
                        <select name="major_id" class="form-select" required>
                            <option value="">-- Pilih Jurusan --</option>
                            @foreach($majors as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
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
