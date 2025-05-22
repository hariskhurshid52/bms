<?= $this->section('styles') ?>
<?= $this->endSection() ?>
<?= $this->extend('common/default-nav'); ?> <?= $this->section('content') ?>


    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Update Expense <a href="<?= route_to('admin.expense.list') ?>"
                                                            class="btn btn-primary btn-sm pull-right"
                                                            role="button">List All</a></h4>
                    <hr/>
                    <div class="row">
                        <form action="<?= route_to('admin.expense.update') ?>" method="POST"
                              class="tab-content twitter-bs-wizard-tab-content">

                            <?= csrf_field() ?>
                            <?= form_hidden('expense_id', $expense['id'])?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-2">
                                        <label for="type" class="form-label"> <strong class="text-danger">*</strong> Type</label>
                                        <select class="form-control select2" id="type"
                                                data-placeholder="Select Expense Type"
                                                name="type">

                                            <?php foreach ([
                                                               'billboard' => 'Billboard',
                                                               'other' => 'Other'
                                                           ] as $t => $type): ?>
                                                <option value="<?= $t ?>"
                                                    <?= $expense['type'] == $t ? 'selected' : '' ?>>
                                                    <?= $type ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div id="cntBillboard" style="display:<?=$expense['type']==='billboard'?'block':'none'?>;">
                                        <div class="mb-2">
                                            <label for="billboard" class="form-label">Select
                                                Billboard</label>
                                            <select class="form-control select2" id="billboard"
                                                    data-placeholder="Select billboard"
                                                    name="billboard">

                                                <?php foreach ($billboards as $t => $types): ?>
                                                    <optgroup label="<?= $t ?>">
                                                        <?php foreach ($types as $billboard): ?>
                                                            <option value="<?= $billboard['id'] ?>"
                                                                <?= $expense['billboard_id'] == $billboard['id'] ? 'selected' : '' ?>>
                                                                <?= $billboard['name'] . ' ( ' . $billboard['area'] . ' )' ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </optgroup>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label for="amount" class="form-label"> <strong class="text-danger">*</strong> Amount</label>
                                        <input type="number" class="form-control" id="amount"
                                               name="amount" value="<?= $expense['amount'] ?? '0.00' ?>"/>
                                    </div>
                                    <div class="mb-2">
                                        <label for="addtionalInformatoin" class="form-label">Additional
                                            Information</label>
                                        <textarea class="form-control" id="addtionalInformatoin"
                                                  name="addtionalInformatoin"><?=$expense['addtional_info'] ?></textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label for="expense_date" class="form-label"> <strong class="text-danger">*</strong> Expense Date</label>
                                        <div class="input-group position-relative datepicker"
                                             id="expensePicker">
                                            <input autocomplete="off" data-provide="datepicker"
                                                   data-date-format="yyyy-mm-dd"
                                                   data-date-autoclose="true"
                                                   data-date-container="#expensePicker" type="text"
                                                   class="form-control" id="expenseDate"
                                                   name="expenseDate" readonly
                                                   value="<?= old('expenseDate', date('Y-m-d', strtotime($expense['expense_date'] ))) ?>">
                                            <span class="input-group-text"><i
                                                    class="ri-calendar-event-fill"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary pull-right ">Update</button>
                            </div>
                        </form>

                    </div>
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