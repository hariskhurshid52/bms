<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?= $title ?? 'Dashboard' ?> - Billboard Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Billboard Management System" name="description" />
    <meta content="BMS" name="author" />
    
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico') ?>">

    <!-- Bootstrap Css -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url('assets/css/icons.min.css') ?>" rel="stylesheet" type="text/css" />
    <!-- App Css -->
    <link href="<?= base_url('assets/css/app.min.css') ?>" rel="stylesheet" type="text/css" />
    <!-- Custom Css -->
    <link href="<?= base_url('assets/css/custom.css') ?>" rel="stylesheet" type="text/css" />
</head>

<body data-sidebar="dark">
    <!-- Begin page -->
    <div id="layout-wrapper">
        <!-- Header -->
        <?= $this->include('admin/layouts/header') ?>
        
        <!-- Left Sidebar -->
        <?= $this->include('admin/layouts/sidebar') ?>

        <!-- Main Content -->
        <div class="main-content">
            <div class="page-content">
                <?= $this->renderSection('content') ?>
            </div>
        </div>

        <!-- Footer -->
        <?= $this->include('admin/layouts/footer') ?>
    </div>

    <!-- JAVASCRIPT -->
    <!-- Jquery -->
    <script src="<?= base_url('assets/libs/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap Bundle -->
    <script src="<?= base_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- Metismenu -->
    <script src="<?= base_url('assets/libs/metismenu/metisMenu.min.js') ?>"></script>
    <!-- Simplebar -->
    <script src="<?= base_url('assets/libs/simplebar/simplebar.min.js') ?>"></script>
    <!-- Waves -->
    <script src="<?= base_url('assets/libs/node-waves/waves.min.js') ?>"></script>
    <!-- App js -->
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
    <!-- Custom js -->
    <script src="<?= base_url('assets/js/custom.js') ?>"></script>

    <!-- Additional Scripts -->
    <?= $this->renderSection('scripts') ?>
</body>
</html> 