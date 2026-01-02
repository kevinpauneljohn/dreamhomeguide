<!-- TOP NAV -->
<nav class="navbar navbar-expand bg-white shadow-sm mb-4 px-3">
    <button id="toggleSidebar" class="btn btn-outline-secondary me-3">
        <i class="bi bi-list"></i>
    </button>

    <ul class="navbar-nav ms-auto align-items-center">

        <!-- 🔔 NOTIFICATIONS -->
        <li class="nav-item dropdown me-3">
            <a class="nav-link position-relative" data-bs-toggle="dropdown" href="#">
                <span class="position-relative d-inline-block">
                <i class="bi bi-bell fs-5"></i>
                    <span class="position-absolute top-50 start-100 translate-middle badge rounded-pill bg-danger" id="notification-count"></span>
                </span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow" style="width: 320px" id="notification-dropdown-menu">

{{--                <li><hr class="dropdown-divider"></li>--}}
{{--                <li>--}}
{{--                    <a class="dropdown-item text-center small" href="#">--}}
{{--                    <a class="dropdown-item text-center small" href="{{ route('notificationsMarkRead.index') }}">--}}
{{--                        View all notificationsMarkRead--}}
{{--                    </a>--}}
{{--                </li>--}}
            </ul>
        </li>

        <!-- 👤 USER MENU -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                <i class="bi bi-person-circle"></i> {{ auth()->user()->full_name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{route('profile')}}">Profile</a></li>
{{--                <li><a class="dropdown-item" href="#">Settings</a></li>--}}
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}">
                        Logout
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>


