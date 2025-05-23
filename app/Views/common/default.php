<?php

$theme_url = base_url() . 'assets/minton/assets/';
$router = \CodeIgniter\Config\Services::router();
$current_route = $router->getMatchedRouteOptions();
$current_route = isset($current_route['as']) ? $current_route['as'] : 'dashboard';
?>

<!DOCTYPE html>
<html lang="en" data-sidebar-size="condensed" data-layout-mode="" data-topbar-color="light" data-bs-theme="light"
      data-layout-position="fixed">
<head>
    <?= csrf_meta() ?>
    <meta charset="utf-8"/>
    <title>Hoardings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= $theme_url ?>images/favicon.ico">
    <link href="<?= $theme_url ?>libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?= $theme_url ?>libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?= $theme_url ?>libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?= $theme_url ?>libs/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?= $theme_url ?>libs/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= $theme_url ?>libs/multiselect/css/multi-select.css" rel="stylesheet" type="text/css"/>
    <link href="<?= $theme_url ?>libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= $theme_url ?>libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css"/>
    <link href="<?= $theme_url ?>libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?= $theme_url ?>libs/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css">
    <link href="<?= $theme_url ?>/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>

    <!-- App css -->
    <link href="<?= $theme_url ?>css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= $theme_url ?>css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet"/>
    <link href="<?= base_url() ?>assets/css/app.css" rel="stylesheet" type="text/css"/>

    <!-- icons -->
    <link href="<?= $theme_url ?>css/icons.min.css" rel="stylesheet" type="text/css"/>

    <!-- Theme Config Js -->
    <script src="<?= $theme_url ?>js/config.js"></script>

    <script src="<?= $theme_url ?>libs/sweetalert2/sweetalert2.min.js"></script>

    <style>
        .float-right, .pull-right {
            float: right !important;
        }

        #pageloader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #00000063;
            z-index: 9999;
        }

        #pageloader div {
            z-index: 99999;
            width: 40px;
            height: 40px;
            position: absolute;
            left: 50%;
            top: 50%;
            margin: -20px 0 0 -20px;
        }

    </style>
    <?= $this->renderSection('styles') ?>

</head>

<body>
<div id="preloader">
    <div id="status">
        <div class="spinner">Loading...</div>
    </div>
</div>
<div id="pageloader">
    <div>
        <div class="spinner">Loading...</div>
    </div>
</div>
<!-- Begin page -->
<div id="wrapper">

    <?= $this->include('common/top-bar') ?>

    <?php if (false): ?>
        <div class="topnav">
            <div class="container-fluid">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link  arrow-none" href="" id="topnav-dashboard"
                                   role="button"
                                   aria-haspopup="true" aria-expanded="false">
                                    <i class="ri-dashboard-line me-1"></i> Dashboard

                                </a>

                            </li>
                            <?php if (session()->get('loggedIn')['roleId'] == 1): ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="manageUsers"
                                       role="button"
                                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe-users me-1"></i> Users
                                        <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="manageUsers">

                                        <a href="<?= route_to("admin.users.create") ?>" class="dropdown-item"><i
                                                    class="fe-plus align-middle me-1"></i> Create</a>
                                        <a href="<?= route_to("admin.users.listAll") ?>" class="dropdown-item"><i
                                                    class="fe-list align-middle me-1"></i> List All</a>

                                    </div>
                                </li>
                            <?php elseif (session()->get('loggedIn')['roleId'] == 2): ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="manageUsers"
                                       role="button"
                                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe-users me-1"></i> Users
                                        <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="manageUsers">

                                        <a href="<?= route_to("operator.users.create") ?>" class="dropdown-item"><i
                                                    class="fe-plus align-middle me-1"></i> Create</a>
                                        <a href="<?= route_to("operator.users.listAll") ?>" class="dropdown-item"><i
                                                    class="fe-list align-middle me-1"></i> List All</a>

                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="manageTemplates"
                                       role="button"
                                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ri-pencil-ruler-2-line me-1"></i> Alert Templates
                                        <div class="arrow-down"></div>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="manageTemplates">
                                        <a href="<?= route_to("operator.alertTemplate.create") ?>"
                                           class="dropdown-item"><i
                                                    class="fe-plus align-middle me-1"></i> Create</a>
                                        <a href="<?= route_to("operator.alertTemplate.listAll") ?>"
                                           class="dropdown-item"><i
                                                    class="fe-list align-middle me-1"></i> List All</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="presetSchedules"
                                       role="button"
                                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ri-task-line me-1"></i> Manage Schedule
                                        <div class="arrow-down"></div>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="presetSchedules">
                                        <a href="<?= route_to("operator.schedules.cycles.create") ?>"
                                           class="dropdown-item"><i
                                                    class="fe-plus align-middle me-1"></i> Create</a>
                                        <a href="<?= route_to("operator.schedules.cycles.listAll") ?>"
                                           class="dropdown-item"><i
                                                    class="fe-list align-middle me-1"></i> List All</a>
                                    </div>
                                </li>
                            <?php elseif (session()->get('loggedIn')['roleId'] == 3): ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="manageShortCodes"
                                       role="button"
                                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe-users me-1"></i> Short Codes
                                        <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="manageShortCodes">

                                        <a href="<?= route_to("partner.shortCode.reserved") ?>" class="dropdown-item"><i
                                                    class="fe-plus align-middle me-1"></i> Reserve Short Code</a>
                                        <a href="<?= route_to("partner.shortCode.orders.list") ?>"
                                           class="dropdown-item"><i
                                                    class="fe-list align-middle me-1"></i> Orders</a>

                                    </div>
                                </li>

                            <?php endif; ?>


                        </ul> <!-- end navbar-->
                    </div> <!-- end .collapsed-->
                </nav>
            </div> <!-- end container-fluid -->
        </div>
    <?php endif; ?>
    <!-- end topnav-->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">
                <?= $this->renderSection('content') ?>
            </div> <!-- container -->

        </div> <!-- content -->
        <?php if (false): ?>

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <?= date('Y') ?> &copy; Sonic by <a href="https://mcpinsight.com">MCP INSIGHT</a>
                        </div>

                    </div>
                </div>
            </footer>
            <!-- end Footer -->
        <?php endif; ?>
    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->

<!-- Right Sidebar -->
<div class="offcanvas offcanvas-end right-bar" tabindex="-1" id="theme-settings-offcanvas" data-bs-scroll="true"
     data-bs-backdrop="true">
    <div data-simplebar class="h-100">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-bordered " role="tablist">

            <li class="nav-item">
                <a class="nav-link py-2 active" data-bs-toggle="tab" href="#settings-tab" role="tab">
                    <i class="mdi mdi-cog-outline d-block font-22 my-1"></i>
                </a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content pt-0">


            <div class="tab-pane active" id="settings-tab" role="tabpanel">
                <h6 class="fw-medium px-3 m-0 py-2 font-13 text-uppercase bg-light">
                    <span class="d-block py-1">Theme Settings</span>
                </h6>

                <div class="p-3">
                    <div class="alert alert-warning" role="alert">
                        <strong>Customize </strong> the overall color scheme, sidebar menu, etc.
                    </div>

                    <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Color Scheme</h6>
                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="data-bs-theme" value="light"
                               id="light-mode-check" checked>
                        <label class="form-check-label" for="light-mode-check">Light Mode</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="data-bs-theme" value="dark"
                               id="dark-mode-check">
                        <label class="form-check-label" for="dark-mode-check">Dark Mode</label>
                    </div>

                    <!-- Width -->
                    <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Width</h6>
                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="data-layout-width" value="fluid"
                               id="fluid-check" checked>
                        <label class="form-check-label" for="fluid-check">Fluid</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="data-layout-width" value="boxed"
                               id="boxed-check">
                        <label class="form-check-label" for="boxed-check">Boxed</label>
                    </div>


                    <!-- Topbar -->
                    <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Topbar</h6>
                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="data-topbar-color" value="light"
                               id="lighttopbar-check">
                        <label class="form-check-label" for="lighttopbar-check">Light</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="data-topbar-color" value="dark"
                               id="darktopbar-check" checked>
                        <label class="form-check-label" for="darktopbar-check">Dark</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="data-topbar-color" value="brand"
                               id="brandtopbar-check">
                        <label class="form-check-label" for="brandtopbar-check">brand</label>
                    </div>


                    <!-- Menu positions -->
                    <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Menus Positon <small>(Leftsidebar and Topbar)</small>
                    </h6>
                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="data-layout-position" value="fixed"
                               id="fixed-check" checked>
                        <label class="form-check-label" for="fixed-check">Fixed</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="data-layout-position" value="scrollable"
                               id="scrollable-check">
                        <label class="form-check-label" for="scrollable-check">Scrollable</label>
                    </div>


                    <!-- Menu Color-->
                    <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Menu Color</h6>
                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="data-menu-color" value="light"
                               id="light-check" checked>
                        <label class="form-check-label" for="light-check">Light</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="data-menu-color" value="dark"
                               id="dark-check">
                        <label class="form-check-label" for="dark-check">Dark</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="data-menu-color" value="brand"
                               id="brand-check">
                        <label class="form-check-label" for="brand-check">Brand</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="data-menu-color" value="gradient"
                               id="gradient-check">
                        <label class="form-check-label" for="gradient-check">Gradient</label>
                    </div>


                    <!-- size -->
                    <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Left Sidebar Size</h6>
                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="data-sidebar-size" value="default"
                               id="default-size-check" checked>
                        <label class="form-check-label" for="default-size-check">Default</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="data-sidebar-size" value="condensed"
                               id="condensed-check">
                        <label class="form-check-label" for="condensed-check">Condensed <small>(Extra Small
                                size)</small></label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="data-sidebar-size" value="compact"
                               id="compact-check">
                        <label class="form-check-label" for="compact-check">Compact <small>(Small size)</small></label>
                    </div>


                    <!-- User info -->
                    <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Sidebar User Info</h6>
                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="data-sidebar-user" value="true"
                               id="sidebaruser-check">
                        <label class="form-check-label" for="sidebaruser-check">Enable</label>
                    </div>

                    <div class="d-grid mt-4">
                        <button class="btn btn-primary" id="resetBtn">Reset to Default</button>

                        <a href="#"
                           class="btn btn-danger mt-2" target="_blank"><i class="mdi mdi-basket me-1"></i> Purchase Now</a>
                    </div>

                </div>

            </div>
        </div>

    </div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- Vendor js -->
<script src="<?= $theme_url ?>js/vendor.min.js"></script>

<script src="<?= $theme_url ?>libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= $theme_url ?>libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= $theme_url ?>libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= $theme_url ?>libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="<?= $theme_url ?>libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= $theme_url ?>libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="<?= $theme_url ?>libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= $theme_url ?>libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="<?= $theme_url ?>libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= $theme_url ?>libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="<?= $theme_url ?>libs/datatables.net-select/js/dataTables.select.min.js"></script>
<script src="<?= $theme_url ?>libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?= $theme_url ?>libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?= $theme_url ?>libs/moment/min/moment.min.js"></script>
<script src="<?= $theme_url ?>libs/jquery.scrollto/jquery.scrollTo.min.js"></script>
<script src="<?= $theme_url ?>libs/jquery-toast-plugin/jquery.toast.min.js"></script>
<script src="<?= $theme_url ?>libs/select2/js/select2.min.js"></script>
<script src="<?= $theme_url ?>libs/clockpicker/bootstrap-clockpicker.min.js"></script>
<script src="<?= $theme_url ?>libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?= $theme_url ?>libs/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- App js -->
<script src="<?= $theme_url ?>js/app.min.js"></script>
<script src="<?= base_url('assets/js/app.js') ?>"></script>
<script>
    (function ($) {
        showSuccessToast = function (msg) {
            'use strict';
            resetToastPosition();
            $.toast({
                heading: 'Success',
                text: msg,
                showHideTransition: 'slide',
                icon: 'success',
                loaderBg: '#f96868',
                position: 'top-right'
            })
        };
        showDangerToast = function (msg) {
            'use strict';
            resetToastPosition();
            $.toast({
                heading: 'Error',
                text: msg,
                showHideTransition: 'slide',
                icon: 'error',
                loaderBg: '#f2a654',
                position: 'top-right'
            })
        };
        resetToastPosition = function () {
            $('.jq-toast-wrap').removeClass('bottom-left bottom-right top-left top-right mid-center');
            $(".jq-toast-wrap").css({
                "top": "",
                "left": "",
                "bottom": "",
                "right": ""
            }); //to remove previous position style
        }
        ajaxCall = (url, params = {}, loader = false) => {
            const _options = {
                url: url,
                type: 'POST',
                data: {
                    '<?=csrf_token()?>': '<?=csrf_hash()?>',
                    ...params
                },
                headers: {},
                beforeSend: () => {

                },

            };
            return $.ajax(_options)
        }
    })(jQuery);
    <?php if(session()->has('postBack')): $postBack = session()->get('postBack'); ?>
    <?php if($postBack['status'] === "success"): ?>
    showSuccessToast(`<?= $postBack['message'] ?>`);
    <?php else: ?>
    showDangerToast(`<?= $postBack['message'] ?>`);
    <?php endif; ?>
    <?php endif; ?>
    $(document).ready(function () {
        if ($('.input-field-alert').length) {
            $('.input-field-alert').slideUp(5000);
        }
        if ($('.select2').length) {
            $('.select2').select2()
        }
        if ($('.multiselect2').length) {
            $('.multiselect2').multiSelect();
        }
        if ($('.dateRangePicker').length) {
            $('.dateRangePicker').daterangepicker({
                startDate: moment().startOf('month'),
                endDate: moment(),
                autoUpdateInput: true,
                locale: {
                    format: 'YYYY-MM-DD'
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Month To Date': [moment().startOf('month'), moment()],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            });
        }


    });


</script>
<?= $this->renderSection('scripts') ?>
</body>

</html>