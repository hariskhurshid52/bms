<?php
$theme_url = base_url() . 'assets/';
$router = \CodeIgniter\Config\Services::router();
$current_route = $router->getMatchedRouteOptions();
$current_route = isset($current_route['as']) ? $current_route['as'] : 'dashboard';

?>
<!DOCTYPE html>
<html lang="en" data-layout-mode="" data-topbar-color="light" data-bs-theme="light" data-layout-position="fixed">
<head>
    <?= csrf_meta() ?>
    <meta charset="utf-8"/>
    <title>Hording</title>
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

   
    <!-- end topnav-->
    <!-- ========== Left Sidebar Start ========== -->
    <?= $this->include('common/left-menu') ?>
    <!-- Left Sidebar End -->
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
                            <?= date('Y') ?> &copy; Sonic by <a href="">Hordings</a>
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
<script src="<?= $theme_url ?>libs/sweetalert2/sweetalert2.min.js"></script>
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

        $('a[data-notification]').on('click', function (e) {
            e.preventDefault();

            $.toast().reset("all");
            $.toast({
                heading: 'Info',
                text: $(this).attr('data-notification'),
                position: 'top-right',
                loaderBg: '#1ea69a',
                icon: 'info',
                hideAfter: 3000,
                stack: 1,
                showHideTransition: 'fade'
            });

            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                let count = 0;
                try {
                    count = parseInt($("[notification-count]").html()) - 1
                } catch (e) {

                }
                $("[notification-count]").html(count)
                return
                const notificationId = $(this).attr('data-notification');
                ajaxCall('<?=route_to('notification.markAsRead')?>', {
                    notificationId: notificationId
                }).then((response) => {
                    if (response.status === "success") {
                        window.location.href = $(this).attr('href');
                    }
                });
            }

        });
    });


</script>
<?= $this->renderSection('scripts') ?>
</body>

</html>