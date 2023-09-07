@extends('layouts.app')
@section('title', 'Results')

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
    <h1>{{ $page_title ?? '' }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">{{ $page_title ?? '' }}</li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->

<section class="section dashboard">
    <div class="row">
        <!-- Sales Card -->
        <div class="col-md-12">
            <div class="card info-card sales-card">

                <div class="card-body">
                    <h5 class="card-title">{{ $page_title ?? '' }} <span>| Total</span></h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $count ?? '' }}</h6>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Left side columns -->
        <div class="col-lg-12">
            <div class="row">
                <!-- Recent Sales -->
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-header">
                            <h5 class="card-title">{{ ('Election Results') }}</h5> |
                            <a href="{{ route('download-result') }}" class="btn btn-primary">Download Result /
                                Print Result</a>
                        </div>
                        <div class="card-body">
                            {{-- <h2 class="card-text text-center text-uppercase">Election Results</h2> --}}
                            <hr>
                            @foreach ($results as $electionId => $election)
                            <h4 class="card-text text-center">{{ $election['title'] }}</h4>
                            {{-- --}}
                            <div class="bd-example-snippet bd-code-snippet">
                                <div class="bd-example m-0 border-0">
                                    <table class="table table-sm table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Vote(s)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $i = 1;
                                            @endphp
                                            @foreach ($election['results'] as $result)
                                            <tr>
                                                <td>{{ $i++; }}</td>
                                                <td>{{ $result['name'] }}</td>
                                                <td>{{ $result['votes'] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endforeach
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