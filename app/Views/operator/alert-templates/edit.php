<?= $this->section('styles') ?>
<?= $this->endSection() ?>
<?= $this->extend('common/default') ?>
<?= $this->section('content') ?>
<?php
$errors = session()->getFlashdata('errors');
?>
    <div class="row mt-4">
        <div class="col-md-12 col-sm-12 ">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Edit Template</h4>
                    <hr/>


                    <form role="form">
                        <div class="mb-2">
                            <label for="alertType" class="form-label">Alert type</label>

                            <div class="form-group mb-3">
                                <div class="form-check-inline">
                                    <input class="form-radio-input" type="radio" value="email" id="alertTypeE"
                                           name="alertType"
                                        <?= $template['type'] == 'email' ? 'checked' : '' ?>
                                    >
                                    <label class="form-radio-label" for="alertTypeE">
                                        Email
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-radio-input" type="radio" value="notification" name="alertType"
                                        <?= $template['type'] == 'notification' ? 'checked' : '' ?>
                                           id="alertTypeN">
                                    <label class="form-radio-label" for="alertTypeN">Dashboard Notification </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="templateName" class="form-label">Template Name</label>
                                <input type="text" class="form-control" id="templateName"
                                       value="<?= $template['name'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="templateSubject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="templateSubject"  value="<?= $template['subject'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="templateEditor" class="form-label">Template Content</label>
                                <textarea id="templateEditor" rows="3"><?= $template['html'] ?></textarea>
                            </div>

                            <label for="alertType" class="form-label">For which action you want to send this
                                alert? </label>
                            <div class="form-group mb-3">
                                <div class="form-check-inline">
                                    <input class="form-radio-input" type="radio" value="action"
                                        <?= $template['action'] == 'action' ? 'checked' : '' ?>
                                           id="notificationActionA" checked name="notificationAction">
                                    <label class="form-radio-label" for="notificationActionA">
                                        On Action (Cycle Add/Update)
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-radio-input" type="radio" value="submission"
                                        <?= $template['action'] == 'submission' ? 'checked' : '' ?>
                                           id="notificationActionS" name="notificationAction">
                                    <label class="form-radio-label" for="notificationActionS">On Submission </label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-radio-input" type="radio" value="delivery"
                                        <?= $template['action'] == 'delivery' ? 'checked' : '' ?>
                                           id="notificationActionD" name="notificationAction">
                                    <label class="form-radio-label" for="notificationActionD">On Delivery </label>
                                </div>
                            </div>


                    </form>
                </div>
            </div>

        </div>
        <div class="col-md-12 mt-3">
            <div class="card ">
                <div class="card-body">
                    <h4 class="card-title">Customize notification rules</h4>
                    <hr/>
                    <div class="row">

                        <div class="mb-2 col-md-6 col-sm-12">
                            <label for="roles" class="form-label">Roles</label>
                            <select name="roles" id="roles" class="form-control select2" multiple
                                    data-placeholder="Select roles form list">

                                <?php foreach ($roles as $role): ?>
                                    <option <?= in_array($role['id'], $assignedRoles) ? 'selected' : '' ?>
                                            value="<?= $role['id'] ?>"><?= $role['roleName'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-2 col-md-6 col-sm-12">
                            <label for="roles" class="form-label">Additional Recipients </label>
                            <div class="form-group mb-3">
                                <div class="form-check-inline">
                                    <input class="form-radio-input" type="checkbox" value="operator" id="recipientsOP"
                                        <?= $template['notifyOperator'] == 'yes' ? 'checked' : '' ?>
                                           name="recipientsOP">
                                    <label class="form-radio-label" for="recipientsOP">
                                        Operator
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-radio-input" type="radio" value="all" name="recipients"
                                        <?= $template['partners'] == 'all' ? 'checked' : '' ?>
                                           id="recipientsAP">
                                    <label class="form-radio-label" for="recipientsAP">All Partners </label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-radio-input" type="radio" value="relative"
                                        <?= $template['partners'] == 'relative' ? 'checked' : '' ?>
                                           name="recipients" id="recipientsSP">
                                    <label class="form-radio-label" for="recipientsSP">Specific Partner </label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-radio-input" type="radio" value="none" name="recipients"
                                        <?= $template['partners'] == 'none' ? 'checked' : '' ?>
                                           id="recipientsN" checked>
                                    <label class="form-radio-label" for="recipientsN">None </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2 col-md-6 col-sm-12 <?= $template['action'] == 'action' ? 'd-none' : '' ?>" data-alert-action="reminder">
                            <label for="notificationFrequency" class="form-label">Days Before</label>
                            <input type="text" class="form-control" id="notificationFrequency"
                                   name="notificationFrequency"
                                   value="<?= $template['frequency'] ?>"
                                   placeholder="Specify how many days before the scheduled date the reminder should be sent (e.g., 3 days before)">


                        </div>
                        <div class="mb-2 col-md-6 col-sm-12  <?= $template['action'] == 'action' ? 'd-none' : '' ?>"  data-alert-type="email" data-alert-action="reminder">
                            <label for="notificationTime" class="form-label">Alert Time</label>
                            <div class="input-group clockpicker">
                                <input type="text" class="form-control" value="<?= $template['time'] ?>"
                                       id="notificationTime">
                                <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                            </div>

                        </div>
                        <div class="mb-2 col-md-6 col-sm-12 <?= $template['action'] != 'action' ? 'd-none' : '' ?>" data-alert-action="action" >
                            <label for="action" class="form-label">Select Action</label>
                            <select class="form-control" id="action" name="action">
                                <?php  foreach ([
                                                    'reserved_short_code'=>'Reserved Shortcode',
                                                    'new_order'=>'New Order',
                                                    'process_order'=>'Process Order',
                                                    'live_order'=>'Live Shortcode ',
                                                    'cancel_order'=>'Cancel Short Code Order',
                                                    'cancel_reservation'=>'Cancel Short Code Reservation',
                                                    'migration_order'=>'Migrate Shortcode',
                                                    'cancel_migraiton'=>'Cancel Migration',
                                                    'approve_migraiton'=>'Approve Migration',
                                                    'submission_cycle_update'=>'Submission Cycle Update',
                                                    'delivery_cycle_update'=>'Submission Cycle Update',
                                                    'submission_date_reminder'=>'Submission Date Reminder',
                                                    'delivery_date_reminder'=>'Delivery Date Reminder',
                                                    'export_report'=>'Export Report',
                                                ] as $k=>$v): ?>
                                    <option <?=$template['keyAction'] ==$k ? 'selected':''?> value="<?=$k?>"><?=$v?></option>
                                <?php endforeach; ?>

                            </select>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="card ">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary pull-right" id="saveTemplate">Update</button>
                </div>
            </div>
        </div>
        <!-- end col -->


    </div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
    <script src="<?= base_url('assets/vendors/tinymce/tinymce.min.js') ?>"></script>
    <script>

        $(document).ready(function () {
            initEditor();
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
                    $('[data-alert-action="action"]').addClass('d-none');
                } else {
                    $('[data-alert-action="reminder"]').addClass('d-none');
                    $('[data-alert-action="action"]').removeClass('d-none');
                }
            })

        })





        $("#saveTemplate").click(() => {
            saveTemplate();
        });

        initEditor = () => {
            initEmailTemplateEditor("#templateEditor");
        }
        saveTemplate = () => {
            let alertType = $('input[name=alertType]:checked').val();
            let templateName = $("#templateName").val();
            let template = tinymce.get('templateEditor').getContent();
            let notificationAction = $('input[name=notificationAction]:checked').val();
            let roles = $("#roles").val();
            let partners = $('input[name=recipients]:checked').val();
            let operator = $('#recipientsOP').is(':checked');
            let templateSubject = $("#templateSubject").val();
            let keyAction = $("#action").val();
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
            ajaxCall('<?= route_to("operator.alertTemplate.update") ?>', {
                alertType,
                templateName,
                template,
                notificationAction,
                partners,
                roles,
                notificationTime,
                templateSubject,
                keyAction,
                frequency,
                operator,
                templateId: '<?= $template['id'] ?>'
            }).then(response => {
                $("#pageloader").hide();
                if (response.status === 'success') {
                    showSuccessToast(response.message);
                    setTimeout(() => {
                       window.location.reload()
                    }, 2000)
                } else {
                    showDangerToast(response.message);
                }
            }).catch(err => {
                $("#pageloader").hide();
                showDangerToast(err.message || 'Unable to update alert template');
            })

        }


    </script>
<?= $this->endSection() ?>