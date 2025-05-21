<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="<?= route_to('dashboard') ?>   ">
            <img src="<?= base_url('assets/images/logo.svg') ?>" alt="logo"/>
        </a>
        <a class="navbar-brand brand-logo-mini" href="<?= route_to('dashboard') ?>">
            <img src="<?= base_url('assets/images/logo-mini.svg') ?>" alt="logo"/>
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav d-none d-md-block">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="LanguageDropdown" href="#" data-toggle="dropdown"
                   aria-expanded="false">
                    <i class="flag-icon flag-icon-us"></i>
                    English
                </a>
                <div class="dropdown-menu navbar-dropdown pb-0" aria-labelledby="LanguageDropdown">
                    <a class="dropdown-item preview-item px-3 py-0">
                        <div class="preview-thumbnail">
                            <div class="preview-icon">
                                <i class="flag-icon flag-icon-cn"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="font-weight-light mb-0 small-text">
                                Chinese
                            </p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item px-3 py-0">
                        <div class="preview-thumbnail">
                            <div class="preview-icon">
                                <i class="flag-icon flag-icon-es"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="font-weight-light mb-0 small-text">
                                Spanish
                            </p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item px-3 py-0">
                        <div class="preview-thumbnail">
                            <div class="preview-icon">
                                <i class="flag-icon flag-icon-bl"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="font-weight-light mb-0 small-text">
                                French
                            </p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item px-3 py-0">
                        <div class="preview-thumbnail">
                            <div class="preview-icon">
                                <i class="flag-icon flag-icon-ae"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="font-weight-light mb-0 small-text">
                                Arabic
                            </p>
                        </div>
                    </a>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">


            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                   data-toggle="dropdown">
                    <i class="mdi mdi-bell-outline"></i>
                    <span class="count">4</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                     aria-labelledby="notificationDropdown">
                    <a class="dropdown-item">
                        <p class="mb-0 font-weight-normal float-left">You have 4 new notifications
                        </p>
                        <span class="badge badge-pill badge-warning float-right">View all</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-success">
                                <i class="mdi mdi-alert-circle-outline mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-medium text-dark">Application Error</h6>
                            <p class="font-weight-light small-text">
                                Just now
                            </p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-warning">
                                <i class="mdi mdi-comment-text-outline mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-medium text-dark">Settings</h6>
                            <p class="font-weight-light small-text">
                                Private message
                            </p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-info">
                                <i class="mdi mdi-email-outline mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-medium text-dark">New user registration</h6>
                            <p class="font-weight-light small-text">
                                2 days ago
                            </p>
                        </div>
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
                <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown"
                   aria-expanded="false">
                    <div class="dropdown-toggle-wrapper">
                        <div class="inner">
                            <div class="inner">
                                <span class="profile-text font-weight-bold">
                                    <?= session()->get('loggedIn')['name'] ?>

                                </span>
                                <small class="profile-text small"><?= session()->get('loggedIn')['role'] ?> <?= session()->get('loggedIn')['roleId'] != 1 ? (" - " . session()->get('loggedIn')['operator']) : '' ?></small>
                            </div>
                            <div class="inner">
                                <div class="icon-wrapper">
                                    <i class="mdi mdi-chevron-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <hr>

                    <a class="dropdown-item mt-2" href="<?= route_to('logout') ?>">
                        <i class="fa fa-sign-out"></i><span> Sign Out</span>
                    </a>
                </div>
            </li>

        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>