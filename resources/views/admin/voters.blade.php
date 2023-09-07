@extends('layouts.app')
@section('title', 'Voters')

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
                            <h5 class="card-title">{{ $page_title }} <span>| Total</span></h5>

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

                <!-- Recent Sales -->
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">

                        <div class="card-body">
                            <h5 class="card-title">{{ $page_title }} <span>| All</span></h5>
                            <div class="bd-example-snippet bd-code-snippet">
                                <div class="bd-example m-0 border-0">
                                    <table class="table table-responsive table-bordered" id="example1">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Permission</th>
                                                <th scope="col">Date Created</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $i = 1;
                                            @endphp
                                            @foreach ($voters as $voter)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $voter->name }}</td>
                                                <td>{{ $voter->email }}</td>
                                                @if ($voter->has_voted)
                                                <td>
                                                    <span class="badge text-bg-success rounded-pill">
                                                        <i class="fas fa-check"></i>
                                                        {{ ('User has voted') }}
                                                    </span>
                                                </td>
                                                @else
                                                <td>
                                                    <span class="badge text-bg-danger rounded-pill">
                                                        <i class="fas fa-close"></i>
                                                        {{ ('User has not voted') }}
                                                    </span>
                                                </td>
                                                @endif
                                                {{-- <td>{{ $voter->has_voted }}</td> --}}
                                                <td>{{ $voter->created_at }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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