<!doctype html>
<html lang="en" class="h-100" data-bs-theme="auto">

<head>
    <script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.112.5">
    <title>{{ ('EbuCodes VotingMS') }}</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/cover/">
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
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
</head>

<body class="d-flex h-100 text-center text-bg-dark">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">


        <header class="mb-auto">
            <div>
                <h3 class="float-md-start mb-0">EbuCodes</h3>
                <nav class="nav nav-masthead justify-content-center float-md-end">
                    {{-- <a class="nav-link fw-bold py-1 px-0 active" aria-current="page" href="{{ url('/') }}">Home</a>
                    --}}
                    @if (Route::has('login'))
                    @auth
                    @if (Auth::user()->role == 'voter')
                    <a class="nav-link fw-bold py-1 px-0" href="{{ route('voter.dashboard') }}">Dashboard</a>
                    @else
                    <a class="nav-link fw-bold py-1 px-0" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    @endif

                    @else
                    <a class="nav-link fw-bold py-1 px-0" href="{{ route('login') }}">Login</a>
                    @if (Route::has('register'))
                    <a class="nav-link fw-bold py-1 px-0" href="{{ route('register') }}">Register</a>
                    @endif
                    @endauth
                    @endif


                </nav>
            </div>
        </header>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <main class="px-3">
            <h1>NOTE</h1>
            <p class="lead">Voters can only vote once</p>
            <p class="lead">
                <a href="{{ route('live-results') }}" class="btn btn-lg btn-light fw-bold border-white bg-white">View
                    Live Results</a>
            </p>
        </main>

        <footer class="mt-auto text-white-50">
            <p>Cover template for <a href="https://getbootstrap.com/" class="text-white">Bootstrap</a>, by <a
                    href="https://twitter.com/mdo" class="text-white">@mdo</a>.</p>
        </footer>
    </div>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    @if (session('sweetAlert'))
    <script>
        Swal.fire({
			title: '{{ session('sweetAlert.title') }}',
			text: '{{ session('sweetAlert.message') }}',
			icon: '{{ session('sweetAlert.type') }}',
		});
    </script>
    @endif
</body>

</html>