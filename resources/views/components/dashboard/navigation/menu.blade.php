<!-- SIDEBAR -->
<div id="sidebar" class="sidebar bg-dark text-white position-fixed p-3">
    <h5 class="pb-3 border-bottom text-center">
        <span class="sidebar-title">DHG</span>
    </h5>

    <ul class="nav nav-pills flex-column mt-3">

        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link text-white {{ Route::is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Properties -->
        @can('view listing')
            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center {{ Route::is('property.index') || Route::is('property.create') ? 'active' : '' }}"
                   data-bs-toggle="collapse"
                   href="#propertiesMenu"
                   role="button"
                   aria-expanded="false"
                   aria-controls="propertiesMenu">

                <span>
                    <i class="bi bi-bar-chart"></i> Properties
                </span>

                    <i class="bi bi-caret-down-fill small"></i>
                </a>

                <ul class="collapse {{ Route::is('property.index') || Route::is('property.create') ? 'show' : '' }} ps-4" id="propertiesMenu">
                    <li><a href="{{route('property.index')}}" class="nav-link text-white-50 {{ Route::is('property.index') ? 'active' : '' }}">View Properties</a></li>
                    <li><a href="{{route('property.create')}}" class="nav-link text-white-50 {{ Route::is('property.create') ? 'active' : '' }}">Add property</a></li>
                </ul>
            </li>
        @endcan

        <!-- Users -->
        @can('view user')
            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center {{ Route::is('user.index') || Route::is('user.create') ? 'active' : '' }}"
                   data-bs-toggle="collapse"
                   href="#usersMenu"
                   role="button"
                   aria-expanded="false"
                   aria-controls="usersMenu">

                <span>
                    <i class="bi bi-people"></i> Users
                </span>

                    <i class="bi bi-caret-down-fill small"></i>
                </a>

                <ul class="collapse {{ Route::is('user.index') || Route::is('user.create') ? 'show' : '' }} ps-4" id="usersMenu">
                    <li><a href="{{route('user.index')}}" class="nav-link text-white-50 {{ Route::is('user.index') ? 'active' : '' }}">View Users</a></li>
                    <li><a href="{{route('user.create')}}" class="nav-link text-white-50 {{ Route::is('user.create') ? 'active' : '' }}">Add User</a></li>
                </ul>
            </li>
        @endcan

        <!-- Reports with Submenu -->
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center"
               data-bs-toggle="collapse"
               href="#reportsMenu"
               role="button"
               aria-expanded="false"
               aria-controls="reportsMenu">

                <span>
                    <i class="bi bi-bar-chart"></i> Reports
                </span>

                <i class="bi bi-caret-down-fill small"></i>
            </a>

            <ul class="collapse ps-4" id="reportsMenu">
                <li><a href="#" class="nav-link text-white-50">Sales Report</a></li>
                <li><a href="#" class="nav-link text-white-50">Agent Performance</a></li>
                <li><a href="#" class="nav-link text-white-50">Commission Summary</a></li>
            </ul>
        </li>

    </ul>
    <hr/>

    <ul class="nav nav-pills flex-column mt-3">

        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{route('crm.index')}}" class="nav-link text-white {{ Route::is('crm.index') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>CRM</span>
            </a>
        </li>

        <!-- Properties -->
        @can('view lead')
            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center {{ Route::is('leads.index') || Route::is('leads.create') ? 'active' : '' }}"
                   data-bs-toggle="collapse"
                   href="#leadsMenu"
                   role="button"
                   aria-expanded="false"
                   aria-controls="leadsMenu">

                <span>
                    <i class="bi bi-bar-chart"></i> Leads
                </span>

                    <i class="bi bi-caret-down-fill small"></i>
                </a>

                <ul class="collapse {{ Route::is('leads.index') || Route::is('leads.create') ? 'show' : '' }} ps-4" id="leadsMenu">
                    <li><a href="{{route('leads.index')}}" class="nav-link text-white-50 {{ Route::is('leads.index') ? 'active' : '' }}">View Leads</a></li>
                    <li><a href="{{route('leads.create')}}" class="nav-link text-white-50 {{ Route::is('leads.create') ? 'active' : '' }}">Add Lead</a></li>
                </ul>
            </li>
        @endcan

    </ul>
</div>
