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

<?= $this->extend('common/default-nav') ?>
<?= $this->section('content') ?>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">
                    Edit Booking
                    <a href="<?= route_to('admin.orders.list') ?>" class="btn btn-primary btn-sm float-end">List All Bookings</a>
                </h4>
                <hr/>
                <form action="<?= route_to('admin.order.update') ?>" method="POST">
                    <?= csrf_field() ?>
                    <?= form_hidden('order_id', $order['id']) ?>
                    <!-- Section: Booking Details -->
                    <div class="form-section-title"><i class="bi bi-clipboard-check"></i> Booking Details</div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="billboard" class="form-label"> <strong class="text-danger">*</strong> Select Hoarding</label>
                            <select class="form-control select2" id="billboard" name="billboard">
                                <?php foreach ($billboards as $t => $types): ?>
                                    <optgroup label="<?= $t ?>">
                                        <?php foreach ($types as $billboard): ?>
                                            <option value="<?= $billboard['id'] ?>" <?= $order['billboard_id'] == $billboard['id'] ? 'selected' : '' ?>>
                                                <?= $billboard['name'] . ' (' . $billboard['area'] . ')' ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="display" class="form-label">Display (Brand/Campaign)</label>
                            <input type="text" class="form-control" id="display" name="display" value="<?= $order['display'] ?>"/>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="customer" class="form-label"> <strong class="text-danger">*</strong> Select Client</label>
                            <select class="form-control select2" id="customer" name="customer">
                                <?php foreach ($customers as $customer): ?>
                                    <option value="<?= $customer['id'] ?>" <?= $order['customer_id'] == $customer['id'] ? 'selected' : '' ?>>
                                        <?= $customer['first_name'] . ' ' . ($customer['customer_type'] === "agency" ? '(Agency)' : '') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- Section: Reservation Dates -->
                    <div class="form-section-title"><i class="bi bi-calendar-event"></i> Reservation Dates</div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="reservationStart" class="form-label"> <strong class="text-danger">*</strong> Reservation Start From</label>
                            <div class="input-group position-relative datepicker" id="resSPicker">
                                <input type="text" class="form-control" id="reservationStart" name="reservationStart" readonly data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-date-container="#resSPicker" value="<?= date('Y-m-d', strtotime($order['start_date'])) ?>">
                                <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="reservationEnd" class="form-label"> <strong class="text-danger">*</strong> Reservation End At</label>
                            <div class="input-group position-relative datepicker" id="resEPicker">
                                <input type="text" class="form-control" id="reservationEnd" name="reservationEnd" readonly data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-date-container="#resEPicker" value="<?= date('Y-m-d', strtotime($order['end_date'])) ?>">
                                <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                            </div>
                        </div>
                    </div>
                    <!-- Section: Additional Information -->
                    <div class="form-section-title"><i class="bi bi-info-circle"></i> Additional Information</div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label for="additionalInformation" class="form-label"> <strong class="text-danger">*</strong> Additional Information</label>
                            <textarea class="form-control" id="additionalInformation" name="addtionalInformatoin"><?= $order['addtional_info'] ?></textarea>
                        </div>
                    </div>
                    <!-- Section: Payment Information -->
                    <div class="form-section-title"><i class="bi bi-cash-coin"></i> Payment Information</div>
                    <div class="row">
                        <div class="col-md-5 mb-2">
                            <label for="totalCost" class="form-label"> <strong class="text-danger">*</strong> Total Cost For Selected Time Period <span class="booking-price"><sup class="text-info"><i>min booking price : <?= $order['booking_price'] ?> </i></sup></span></label>
                            <input type="number" class="form-control" id="totalCost" name="totalCost" value="<?= $order['amount'] ?>"/>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="taxPercent" class="form-label">Tax 16(%)</label>
                            <input type="number" step="0.01" readonly class="form-control" id="taxAmount" name="taxAmount" value="<?= $order['tax_amount'] ?>"/>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="totalPriceInclTax" class="form-label"> <strong class="text-danger">*</strong> Total Price Including Tax</label>
                            <input type="number" step="0.01" readonly class="form-control" id="totalPriceInclTax" name="totalPriceInclTax" value="<?= $order['total_price'] ?>"/>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="paymentMethod" class="form-label"> <strong class="text-danger">*</strong> Payment Method</label>
                            <select class="form-control" name="paymentMethod" id="paymentMethod">
                                <?php foreach (['full' => 'Full Payment Cash', 'installment' => 'Installment', 'cross_cheque' => 'Through Cross Cheque'] as $k => $v): ?>
                                    <option value="<?= $k ?>" <?= $order['payment_method'] == $k ? 'selected' : '' ?>><?= $v ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="advPayment" class="form-label"> <strong class="text-danger">*</strong> Advance Payment</label>
                            <input type="number" class="form-control" id="advPayment" name="advPayment" value="<?= $order['advPayment'] ?>"/>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="paymentDueDate" class="form-label"> <strong class="text-danger">*</strong> Payment Due Date</label>
                            <div class="input-group position-relative datepicker" id="resDueDate">
                                <input type="text" class="form-control" id="paymentDueDate" name="paymentDueDate" readonly data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-date-container="#resDueDate" value="<?= date('Y-m-d', strtotime($order['payment_due_date'])) ?>">
                                <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary float-end">Update Booking</button>
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
        $("#billboard").change(function () {
            getBillboards($(this).val());
        });

        $('#totalCost').keyup(function(){
            const totalCost = parseFloat($(this).val());
            if (!isNaN(totalCost)) {
                const tax = (totalCost * 0.16).toFixed(2);
                const totalWithTax = (totalCost + parseFloat(tax)).toFixed(2);

                $('#taxAmount').val(tax);
                $('#totalPriceInclTax').val(totalWithTax);
            } else {
                $('#taxAmount').val('0.00');
                $('#totalPriceInclTax').val('0.00');
            }
        });

        <?php if ($order['billboard_id']): ?>
        getBillboards('<?= $order['billboard_id'] ?>');
        <?php endif; ?>
    });

    const getBillboards = (id) => {
        if (!id) return;
        $('.booking-price').html(`<sup class="text-info"><i>min booking price : 0000 </i></sup>`);

        ajaxCall('<?= route_to('admin.billboard.get.ajax') ?>', { hording: id })
            .then((response) => {
                if (response.data) {
                    $('.booking-price').html(`<sup class="text-info"><i>min booking price : ${response.data.booking_price} PKR </i></sup>`);
                }
            })
            .catch(err => console.log(err));
    }
</script>
<?= $this->endSection() ?>
