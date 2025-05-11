<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8"> <?= csrf_meta() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?> | MCP Sonic</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?= base_url('assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css') ?>">
    <link rel="stylesheet"
          href="<?= base_url('assets/vendors/iconfonts/simple-line-icon/css/simple-line-icons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/css/vendor.bundle.addons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/iconfonts/font-awesome/css/font-awesome.min.css'); ?>"/>
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/daterangepicker.css') ?>"/>
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/enjoyhint.css') ?>">
    <link rel="stylesheet"
          href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css"/>

    <!-- endinject -->

    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/images/fv-icons') ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/images/fv-icons') ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/images/fv-icons') ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url('assets/images/fv-icons') ?>/site.webmanifest">
    <link rel="mask-icon" href="<?= base_url('assets/images/fv-icons') ?>/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    <script src="<?= base_url('assets/vendors/js/vendor.bundle.base.js') ?>"></script>
    <script src="<?= base_url('assets/vendors/js/vendor.bundle.addons.js') ?>"></script>
	<?= $this->renderSection('styles') ?>
</head>

<body class="horizontal-menu-2 light">
<div class="container-scroller"> 
    <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
            <div class="content-wrapper"> <?= $this->renderSection('content') ?> </div>
        </div>
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<!-- endinject -->
<!-- Plugin js for this page-->
<script type="text/javascript" src="<?= base_url('assets/js/moment.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/daterangepicker.js') ?>"></script>
<!-- End plugin js for this page-->
<!-- Custom js for this page-->
<script type="text/javascript" src="<?= base_url('assets/js/kinetic.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/jquery.scrollTo.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/enjoyhint.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dashboard.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/datatable.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.2/dist/jquery.fancybox.min.js"></script>
<script src="<?= base_url('assets/js/horizontal-menu.js') ?>"></script>
<script src="<?= base_url('assets/js/notify.js') ?>"></script>
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
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
        let startDate = '<?=isset($startDate) ? $startDate : date('Y-m-d', strtotime('now'))?>',
            endDate = '<?=isset($endDate) ? $endDate : date('Y-m-d', strtotime('now'))?>';
        $('#daterange').daterangepicker({
            "startDate": moment(startDate, 'DD-MM-YYYY'),
            "endDate": moment(endDate, 'DD-MM-YYYY'),
            "showDropdowns": true,
            "showWeekNumbers": true,
            "autoApply": true,
            "autoUpdateInput": true,
            "minYear": 2016,
            "dateLimit": {
                "month": 1
            },
            "locale": {
                "format": 'DD-MM-YYYY',
                "separator": ' - '
            },
            "maxDate": moment(),
            "opens": "left",
            "drops": "down",
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, function (start, end, label) {
            $('#theDateRange').val(`${start.format('DD-MM-YYYY')} - ${end.format('DD-MM-YYYY')}`)
        });
        if ($("#fldatesearch").length) {
            return;
            var start = moment().subtract(29, 'days');
            var end = moment();
            $("#fldatesearch").daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, (start, end) => {
                $("#fldatesearch").val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
				<?php if (session()->get('route')['method'] == "dashboard") : ?>
                searchVtxDashboard(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'))
				<?php endif ?>

            })

            function searchVtxDashboard(start, end) {
                let url = `${window.location.origin}${window.location.pathname}`,
                    queryString = getAllUrlParams();
                queryString['start'] = start;
                queryString['end'] = end;

                window.location.href = `${url}?${convertToUrl(queryString)}`
            }
        }
        if ($(".select2").length) {
            $(".select2").select2({
                placeholder: 'Select from list'
            })
        }
        if ($(".data-table").length) {
            $(".data-table").DataTable()
        }

        if ($('.alert-pb').length > 0) {
            setInterval(() => {
                $('.alert-pb').fadeOut()
            }, 3000)
        }
        if ($(".tags-input").length) {
            $(".tags-input").tagsinput()
        }

        $('.users-list ul li input').keyup((e) => {
            const searchVal = $(e.currentTarget).val().toUpperCase()
            $('.users-list ul li.dropdown-item').each((i, li) => {
                const client = (li.textContent || li.innerText).toUpperCase()
                if (client.indexOf(searchVal) > -1) {
                    li.setAttribute('style', 'display:flex !important')
                } else {
                    li.setAttribute('style', 'display:none !important')
                }
            })
        })
    })
</script>
<!-- End custom js for this page--> <?= $this->renderSection('scripts') ?>
</body>

</html>