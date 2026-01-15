<!-- SIDEBAR -->
<div id="sidebar" class="sidebar bg-dark text-white position-fixed p-3">
    <h5 class="pb-3 border-bottom text-center">
        <span class="sidebar-title">DHG</span>
    </h5>

    <ul class="nav nav-pills flex-column mt-3">

        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link text-white {{ Route::is('dashboard') ? 'active' : '' }}">

                <span>
                    <i class="bi bi-speedometer2"></i> Dashboard
                </span>
            </a>
        </li>
        <!-- Projects -->
        @can('view project')

            <li class="nav-item">
                <a href="{{route('project.index')}}" class="nav-link text-white {{ Route::is('project.index') || Route::is('project.show') ? 'active' : '' }}">
                        <span>
                            <i class="fa-solid fa-building-columns"></i> Projects
                        </span>
                </a>
            </li>
        @endcan
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
                    <i class="bi bi-buildings"></i> Properties



                </span>

                    <i class="bi bi-caret-down-fill small"></i>
                </a>

                <ul class="collapse {{ Route::is('property.index') || Route::is('property.create') ? 'show' : '' }} ps-4" id="propertiesMenu">
                    @can('view listing')
                        <li><a href="{{route('property.index')}}" class="nav-link text-white-50 {{ Route::is('property.index') ? 'active' : '' }}">View Properties</a></li>
                    @endcan
                    @can('add listing')
                            <li><a href="{{route('property.create')}}" class="nav-link text-white-50 {{ Route::is('property.create') ? 'active' : '' }}">Add property</a></li>
                    @endcan

                </ul>
            </li>
        @endcan

        <!-- Computations -->
        @can('view computation')

            <li class="nav-item">
                <a href="{{route('computations.index')}}" class="nav-link text-white {{ Route::is('computations.index') ? 'active' : '' }}">
                        <span>
                            <i class="fa-solid fa-calculator"></i> Computations
                        </span>
                </a>
            </li>
        @endcan

        <!-- Roles -->
        @can('view role')

            <li class="nav-item">
                <a href="{{route('roles.index')}}" class="nav-link text-white {{ Route::is('roles.index') ? 'active' : '' }}">
                        <span>
                            <i class="fa-solid fa-user-tag"></i> Roles
                        </span>
                </a>
            </li>
        @endcan

        <!-- Permissions -->
        @can('view permission')

            <li class="nav-item">
                <a href="{{route('permissions.index')}}" class="nav-link text-white {{ Route::is('permissions.index') ? 'active' : '' }}">
                        <span>
                            <i class="fa-solid fa-key"></i> Permissions
                        </span>
                </a>
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
                    @can('view user')
                        <li><a href="{{route('user.index')}}" class="nav-link text-white-50 {{ Route::is('user.index') ? 'active' : '' }}">View Users</a></li>
                    @endcan
                    @can('add user')
                            <li><a href="{{route('user.create')}}" class="nav-link text-white-50 {{ Route::is('user.create') ? 'active' : '' }}">Add User</a></li>
                    @endcan

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
                    @can('view blog')
                        <li><a href="{{route('blog.index')}}" class="nav-link text-white-50 {{ Route::is('blog.index') ? 'active' : '' }}">View Blogs</a></li>
                    @endcan
                    @can('add blog')
                            <li><a href="{{route('blog.create')}}" class="nav-link text-white-50 {{ Route::is('blog.create') ? 'active' : '' }}">Add Blog</a></li>
                    @endcan
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
                    <span>
                        <i class="bi bi-speedometer2"></i> CRM
                    </span>
                </a>
            </li>
        @endcan

        @can('add lead')
                <li class="nav-item">
                    <a href="{{route('leads.create')}}" class="nav-link text-white {{ Route::is('leads.create') ? 'active' : '' }}">
                        <span>
                            <i class="bi bi-person-add"></i> Add New Lead
                        </span>
                    </a>
                </li>
        @endcan

            <!-- Permissions -->
            @can('view appointment')

                <li class="nav-item">
                    <a href="{{route('appointment.index')}}" class="nav-link text-white {{ Route::is('appointment.index') ? 'active' : '' }}">
                        <span>
                            <i class="fa-solid fa-calendar-days"></i> Appointments
                        </span>
                    </a>
                </li>
            @endcan

            <!-- Permissions -->
            @can('view task')

                <li class="nav-item">
                    <a href="{{ route('task.index') }}"
                       class="nav-link text-white {{ request()->routeIs('task.*') ? 'active' : '' }}">
                    <span>
                        <i class="fa-solid fa-bolt"></i> Tasks
                    </span>
                    </a>
                </li>

            @endcan

    </ul>
</div>
