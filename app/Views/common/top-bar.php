<?php
$theme_url = base_url() . '<?=base_url()?>assets/minton/<?=base_url()?>assets/';
$router = \CodeIgniter\Config\Services::router();
$current_route = $router->getMatchedRouteOptions();
$current_route = isset($current_route['as']) ? $current_route['as'] : 'dashboard';


?>

    <!-- Topbar Start -->
    <div class="navbar-custom">
        <div class="container-fluid">

            <ul class="list-unstyled topnav-menu float-end mb-0">


                <li class="d-none d-md-inline-block">
                    <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" id="light-dark-mode"
                       href="#">
                        <i class="fe-moon noti-icon"></i>
                    </a>
                </li>


                <li class="dropdown d-none d-lg-inline-block">
                    <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen"
                       href="#">
                        <i class="fe-maximize noti-icon"></i>
                    </a>
                </li>





                <li class="dropdown notification-list topbar-dropdown">
                    <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown"
                       href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="<?= base_url() ?>assets/images/users/avatar-1.jpg" alt="user-image"
                             class="rounded-circle">
                        <span class="pro-user-name ms-1">
                                    <?=session()->get('loggedIn')['name']?> <i class="mdi mdi-chevron-down"></i>
                                </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                        <!-- item-->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>

                        <!-- item-->


                        <div class="dropdown-divider"></div>

                        <!-- item-->
                        <a href="<?=route_to('logout')?>" class="dropdown-item notify-item">
                            <i class="ri-logout-box-line"></i>
                            <span>Logout</span>
                        </a>

                    </div>
                </li>



            </ul>

            <!-- LOGO -->
            <div class="logo-box">
                <a href="<?= route_to('home') ?>" class="logo logo-dark text-center">
                            <span class="logo-sm">
                                <img src="<?= base_url() ?>assets/images/logos/logo-main.png" alt="" height="24">
                                <!-- <span class="logo-lg-text-light">Minton</span> -->
                            </span>
                    <span class="logo-lg">
                                <img src="<?= base_url() ?>assets/images/logos/logo-main.png" alt="" height="35">
                        <!-- <span class="logo-lg-text-light">M</span> -->
                            </span>
                </a>

                <a href="<?= route_to('home') ?>" class="logo logo-light text-center">
                            <span class="logo-sm">
                                <img src="<?= base_url() ?>assets/images/logos/logo-main.png" alt="" height="24">
                            </span>
                    <span class="logo-lg">
                                <img src="<?= base_url() ?>assets/images/logos/logo-main.png" alt="" height="35">
                            </span>
                </a>
            </div>

            <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                <li>
                    <button class="button-menu-mobile waves-effect waves-light">
                        <i class="fe-menu"></i>
                    </button>
                </li>

                <li>
                    <!-- Mobile menu toggle (Horizontal Layout)-->
                    <a class="navbar-toggle nav-link" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </li>




            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- Topbar End -->


<?= $this->section('scripts') ?>
    <script>

    </script>
<?= $this->endSection() ?>

<style>
.navbar-custom {
    background: #fff;
    border-bottom: 4px solid #388e3c; /* Green accent */
    box-shadow: 0 2px 8px rgba(56, 142, 60, 0.08);
    padding: 0 32px;
}
.topnav-menu .nav-link, .topnav-menu .nav-user {
    color: #388e3c !important;
    font-weight: 500;
    transition: color 0.2s;
}
.topnav-menu .nav-link:hover, .topnav-menu .nav-user:hover {
    color: #256029 !important;
}
.logo-box {
    border-right: 2px solid #388e3c;
    padding-right: 24px;
    margin-right: 24px;
}
</style>