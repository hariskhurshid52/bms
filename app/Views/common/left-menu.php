<?php
$theme_url = base_url() . '<?=base_url()?><?=base_url()?>assets/minton/<?=base_url()?><?=base_url()?>assets/';
$router = \CodeIgniter\Config\Services::router();
$current_route = $router->getMatchedRouteOptions();
$current_route = isset($current_route['as']) ? $current_route['as'] : 'dashboard';

?>

<style>
.left-side-menu {
    background: #388e3c !important;
    color: #fff !important;
    /* border-radius: 0 24px 24px 0; */
    box-shadow: 2px 0 12px rgba(56, 142, 60, 0.08);
}
#side-menu .menu-title {
    color: #c8e6c9 !important;
    font-weight: 700;
    letter-spacing: 1px;
}
#side-menu > li > a {
    color: #fff !important;
    border-radius: 12px;
    margin: 4px 0;
    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
    font-weight: 500;
    box-shadow: none;
}
#side-menu > li > a.active, #side-menu > li > a:hover {
    background: linear-gradient(90deg, #4caf50 80%, #388e3c 100%) !important;
    color: #fff !important;
    font-weight: 700;
    box-shadow: 0 2px 8px rgba(56, 142, 60, 0.10);
    border-radius: 12px;
}
#side-menu .nav-second-level li a {
    color: #e0f2f1 !important;
    border-radius: 8px;
    margin: 2px 0;
    transition: background 0.2s, color 0.2s;
}
#side-menu .nav-second-level li a.active, #side-menu .nav-second-level li a:hover {
    background: #388e3c !important;
    color: #fff !important;
    font-weight: 600;
    border-radius: 8px;
}
#side-menu i {
    color: #c8e6c9 !important;
}
.logo-box {
    background: transparent !important;
    border-bottom: 2px solid #4caf50;
    margin-bottom: 16px;
    padding-bottom: 8px;
}
</style>

<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <!-- LOGO -->
    <div class="logo-box">
        <a href="<?= session()->get('loggedIn')['roleId'] == 3 ? route_to('marketing-dashboard') : route_to('dashboard') ?>" class="logo logo-dark text-center">
            <span class="logo-sm">
                <img src="<?= base_url() ?>assets/images/logos/logo-main.png" alt="" height="24" style="filter: brightness(0) invert(1);">
            </span>
            <span class="logo-lg">
                <img src="<?= base_url() ?>assets/images/logos/logo-main.png" alt="" height="35" style="filter: brightness(0) invert(1);">
            </span>
        </a>

        <a href="<?= session()->get('loggedIn')['roleId'] == 3 ? route_to('marketing-dashboard') : route_to('dashboard') ?>" class="logo logo-light text-center">
            <span class="logo-sm">
                <img src="<?= base_url() ?>assets/images/logos/logo-main.png" alt="" height="24" style="filter: brightness(0) invert(1);">
            </span>
            <span class="logo-lg">
                <img src="<?= base_url() ?>assets/images/logos/logo-main.png" alt="" height="35" style="filter: brightness(0) invert(1);">
            </span>
        </a>
    </div>

    <div class="h-100" data-simplebar>
        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="menu-title">Navigation</li>

                <li>
                    <a href="<?= session()->get('loggedIn')['roleId'] == 3 ? route_to('marketing-dashboard') : route_to('dashboard') ?>" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span> Dashboards </span>
                    </a>

                </li>

                <?php if (session()->get('loggedIn')['roleId'] == 1): ?>


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
                                    <a href="<?= route_to('admin.customer.create') ?>">Add New</a>
                                </li>
                                <li>
                                    <a href="<?= route_to('admin.customers.list') ?>">List All</a>
                                </li>

                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
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
                                <a href="<?= route_to('admin.billboard.create') ?>">Add New</a>
                            </li>
                            <li>
                                <a href="<?= route_to('admin.billboard.list') ?>">List All</a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="menu-title mt-2">Manage Bookings & Expenses</li>
                <li>
                    <a href="#mngOrders" data-bs-toggle="collapse" aria-expanded="false"
                       aria-controls="mngOrders">
                        <i class="ri-signal-tower-fill"></i>
                        <span> Bookings </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="mngOrders">
                        <ul class="nav-second-level">
                            <li>
                                <a href="<?= route_to('admin.order.create') ?>">Add Booking</a>
                            </li>
                            <li>
                                <a href="<?= route_to('admin.orders.list') ?>">List All</a>
                            </li>

                        </ul>
                    </div>
                </li>
                <?php if (session()->get('loggedIn')['roleId'] == 1): ?>
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
                                    <a href="<?= route_to('admin.expense.create') ?>">Add Expense</a>
                                </li>
                                <li>
                                    <a href="<?= route_to('admin.expense.list') ?>">List All</a>
                                </li>

                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
                <?php if (session()->get('loggedIn')['roleId'] == 1): ?>
                    <li class="menu-title mt-2">Reports</li>
                    <li>
                        <a href="<?= route_to('admin.report.hoardingWiseRevenue') ?>">
                            <i class="ri-bar-chart-2-line"></i>
                            <span> Hoarding Wise Revenue Report </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= route_to('admin.report.hoardingWiseExpense') ?>">
                            <i class="ri-money-dollar-circle-line"></i>
                            <span> Hoarding Wise Expense Report </span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->