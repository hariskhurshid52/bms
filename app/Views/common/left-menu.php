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
                <img src="<?= base_url() ?>assets/images/logos/logo-sm-dark.png" alt="" height="24">
                <!-- <span class="logo-lg-text-light">Minton</span> -->
            </span>
            <span class="logo-lg">
                <img src="<?= base_url() ?>assets/images/logos/logo-dark.png" alt="" height="70">
                <!-- <span class="logo-lg-text-light">M</span> -->
            </span>
        </a>

        <a href="index-2.html" class="logo logo-light text-center">
            <span class="logo-sm">
                <img src="<?= base_url() ?>assets/images/logos/logo-sm.png" alt="" height="24">
            </span>
            <span class="logo-lg">
                <img src="<?= base_url() ?>assets/images/logos/logo-light.png" alt="" height="70">
            </span>
        </a>
    </div>

    <div class="h-100" data-simplebar>
        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="menu-title">Navigation</li>

                <li>
                    <a href="<?=route_to('dashboard')?>" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span> Dashboards </span>
                    </a>

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
                        <span> Clients </span>
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
                <li class="menu-title mt-2">Ads & Boards</li>
                <li>
                    <a href="#sidebarBillboards" data-bs-toggle="collapse" aria-expanded="false"
                        aria-controls="sidebarBillboards">
                        <i class="ri-signal-tower-fill"></i>
                        <span> Boards </span>
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
                <li class="menu-title mt-2">Manage Bookings & Expenses</li>
                <li>
                    <a href="#mngOrders" data-bs-toggle="collapse" aria-expanded="false"
                        aria-controls="mngOrders">
                        <i class="ri-signal-tower-fill"></i>
                        <span> Orders </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="mngOrders">
                        <ul class="nav-second-level">
                            <li>
                                <a href="<?=route_to('admin.order.create')?>">Add Booking</a>
                            </li>
                            <li>
                                <a href="<?=route_to('admin.orders.list')?>">List All</a>
                            </li>
                            
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#mngExpenses" data-bs-toggle="collapse" aria-expanded="false"
                       aria-controls="mngExpenses">
                        <i class="ri-signal-tower-fill"></i>
                        <span> Expenses </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="mngExpenses">
                        <ul class="nav-second-level">
                            <li>
                                <a href="<?=route_to('admin.expense.create')?>">Add Expense</a>
                            </li>
                            <li>
                                <a href="<?=route_to('admin.expense.list')?>">List All</a>
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