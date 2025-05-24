<?php
$theme_url = base_url() . 'assets/';
?>

<!DOCTYPE html>
<html lang="en" data-topbar-color="brand">

<head>
    <?= csrf_meta() ?>
    <meta charset="utf-8" />
    <title>Log In | Hoarding</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Mobile App/Progressive Web App Meta -->
    <link rel="icon" href="<?= base_url('assets/images/logo.png') ?>" type="image/png">
    <link rel="apple-touch-icon" href="<?= base_url('assets/images/logo.png') ?>">
    <link rel="apple-touch-icon" sizes="192x192" href="<?= base_url('assets/images/logo-sm.png') ?>">
    <link rel="apple-touch-icon" sizes="512x512" href="<?= base_url('assets/images/logo.png') ?>">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link rel="apple-touch-startup-image" href="<?= base_url('assets/images/logo.png') ?>" media="(device-width: 320px) and (device-height: 568px)">
    <link rel="apple-touch-startup-image" href="<?= base_url('assets/images/logo.png') ?>" media="(device-width: 375px) and (device-height: 667px)">
    <link rel="apple-touch-startup-image" href="<?= base_url('assets/images/logo.png') ?>" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)">
    <link rel="apple-touch-startup-image" href="<?= base_url('assets/images/logo.png') ?>" media="(device-width: 375px) and (device-height: 812px)">
    <link rel="apple-touch-startup-image" href="<?= base_url('assets/images/logo.png') ?>" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)">
    <link rel="apple-touch-startup-image" href="<?= base_url('assets/images/logo.png') ?>" media="(min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait)">

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= $theme_url ?>assets/images/favicon.ico">

    <!-- App css -->
    <link href="<?= $theme_url ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $theme_url ?>libs/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= $theme_url ?>/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />
    <link href="<?= $theme_url ?>/css/icons.min.css" rel="stylesheet" type="text/css" />

    <!-- Theme Config Js -->
    <script src="<?= $theme_url ?>/js/config.js"></script>
</head>

<body class="auth-fluid-pages pb-0">
    <div class="auth-fluid">
        <!-- Auth fluid right content -->
        <div class="auth-fluid-right">
            
        </div>

        <!-- Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="align-items-cente d-flex h-100">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="text-center text-lg-start">
                        <div class="auth-logo d-flex justify-content-center">
                            <a href="<?=route_to('home')?>" class="logo logo-dark text-center">
                                <span class="logo-lg">
                                    <img src="<?=base_url()?>/assets/images/logos/logo-login.png" alt="" height="150">
                                </span>
                            </a>
                            <a href="<?=route_to('home')?>" class="logo logo-light text-center">
                                <span class="logo-lg">
                                    <img src="<?=base_url()?>/assets/images/logos/logo-login.png" alt="" height="150">
                                </span>
                            </a>
                        </div>
                    </div>

                    <!-- title-->
                    <h4 class="mt-4">Sign In</h4>
                    <p class="text-muted mb-4">Enter your username or email address and password to access panel.</p>

                    <!-- form -->
                    <form method="post" action="<?=route_to('login.verify')?>">
                        <?=csrf_field()?>
                        <div class="mb-2">
                            <label for="emailaddress" class="form-label">Email / Username</label>
                            <input class="form-control" type="text" name="username" id="emailaddress" placeholder="Enter your username/email">
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
                                <label class="form-check-label" for="checkbox-signin">Remember me</label>
                            </div>
                        </div>

                        <div class="d-grid text-center">
                            <button class="btn btn-primary" type="submit">Log In</button>
                        </div>
                    </form>
                    <!-- end form-->

                    
                </div>
            </div>
        </div>
    </div>

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
                $('.jq-toast-wrap').removeClass('bottom-left bottom-right top-left top-right mid-center');
                $(".jq-toast-wrap").css({
                    "top": "",
                    "left": "",
                    "bottom": "",
                    "right": ""
                });
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

