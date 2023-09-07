@extends('layouts.app')
@section('title', 'Candidates')

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
                            <h5 class="card-title">Candidates <span>| Total</span></h5>

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

                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Candidates <span>| Add</span></h5>
                            <!-- Basic Modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#create">
                                Create new candidate
                            </button>
                            <div class="modal fade" id="create" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Create New Candidate</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('candidates.store') }}" method="POST"
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
                                                    <label for="">Position</label>
                                                    <select name="position" id="" class="form-control" required>
                                                        <option value="">Select position</option>
                                                        @foreach ($positions as $position)
                                                        <option value="{{ $position->id }}">{{ $position->title }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{-- --}}
                                                <div class="form-group mb-3">
                                                    <label for="">Gender:</label>
                                                    <select name="sex" id="" class="form-control" required>
                                                        <option value="">Gender?</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                                {{-- --}}
                                                <div class="form-group mb-3">
                                                    <label for="">Image:</label>
                                                    <input type="file" name="image" class="form-control"
                                                        accept="image/*" required>
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

                <!-- Recent Sales -->
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">

                        <div class="card-body">
                            <h5 class="card-title">Candidates <span>| All</span></h5>

                            <table class="table-borderless datatable table-responsive table" id="example1">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Sex</th>
                                        <th scope="col">Election</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Date Created</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($candidates as $candidate)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $candidate->name }}</td>
                                        <td>{{ $candidate->email }}</td>
                                        <td>{{ $candidate->sex }}</td>
                                        <td>{{ $candidate->election->title }}</td>
                                        <td><img src="/img/candidates/{{ $candidate->image }}"
                                                class="img-responsive img-fluid" width="50" height="50">
                                        </td>
                                        <td>{{ $candidate->created_at }}</td>
                                        <td>
                                            <a data-bs-toggle="modal" data-bs-target="#edit{{ $candidate->id }}">
                                                <i class="fas fa-edit text-success"></i>
                                            </a>
                                            {{-- --}}
                                            <a data-bs-toggle="modal" data-bs-target="#delete{{ $candidate->id }}">
                                                <i class="fas fa-trash text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    {{-- edit --}}
                                    <div class="modal fade" id="edit{{ $candidate->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('candidates.update', $candidate->id) }}"
                                                        method="POST" novalidate>
                                                        @csrf
                                                        @method('put')
                                                        {{-- --}}
                                                        <div class="form-group mb-3">
                                                            <label for="">Name</label>
                                                            <input type="text" name="name" class="form-control"
                                                                value="{{ $candidate->name }}" required>
                                                        </div>
                                                        {{-- --}}
                                                        <div class="form-group mb-3">
                                                            <label for="">Email</label>
                                                            <input type="text" name="email" class="form-control"
                                                                value="{{ $candidate->email }}" required>
                                                        </div>
                                                        {{-- --}}
                                                        {{-- <div class="form-group mb-3">
                                                            <label for="">Position</label>
                                                            <input type="text" name="position" class="form-control"
                                                                value="{{ $candidate->position }}" required>
                                                        </div> --}}
                                                        {{-- --}}
                                                        <div class="form-group mb-3">
                                                            <label for="">Sex:</label>
                                                            <input type="text" name="sex" class="form-control"
                                                                value="{{ $candidate->sex }}" required>
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
                        <div class="modal fade" id="delete{{ $candidate->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('candidates.destroy', $candidate->id) }}" method="POST">
                                            @csrf
                                            @method('delete')
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