@extends('layouts.app')
@section('title', 'Admins')

@section('content')
{{-- --}}
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="pagetitle">
    <h1>{{ $page_title }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">{{ $page_title }}</li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->

<section class="section dashboard">
    <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-12">
            <div class="row">

                <!-- Sales Card -->
                <div class="col-md-12">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Admins <span>| Total</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $count }}</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End Sales Card -->
                @if (Auth::user()->permission === 'super')
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Admins <span>| Add</span></h5>
                            <!-- Basic Modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#create">
                                Create new admin
                            </button>
                            <div class="modal fade" id="create" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Create New Admin</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.add') }}" method="POST"
                                                class="needs-validation" enctype="multipart/form-data" novalidate>
                                                @csrf
                                                {{-- --}}
                                                <div class="form-group mb-3">
                                                    <label for="">Name</label>
                                                    <input type="text" name="name" class="form-control" required>
                                                </div>
                                                {{-- --}}
                                                <div class="form-group mb-3">
                                                    <label for="">Email</label>
                                                    <input type="email" name="email" class="form-control" required>
                                                </div>
                                                {{-- --}}
                                                <div class="form-group mb-3">
                                                    <label for="">Password</label>
                                                    <input type="password" name="password" class="form-control"
                                                        required>
                                                </div>
                                                {{-- --}}
                                                <div class="form-group mb-3">
                                                    <label for="">Permission</label>
                                                    <select name="permission" id="" class="form-control" required>
                                                        <option value="">Select permission</option>
                                                        <option value="member">Member</option>
                                                        <option value="editor">Editor</option>
                                                        <option value="super">Super</option>
                                                    </select>
                                                </div>
                                                {{-- --}}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- End Basic Modal-->
                        </div>
                    </div>
                </div>
                @else
                <div class="col-lg-6">
                </div>
                @endif


                <!-- Recent Sales -->
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">

                        <div class="card-body">
                            <h5 class="card-title">Admins <span>| All</span></h5>

                            <table class="table-borderless datatable table-responsive table" id="example1">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Permission</th>
                                        <th scope="col">Date Created</th>
                                        @if ($user->permission ==='super')
                                        <th scope="col">Action</th>
                                        @endif

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($admins as $admin)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->permission }}</td>
                                        <td>{{ $admin->created_at }}</td>
                                        @if ($user->permission === 'super')
                                        <td>
                                            <a data-bs-toggle="modal" data-bs-target="#edit{{ $admin->id }}">
                                                <i class="fas fa-edit text-success"></i>
                                            </a>
                                            {{-- --}}
                                            <a data-bs-toggle="modal" data-bs-target="#delete{{ $admin->id }}">
                                                <i class="fas fa-trash text-danger"></i>
                                            </a>
                                        </td>
                                        @endif

                                    </tr>
                                    {{-- edit --}}
                                    <div class="modal fade" id="edit{{ $admin->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.update', $admin->id) }}" method="POST"
                                                        novalidate>
                                                        @csrf
                                                        {{-- --}}
                                                        <div class="form-group mb-3">
                                                            <label for="">Name</label>
                                                            <input type="text" name="name" class="form-control"
                                                                value="{{ $admin->name }}" required>
                                                        </div>
                                                        {{-- --}}
                                                        <div class="form-group mb-3">
                                                            <label for="">Email</label>
                                                            <input type="text" name="email" class="form-control"
                                                                value="{{ $admin->email }}" required>
                                                        </div>
                                                        {{-- --}}
                                                        <div class="form-group mb-3">
                                                            <label for="">Permission</label>
                                                            <input type="text" name="permission" class="form-control"
                                                                value="{{ $admin->permission }}" required>
                                                        </div>
                                                        {{-- --}}
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save
                                                                changes</button>
                                                        </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                        </div>
                        {{-- delete--}}
                        <div class="modal fade" id="delete{{ $admin->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.delete', $admin->id) }}" method="POST">
                                            @csrf
                                            <div class="form-floating">
                                                <p>Are you sure you want to delete?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save
                                                    changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        </tbody>
                        </table>

                    </div>

                </div>
            </div>
            <!-- End Recent Sales -->
        </div>
    </div>
    <!-- End Left side columns -->
    </div>
</section>
@endsection
