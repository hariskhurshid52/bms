<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8"> <?= csrf_meta() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= isset($title) ? $title . ' |' : '' ?> MCP Sonic</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?= base_url('assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/icheck/skins/all.css') ?>">
    <link  href="<?= base_url('assets/vendors/iconfonts/simple-line-icon/css/simple-line-icons.css') ?>">

    <link rel="stylesheet" href="<?= base_url('assets/vendors/iconfonts/font-awesome/css/font-awesome.min.css'); ?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/vendors/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/css/vendor.bundle.addons.css') ?>">
    <!-- endinject -->
    <!-- plugin css for this page -->

    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/daterangepicker.css') ?>"/>
    <!-- End plugin css for this page -->
    <!-- inject:css -->


    <link rel="stylesheet" href="<?= base_url('assets/css/enjoyhint.css') ?>">
    <link rel="stylesheet"  href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css"/>

    <!-- endinject -->

    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/images/fv-icons') ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/images/fv-icons') ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/images/fv-icons') ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url('assets/images/fv-icons') ?>/site.webmanifest">
    <link rel="mask-icon" href="<?= base_url('assets/images/fv-icons') ?>/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    <script src="<?= base_url('assets/vendors/js/vendor.bundle.base.js') ?>"></script>
    <script src="<?= base_url('assets/vendors/js/vendor.bundle.addons.js') ?>"></script>
    <?= $this->renderSection('styles') ?>
</head>

<body>
<div id="pageloader">
    <div class="pixel-loader"></div>
</div>
<div class="container-scroller">
    <?= $this->include('common/top-menu') ?>
    <div class="container-fluid page-body-wrapper">
        <?= $this->include('common/left-menu') ?>

        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <?= $this->renderSection('content') ?>
            </div>
            <!-- content-wrapper ends -->

        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>

<!-- plugins:js -->
<!-- endinject -->
<!-- Plugin js for this page-->
<script type="text/javascript" src="<?= base_url('assets/js/moment.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/daterangepicker.js') ?>"></script>
<!-- End plugin js for this page-->
<!-- Custom js for this page-->
<script type="text/javascript" src="<?= base_url('assets/js/kinetic.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/jquery.scrollTo.min.js') ?>"></script>


<script type="text/javascript" src="<?= base_url('assets/js/datatable.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.2/dist/jquery.fancybox.min.js"></script>
<script src="<?= base_url('assets/js/horizontal-menu.js') ?>"></script>
<script src="<?= base_url('assets/js/notify.js') ?>"></script>
<script src="<?= base_url('assets/js/app.js') ?>"></script>
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

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

    function getAllUrlParams(url) {

        // get query string from url (optional) or window
        var queryString = url ? url.split('?')[1] : window.location.search.slice(1);

        // we'll store the parameters here
        var obj = {};

        // if query string exists
        if (queryString) {

            // stuff after # is not part of query string, so get rid of it
            queryString = queryString.split('#')[0];

            // split our query string into its component parts
            var arr = queryString.split('&');

            for (var i = 0; i < arr.length; i++) {
                // separate the keys and the values
                var a = arr[i].split('=');

                // set parameter name and value (use 'true' if empty)
                var paramName = a[0];
                var paramValue = typeof (a[1]) === 'undefined' ? true : a[1];

                // (optional) keep case consistent
                paramName = paramName.toLowerCase();
                if (typeof paramValue === 'string') paramValue = paramValue.toLowerCase();

                // if the paramName ends with square brackets, e.g. colors[] or colors[2]
                if (paramName.match(/\[(\d+)?\]$/)) {

                    // create key if it doesn't exist
                    var key = paramName.replace(/\[(\d+)?\]/, '');
                    if (!obj[key]) obj[key] = [];

                    // if it's an indexed array e.g. colors[2]
                    if (paramName.match(/\[\d+\]$/)) {
                        // get the index value and add the entry at the appropriate position
                        var index = /\[(\d+)\]/.exec(paramName)[1];
                        obj[key][index] = paramValue;
                    } else {
                        // otherwise add the value to the end of the array
                        obj[key].push(paramValue);
                    }
                } else {
                    // we're dealing with a string
                    if (!obj[paramName]) {
                        // if it doesn't exist, create property
                        obj[paramName] = paramValue;
                    } else if (obj[paramName] && typeof obj[paramName] === 'string') {
                        // if property does exist and it's a string, convert it to an array
                        obj[paramName] = [obj[paramName]];
                        obj[paramName].push(paramValue);
                    } else {
                        // otherwise add the property
                        obj[paramName].push(paramValue);
                    }
                }
            }
        }

        return obj;
    }

    function convertToUrl(data) {
        return Object.entries(data).map(e => e.join('=')).join('&');

    }

    $(document).ready(() => {
        $(".select2").select2()
        if ($('.invalid-field-error').length > 0) {
            setInterval(() => {
                $('.invalid-field-error').fadeOut()
            }, 3000)
        }
        $('.icheck input').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal',
            increaseArea: '20%'
        });
        $('.icheck-square input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square',
            increaseArea: '20%'
        });
    })

    <?php if(session()->has('postBack')): $postBack = session()->get('postBack'); ?>
    <?php if($postBack['status'] === "success"): ?>
    showSuccessToast(`<?= $postBack['message'] ?>`);
    <?php else: ?>
    showDangerToast(`<?= $postBack['message'] ?>`);
    <?php endif; ?>
    <?php endif; ?>
</script>
<!-- End custom js for this page--> <?= $this->renderSection('scripts') ?>
</body>

</html>