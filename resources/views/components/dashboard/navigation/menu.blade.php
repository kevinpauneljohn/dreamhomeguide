<!-- SIDEBAR -->
<div id="sidebar" class="sidebar bg-dark text-white position-fixed p-3">
    <h5 class="pb-3 border-bottom text-center">
        <span class="sidebar-title">DHG</span>
    </h5>

    <ul class="nav nav-pills flex-column mt-3">
        <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link text-white {{ Route::is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @can('view listing')
        <li>
            <a href="{{route('property.index')}}" class="nav-link text-white {{ Route::is('property.index') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i>
                <span>Properties</span>
            </a>
        </li>
        @endcan

        @can('view agent')
            <li>
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-people"></i>
                    <span>Agents</span>
                </a>
            </li>
        @endcan

        <li>
            <a href="#" class="nav-link text-white">
                <i class="bi bi-bar-chart"></i>
                <span>Reports</span>
            </a>
        </li>
    </ul>
</div>
