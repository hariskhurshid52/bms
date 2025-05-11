<?= $this->extend('common/default') ?>
<?= $this->section('styles') ?>

<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title"> Setup Designated Email Addresses </h4>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <div class="p-2">

                            <form class="form-horizontal" role="form">
                                <div class="mb-2 row">
                                    <label class="col-md-4 col-form-label" for="reservedNotification">Order Reserved
                                        Notification</label>
                                    <div class="repeater col-md-8" data-repeater="reservedNotification">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div data-repeater-list="lsEmails">
                                                    <?php if (isset($emailConfigs['reserved_short_code']) && !empty($emailConfigs['reserved_short_code'])): ?>
                                                        <?php foreach ($emailConfigs['reserved_short_code'] as $email): ?>
                                                            <div data-repeater-item class="row mb-2">
                                                                <div class="col-md-10">
                                                                    <input type="text" class="form-control" name="email"
                                                                        value="<?= $email ?>" />
                                                                </div>

                                                                <div
                                                                    class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                    <button data-repeater-delete type="button"
                                                                        class="btn btn-danger btn-xs"><i
                                                                            class="mdi mdi-trash-can"></i></button>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <div data-repeater-item class="row mb-2">
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="email" />
                                                            </div>

                                                            <div
                                                                class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                <button data-repeater-delete type="button"
                                                                    class="btn btn-danger btn-xs"><i
                                                                        class="mdi mdi-trash-can"></i></button>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>


                                            </div>
                                            <div class="col-md-2 d-flex align-items-start align-items-center">
                                                <button data-repeater-create type="button"
                                                    class="btn btn-success btn-xs"><i class="mdi mdi-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-4 col-form-label" for="newOrderNotification">New Order
                                        Notification</label>
                                    <div class="repeater col-md-8" data-repeater="newOrderNotification">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div data-repeater-list="lsEmails">
                                                    <?php if (isset($emailConfigs['new_order']) && !empty($emailConfigs['new_order'])): ?>
                                                        <?php foreach ($emailConfigs['new_order'] as $email): ?>
                                                            <div data-repeater-item class="row mb-2">
                                                                <div class="col-md-10">
                                                                    <input type="text" class="form-control" name="email"
                                                                        value="<?= $email ?>" />
                                                                </div>

                                                                <div
                                                                    class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                    <button data-repeater-delete type="button"
                                                                        class="btn btn-danger btn-xs"><i
                                                                            class="mdi mdi-trash-can"></i></button>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <div data-repeater-item class="row mb-2">
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="email" />
                                                            </div>

                                                            <div
                                                                class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                <button data-repeater-delete type="button"
                                                                    class="btn btn-danger btn-xs"><i
                                                                        class="mdi mdi-trash-can"></i></button>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>


                                            </div>
                                            <div class="col-md-2 d-flex align-items-start align-items-center">
                                                <button data-repeater-create type="button"
                                                    class="btn btn-success btn-xs"><i class="mdi mdi-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-4 col-form-label" for="processingOrderNotification">Order
                                        Processing Notification</label>
                                    <div class="repeater col-md-8" data-repeater="processingOrderNotification">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div data-repeater-list="lsEmails">
                                                    <?php if (isset($emailConfigs['process_order']) && !empty($emailConfigs['process_order'])): ?>
                                                        <?php foreach ($emailConfigs['process_order'] as $email): ?>
                                                            <div data-repeater-item class="row mb-2">
                                                                <div class="col-md-10">
                                                                    <input type="text" class="form-control" name="email"
                                                                        value="<?= $email ?>" />
                                                                </div>

                                                                <div
                                                                    class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                    <button data-repeater-delete type="button"
                                                                        class="btn btn-danger btn-xs"><i
                                                                            class="mdi mdi-trash-can"></i></button>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <div data-repeater-item class="row mb-2">
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="email" />
                                                            </div>

                                                            <div
                                                                class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                <button data-repeater-delete type="button"
                                                                    class="btn btn-danger btn-xs"><i
                                                                        class="mdi mdi-trash-can"></i></button>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>


                                            </div>
                                            <div class="col-md-2 d-flex align-items-start align-items-center">
                                                <button data-repeater-create type="button"
                                                    class="btn btn-success btn-xs"><i class="mdi mdi-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-4 col-form-label" for="liveShortCodeNotification">Live
                                        Shortcode Notification</label>
                                    <div class="repeater col-md-8" data-repeater="liveShortCodeNotification">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div data-repeater-list="lsEmails">
                                                    <?php if (isset($emailConfigs['live_order']) && !empty($emailConfigs['live_order'])): ?>
                                                        <?php foreach ($emailConfigs['live_order'] as $email): ?>
                                                            <div data-repeater-item class="row mb-2">
                                                                <div class="col-md-10">
                                                                    <input type="text" class="form-control" name="email"
                                                                        value="<?= $email ?>" />
                                                                </div>

                                                                <div
                                                                    class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                    <button data-repeater-delete type="button"
                                                                        class="btn btn-danger btn-xs"><i
                                                                            class="mdi mdi-trash-can"></i></button>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <div data-repeater-item class="row mb-2">
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="email" />
                                                            </div>

                                                            <div
                                                                class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                <button data-repeater-delete type="button"
                                                                    class="btn btn-danger btn-xs"><i
                                                                        class="mdi mdi-trash-can"></i></button>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>


                                            </div>
                                            <div class="col-md-2 d-flex align-items-start align-items-center">
                                                <button data-repeater-create type="button"
                                                    class="btn btn-success btn-xs"><i class="mdi mdi-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-4 col-form-label" for="cancelShortCodeNotification">Cancel
                                        Order Notification</label>
                                    <div class="repeater col-md-8" data-repeater="cancelShortCodeNotification">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div data-repeater-list="lsEmails">
                                                    <?php if (isset($emailConfigs['cancel_order']) && !empty($emailConfigs['cancel_order'])): ?>
                                                        <?php foreach ($emailConfigs['cancel_order'] as $email): ?>
                                                            <div data-repeater-item class="row mb-2">
                                                                <div class="col-md-10">
                                                                    <input type="text" class="form-control" name="email"
                                                                        value="<?= $email ?>" />
                                                                </div>

                                                                <div
                                                                    class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                    <button data-repeater-delete type="button"
                                                                        class="btn btn-danger btn-xs"><i
                                                                            class="mdi mdi-trash-can"></i></button>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <div data-repeater-item class="row mb-2">
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="email" />
                                                            </div>

                                                            <div
                                                                class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                <button data-repeater-delete type="button"
                                                                    class="btn btn-danger btn-xs"><i
                                                                        class="mdi mdi-trash-can"></i></button>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>


                                            </div>
                                            <div class="col-md-2 d-flex align-items-start align-items-center">
                                                <button data-repeater-create type="button"
                                                    class="btn btn-success btn-xs"><i class="mdi mdi-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-4 col-form-label" for="migratonRequestNotification">Migration
                                        Request Notification</label>
                                    <div class="repeater col-md-8" data-repeater="migratonRequestNotification">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div data-repeater-list="lsEmails">
                                                    <?php if (isset($emailConfigs['migration_order']) && !empty($emailConfigs['migration_order'])): ?>
                                                        <?php foreach ($emailConfigs['migration_order'] as $email): ?>
                                                            <div data-repeater-item class="row mb-2">
                                                                <div class="col-md-10">
                                                                    <input type="text" class="form-control" name="email"
                                                                        value="<?= $email ?>" />
                                                                </div>

                                                                <div
                                                                    class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                    <button data-repeater-delete type="button"
                                                                        class="btn btn-danger btn-xs"><i
                                                                            class="mdi mdi-trash-can"></i></button>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <div data-repeater-item class="row mb-2">
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="email" />
                                                            </div>

                                                            <div
                                                                class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                <button data-repeater-delete type="button"
                                                                    class="btn btn-danger btn-xs"><i
                                                                        class="mdi mdi-trash-can"></i></button>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>


                                            </div>
                                            <div class="col-md-2 d-flex align-items-start align-items-center">
                                                <button data-repeater-create type="button"
                                                    class="btn btn-success btn-xs"><i class="mdi mdi-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-4 col-form-label"
                                        for="cancelMigratonRequestNotification">Cancel Migration Request
                                        Notification</label>
                                    <div class="repeater col-md-8" data-repeater="cancelMigratonRequestNotification">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div data-repeater-list="lsEmails">
                                                    <?php if (isset($emailConfigs['cancel_migraiton']) && !empty($emailConfigs['cancel_migraiton'])): ?>
                                                        <?php foreach ($emailConfigs['cancel_migraiton'] as $email): ?>
                                                            <div data-repeater-item class="row mb-2">
                                                                <div class="col-md-10">
                                                                    <input type="text" class="form-control" name="email"
                                                                        value="<?= $email ?>" />
                                                                </div>

                                                                <div
                                                                    class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                    <button data-repeater-delete type="button"
                                                                        class="btn btn-danger btn-xs"><i
                                                                            class="mdi mdi-trash-can"></i></button>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <div data-repeater-item class="row mb-2">
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="email" />
                                                            </div>

                                                            <div
                                                                class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                <button data-repeater-delete type="button"
                                                                    class="btn btn-danger btn-xs"><i
                                                                        class="mdi mdi-trash-can"></i></button>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>


                                            </div>
                                            <div class="col-md-2 d-flex align-items-start align-items-center">
                                                <button data-repeater-create type="button"
                                                    class="btn btn-success btn-xs"><i class="mdi mdi-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-4 col-form-label"
                                        for="migratonApprovalRequestNotification">Migration Approval Request
                                        Notification</label>
                                    <div class="repeater col-md-8" data-repeater="migratonApprovalRequestNotification">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div data-repeater-list="lsEmails">
                                                    <?php if (isset($emailConfigs['approve_migraiton']) && !empty($emailConfigs['approve_migraiton'])): ?>
                                                        <?php foreach ($emailConfigs['approve_migraiton'] as $email): ?>
                                                            <div data-repeater-item class="row mb-2">
                                                                <div class="col-md-10">
                                                                    <input type="text" class="form-control" name="email"
                                                                        value="<?= $email ?>" />
                                                                </div>

                                                                <div
                                                                    class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                    <button data-repeater-delete type="button"
                                                                        class="btn btn-danger btn-xs"><i
                                                                            class="mdi mdi-trash-can"></i></button>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <div data-repeater-item class="row mb-2">
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="email" />
                                                            </div>

                                                            <div
                                                                class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                <button data-repeater-delete type="button"
                                                                    class="btn btn-danger btn-xs"><i
                                                                        class="mdi mdi-trash-can"></i></button>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>


                                            </div>
                                            <div class="col-md-2 d-flex align-items-start align-items-center">
                                                <button data-repeater-create type="button"
                                                    class="btn btn-success btn-xs"><i class="mdi mdi-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-4 col-form-label"
                                        for="submissionCycleUpdateNotification">Submission Cycle Notification</label>
                                    <div class="repeater col-md-8" data-repeater="submissionCycleUpdateNotification">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div data-repeater-list="lsEmails">
                                                    <?php if (isset($emailConfigs['submission_cycle_update']) && !empty($emailConfigs['submission_cycle_update'])): ?>
                                                        <?php foreach ($emailConfigs['submission_cycle_update'] as $email): ?>
                                                            <div data-repeater-item class="row mb-2">
                                                                <div class="col-md-10">
                                                                    <input type="text" class="form-control" name="email"
                                                                        value="<?= $email ?>" />
                                                                </div>

                                                                <div
                                                                    class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                    <button data-repeater-delete type="button"
                                                                        class="btn btn-danger btn-xs"><i
                                                                            class="mdi mdi-trash-can"></i></button>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <div data-repeater-item class="row mb-2">
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="email" />
                                                            </div>

                                                            <div
                                                                class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                <button data-repeater-delete type="button"
                                                                    class="btn btn-danger btn-xs"><i
                                                                        class="mdi mdi-trash-can"></i></button>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>


                                            </div>
                                            <div class="col-md-2 d-flex align-items-start align-items-center">
                                                <button data-repeater-create type="button"
                                                    class="btn btn-success btn-xs"><i class="mdi mdi-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-4 col-form-label"
                                        for="deliveryCycleUpdateNotification">Delivery Cycle Notification</label>
                                    <div class="repeater col-md-8" data-repeater="deliveryCycleUpdateNotification">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div data-repeater-list="lsEmails">
                                                    <?php if (isset($emailConfigs['delivery_cycle_update']) && !empty($emailConfigs['delivery_cycle_update'])): ?>
                                                        <?php foreach ($emailConfigs['delivery_cycle_update'] as $email): ?>
                                                            <div data-repeater-item class="row mb-2">
                                                                <div class="col-md-10">
                                                                    <input type="text" class="form-control" name="email"
                                                                        value="<?= $email ?>" />
                                                                </div>

                                                                <div
                                                                    class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                    <button data-repeater-delete type="button"
                                                                        class="btn btn-danger btn-xs"><i
                                                                            class="mdi mdi-trash-can"></i></button>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <div data-repeater-item class="row mb-2">
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="email" />
                                                            </div>

                                                            <div
                                                                class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                <button data-repeater-delete type="button"
                                                                    class="btn btn-danger btn-xs"><i
                                                                        class="mdi mdi-trash-can"></i></button>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>


                                            </div>
                                            <div class="col-md-2 d-flex align-items-start align-items-center">
                                                <button data-repeater-create type="button"
                                                    class="btn btn-success btn-xs"><i class="mdi mdi-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-4 col-form-label" for="submissionDateNotification">Submission
                                        Date Notification</label>
                                    <div class="repeater col-md-8" data-repeater="submissionDateNotification">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div data-repeater-list="lsEmails">
                                                    <?php if (isset($emailConfigs['submission_date_reminder']) && !empty($emailConfigs['submission_date_reminder'])): ?>
                                                        <?php foreach ($emailConfigs['submission_date_reminder'] as $email): ?>
                                                            <div data-repeater-item class="row mb-2">
                                                                <div class="col-md-10">
                                                                    <input type="text" class="form-control" name="email"
                                                                        value="<?= $email ?>" />
                                                                </div>

                                                                <div
                                                                    class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                    <button data-repeater-delete type="button"
                                                                        class="btn btn-danger btn-xs"><i
                                                                            class="mdi mdi-trash-can"></i></button>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <div data-repeater-item class="row mb-2">
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="email" />
                                                            </div>

                                                            <div
                                                                class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                <button data-repeater-delete type="button"
                                                                    class="btn btn-danger btn-xs"><i
                                                                        class="mdi mdi-trash-can"></i></button>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>


                                            </div>
                                            <div class="col-md-2 d-flex align-items-start align-items-center">
                                                <button data-repeater-create type="button"
                                                    class="btn btn-success btn-xs"><i class="mdi mdi-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-4 col-form-label" for="deliveryDateNotification">Delivery Date
                                        Notification</label>
                                    <div class="repeater col-md-8" data-repeater="deliveryDateNotification">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div data-repeater-list="lsEmails">
                                                    <?php if (isset($emailConfigs['delivery_date_reminder']) && !empty($emailConfigs['delivery_date_reminder'])): ?>
                                                        <?php foreach ($emailConfigs['delivery_date_reminder'] as $email): ?>
                                                            <div data-repeater-item class="row mb-2">
                                                                <div class="col-md-10">
                                                                    <input type="text" class="form-control" name="email"
                                                                        value="<?= $email ?>" />
                                                                </div>

                                                                <div
                                                                    class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                    <button data-repeater-delete type="button"
                                                                        class="btn btn-danger btn-xs"><i
                                                                            class="mdi mdi-trash-can"></i></button>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <div data-repeater-item class="row mb-2">
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="email" />
                                                            </div>

                                                            <div
                                                                class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                                <button data-repeater-delete type="button"
                                                                    class="btn btn-danger btn-xs"><i
                                                                        class="mdi mdi-trash-can"></i></button>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>


                                            </div>
                                            <div class="col-md-2 d-flex align-items-start align-items-center">
                                                <button data-repeater-create type="button"
                                                    class="btn btn-success btn-xs"><i class="mdi mdi-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary float-right mt-4" onclick="setUp()">Add
                                    Configurations
                                </button>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="<?= base_url() ?>assets/js/jquery.repeater.min.js"></script>

<script>
    $(document).ready(function () {
        $('.repeater').repeater({
            initEmpty: false,
            isFirstItemUndeletable: true
        })
    })
    setUp = () => {
        const repReservedNotification = $('[data-repeater="reservedNotification"]').repeaterVal(),
            repNewOrderNotification = $('[data-repeater="newOrderNotification"]').repeaterVal(),
            repProcessing = $('[data-repeater="processingOrderNotification"]').repeaterVal(),
            repLive = $('[data-repeater="liveShortCodeNotification"]').repeaterVal(),
            repCancel = $('[data-repeater="cancelShortCodeNotification"]').repeaterVal(),
            repMigration = $('[data-repeater="migratonRequestNotification"]').repeaterVal(),
            repCancelMigration = $('[data-repeater="cancelMigratonRequestNotification"]').repeaterVal(),
            repApprovalMigration = $('[data-repeater="migratonApprovalRequestNotification"]').repeaterVal(),
            repSubmissionCycleUpdate = $('[data-repeater="submissionCycleUpdateNotification"]').repeaterVal(),
            repDeliveryCycleUpdate = $('[data-repeater="deliveryCycleUpdateNotification"]').repeaterVal(),
            repSubmission = $('[data-repeater="submissionDateNotification"]').repeaterVal(),
            repDelivery = $('[data-repeater="deliveryDateNotification"]').repeaterVal();

        let reserved = [], newOrders = [], processing = [], live = [], cancel = [], migration = [],
            cancelMigration = [], approvalMigration = [], submissionUpdate = [], deliveryUpdate = [],
            submissionReminder = [], deliveryReminder = [];

        for (const input of repReservedNotification.lsEmails) {
            if (input.email) {
                reserved.push(input.email);
            }
        }

        for (const input of repNewOrderNotification.lsEmails) {
            if (input.email) {
                newOrders.push(input.email);
            }
        }

        for (const input of repProcessing.lsEmails) {
            if (input.email) {
                processing.push(input.email);
            }
        }

        for (const input of repLive.lsEmails) {
            if (input.email) {
                live.push(input.email);
            }
        }

        for (const input of repCancel.lsEmails) {
            if (input.email) {
                cancel.push(input.email);
            }
        }

        for (const input of repMigration.lsEmails) {
            if (input.email) {
                migration.push(input.email);
            }
        }

        for (const input of repCancelMigration.lsEmails) {
            if (input.email) {
                cancelMigration.push(input.email);
            }
        }

        for (const input of repApprovalMigration.lsEmails) {
            if (input.email) {
                approvalMigration.push(input.email);
            }
        }

        for (const input of repSubmissionCycleUpdate.lsEmails) {
            if (input.email) {
                submissionUpdate.push(input.email);
            }
        }

        for (const input of repDeliveryCycleUpdate.lsEmails) {
            if (input.email) {
                deliveryUpdate.push(input.email);
            }
        }

        for (const input of repSubmission.lsEmails) {
            if (input.email) {
                submissionReminder.push(input.email);
            }
        }

        for (const input of repDelivery.lsEmails) {
            if (input.email) {
                deliveryReminder.push(input.email);
            }
        }

        $("#pageloader").show()

        ajaxCall('<?= route_to('partner.alert.emailConfig.store') ?>', {
            reserved, newOrders, processing, live, cancel, migration,
            cancelMigration, approvalMigration, submissionUpdate, deliveryUpdate,
            submissionReminder, deliveryReminder
        }).then(response => {
            $("#pageloader").hide()
            if (response.status === "success") {
                showSuccessToast(response.message);
            } else {
                showDangerToast(response.message);
            }

            setTimeout(() => {
                // window.location.reload()
            }, 2000)
        }).catch(err => {
            $("#pageloader").hide()
            showDangerToast("Invalid server response, Please try again")
        })

    }
</script>
<?= $this->endSection() ?>