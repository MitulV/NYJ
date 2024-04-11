<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light m-3">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @can('Dashboard')
                <li class="nav-item">
                    <a href="{{ route('admin.home') }}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                        <p>
                            <i class="fas fa-fw fa-tachometer-alt">

                            </i>
                            <span>{{ trans('global.dashboard') }}</span>
                        </p>
                    </a>
                </li>
                @endcan
                @can('Event_Management')
                <li class="nav-item">
                    <a href="{{ route('admin.events.index') }}" class="nav-link {{ request()->is('admin/events') || request()->is('admin/events/*') ? 'active' : '' }}">
                        <p>
                            <i class="fas fa-fw fa-calendar-alt"></i>

                            </i>
                            <span>Events</span>
                        </p>
                    </a>
                </li>
                @endcan
                @can('Category_Management')
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->is('admin/categories') || request()->is('admin/categories/*') ? 'active' : '' }}">
                        <p>
                            <i class="fa-fw fas fa-flag-checkered"></i>

                            </i>
                            <span>Categories</span>
                        </p>
                    </a>
                </li>
                @endcan
                @can('City_Management')
                <li class="nav-item">
                    <a href="{{ route('admin.cities.index') }}" class="nav-link {{ request()->is('admin/cities') || request()->is('admin/cities/*') ? 'active' : '' }}">
                        <p>
                            <i class="fa-fw fas fa-location-arrow"></i>

                            </i>
                            <span>Cities</span>
                        </p>
                    </a>
                </li>
                @endcan
                @can('My_Bookings')
                <li class="nav-item">
                    <a href="{{ route('admin.mybookings.index') }}" class="nav-link {{ request()->is('admin/my-bookings') || request()->is('admin/my-bookings/*') ? 'active' : '' }}">
                        <p>
                            <i class="fas fa-fw fa-cart-plus"></i>
                            <span>My Bookings</span>
                        </p>
                    </a>
                </li>
                @endcan

                @can('Bookings')
                <li class="nav-item">
                    <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->is('user/my-bookings') || request()->is('user/my-bookings/*') ? 'active' : '' }}">
                        <p>
                            <i class="fas fa-fw fa-cart-plus"></i>
                            <span>Bookings</span>
                        </p>
                    </a>
                </li>
                @endcan
                
                
                {{-- @can('User_Management')
                    <li
                        class="nav-item has-treeview {{ request()->is('admin/permissions*') ? 'menu-open' : '' }} {{ request()->is('admin/roles*') ? 'menu-open' : '' }} {{ request()->is('admin/users*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw fas fa-users">

                            </i>
                            <p>
                                <span>{{ trans('cruds.userManagement.title') }}</span>
                                <i class="right fa fa-fw fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            
                                <li class="nav-item">
                                    <a href="{{ route('admin.permissions.index') }}"
                                        class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.permission.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            
                            
                                <li class="nav-item">
                                    <a href="{{ route('admin.roles.index') }}"
                                        class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-briefcase">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.role.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.index') }}"
                                        class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-user">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.user.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            
                        </ul>
                    </li>
                @endcan --}}

                @can('User_Management')
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}"
                        class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-user">

                        </i>
                        <p>
                            <span>{{ trans('cruds.user.title') }}</span>
                        </p>
                    </a>
                </li>
                @endcan
                
                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt">

                            </i>
                            <span>{{ trans('global.logout') }}</span>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
