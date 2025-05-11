<?= $this->section('styles') ?>
<style>
    .submission-cnt {
        display: flex;
        justify-content: flex-end;
        flex-wrap: nowrap;
        align-items: center;

        #loader-check {
            display: none;
        }
    }
</style>
<?= $this->endSection() ?>
<?= $this->extend('common/header') ?>
<?= $this->section('content') ?>
<?php
$errors = session()->getFlashdata('errors');
?>
<div class="row mb-4">
    <div class="col-12 d-flex align-items-center justify-content-between">
        <h4 class="page-title">Create Schedules</h4>
    </div>
</div>
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form id="fmNewCycle" class="forms-sample" method="post"
                    action="<?= route_to('operator.schedules.cycle.store') ?>">
                    <?= csrf_field() ?>
                    <div class="form-group row">
                        <label for="submissionDate" class="col-sm-3 col-form-label">Submission Date</label>
                        <div class="col-sm-9">
                            <div id="datepicker-popup" class="input-group date datepicker">
                                <input id="submissionDate" name="submissionDate" type="text" class="form-control"
                                    value="<?= date('Y-m-d') ?>">
                                <span class="input-group-addon input-group-append border-left">
                                    <span class="mdi mdi-calendar input-group-text"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="deliveryDate" class="col-sm-3 col-form-label">Delivery Date</label>
                        <div class="col-sm-9">
                            <div id="datepicker-popup" class="input-group date datepicker">
                                <input id="deliveryDate" name="deliveryDate" value="<?= date('Y-m-d') ?>" type="text"
                                    class="form-control">
                                <span class="input-group-addon input-group-append border-left">
                                    <span class="mdi mdi-calendar input-group-text"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 submission-cnt">

                        <div id="loader-check">
                            <div class="dot-opacity-loader">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mr-2 pull-right" id="validate">Confirm
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>

<script>
    if ($(".datepicker").length) {
        $('.datepicker').datepicker({
            enableOnReadonly: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    }
    $("#validate").on('click', (e) => {
        e.preventDefault();
        const submissionDate = $("#submissionDate").val(),
            deliveryDate = $("#deliveryDate").val(),
            notificationType = $("#notificationType").val();
        if (!submissionDate) {
            $("#submissionDate").focus();
            showDangerToast("Submission Date is required");
            return;
        } else if (!deliveryDate) {
            $("#deliveryDate").focus();
            showDangerToast("Delivery Date is required");
            return;
        }
        $("#loader-check").show();
        $(this).prop('disabled', true);
        ajaxCall('<?= route_to('operator.schedules.cycle.validate') ?>', {
            submissionDate,
            deliveryDate,
        }).then((response) => {
            $(this).prop('disabled', false);
            $("#loader-check").hide();
            if (response.status === "success") {
                swal({
                    title: "Confirmation",
                    text: 'Do you want to create this cycle?',
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, do it!"
                }, function (isConfirm) {
                    if (isConfirm) {
                        $("#fmNewCycle").submit()
                    }
                })
            } else if (response.status === "validation") {
                showWarningToast(response.message);
            } else {
                showDangerToast(response.message);
            }
        }).catch((err) => {
            console.log(err);
            $(this).prop('disabled', false);
            $("#loader-check").hide();
            showDangerToast("Failed to complete request");
        })
    })
</script>

<?= $this->endSection() ?>