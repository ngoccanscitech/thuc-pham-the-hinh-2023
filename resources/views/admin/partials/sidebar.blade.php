<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="/AdminLTE-3.2.0/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <!-- SidebarSearch Form -->
        <div class="form-inline mt-2">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route('categories.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Danh Mục
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('products.index')}}" class="nav-link">
                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                        <p>
                            Sản Phẩm
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('orders.index')}}" class="nav-link">
                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                        <p>
                            Quản lý đơn đặt hàng
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('delivery.create')}}" class="nav-link">
                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                        <p>
                            Quản lý vận chuyển
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('coupons.index')}}" class="nav-link">
                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                        <p>
                            Quản lý mã giảm giá
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('sliders.index')}}" class="nav-link">
                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                        <p>
                            Slider
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('settings.index')}}" class="nav-link">
                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                        <p>
                            Setting
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link">
                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                        <p>
                            Quản lý nhân viên
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('roles.index')}}" class="nav-link">
                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                        <p>
                            Quản lý Role
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('permissions.create')}}" class="nav-link">
                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                        <p>
                            Tạo data permission
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
