<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')

<body>
	@include('layouts.navbar')

	@include('layouts.sidebar')

	<main class="main"
		id="main">
		@yield('content')
	</main>

	@include('layouts.footer')
	@include('layouts.scripts')
</body>

</html>
