<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="Login"/>
    <meta property="og:title" content="Hording"/>


    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= csrf_meta() ?>
    <title>Login | MCP Sonic</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?= base_url('assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet"
          href="<?= base_url('assets/vendors/iconfonts/simple-line-icon/css/simple-line-icons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/css/vendor.bundle.addons.css') ?>">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <!-- endinject -->
    <link rel="shortcut icon" href=" <?= base_url('assets/images/favicon.ico') ?>"/>
    <script src="<?= base_url('assets/vendors/js/vendor.bundle.base.js') ?>"></script>
    <script src="<?= base_url('assets/vendors/js/vendor.bundle.addons.js') ?>"></script>
</head>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper auth p-0 theme-two">
            <div class="row d-flex align-items-stretch">
                <div class="col-md-4 banner-section d-none d-md-flex align-items-stretch justify-content-center">
                    <div class="slide-content bg-1">
                    </div>
                </div>
                <div class="col-12 col-md-8 h-100 bg-white">
                    <div class="auto-form-wrapper d-flex align-items-center justify-content-center flex-column">
                        <div class="nav-get-started">
                            <img style="height:55px;" src="<?= base_url('assets/images/mcpverify-logo.png') ?>"
                                 alt="MCP Sonic Logo">
                        </div>
                        <form action="<?= base_url('verify') ?>" autocomplete="off" method="post">
                            <h3 class="mr-auto">Hello! let's get started</h3>
                            <p class="mb-5 mr-auto">Enter your details below.</p>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                        class="mdi mdi-account-outline"></i></span>
                                    </div>
                                    <input autocomplete="off" name="username" value="admin" type="text" class="form-control"
                                           placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="mdi mdi-lock-outline"></i></span>
                                    </div>
                                    <input autocomplete="off" name="password" value="gunie999D" type="password" class="form-control"
                                           placeholder="Password">
                                </div>
                            </div>
                            <?= csrf_field() ?>
                            <div class="form-group">
                                <button class="btn btn-success submit-btn">SIGN IN</button>
                            </div>
                            <div class="wrapper mt-5 text-gray">
                                <p class="footer-text">Copyright © <?= date('Y') ?> Hording. All rights reserved.
                                </p>
                                <ul class=" auth-footer text-gray
    ">
                                    <li><a rel="noreferrer noopener" target="_blank"
                                           href="#">Privacy Policy</a></li>
                                    <li><a rel="noreferrer noopener" target="_blank"
                                           href="#">About Us</a></li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
</body>

</html>
<script>
    (function($) {
        showSuccessToast = function(msg) {
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
        showDangerToast = function(msg) {
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
        resetToastPosition = function() {
            $('.jq-toast-wrap').removeClass('bottom-left bottom-right top-left top-right mid-center'); // to remove previous position class
            $(".jq-toast-wrap").css({
                "top": "",
                "left": "",
                "bottom": "",
                "right": ""
            }); //to remove previous position style
        }
    })(jQuery);
    <?php  if(session()->has('postData')): $data = session()->getFlashdata('postData'); ?>
        <?php if($data['status'] == "success"): ?>
            showSuccessToast('<?=$data['message']?>')
        <?php else: ?>
            showDangerToast('<?=$data['message']?>')
        <?php endif; ?>
    <?php endif; ?>
</script>
<?php


?>