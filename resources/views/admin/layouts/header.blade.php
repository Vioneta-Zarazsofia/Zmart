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
                                <p>
                                    Dashboard {{ Request::segment(2) }}
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('admin/admin/list') }}"
                                class="nav-link @if (Request::segment(2) == 'admin') active @endif">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Admin
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/customer/list') }}"
                                class="nav-link @if (Request::segment(2) == 'customer') active @endif">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Customer
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/courier/list') }}"
                                class="nav-link @if (Request::segment(2) == 'courier') active @endif">
                                <i class="nav-icon fas fa-truck"></i>
                                <p> Kurir </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/supplier/list') }}"
                                class="nav-link @if (Request::segment(2) == 'supplier') active @endif">
                                <i class="nav-icon fas fa-people-carry"></i>
                                <p> Suplier </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('admin/category/list') }}"
                                class="nav-link @if (Request::segment(2) == 'category') active @endif">
                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>
                                    Category
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('admin/sub_category/list') }}"
                                class="nav-link @if (Request::segment(2) == 'sub_category') active @endif">
                                <i class="nav-icon fas fa-th-list"></i>
                                <p>
                                    Sub Category
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/brand/list') }}"
                                class="nav-link @if (Request::segment(2) == 'brand') active @endif">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>
                                    Brand
                                </p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ url('admin/color/list') }}"
                                class="nav-link @if (Request::segment(2) == 'size') active @endif">
                                <i class="nav-icon fas fa-palette"></i>        <p>
                                    Color
                                </p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{ url('admin/purchase') }}"
                                class="nav-link {{ Request::is('admin/purchase*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-truck-loading"></i>
                                <p>Pembelian Produk</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('admin/product/list') }}"
                                class="nav-link @if (Request::segment(2) == 'product') active @endif">
                                <i class="nav-icon fab fa-product-hunt"></i>
                                <p>
                                    Produk
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/orders/waiting') }}"
                                class="nav-link @if (Request::segment(2) == 'orders' && Request::segment(3) == 'waiting') active @endif">
                                <i class="nav-icon fas fa-money-check-alt"></i>
                                <p>
                                    Pesanan
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('admin/discountcode/list') }}"
                                class="nav-link @if (Request::segment(2) == 'discountcode') active @endif">
                                <i class="nav-icon fas fa-percent"></i>
                                <p>
                                    Kode Diskon
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('admin/shipping_charge/list') }}"
                                class="nav-link @if (Request::segment(2) == 'shipping_charge') active @endif">
                                <i class="nav-icon fas fa-shipping-fast"></i>
                                <p>
                                    Biaya Pengiriman
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/contactus') }}"
                                class="nav-link @if (Request::segment(2) == 'contactus') active @endif">
                                <i class="nav-icon fas fa-phone"></i>
                                <p>
                                    Contact Us
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('admin/system-setting') }}"
                                class="nav-link @if (Request::segment(2) == 'system-setting') active @endif">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>Pengaturan Sistem</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.faq.index') }}"
                                class="nav-link @if (Request::segment(2) == 'faq') active @endif">
                                <i class="nav-icon fas fa-question-circle"></i>
                                <p>FAQ</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('admin/logout') }}" class="nav-link">

                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
