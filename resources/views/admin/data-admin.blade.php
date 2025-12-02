@extends('admin.layouts.main',['title' => 'DATA ADMINS'])
@section('content')

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h5>Data Admins</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#insertModal">
                Add Admin
            </button>
        </div>
    </div>
    <div class="table-responsive text-nowrap">
        <table id="dataTable" class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Address</th>
                    <th>Number Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @php
                $no = 1;
                @endphp
                @forelse ($admins as $data )
                @php
                $id = $data->id;
                $name = $data->name;
                $address = $data->address;
                $number_phone = $data->number_phone;
                $email = $data->user->email; // Added email variable
                $role = $data->user->role; // Added role variable
                $username = $data->user->username; // Added username variable


                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $data->name }}</td>
                    <td> <strong>{{ $data->user->username }}</strong></td>
                    <td>{{ $data->user->email}}</td>
                    <td><span class="badge bg-label-primary me-1">{{ $data->user->role }}</span></td>
                    <td>{{ $data->address}}</td>
                    <td>{{ $data->number_phone}}</td>

                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>

                            <ul class="dropdown-menu">
                                <li>
                                    <button type="button" class="dropdown-item text-success" data-bs-toggle="modal"
                                        data-bs-target="#updateModal{{ $id }}">
                                        <i class="bx bx-edit-alt me-1 text-success"></i> Edit
                                    </button>
                                </li>

                                <li>
                                    <form id="delete-form-{{ $id }}" action="{{ route('data.admins.destroy', $id) }}"
                                        method="POST" class="d-inline form-delete">

                                        @csrf
                                        @method('DELETE')

                                        <button data-id="{{ $id }}" type="button"
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
                <div class="modal fade" id="updateModal{{ $id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <form action="{{ route('data.admins.update', $id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Admin</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Name</label>
                                            <input name="name" type="text" class="form-control" value="{{ $name }}"
                                                required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Username</label>
                                            <input name="username" type="text" class="form-control"
                                                value="{{ $username }}" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email</label>
                                            <input name="email" type="email" class="form-control" value="{{ $email }}"
                                                required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">New Password (Optional)</label>
                                            <input name="password" type="password" class="form-control">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Confirm Password</label>
                                            <input name="password_confirmation" type="password" class="form-control">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Number Phone</label>
                                            <input name="number_phone" type="text" class="form-control"
                                                value="{{ $number_phone }}">
                                        </div>
                                    </div>

                                    <!-- ADDRESS FULL WIDTH -->
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea name="address" class="form-control" rows="3">{{ $address }}</textarea>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button class="btn btn-primary">Save changes</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>


                @empty

                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- Insert Modal -->
<div class="modal fade" id="insertModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">

        <form action="{{ route('data.admins.store') }}" method="POST">
            @csrf

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name</label>
                            <input name="name" type="text" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username</label>
                            <input name="username" type="text" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password</label>
                            <input name="password" type="password" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input name="password_confirmation" type="password" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Number Phone</label>
                            <input name="number_phone" type="text" class="form-control">
                        </div>
                    </div>

                    <!-- ADDRESS FULL WIDTH -->
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="3"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Save</button>
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
