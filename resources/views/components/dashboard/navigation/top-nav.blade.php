<!-- TOP NAV -->
<nav class="navbar navbar-expand bg-white shadow-sm mb-4 px-3">
    <button id="toggleSidebar" class="btn btn-outline-secondary me-3">
        <i class="bi bi-list"></i>
    </button>

{{--    <span class="navbar-brand mb-0 h5">Dashboard</span>--}}

    <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                <i class="bi bi-person-circle"></i> {{auth()->user()->name}}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>
