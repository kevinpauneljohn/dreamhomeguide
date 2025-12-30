<!-- SIDEBAR -->
<div id="sidebar" class="sidebar bg-dark text-white position-fixed p-3">
    <h5 class="pb-3 border-bottom text-center">
        <a href="{{route('home')}}" class="text-white text-decoration-none"><span class="sidebar-title">DHG</span></a>
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

        <!-- Blogs -->
        @can('view blog')
            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center {{ Route::is('blog.index') || Route::is('blog.create') ? 'active' : '' }}"
                   data-bs-toggle="collapse"
                   href="#blogsMenu"
                   role="button"
                   aria-expanded="false"
                   aria-controls="blogsMenu">

                <span>
                    <i class="bi bi-journal-text"></i> Blogs
                </span>

                    <i class="bi bi-caret-down-fill small"></i>
                </a>

                <ul class="collapse {{ Route::is('blog.index') || Route::is('blog.create') ? 'show' : '' }} ps-4" id="blogsMenu">
                    <li><a href="{{route('blog.index')}}" class="nav-link text-white-50 {{ Route::is('blog.index') ? 'active' : '' }}">View Blogs</a></li>
                    <li><a href="{{route('blog.create')}}" class="nav-link text-white-50 {{ Route::is('blog.create') ? 'active' : '' }}">Add Blog</a></li>
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

        @can('view lead')
            <li class="nav-item">
                <a href="{{route('crm.index')}}" class="nav-link text-white {{ Route::is('crm.index') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>CRM</span>
                </a>
            </li>
        @endcan

        @can('view lead')
                <li class="nav-item">
                    <a href="{{route('leads.create')}}" class="nav-link text-white {{ Route::is('leads.create') ? 'active' : '' }}">
                        <i class="bi bi-person-add"></i>
                        <span>Add New Lead</span>
                    </a>
                </li>
        @endcan

            <!-- Roles -->
            @can('view role')

                <li class="nav-item">
                    <a href="{{route('roles.index')}}" class="nav-link text-white {{ Route::is('roles.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-tag"></i>
                        <span>Roles</span>
                    </a>
                </li>
            @endcan

            <!-- Permissions -->
            @can('view permission')

                <li class="nav-item">
                    <a href="{{route('permissions.index')}}" class="nav-link text-white {{ Route::is('permissions.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-key"></i>
                        <span>Permissions</span>
                    </a>
                </li>
            @endcan

    </ul>
</div>
