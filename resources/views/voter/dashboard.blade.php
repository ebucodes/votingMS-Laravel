<head>
    <script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.112.5">
    <title>{{ ('EbuCodes Voter Dashboard') }}</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/headers/">
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="{{ asset('css/voter.css') }}" rel="stylesheet">
</head>

<body>
    <main>
        <header class="p-3 mb-3 border-bottom">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="{{ url('/') }}"
                        class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                        <img src="{{ asset('img/logo/logo2.png') }}" width="40" height="40" alt="">
                    </a>

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="{{ url('/') }}" class="nav-link px-2 link-secondary">Overview</a></li>
                        {{-- <li><a href="{{ route('live-results') }}" class="nav-link px-2 link-body-emphasis">Live
                                Result</a></li> --}}
                    </ul>

                    <div class="dropdown text-end">
                        <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                            {{-- <img src="{{ asset('img/me.jpeg') }}" alt="mdo" width="32" height="32"
                                class="rounded-circle"> --}}
                        </a>
                        <ul class="dropdown-menu text-small">
                            {{-- <li><a class="dropdown-item" href="#">New project...</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li> --}}
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                                                            document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i>
                                    Sign Out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                {{-- <a class="dropdown-item" href="#">Sign out</a> --}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        {{-- @if (Session::has('fail'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5><i class="icon fas fa-ban"></i>{{ Session::get('fail') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <h5><i class="icon fas fa-check"></i>{{ Session::get('success') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif --}}
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
        @if ($user->has_voted == false)
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">

                        @foreach ($livePolls as $poll)
                        @if ($poll->candidates->count() > 0)
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    {{ $poll->title }}
                                </h4>
                            </div>
                            <div class="card-body">
                                <p class="card-text">Opens at: {{\Carbon\Carbon::parse($poll->start)->format('F dS, Y -
                                    h:i
                                    A')}}</p>
                                <p class="card-text">Closes At: {{\Carbon\Carbon::parse($poll->end)->format('F dS, Y -
                                    h:i
                                    A')}}</p>
                                {{-- --}}
                                <form action="{{ route('submit.vote') }}" class="needs-validation" method="POST"
                                    novalidate>
                                    @csrf
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Candidate Name</th>
                                                <th scope="col">Sex</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Vote</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $i = 1;
                                            @endphp
                                            @foreach ($poll->candidates as $candidate)
                                            <tr>
                                                <td>{{ $i++; }}</td>
                                                <td>{{ $candidate->name }}</td>
                                                <td>{{ $candidate->sex }}</td>
                                                <td><img src="{{ asset('img/candidates/' . $candidate->image) }}"
                                                        alt="{{ $candidate->name }}" width="50" height="50"></td>
                                                <td>
                                                    {{-- <input type="radio" name="votes[{{ $poll->id }}]"
                                                        value="{{ $candidate->id }}" required> --}}
                                                    <input type="radio" name="votes[{{ $poll->id }}]"
                                                        value="{{ $candidate->id }}">
                                                    <input type="hidden" name="candidate_ids[{{ $poll->id }}]"
                                                        value="{{ $candidate->id }}">
                                                    <input type="hidden" name="election_id" value="{{ $poll->id }}">
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                        <br>
                        @endif
                        @endforeach
                        <div class="card-footer">
                            @if ($livePolls->count() > 0)
                            <button type="submit" class="btn btn-primary">Submit Vote</button>
                            @endif
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        @endif


    </main>
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> --}}
    @if (session('sweetAlert'))
    <script>
        Swal.fire({
			title: '{{ session('sweetAlert.title') }}',
			text: '{{ session('sweetAlert.message') }}',
			icon: '{{ session('sweetAlert.type') }}',
		});
    </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/form-validation.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>