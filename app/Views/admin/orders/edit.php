<?= $this->section('styles') ?>
<?= $this->endSection() ?>
<?= $this->extend('common/default-nav') ?>
<?= $this->section('content') ?>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">
                    Edit Booking
                    <a href="<?= route_to('admin.orders.list') ?>" class="btn btn-primary btn-sm float-end" role="button">List All</a>
                </h4>
                <hr/>
                <form action="<?= route_to('admin.order.update') ?>" method="POST">
                    <?= csrf_field() ?>
                    <?= form_hidden('order_id', $order['id']) ?>

                    <div class="mb-2">
                        <label for="billboard" class="form-label">Select Billboard</label>
                        <select class="form-control select2" id="billboard" name="billboard">
                            <?php foreach ($billboards as $t => $types): ?>
                                <optgroup label="<?= $t ?>">
                                    <?php foreach ($types as $billboard): ?>
                                        <option value="<?= $billboard['id'] ?>"
                                            <?= $order['billboard_id'] == $billboard['id'] ? 'selected' : '' ?>>
                                            <?= $billboard['name'] . ' (' . $billboard['area'] . ')' ?>
                                        </option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="customer" class="form-label">Select Client</label>
                        <select class="form-control select2" id="customer" name="customer">
                            <?php foreach ($customers as $customer): ?>
                                <option value="<?= $customer['id'] ?>"
                                    <?= $order['customer_id'] == $customer['id'] ? 'selected' : '' ?>>
                                    <?= $customer['first_name'] . ' ' . ($customer['customer_type'] === "agency" ? '(Agency)' : '') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="reservationStart" class="form-label">Reservation Start From</label>
                            <div class="input-group position-relative datepicker" id="resSPicker">
                                <input autocomplete="off" data-provide="datepicker"
                                       data-date-format="yyyy-mm-dd" data-date-autoclose="true"
                                       data-date-container="#resSPicker" type="text"
                                       class="form-control" id="reservationStart"
                                       name="reservationStart" readonly
                                       value="<?= date('Y-m-d', strtotime($order['start_date'])) ?>">
                                <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="reservationEnd" class="form-label">Reservation End At</label>
                            <div class="input-group position-relative datepicker" id="resEPicker">
                                <input autocomplete="off" data-provide="datepicker"
                                       data-date-format="yyyy-mm-dd" data-date-autoclose="true"
                                       data-date-container="#resEPicker" type="text"
                                       class="form-control" id="reservationEnd"
                                       name="reservationEnd" readonly
                                       value="<?= date('Y-m-d', strtotime($order['end_date'])) ?>">
                                <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="additionalInformation" class="form-label">Additional Information</label>
                        <textarea class="form-control" id="additionalInformation"
                                  name="addtionalInformatoin"><?= $order['addtional_info'] ?></textarea>
                    </div>

                    <h4 class="header-title mt-3">Payment Information</h4>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="totalCost" class="form-label">
                                Total Cost For Selected Time Period
                                <span class="booking-price">
                                    <sup class="text-info">
                                        <i>min booking price : <?= $order['booking_price'] ?> </i>
                                    </sup>
                                </span>
                            </label>
                            <input type="number" class="form-control" id="totalCost" name="totalCost"
                                   value="<?= $order['amount'] ?>" />
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="paymentMethod" class="form-label">Payment Method</label>
                            <select class="form-control" name="paymentMethod" id="paymentMethod">
                                <?php foreach (['full' => 'Full Payment Cash', 'installment' => 'Installment'] as $k => $v): ?>
                                    <option value="<?= $k ?>" <?= $order['payment_method'] == $k ? 'selected' : '' ?>>
                                        <?= $v ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-12 mb-2">
                            <label for="advPayment" class="form-label">Advance Payment</label>
                            <input type="number" class="form-control" id="advPayment"
                                   name="advPayment" value="<?= $order['advPayment'] ?>" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary float-end">Update Order</button>
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

        <?php if ($order['billboard_id']): ?>
        getBillboards('<?= $order['billboard_id'] ?>');
        <?php endif; ?>
    });

    const getBillboards = (id) => {
        if (!id) return;

        $('.booking-price').html(`<sup class="text-info"><i>min booking price : 0000 </i></sup>`);

        ajaxCall('<?= route_to('admin.billboard.get.ajax') ?>', {
            hording: id
        }).then((response) => {
            if (response.data) {
                $('.booking-price').html(`<sup class="text-info"><i>min booking price : ${response.data.booking_price} PKR </i></sup>`);
            }
        }).catch(err => console.log(err));
    }
</script>
<?= $this->endSection() ?>
