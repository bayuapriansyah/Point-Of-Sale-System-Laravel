<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link text-center">
        <span class="brand-text font-weight-light">POS APP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block text-center">{{ Auth()->user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @foreach ($routes as $route)
                    @if (!$route['is_dropdown'])
                        <li class="nav-item">
                            <a href="{{ route($route['route_name']) }}"
                                class="nav-link {{ request()->routeIs($route['route_active']) ? 'active' : '' }}">
                                <i class="nav-icon {{ $route['icon'] ?? 'fas fa-circle' }}"></i>
                                <p>
                                    {{ $route['label'] }}
                                </p>
                            </a>
                        </li>
                    @else
                        <li class=" nav-item {{ request()->routeIs(($route['route_active'])) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon {{ $route['icon'] ?? 'fas fa-circle' }}"></i>
                                <p>
                                    {{ $route['label'] }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            @foreach ($route['dropdown'] as $item)
                                <ul class="nav nav-treeview mr-3">
                                    <li class="nav-item">
                                        <a href="{{ route($item['route_name']) }}"
                                            class="nav-link {{ request()->routeIs($item['route_active']) ? 'active' : '' }}">
                                            <i class="far fa-circle"></i>
                                            <p>{{ $item['label'] }}</p>
                                        </a>
                                    </li>
                                </ul>
                            @endforeach

                        </li>
                    @endif



                @endforeach

                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

            </ul>
            </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>