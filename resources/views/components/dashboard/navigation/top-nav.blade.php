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

                @php
                    $unreadCount = auth()->user()->unreadNotifications->count();
                @endphp

                @if($unreadCount > 0)
                    <span class="position-absolute top-50 start-100 translate-middle badge rounded-pill bg-danger" id="notification-count">
                        {{ $unreadCount }}
                    </span>
                @endif
                </span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow" style="width: 320px">
                <li class="dropdown-header fw-semibold">Notifications</li>
                @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                    <li id="notification-item-{{$notification->id}}">
                        <a class="dropdown-item small" href="{{ $notification->data['url'].'?notification=read&id='.$notification->id ?? '#' }}">
                            <div class="fw-semibold">
                                {{ ucfirst(str_replace('_',' ', $notification->data['type'] ?? 'Notification')) }}
                            </div>
                            <div class="text-muted small">
                                {{ $notification->data['name'] ?? 'New update' }}
                            </div>
                        </a>
                    </li>
                @empty
                    <li>
                        <span class="dropdown-item text-muted small">
                            No new notifications
                        </span>
                    </li>
                @endforelse

                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-center small" href="#">
{{--                    <a class="dropdown-item text-center small" href="{{ route('notifications.index') }}">--}}
                        View all notifications
                    </a>
                </li>
            </ul>
        </li>

        <!-- 👤 USER MENU -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
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


