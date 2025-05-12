<?php
$theme_url = base_url() . 'assets/';
?>

<!DOCTYPE html>
<html lang="en" data-topbar-color="brand">

<head>
    <?= csrf_meta() ?>
    <meta charset="utf-8" />
    <title>Log In | Hording</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= $theme_url ?>assets/images/favicon.ico">

    <!-- App css -->
    <link href="<?= $theme_url ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <link href="<?= $theme_url ?>libs/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet" type="text/css"/>

    
    <link href="<?= $theme_url ?>/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />

    <!-- icons -->
    <link href="<?= $theme_url ?>/css/icons.min.css" rel="stylesheet" type="text/css" />

    <!-- Theme Config Js -->
    <script src="<?= $theme_url ?>/js/config.js"></script>


</head>

<body class="loading">

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-4">
                <div class="card">

                    <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                            <div class="auth-logo">
                                <a href="index-2.html" class="logo logo-dark text-center">
                                            <span class="logo-lg">
                                                <img src="<?=base_url()?>/assets/images/logos/logo-dark.png" alt="" height="70">
                                            </span>
                                </a>

                                <a href="index-2.html" class="logo logo-light text-center">
                                            <span class="logo-lg">
                                                <img src="<?=base_url()?>/assets/images/logos/logo-light.png" alt="" height="70">
                                            </span>
                                </a>
                            </div>
                            <p class="text-muted mb-4 mt-3">Enter your username or email address and password to access panel.</p>
                        </div>

                        <form method="post" action="<?=route_to('login.verify')?>">
                            <?=csrf_field()?>
                            <div class="mb-2">
                                <label for="emailaddress" class="form-label">Email / Username</label>
                                <input class="form-control" type="text" name="username" id="emailaddress"  placeholder="Enter your username/email">
                            </div>

                            <div class="mb-2">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">

                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkbox-signin" checked>
                                    <label class="form-check-label" for="checkbox-signin">
                                        Remember me
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid mb-0 text-center">
                                <button class="btn btn-primary" type="submit"> Log In </button>
                            </div>

                        </form>



                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->


                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->



<!-- Vendor js -->
<script src="<?= $theme_url ?>/js/vendor.min.js"></script>
<script src="<?= $theme_url ?>libs/jquery-toast-plugin/jquery.toast.min.js"></script>

<!-- App js -->
<script src="<?= $theme_url ?>/js/app.min.js"></script>
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
</body>

</html>

