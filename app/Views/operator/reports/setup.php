<?= $this->section('styles') ?>
<?= $this->endSection() ?>
<?= $this->extend('common/default') ?>
<?= $this->section('content') ?>
<?php
$errors = session()->getFlashdata('errors');
?>

    <form class="row mt-4" method="post" action="<?= route_to('operator.reports.setup.store') ?>">
        <?= csrf_field() ?>
        <div class="col-md-12 col-sm-12 ">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Create Reporting Template</h4>
                    <hr/>


                    <div class="mb-2">

                        <div class="mb-3">
                            <label for="templateName" class="form-label">Template Name</label>
                            <input type="text" class="form-control" name="templateName" id="templateName"
                                   value="<?= old('templateName') ?>">
                        </div>
                        <label for="partner" class="form-label">Select Departments</label>
                        <select name="roles[]" id="roles" class="form-control select2" multiple
                                data-placeholder="Select roles form list">
                            <option></option>
                            <?php foreach ($roles as $role): ?>
                                <option <?= old('recipients') === $role['id'] ? 'selected' : '' ?>
                                        value="<?= $role['id'] ?>"><?= $role['roleName'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="mb-3 mt-3">
                            <label for="recipients" class="form-label">Additional Recipients <small>(comma separated)</small> </label>
                            <input type="text" class="form-control" name="recipients" id="recipients"
                                   value="<?= old('recipients') ?>">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="templateName" class="form-label">Choose Fields to include in
                                template</label>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="row">
                                        <?php foreach ($fields as $k => $field): ?>
                                            <div class="col-md-3">
                                                <div class="form-check-inline mb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="<?= $k ?>" id="field_<?= $k ?>"
                                                           name="fields[]"
                                                           checked>
                                                    <label class="form-check-label" for="field_<?= $k ?>">
                                                        <?= $field ?>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>

                                    </div>
                                </div>

                            </div>
                        </div>


                        <?php if (false): ?>
                            <label for="reportType" class="form-label">Report type</label>

                            <div class="form-group mb-3">
                                <div class="form-check-inline">
                                    <input class="form-radio-input" type="radio" value="email" id="reportTypeE"
                                           name="reportType"
                                    >
                                    <label class="form-radio-label" for="reportTypeE">
                                        Email
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-radio-input" type="radio" value="csv" name="reportType"
                                           id="reportTypeCsv">
                                    <label class="form-radio-label" for="reportTypeCsv">CSV </label>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
        <?php if (false): ?>
            <div class="col-md-12 mt-3 ">
                <div class="card ">
                    <div class="card-body">
                        <h4 class="card-title">Customize email rules</h4>
                        <hr/>
                        <div class="row">
                            <div class="mb-2 col-md-6 col-sm-12">
                                <label for="roles" class="form-label">Roles</label>
                                <select name="roles" id="roles" class="form-control select2" multiple
                                        data-placeholder="Select roles form list">

                                </select>
                            </div>
                            <div class="mb-2 col-md-6 col-sm-12">
                                <label for="roles" class="form-label">Additional Recipients</label>
                                <div class="form-group mb-3">
                                    <div class="form-check-inline">
                                        <input class="form-radio-input" type="checkbox" value="operator"
                                               id="recipientsOP"
                                               name="recipientsOP">
                                        <label class="form-radio-label" for="recipientsOP">
                                            Operator
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-radio-input" type="radio" value="all" name="recipients"
                                               id="recipientsAP">
                                        <label class="form-radio-label" for="recipientsAP">All Partners </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-radio-input" type="radio" value="relative"
                                               name="recipients" id="recipientsSP">
                                        <label class="form-radio-label" for="recipientsSP">Specific Partner </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-radio-input" type="radio" value="none" name="recipients"
                                               id="recipientsN" checked>
                                        <label class="form-radio-label" for="recipientsN">None </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2 col-md-6 col-sm-12">
                                <label for="notificationFrequency" class="form-label">Days Before</label>
                                <input type="text" class="form-control" id="notificationFrequency"
                                       name="notificationFrequency"
                                       placeholder="Specify how many days before the scheduled date the reminder should be sent (e.g., 3 days before)">


                            </div>
                            <div class="mb-2 col-md-6 col-sm-12 d-none" data-alert-type="email">
                                <label for="notificationTime" class="form-label">Alert Time</label>
                                <div class="input-group clockpicker">
                                    <input type="text" class="form-control" value="09:30 AM" id="notificationTime">
                                    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-md-12 mt-3 mb-3">
            <div class="card ">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary pull-right" id="saveTemplate">Submit</button>
                </div>
            </div>
        </div>
        <!-- end col -->
    </form>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>


    <script>
        $(document).ready(function () {
            initEditor();
            // $('#notificaitonTime').datetimepicker({
            //     format: 'LT'
            // });

        })


        $('input[name=alertType]').change(function (event) {
            if ($(this).val() === "email") {
                $('[data-alert-type=email]').removeClass('d-none');
            } else {
                // $('#notificaitonTimeCnt').addClass('d-none');
                $('[data-alert-type=email]').addClass('d-none');
            }
        })
        $('input[name=notificationAction]').change(function (event) {
            if ($(this).val() !== "action") {
                $('[data-alert-action="reminder"]').removeClass('d-none');
            } else {
                $('[data-alert-action="reminder"]').addClass('d-none');
            }
        })

        $("#saveTemplate").click(() => {
            saveTemplate();
        });


        saveTemplate = () => {
            let alertType = $('input[name=alertType]:checked').val();
            let templateName = $("#templateName").val();
            let template = tinymce.get('templateEditor').getContent();
            let notificationAction = $('input[name=notificationAction]:checked').val();
            let roles = $("#roles").val();
            let partners = $('input[name=recipients]:checked').val();
            let operator = $('#recipientsOP').is(':checked');

            let frequency = $("#notificationFrequency").val();
            let notificationTime = $("#notificationTime").val();

            if (!alertType) {
                showDangerToast("Please select alert type");
                return
            } else if (!templateName) {
                showDangerToast("Please write template name");
                return
            } else if (!template) {
                showDangerToast("Please provide email template");
                return
            } else if (!notificationAction) {
                showDangerToast("Please select valid action");
                return
            }
            if (alertType === 'email' && notificationAction != 'action') {
                if (!frequency) {
                    showDangerToast("Please specify frequency");
                    return
                }
                if (!notificationTime) {
                    showDangerToast("Please select notification time");
                    return
                }

            }
            $("#pageloader").show();

            ajaxCall('<?= route_to("operator.alertTemplate.store") ?>', {
                alertType,
                templateName,
                template,
                notificationAction,
                partners,
                roles,
                notificationTime,
                frequency,
                operator

            }).then(response => {
                $("#pageloader").hide();
                if (response.status === 'success') {
                    showSuccessToast(response.message);
                    setTimeout(() => {
                        window.location.href = '<?= route_to("operator.alertTemplate.index") ?>'
                    }, 2000)
                } else {
                    showDangerToast(response.message);
                }
            }).catch(err => {
                $("#pageloader").hide();
                showDangerToast(err.message || 'Unable to save email template');
            })
        }


    </script>
<?= $this->endSection() ?>