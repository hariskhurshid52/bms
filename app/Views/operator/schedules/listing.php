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
<?= $this->extend('common/default') ?>
<?= $this->section('content') ?>
<?php

?>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Manage Schedule
                    <button class="btn btn-primary pull-right btn-sm" data-bs-toggle="modal"
                        data-bs-target="#addNewCycle" id="btnAddCycle">Add New
                    </button>
                </h4>
                <hr />
                <div class="table-responsive">
                    <table class="table table-hover" id="dtCycles">
                        <thead>
                            <tr>
                                <th>Submission Date</th>
                                <th>Delivery Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cycles as $cycle):

                                $currentTimestamp = strtotime('now');
                                $todayTimestamp = strtotime($today);
                                $submissionTimestamp = strtotime($cycle['submissionDate']);
                                $submissionClass = ($currentTimestamp > $submissionTimestamp) ? 'passed' : '';
                                if ($submissionTimestamp == $todayTimestamp) {
                                    $submissionClass = 'current';
                                }
                                if ($cycle['submissionDate'] == $recent['submission']) {
                                    $submissionClass = 'recent';
                                }

                                $deliveryTimestamp = strtotime($cycle['deliveryDate']);
                                $deliveryClass = ($currentTimestamp > $deliveryTimestamp) ? 'passed' : '';
                                if ($cycle['deliveryDate'] == $recent['delivery']) {
                                    $deliveryClass = 'recent';
                                }
                                if ($deliveryTimestamp == $todayTimestamp) {
                                    $deliveryClass = 'current';
                                }
                                $showActionBtn = !($submissionClass === "passed" && $deliveryClass === "passed");
                                ?>
                                <tr data-cycle="<?= $submissionClass === "passed" && $deliveryClass === "passed" ? 'passed' : '' ?>"
                                    class="<?= $submissionClass === "passed" && $deliveryClass === "passed" ? 'd-none' : '' ?>">

                                    <td class="cycle cycle-<?= $submissionClass ?>     ">
                                        <span class="cycle cycle-<?= $submissionClass ?>"><?= date('d-m-Y', strtotime($cycle['submissionDate'])) ?></span>
                                        <?=strtotime('now') > strtotime($cycle['submissionDate']) ? '<sup class="passed">Passed</sup>':''  ?>

                                    </td>
                                    <td class="cycle cycle-<?= $deliveryClass ?> ">
                                        <?= date('d-m-Y', strtotime($cycle['deliveryDate'])) ?>
                                    </td>
                                    <td>
                                        <?php if ($showActionBtn): ?>
                                            <button onclick="editCycle('<?= $cycle['id'] ?>')"
                                                class="btn btn-sm btn-primary"><span class="fe-edit"></span></button>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addNewCycle" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addNewCycle">Add New Schedule</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="fmNewCycle" class="forms-sample" method="post"
                action="<?= route_to('operator.schedules.cycle.store') ?>">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="submissionDate" class="form-label">Submission Date</label>
                                <div class="input-group position-relative datepicker" id="submissionDatePicker">
                                    <input autocomplete="off" data-provide="datepicker" data-date-format="yyyy-mm-dd"
                                        data-date-autoclose="true" data-date-container="#submissionDatePicker"
                                        type="text" class="form-control" id="submissionDate" name="submissionDate"
                                        readonly value="<?= date('Y-m-d') ?>">
                                    <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="deliveryDate" class="form-label">Delivery Date</label>
                                <div class="input-group position-relative datepicker" id="deliveryDatePicker">
                                    <input autocomplete="off" data-provide="datepicker" data-date-format="yyyy-mm-dd"
                                        data-date-autoclose="true" data-date-container="#deliveryDatePicker" type="text"
                                        name="deliveryDate" class="form-control" id="deliveryDate" readonly
                                        value="<?= date('Y-m-d') ?>">
                                    <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveCycle">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editCycleStep1" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editCycleStep1">Edit Schedule</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="modal-body p-4" id="editCycleStep1Cnt">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" disabled data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" disabled id="btnGoToStep2">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editCycleStep2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editCycleStep2">Edit Schedule Alert</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="modal-body p-4" id="editCycleStep2Cnt">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" disabled data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" disabled id="btnUpdateCycle">Update</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-md" id="mdEditCycleChangeEmail">
    <div class="modal-dialog" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Email Template</h5>
            </div>
            <div class="modal-body " id="mdEditCycleChangeEmailContent">
                <div class="pixel-loader"></div>
            </div>

        </div>
    </div>
</div>

<div class="modal modal-md" id="mdEditCycleChangeAlert">
    <div class="modal-dialog" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alert Template</h5>
            </div>
            <div class="modal-body " id="mdEditCycleChangeAlertContent">
                <div class="pixel-loader"></div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/vendors/tinymce/tinymce.min.js') ?>"></script>
<script>
    if ($(".datepicker").length) {
        // $('.datepicker').datepicker({
        //     enableOnReadonly: true,
        //     todayHighlight: true,
        //     format: 'yyyy-mm-dd',
        //     autoclose: true
        // });
    }

    $(document).ready(function () {
        $('#dtCycles').DataTable({
            pageLength: 20,
            ordering: false,
            lengthMenu: [[10, 20, 50, -1], [10, 20, 50, 100]],
            dom: 'Bfrtip',  // Include the Buttons in the DOM layout
            buttons: [
                {
                    text: 'Toggle Passed Scheule',
                    className: 'btn btn-sm',
                    action: function (e, dt, node, config) {
                        $("[data-cycle='passed']").toggleClass('d-none')
                    }
                }
            ]
        });
        $("#addNewCycle #btnSaveCycle").click((e) => {
            e.preventDefault();
            const submissionDate = $("#addNewCycle #submissionDate").val(),
                deliveryDate = $("#addNewCycle #deliveryDate").val();
            if (!submissionDate) {
                $("#addNewCycle #submissionDate").focus();
                showDangerToast("Submission Date is required");
                return;
            } else if (!deliveryDate) {
                $("#addNewCycle #deliveryDate").focus();
                showDangerToast("Delivery Date is required");
                return;
            }
            $("#pageloader").show();
            $(this).prop('disabled', true);
            ajaxCall('<?= route_to('operator.schedules.cycle.validate') ?>', {
                submissionDate,
                deliveryDate,
            }).then((response) => {
                $(this).prop('disabled', false);
                $("#pageloader").hide();
                if (response.status === "success") {
                    $("#pageloader").show()
                    $("#addNewCycle #fmNewCycle").submit()
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
        $("#editCycleStep2 #btnUpdateCycle").click((e) => {
            e.preventDefault();
            updateCycle()
        })
        $("#editCycleStep1 #btnGoToStep2").click(() => {
            if (!$("#editCycleStep1 input[name=cycleId]").val()) return
            validateCycle($("#editCycleStep1 input[name=cycleId]").val())
        })
    })


    initGrid = () => {
        $('#dtCycles').DataTable({

            processing: true,
            ordering: false,
            serverSide: true,
            ajax: {
                url: "<?= route_to('operator.schedules.cycles.dtList') ?>",
                type: "POST",
                dataType: "json",
                data: function (d) {
                    d['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
                }
            },
            columns: [
                { data: "submissionDate", title: "Submission Date" },
                { data: "deliveryDate", title: "Delivery Date" },
                {
                    data: "alertCycleId",
                    title: "Actions",
                    render: function (data, type, row) {

                        return `
                         <button onclick="editCycle(${data})" class="btn btn-sm btn-primary"><span class="fe-edit"></span></button>
                        
                         `;
                    }
                },

            ],
            order: [[1, 'desc']]
        })
    }

    addCycle = (alertCycleId) => {
        $("#addNewCycle").modal("show");
    }

    editCycle = (alertCycleId) => {
        if (!alertCycleId) {
            showDangerToast("Schedule not found");
            return;
        }
        $("#editCycleStep1 #editCycleStep1Cnt").html(` <div class="d-flex justify-content-center">
                                            <div class="spinner-border" role="status"></div>
                                        </div>`);
        $("#editCycleStep1").modal("show");
        getCycleContent(alertCycleId)
    }

    getCycleContent = (alertCycleId) => {
        if (!alertCycleId) {
            showDangerToast("Schedule not found");
            return;
        }
        $("#editCycleStep1 #editCycleStep1Cnt").html(` <div class="d-flex justify-content-center">
                                            <div class="spinner-border" role="status"></div>
                                        </div>`);
        ajaxCall('<?= route_to('operator.schedules.cycle.content') ?>', {
            cycleId: alertCycleId
        }).then((response) => {
            $("#editCycleStep1 #editCycleStep1Cnt").html(response.step1);
            $("#editCycleStep2 #editCycleStep2Cnt").html(response.step2);
            if ($("#editCycleStep1 #editCycleStep1Cnt .datepicker").length) {
                $('#editCycleStep1 #editCycleStep1Cnt [data-provide="datepicker"]').each(function () {
                    let $this = $(this);
                    let container = $this.data('date-container');
                    $this.datepicker({
                        format: $this.data('date-format') || 'yyyy-mm-dd',
                        autoclose: $this.data('date-autoclose') !== undefined ? $this.data('date-autoclose') : true,
                        container: `#editCycleStep1 #editCycleStep1Cnt ${container}`
                    });
                });
            }
            $("#editCycleStep1 .modal-footer button").prop("disabled", false)


        }).catch((err) => {
            console.log(err)
            showDangerToast("Failed to complete request");
            $("#mdEditCycle").modal("hide");
            $("#mdEditCycleContent").html(``);
        })
    }

    validateCycle = (alertCycleId) => {
        const submissionDate = $("#editCycleStep1 #submissionDate").val(),
            deliveryDate = $("#editCycleStep1 #deliveryDate").val();
        if (!submissionDate) {
            $("#editCycleStep1 #submissionDate").focus();
            showDangerToast("Submission Date is required");
            return;
        } else if (!deliveryDate) {
            $("#editCycleStep1 #deliveryDate").focus();
            showDangerToast("Delivery Date is required");
            return;
        }
        $("#pageloader").show();
        $(this).prop('disabled', true);
        ajaxCall('<?= route_to('operator.schedules.cycle.validate') ?>', {
            submissionDate,
            deliveryDate,
            alertCycleId
        }).then((response) => {
            $(this).prop('disabled', false);
            $("#pageloader").hide();
            if (response.status === "success") {
                $("#editCycleStep1").modal('hide');
                $("#editCycleStep2").modal('show');
                $("#editCycleStep2 .modal-footer button").prop("disabled", false)
                return
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
            $("#mdEditCycle #loader-check").hide();
            showDangerToast("Failed to complete request");
        })
    }

    editCycleChangeEmail = () => {
        if (tinymce.get('emailEditor')) {
            tinymce.get('emailEditor').destroy()
        }
        $("#mdEditCycleChangeEmailContent").html(`<div class="pixel-loader"></div>`);
        $("#mdEditCycleChangeEmail").modal("show", { backdrop: "static", keyboard: false });
        ajaxCall('<?= route_to('operator.alertTemplate.cycleChangeEmailContent') ?>', {}).then((response) => {
            $("#mdEditCycleChangeEmailContent").html(response.html);
            if ($("#mdEditCycleChangeEmailContent #emailEditor").length > 0) {
                initEmailTemplateEditor("#mdEditCycleChangeEmailContent #emailEditor");

            }
        }).catch((err) => {
            console.log(err)
            showDangerToast("Failed to complete request");
            $("#mdEditCycleChangeEmail").modal("hide");
            $("#mdEditCycleChangeEmailContent").html(`<div class="pixel-loader"></div>`);
        })
    }

    editCycleChangeAlert = () => {
        if (tinymce.get('notificationEditor')) {
            tinymce.get('notificationEditor').destroy()
        }
        $("#mdEditCycleChangeAlertContent").html(`<div class="pixel-loader"></div>`);
        $("#mdEditCycleChangeAlert").modal("show", {
            backdrop: "static",
            keyboard: false
        });
        ajaxCall('<?= route_to('operator.alertTemplate.cycleChangeAlertContent') ?>', {}).then((response) => {
            $("#mdEditCycleChangeAlertContent").html(response.html);
            if ($("#mdEditCycleChangeAlertContent #notificationEditor").length > 0) {
                initEmailTemplateEditor("#mdEditCycleChangeAlertContent #notificationEditor", {
                    height: 300
                });

            }
        }).catch((err) => {
            console.log(err)
            showDangerToast("Failed to complete request");
            $("#mdEditCycleChangeAlert").modal("hide");
            $("#mdEditCycleChangeAlertContent").html(`<div class="pixel-loader"></div>`);
        })
    }

    updateTemplate = () => {
        $("#mdEditCycleChangeAlert").modal("hide");
        $("#mdEditCycleChangeEmail").modal("hide");
    }
    updateCycle = () => {
        const alertCycleId = $("#editCycleStep1 input[name=cycleId]").val(),
            submissionDate = $("#editCycleStep1Cnt #submissionDate").val(),
            deliveryDate = $("#editCycleStep1Cnt #deliveryDate").val(),
            partnerEmailAlert = $("#editCycleStep2 #emailNotification").is(":checked") ? "yes" : "no",
            partnerNotificationAlert = $("#editCycleStep2 #alertNotification").is(":checked") ? "yes" : "no";
        if (!alertCycleId) {
            showDangerToast("Your request cannot be completed");
            window.location.reload();
            return
        } else if (!submissionDate) {
            showDangerToast("In valid submission date");
            return;
        } else if (!deliveryDate) {
            showDangerToast("In valid delivery date");
            return;
        }
        let data = {
            alertCycleId, submissionDate, deliveryDate, partnerEmailAlert, partnerNotificationAlert
        }
        if ($("#mdEditCycleChangeEmailContent #emailEditor").length > 0) {
            data.emailTemplate = tinymce.get('emailEditor').getContent()
        }
        if ($("#mdEditCycleChangeAlert #notificationEditor").length > 0) {
            data.alertTemplate = tinymce.get('notificationEditor').getContent()
        }

        ajaxCall('<?= route_to('operator.schedules.cycle.update') ?>', data).then(response => {
            if (response.status === "success") {
                showSuccessToast("Schedule updated successfully")
            } else if (response.status === "validation") {
                showInfoToast(response.message)
            }
            else {
                showDangerToast("Failed to update cycle, Try again");
                setTimeout(() => {
                    // window.location.reload()
                }, 2000)
            }
        }).catch((err) => {
            console.log(err)
            showDangerToast("Failed to complete request");
            $("#editCycleStep2").modal("hide");
            // $("#editCycleStep1 #editCycleStep1Cnt,#editCycleStep2 #editCycleStep2Cnt, #mdEditCycleChangeEmail #mdEditCycleChangeEmailContent,#mdEditCycleChangeAlert #mdEditCycleChangeAlertContent").html(`<div class="pixel-loader"></div>`);
            setTimeout(() => {
                // window.location.reload()
            }, 2000)
        })
    }

</script>

<?= $this->endSection() ?>