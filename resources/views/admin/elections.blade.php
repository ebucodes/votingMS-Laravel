@extends('layouts.app')
@section('title', 'Polls')

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
                            <h5 class="card-title">Polls <span>| Total</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-poll"></i>
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
                            <h5 class="card-title">Polls <span>| Add</span></h5>
                            <!-- Basic Modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#create">
                                Create new poll
                            </button>
                            <div class="modal fade" id="create" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Create New Poll</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('elections.store') }}" method="POST"
                                                class="needs-validation" novalidate>
                                                @csrf
                                                {{-- --}}
                                                <div class="form-group mb-3">
                                                    <label for="">Name</label>
                                                    <input type="text" name="title" class="form-control" required>
                                                </div>
                                                {{-- --}}
                                                <div class="form-group mb-3">
                                                    <label for="">Description</label>
                                                    <textarea name="description" class="form-control" cols="10"
                                                        rows="2"></textarea>
                                                </div>
                                                {{-- --}}
                                                <div class="form-group mb-3">
                                                    <label for="">Begins At:</label>
                                                    <input type="date" name="start" class="form-control" required>
                                                </div>
                                                {{-- --}}
                                                <div class="form-group mb-3">
                                                    <label for="">Ends At:</label>
                                                    <input type="date" name="end" class="form-control" required>
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
                                        <th scope="col">Title</th>
                                        <th scope="col">Start</th>
                                        <th scope="col">End</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date Created</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($elections as $election)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $election->title }}</td>
                                        <td>{{ $election->start }}</td>
                                        <td>{{ $election->end }}</td>
                                        @if ($election->status === 'open')
                                        <td><span class="badge bg-success"> {{ $election->status }}</span></td>
                                        @else
                                        <td><span class="badge bg-danger">{{ $election->status }}</span></td>
                                        @endif
                                        <td>{{ $election->created_at }}</td>
                                        <td>
                                            <a data-bs-toggle="modal" data-bs-target="#edit{{ $election->id }}">
                                                <i class="fas fa-edit text-success"></i>
                                            </a>
                                            {{-- --}}
                                            <a data-bs-toggle="modal" data-bs-target="#delete{{ $election->id }}">
                                                <i class="fas fa-trash text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    {{-- edit --}}
                                    <div class="modal fade" id="edit{{ $election->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('elections.update', $election->id) }}"
                                                        method="POST" novalidate>
                                                        @csrf
                                                        @method('put')
                                                        {{-- --}}
                                                        <div class="form-group mb-3">
                                                            <label for="">Title</label>
                                                            <input type="text" name="title" class="form-control"
                                                                value="{{ $election->title }}" required>
                                                        </div>
                                                        {{-- --}}
                                                        <div class="form-group mb-3">
                                                            <label for="">Description <span>(Optional)</span></label>
                                                            <textarea name="description" class="form-control" cols="10"
                                                                rows="2">{{ $election->description }}</textarea>
                                                        </div>
                                                        {{-- --}}
                                                        <div class="form-group mb-3">
                                                            <label for="">Starts At:</label>
                                                            <input type="text" name="start" class="form-control"
                                                                value="{{ $election->start }}" required>
                                                        </div>
                                                        {{-- --}}
                                                        <div class="form-group mb-3">
                                                            <label for="">Ends At:</label>
                                                            <input type="text" name="end" class="form-control"
                                                                value="{{ $election->end }}" required>
                                                        </div>
                                                        {{-- --}}
                                                        <div class="form-group mb-3">
                                                            <label for="">Status</label>
                                                            <input type="text" name="status" class="form-control"
                                                                value="{{ $election->status }}" required>
                                                        </div>
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
                        <div class="modal fade" id="delete{{ $election->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('elections.destroy', $election->id) }}" method="POST">
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