<?= $this->section('styles') ?>
<style>
    .form-section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #256029;
        border-left: 4px solid #388e3c;
        padding-left: 12px;
        margin-top: 32px;
        margin-bottom: 18px;
        background: linear-gradient(90deg, #e8f5e9 0%, #fff 100%);
        border-radius: 4px;
    }
</style>
<?= $this->endSection() ?>
<?= $this->extend('common/default-nav'); ?> <?= $this->section('content') ?>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">New Expense <a href="<?= route_to('admin.expense.list') ?>"
                                                            class="btn btn-primary btn-sm pull-right"
                                                            role="button">List All</a></h4>
                    <hr/>
                    <form action="<?= route_to('admin.expense.store') ?>" method="POST"
                          class="tab-content twitter-bs-wizard-tab-content">
                        <?= csrf_field() ?>
                        <!-- Section: Expense Details -->
                        <div class="form-section-title"><i class="bi bi-cash-coin"></i> Expense Details</div>
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label for="type" class="form-label"> <strong class="text-danger">*</strong> Type</label>
                                <select class="form-control select2" id="type" data-placeholder="Select Expense Type" name="type">
                                    <?php foreach ([ 'billboard' => 'Billboard', 'other' => 'Other' ] as $t => $type): ?>
                                        <option value="<?= $t ?>" <?= old('type') == $t ? 'selected' : '' ?>><?= $type ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-12 mb-2" id="cntBillboard">
                                <label for="billboard" class="form-label">Select Billboard</label>
                                <select class="form-control select2" id="billboard" data-placeholder="Select billboard" name="billboard">
                                    <?php foreach ($billboards as $t => $types): ?>
                                        <optgroup label="<?= $t ?>">
                                            <?php foreach ($types as $billboard): ?>
                                                <option value="<?= $billboard['id'] ?>" <?= old('billboard') == $billboard['id'] ? 'selected' : '' ?>>
                                                    <?= $billboard['name'] . ' ( ' . $billboard['area'] . ' )' ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="amount" class="form-label"> <strong class="text-danger">*</strong> Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount" value="<?= old('amount') ?? '0.00' ?>"/>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="addtionalInformatoin" class="form-label">Additional Information</label>
                                <textarea class="form-control" id="addtionalInformatoin" name="addtionalInformatoin"><?= old('addtionalInformatoin') ?></textarea>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="expense_date" class="form-label"> <strong class="text-danger">*</strong> Expense Date</label>
                                <div class="input-group position-relative datepicker" id="expensePicker">
                                    <input autocomplete="off" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-date-container="#expensePicker" type="text" class="form-control" id="expenseDate" name="expenseDate" readonly value="<?= old('expenseDate', date('Y-m-d', strtotime('now'))) ?>">
                                    <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary float-end">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    $(document).ready(function () {
        $('#type').change(function () {
            if($(this).val() !== "billboard"){
                $("#cntBillboard").hide();
            } else {
                $("#cntBillboard").show();
            }
        });
    })
</script>
<?= $this->endSection() ?>