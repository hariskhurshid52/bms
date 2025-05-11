<?php
$theme_url = base_url() . '<?=base_url()?><?=base_url()?>assets/minton/<?=base_url()?><?=base_url()?>assets/';
$router = \CodeIgniter\Config\Services::router();
$current_route = $router->getMatchedRouteOptions();
$current_route = isset($current_route['as']) ? $current_route['as'] : 'dashboard';



?>

<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <!-- LOGO -->
    <div class="logo-box">
        <a href="index-2.html" class="logo logo-dark text-center">
            <span class="logo-sm">
                <img src="<?= base_url() ?>assets/images/logo-sm-dark.png" alt="" height="24">
                <!-- <span class="logo-lg-text-light">Minton</span> -->
            </span>
            <span class="logo-lg">
                <img src="<?= base_url() ?>assets/images/logo-dark.png" alt="" height="20">
                <!-- <span class="logo-lg-text-light">M</span> -->
            </span>
        </a>

        <a href="index-2.html" class="logo logo-light text-center">
            <span class="logo-sm">
                <img src="<?= base_url() ?>assets/images/logo-sm.png" alt="" height="24">
            </span>
            <span class="logo-lg">
                <img src="<?= base_url() ?>assets/images/logo-light.png" alt="" height="20">
            </span>
        </a>
    </div>

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">
            <img src="<?= base_url() ?>assets/images/users/avatar-1.jpg" alt="user-img" title="Mat Helme"
                class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="#" class="text-reset dropdown-toggle h5 mt-2 mb-1 d-block" data-bs-toggle="dropdown">Nik
                    Patel</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings me-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock me-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-reset">Admin Head</p>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="menu-title">Navigation</li>

                <li>
                    <a href="#sidebarDashboards" data-bs-toggle="collapse" aria-expanded="false"
                        aria-controls="sidebarDashboards" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span class="badge bg-success rounded-pill float-end">3</span>
                        <span> Dashboards </span>
                    </a>
                    <div class="collapse" id="sidebarDashboards">
                        <ul class="nav-second-level">
                            <li>
                                <a href="index-2.html">Sales</a>
                            </li>
                            <li>
                                <a href="dashboard-crm.html">CRM</a>
                            </li>
                            <li>
                                <a href="dashboard-analytics.html">Analytics</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarLayouts" data-bs-toggle="collapse" aria-expanded="false"
                        aria-controls="sidebarLayouts">
                        <i class="ri-layout-line"></i>
                        <span> Layouts </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarLayouts">
                        <ul class="nav-second-level">
                            <li>
                                <a href="layouts-horizontal.html" target="_blank">Horizontal</a>
                            </li>
                            <li>
                                <a href="layouts-detached.html" target="_blank">Detached</a>
                            </li>
                            <li>
                                <a href="layouts-two-column.html" target="_blank">Two Column Menu</a>
                            </li>
                            <li>
                                <a href="layouts-preloader.html" target="_blank">Preloader</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-title mt-2">Users & Customers</li>

                <li>
                    <a href="<?= route_to('admin.users.listAll') ?>">
                        <i class="ri-user-2-fill"></i>
                        <span> Users </span>
                    </a>
                </li>
                <li>
                    <a href="#sidebarEmail" data-bs-toggle="collapse" aria-expanded="false"
                        aria-controls="sidebarEmail">
                        <i class="ri-user-3-line"></i>
                        <span> Customers </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarEmail">
                        <ul class="nav-second-level">
                            <li>
                                <a href="<?=route_to('admin.customer.create')?>">Add New</a>
                            </li>
                            <li>
                                <a href="<?=route_to('admin.customers.list')?>">List All</a>
                            </li>
                            
                        </ul>
                    </div>
                </li>
                <li class="menu-title mt-2">Ads & Billboards</li>
                <li>
                    <a href="#sidebarBillboards" data-bs-toggle="collapse" aria-expanded="false"
                        aria-controls="sidebarBillboards">
                        <i class="ri-signal-tower-fill"></i>
                        <span> Billboards </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarBillboards">
                        <ul class="nav-second-level">
                            <li>
                                <a href="<?=route_to('admin.billboard.create')?>">Add New</a>
                            </li>
                            <li>
                                <a href="<?=route_to('admin.billboard.list')?>">List All</a>
                            </li>
                            
                        </ul>
                    </div>
                </li>
                <li class="menu-title mt-2">Manage Orders Orders</li>
                <li>
                    <a href="#sidebarBillboards" data-bs-toggle="collapse" aria-expanded="false"
                        aria-controls="sidebarBillboards">
                        <i class="ri-signal-tower-fill"></i>
                        <span> Orders </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarBillboards">
                        <ul class="nav-second-level">
                            <li>
                                <a href="<?=route_to('admin.order.create')?>">Place new order</a>
                            </li>
                            <li>
                                <a href="<?=route_to('admin.orders.list')?>">List All</a>
                            </li>
                            
                        </ul>
                    </div>
                </li>


            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->