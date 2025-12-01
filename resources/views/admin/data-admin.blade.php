@extends('admin.layouts.main',['title' => 'DATA ADMIN'])
@section('content')
<div class="mb-3">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
        Launch modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('data.admins.store') }}" method="post">
                    @csrf
                    <div class="modal-body border m-3 rounded text-white  bg-secondary opacity-20">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Name</label>
                                <input type="text" id="nameBasic" class="form-control" placeholder="Enter Name">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="emailBasic" class="form-label">Email</label>
                                <input type="text" id="emailBasic" class="form-control" placeholder="xxxx@xxx.xx">
                            </div>
                            <div class="col mb-0">
                                <label for="dobBasic" class="form-label">DOB</label>
                                <input type="text" id="dobBasic" class="form-control" placeholder="DD / MM / YY">
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Name</label>
                                <input type="text" id="nameBasic" class="form-control" placeholder="Enter Name">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="emailBasic" class="form-label">Email</label>
                                <input type="text" id="emailBasic" class="form-control" placeholder="xxxx@xxx.xx">
                            </div>
                            <div class="col mb-0">
                                <label for="dobBasic" class="form-label">DOB</label>
                                <input type="text" id="dobBasic" class="form-control" placeholder="DD / MM / YY">
                            </div>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <h5 class="card-header">Data Admins</h5>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
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
                @forelse ($admin as $data )
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
                                <i class="bx bx-dots-vertical-rounded "></i>
                            </button>
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item text-success" href="javascript:void(0);"><i class="bx bx-edit-alt me-1 text-success"></i>
                                    Edit</a>
                                <a class="dropdown-item text-danger" href="javascript:void(0);"><i class="bx bx-trash me-1 text-danger"></i>
                                    Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>

                @empty

                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
