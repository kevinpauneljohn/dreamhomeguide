<!-- SIDEBAR -->
<div id="sidebar" class="sidebar bg-dark text-white position-fixed">
    <h5 class="pb-3 border-bottom text-center">
        <span class="sidebar-title">DHG</span>
    </h5>

    {{-- ================= MAIN ================= --}}
    <ul class="nav nav-pills flex-column">

        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{ route('dashboard') }}"
               class="nav-link text-white {{ Route::is('dashboard') ? 'active' : '' }}">
                <span>
                    <i class="bi bi-speedometer2"></i> Dashboard
                </span>
            </a>
        </li>

    </ul>

    @if(auth()->user()->can('view lead') || auth()->user()->can('add lead')
        || auth()->user()->can('view appointment') || auth()->user()->can('view task') || auth()->user()->can('view sales')
        || auth()->user()->can('add sales'))
        <hr/>
    @endif

    {{-- ================= CRM ================= --}}
    <ul class="nav nav-pills flex-column">

        @can('view lead')
            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center
                   {{ (Route::is('crm.index') || Route::is('leads.*')) ? 'active' : '' }}"
                   data-bs-toggle="collapse"
                   href="#leadsMenu">
                    <span>
                        <i class="bi bi-person-lines-fill"></i> Leads
                    </span>
                    <i class="bi bi-caret-down-fill small"></i>
                </a>

                <ul class="collapse {{ (Route::is('crm.index') || Route::is('leads.*')) ? 'show' : '' }}"
                    id="leadsMenu">
                    <li>
                        <a href="{{ route('crm.index') }}"
                           class="nav-link text-white-50 {{ Route::is('crm.index') ? 'active' : '' }}">
                            Lead Board
                        </a>
                    </li>
{{--                    <li>--}}
{{--                        <a href="{{ route('leads.index') }}"--}}
{{--                           class="nav-link text-white-50 {{ (Route::is('leads.index') || Route::is('leads.show') || Route::is('leads.edit')) ? 'active' : '' }}">--}}
{{--                            View All Leads--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    @can('add lead')
                        <li>
                            <a href="{{ route('leads.create') }}"
                               class="nav-link text-white-50 {{ Route::is('leads.create') ? 'active' : '' }}">
                                Add New Lead
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        @can('view appointment')
            <li class="nav-item">
                <a href="{{ route('appointment.index') }}"
                   class="nav-link text-white {{ request()->routeIs('appointment.*') ? 'active' : '' }}">
                    <span>
                        <i class="fa-solid fa-calendar-days"></i> Appointments
                    </span>
                </a>
            </li>
        @endcan

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

        @can('view sales')
            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center
                   {{ request()->routeIs('sales.*') ? 'active' : '' }}"
                   data-bs-toggle="collapse"
                   href="#salesMenu">
                    <span>
                        <i class="fa-solid fa-chart-line"></i> Sales
                    </span>
                    <i class="bi bi-caret-down-fill small"></i>
                </a>

                <ul class="collapse {{ request()->routeIs('sales.*') ? 'show' : '' }}"
                    id="salesMenu">
                    <li>
                        <a href="{{ route('sales.index') }}"
                           class="nav-link text-white-50 {{ Route::is('sales.index') ? 'active' : '' }}">
                            Sales Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sales.pipeline') }}"
                           class="nav-link text-white-50 {{ Route::is('sales.pipeline') ? 'active' : '' }}">
                            Pipeline
                        </a>
                    </li>
                    @can('add sales')
                        <li>
                            <a href="{{ route('sales.create') }}"
                               class="nav-link text-white-50 {{ Route::is('sales.create') ? 'active' : '' }}">
                                Add New Sale
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

    </ul>

    @if(auth()->user()->can('view project') || auth()->user()->can('view listing') || auth()->user()->can('add listing'))
        <hr/>
    @endif

    {{-- ================= INVENTORY ================= --}}
    <ul class="nav nav-pills flex-column">

        @can('view project')
            <li class="nav-item">
                <a href="{{ route('project.index') }}"
                   class="nav-link text-white {{ Route::is('project.*') ? 'active' : '' }}">
                    <span>
                        <i class="fa-solid fa-building-columns"></i> Projects
                    </span>
                </a>
            </li>
        @endcan

        @can('view listing')
            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center
                   {{ Route::is('property.*') ? 'active' : '' }}"
                   data-bs-toggle="collapse"
                   href="#propertiesMenu">

                    <span>
                        <i class="bi bi-buildings"></i> Properties
                    </span>

                    <i class="bi bi-caret-down-fill small"></i>
                </a>

                <ul class="collapse {{ Route::is('property.*') ? 'show' : '' }}"
                    id="propertiesMenu">
                    <li>
                        <a href="{{ route('property.index') }}"
                           class="nav-link text-white-50 {{ Route::is('property.index') ? 'active' : '' }}">
                            View Properties
                        </a>
                    </li>
                    @can('add listing')
                        <li>
                            <a href="{{ route('property.create') }}"
                               class="nav-link text-white-50 {{ Route::is('property.create') ? 'active' : '' }}">
                                Add Property
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

    </ul>

    @if(auth()->user()->can('view computation'))
        <hr/>
    @endif


    {{-- ================= TOOLS & REPORTS ================= --}}
    <ul class="nav nav-pills flex-column">

        @can('view computation')
            <li class="nav-item">
                <a href="{{ route('computations.index') }}"
                   class="nav-link text-white {{ Route::is('computations.*') ? 'active' : '' }}">
                    <span>
                        <i class="fa-solid fa-calculator"></i> Computations
                    </span>
                </a>
            </li>
        @endcan

        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center"
               data-bs-toggle="collapse"
               href="#reportsMenu">
                <span>
                    <i class="bi bi-bar-chart"></i> Reports
                </span>
                <i class="bi bi-caret-down-fill small"></i>
            </a>

            <ul class="collapse" id="reportsMenu">
                <li><a href="#" class="nav-link text-white-50">Sales Report</a></li>
                <li><a href="#" class="nav-link text-white-50">Agent Performance</a></li>
                <li><a href="#" class="nav-link text-white-50">Commission Summary</a></li>
            </ul>
        </li>

    </ul>

    @if(auth()->user()->can('view user') || auth()->user()->can('add user') || auth()->user()->can('view role') || auth()->user()->can('view permission'))
        <hr/>
    @endif

    {{-- ================= ADMIN ================= --}}
    <ul class="nav nav-pills flex-column">

        @can('view user')
            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center
                   {{ Route::is('user.*') ? 'active' : '' }}"
                   data-bs-toggle="collapse"
                   href="#usersMenu">
                    <span>
                        <i class="bi bi-people"></i> Users
                    </span>
                    <i class="bi bi-caret-down-fill small"></i>
                </a>

                <ul class="collapse {{ Route::is('user.*') ? 'show' : '' }}"
                    id="usersMenu">
                    <li>
                        <a href="{{ route('user.index') }}"
                           class="nav-link text-white-50 {{ Route::is('user.index') ? 'active' : '' }}">
                            View Users
                        </a>
                    </li>
                    @can('add user')
                        <li>
                            <a href="{{ route('user.create') }}"
                               class="nav-link text-white-50 {{ Route::is('user.create') ? 'active' : '' }}">
                                Add User
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        @can('view role')
            <li class="nav-item">
                <a href="{{ route('roles.index') }}"
                   class="nav-link text-white {{ Route::is('roles.*') ? 'active' : '' }}">
                    <span>
                        <i class="fa-solid fa-user-tag"></i> Roles
                    </span>
                </a>
            </li>
        @endcan

        @can('view permission')
            <li class="nav-item">
                <a href="{{ route('permissions.index') }}"
                   class="nav-link text-white {{ Route::is('permissions.*') ? 'active' : '' }}">
                    <span>
                        <i class="fa-solid fa-key"></i> Permissions
                    </span>
                </a>
            </li>
        @endcan

    </ul>

    @if(auth()->user()->can('view blog'))
        <hr/>
    @endif

    {{-- ================= CONTENT ================= --}}
    <ul class="nav nav-pills flex-column">

        @can('view blog')
            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center
                   {{ Route::is('blog.*') ? 'active' : '' }}"
                   data-bs-toggle="collapse"
                   href="#blogsMenu">
                    <span>
                        <i class="bi bi-journal-text"></i> Blogs
                    </span>
                    <i class="bi bi-caret-down-fill small"></i>
                </a>

                <ul class="collapse {{ Route::is('blog.*') ? 'show' : '' }} ps-4"
                    id="blogsMenu">
                    <li>
                        <a href="{{ route('blog.index') }}"
                           class="nav-link text-white-50 {{ Route::is('blog.index') ? 'active' : '' }}">
                            View Blogs
                        </a>
                    </li>
                    @can('add blog')
                        <li>
                            <a href="{{ route('blog.create') }}"
                               class="nav-link text-white-50 {{ Route::is('blog.create') ? 'active' : '' }}">
                                Add Blog
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

    </ul>
</div>
