        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <div class="brand-link"style="text-align: center;">

                <span class="brand-text font-weight-light">Zaitun Mart</span>
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2">
                    </div>
                    <div class="info">
                        @if (Auth::guard('admin')->check())
                            <a class="d-block">{{ Auth::guard('admin')->user()->name }}</a>
                        @endif
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">
                            <a href="{{ url('admin/dashboard') }}"
                                class="nav-link @if (Request::segment(2) == 'dashboard') active @endif">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- Group: Manajemen Pengguna -->
                        <li
                            class="nav-item has-treeview {{ Request::is('admin/admin*') || Request::is('admin/customer*') || Request::is('admin/courier*') || Request::is('admin/supplier*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>
                                    Manajemen Pengguna
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview pl-3">
                                <li class="nav-item">
                                    <a href="{{ url('admin/admin/list') }}"
                                        class="nav-link @if (Request::segment(2) == 'admin') active @endif">
                                        <i class="fas fa-user nav-icon"></i>
                                        <p>Admin</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/customer/list') }}"
                                        class="nav-link @if (Request::segment(2) == 'customer') active @endif">
                                        <i class="fas fa-users nav-icon"></i>
                                        <p>Customer</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/courier/list') }}"
                                        class="nav-link @if (Request::segment(2) == 'courier') active @endif">
                                        <i class="fas fa-truck nav-icon"></i>
                                        <p>Kurir</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/supplier/list') }}"
                                        class="nav-link @if (Request::segment(2) == 'supplier') active @endif">
                                        <i class="fas fa-people-carry nav-icon"></i>
                                        <p>Supplier</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Group: Manajemen Produk -->
                        <li
                            class="nav-item has-treeview {{ Request::is('admin/category*') || Request::is('admin/sub_category*') || Request::is('admin/brand*') || Request::is('admin/product*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-boxes"></i>
                                <p>
                                    Manajemen Produk
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview pl-3">
                                <li class="nav-item">
                                    <a href="{{ url('admin/category/list') }}"
                                        class="nav-link @if (Request::segment(2) == 'category') active @endif">
                                        <i class="fas fa-list-alt nav-icon"></i>
                                        <p>Category</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/sub_category/list') }}"
                                        class="nav-link @if (Request::segment(2) == 'sub_category') active @endif">
                                        <i class="fas fa-th-list nav-icon"></i>
                                        <p>Sub Category</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/brand/list') }}"
                                        class="nav-link @if (Request::segment(2) == 'brand') active @endif">
                                        <i class="fas fa-tags nav-icon"></i>
                                        <p>Brand</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/product/list') }}"
                                        class="nav-link @if (Request::segment(2) == 'product') active @endif">
                                        <i class="fab fa-product-hunt nav-icon"></i>
                                        <p>Produk</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Group: Transaksi -->
                        <li
                            class="nav-item has-treeview {{ Request::is('admin/purchase*') || Request::is('admin/orders*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>
                                    Transaksi
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview pl-3">
                                <li class="nav-item">
                                    <a href="{{ url('admin/purchase') }}"
                                        class="nav-link {{ Request::is('admin/purchase*') ? 'active' : '' }}">
                                        <i class="fas fa-truck-loading nav-icon"></i>
                                        <p>Pembelian Produk</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/orders/waiting') }}"
                                        class="nav-link @if (Request::segment(2) == 'orders') active @endif">
                                        <i class="fas fa-money-check-alt nav-icon"></i>
                                        <p>Pesanan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Group: Pengaturan -->
                        <li
                            class="nav-item has-treeview {{ Request::is('admin/discountcode*') || Request::is('admin/shipping_charge*') || Request::is('admin/system-setting*') || Request::is('admin/contactus') || Request::is('admin/faq*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Pengaturan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview pl-3">
                                <li class="nav-item">
                                    <a href="{{ url('admin/discountcode/list') }}"
                                        class="nav-link @if (Request::segment(2) == 'discountcode') active @endif">
                                        <i class="fas fa-percent nav-icon"></i>
                                        <p>Kode Diskon</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/shipping_charge/list') }}"
                                        class="nav-link @if (Request::segment(2) == 'shipping_charge') active @endif">
                                        <i class="fas fa-shipping-fast nav-icon"></i>
                                        <p>Biaya Pengiriman</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/contactus') }}"
                                        class="nav-link @if (Request::segment(2) == 'contactus') active @endif">
                                        <i class="fas fa-phone nav-icon"></i>
                                        <p>Contact Us</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.faq.index') }}"
                                        class="nav-link @if (Request::segment(2) == 'faq') active @endif">
                                        <i class="fas fa-question-circle nav-icon"></i>
                                        <p>FAQ</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/system-setting') }}"
                                        class="nav-link @if (Request::segment(2) == 'system-setting') active @endif">
                                        <i class="fas fa-cogs nav-icon"></i>
                                        <p>Pengaturan Sistem</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('admin/logout') }}" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->

            </div>
            <!-- /.sidebar -->
        </aside>
