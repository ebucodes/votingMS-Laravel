@if (Auth::user()->role === 'admin')
<!-- ======= Sidebar ======= -->
<aside class="sidebar" id="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link" href="index.html">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul class="nav-content collapse" id="components-nav" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('voters.index') }}">
                        <i class="bi bi-circle"></i><span>Voters</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admins.index') }}">
                        <i class="bi bi-circle"></i><span>Admin</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('candidates.index') }}">
                <i class="fas fa-users"></i>
                <span>Candidates</span>
            </a>
        </li>
        <!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('elections.index') }}">
                <i class="fas fa-poll"></i>
                <span>Elections</span>
            </a>
        </li>
        <!-- End F.A.Q Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('election-results') }}">
                <i class="bi bi-envelope"></i>
                <span>Results</span>
            </a>
        </li>
        <!-- End Contact Page Nav -->
    </ul>
</aside>
<!-- End Sidebar-->
@else
@endif