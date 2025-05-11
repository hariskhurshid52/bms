<?= $this->section('styles') ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>"/> <?= $this->endSection() ?>
<?= $this->extend('common/no-header') ?> <?= $this->section('content') ?>
    <div class="container">
    <div class="col-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class=" alert alert-danger" role="alert" style="margin-top:0px">
                    <i class="bi-exclamation-octagon-fill mr-1"></i>
                    <strong>You are required to change your password.</strong>
                </div>

                <div class="col-md-6 offset-md-3">

                    <div class="card card-outline-secondary mt-2">

                        <div class="card-body">
                            <div class="mb-5">
                                <h3 class="">Change Password</h3>
                            </div>

                            <form class="form" method="post" action="<?= base_url('auth/update-password') ?>"
                                  onsubmit="return validateForm()" role="form" autocomplete="off">
                                <?= csrf_field() ?>
                                <div class="form-group mb-5">
                                    <label for="inputPasswordOld">Current Password</label>
                                    <input type="password" name="inputPasswordOld" class="form-control"
                                           id="inputPasswordOld" required="">
                                    <div class="form-text small text-muted" id="cpass">
                                        <span class="text-danger" id="cpasstxt"><?= $message ?></span>
                                    </div>

                                </div>
                                <div class="form-group mb-5">
                                    <label for="inputPasswordNew">New Password</label>
                                    <input type="password" name="inputPasswordNew" class="form-control"
                                           id="inputPasswordNew"
                                           required="">
                                    <div class="form-text small text-muted" id="npass"><span class="text-danger"
                                                                                             id="npasstxt"></span>
                                    </div>

                                </div>
                                <div class="form-group mb-5">
                                    <label for="inputPasswordNewVerify">Confirm New Password</label>
                                    <input type="password" name="inputPasswordNewVerify" class="form-control"
                                           id="inputPasswordNewVerify" required="">
                                    <div class="form-text small text-muted" id="vpass"><span class="text-danger"
                                                                                             id="vpasstxt"></span>
                                    </div>
                                    <div class="form-group mt-2">
                                        <button type="submit" class="btn btn-success btn-lg float-right">Save</button>
                                    </div>
                            </form>
                        </div>
                    </div>


                </div>

                <div id="successful" class="modal fade" data-backdrop="static" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content border border-primary">
                            <div class="modal-header">
                                <h4 class="modal-title">You've Successfully Changed Your Password</h4>

                            </div>
                            <div class="modal-body">
                                <div class="col-md-12" style="text-align-last:center">
                                    <div class="card ">
                                        <h6></h6>
                                        <div class="row mt-2 mb-2">
                                            <div class="col-md-2"></div>
                                            <a class="btn btn-primary col-md-8"
                                               href="<?= base_url('/') ?>"
                                               onclick="">Click here to signin with new password</a>
                                            <div class="col-md-2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div> <?= $this->endSection() ?>
<?= $this->section('scripts') ?>

    <script>
        function validateForm() {
            var oldPass = $('#inputPasswordOld').val();
            var verifyPass = $('#inputPasswordNewVerify').val();
            var newPass = $('#inputPasswordNew').val();

            $('#npass').hide();
            $('#vpass').hide();
            if (oldPass == newPass) {
                $('#npasstxt').html("Old Password and new password are same");
                $('#npass').show();
                return false;
            } else if (newPass !== verifyPass) {
                $('#vpasstxt').html("New Password and Verify Password are not same");
                $('#vpass').show();
                return false;
            } else {
                return true;
            }

        }
    </script>

<?php if ($status == 'successful'): ?>
    <script>
        console.log('successful');
        $('#successful').modal('show');
    </script>

<?php endif; ?>
<?= $this->endSection() ?>