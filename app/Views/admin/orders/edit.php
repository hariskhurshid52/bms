<?= $this->section('styles') ?>
<?= $this->endSection() ?>
<?= $this->extend('common/default-nav') ?> <?= $this->section('content') ?>




<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="wiz-orders" class="twitter-bs-wizard form-wizard-header">
                            <ul class="twitter-bs-wizard-nav mb-2">
                                <li class="nav-item">
                                    <a href="#billing-info" class="nav-link" data-bs-toggle="tab" data-toggle="tab">
                                        <span class="number">01</span>
                                        <span class="d-none d-sm-inline">Order Info</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#payment-info" class="nav-link" data-bs-toggle="tab" data-toggle="tab">
                                        <span class="number">02</span>
                                        <span class="d-none d-sm-inline">Payment Info</span>
                                    </a>
                                </li>
                            </ul>

                            <form action="<?= route_to('admin.order.update') ?>" method="POST"
                                class="tab-content twitter-bs-wizard-tab-content">
                                <!-- CSRF Token (if using Laravel) -->
                                <?= csrf_field() ?>
                                <?= form_hidden('order_id', $order['id'])?>

                                <div class="tab-pane" id="billing-info">
                                    <div>
                                        <h4 class="header-title">Billing Information</h4>
                                        <p class="sub-header">Fill the form below in order to send you the order's
                                            invoice.</p>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-2">
                                                    <label for="billboard" class="form-label">Select Billboard</label>
                                                    <select class="form-control select2" id="billboard"
                                                        name="billboard">
                                                        <?php foreach ($billboards as $t => $types): ?>
                                                            <optgroup label="<?= $t ?>">
                                                                <?php foreach ($types as $billboard): ?>
                                                                    <option value="<?= $billboard['id'] ?>"
                                                                        <?= $order['billboard_id'] == $billboard['id'] ? 'selected' : '' ?>>
                                                                        <?= $billboard['name'] . ' ( ' . $billboard['area'] . ' )' ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </optgroup>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="mb-2">
                                                    <label for="customer" class="form-label">Select Customer</label>
                                                    <select class="form-control select2" id="customer" name="customer">
                                                        <?php foreach ($customers as $customer): ?>
                                                            <option value="<?= $customer['id'] ?>"
                                                                <?= $order['customer_id'] == $customer['id'] ? 'selected' : '' ?>>
                                                                <?= $customer['first_name'] . ' ' . $customer['last_name'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label for="reservationStart" class="form-label">Reservation Start
                                                        From</label>
                                                    <div class="input-group position-relative datepicker"
                                                        id="resSPicker">
                                                        <input autocomplete="off" data-provide="datepicker"
                                                            data-date-format="yyyy-mm-dd" data-date-autoclose="true"
                                                            data-date-container="#resSPicker" type="text"
                                                            class="form-control" id="reservationStart"
                                                            name="reservationStart" readonly
                                                            value="<?= date('Y-m-d', strtotime($order['start_date'])) ?>">
                                                        <span class="input-group-text"><i
                                                                class="ri-calendar-event-fill"></i></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label for="reservationEnd" class="form-label">Reservation End
                                                        At</label>
                                                    <div class="input-group position-relative datepicker"
                                                        id="resEPicker">
                                                        <input autocomplete="off" data-provide="datepicker"
                                                            data-date-format="yyyy-mm-dd" data-date-autoclose="true"
                                                            data-date-container="#resEPicker" type="text"
                                                            class="form-control" id="reservationEnd"
                                                            name="reservationEnd" readonly
                                                            value="<?= date('Y-m-d', strtotime($order['end_date'])) ?>">
                                                        <span class="input-group-text"><i
                                                                class="ri-calendar-event-fill"></i></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="mb-2">
                                                    <label for="addtionalInformatoin" class="form-label">Additional
                                                        Information</label>
                                                    <textarea class="form-control" id="addtionalInformatoin"
                                                        name="addtionalInformatoin"><?= $order['addtional_info'] ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="pager wizard list-inline mt-2">
                                        <li class="next list-inline-item float-end">
                                            <button type="button" class="btn btn-success"><i
                                                    class="mdi mdi-truck-fast me-1"></i> Proceed to Payments </button>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-pane" id="payment-info">
                                    <div>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label for="totalCost" class="form-label">Total Cost For Selected Time
                                                    Period <span class="booking-price"><sup
                                                                class="text-info"><i>min booking price : <?=$order['booking_price']?> </i></sup></span></label>
                                                <input type="number" class="form-control" id="totalCost"
                                                    name="totalCost" value="<?= $order['amount'] ?>" />
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <label for="paymentMethod" class="form-label">Payment Method</label>
                                                <select class="form-control" name="paymentMethod" id="paymentMethod">
                                                    <?php foreach (['full' => 'Full Payment Cash', 'installment' => 'Installment'] as $k => $v): ?>
                                                        <option value="<?= $k ?>" <?= $order['payment_method'] == $k ? 'selected' : '' ?>><?= $v ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="col-md-12 mb-2">
                                                <label for="advPayment" class="form-label">Advance Payment</label>
                                                <input type="number" class="form-control" id="advPayment"
                                                    name="advPayment" value="<?= $order['advPayment'] ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="pager wizard list-inline mt-3">
                                        <li class="list-inline-item float-end">
                                            <button type="submit" class="btn btn-success"><i
                                                    class="mdi mdi-cash-multiple me-1"></i> Complete Order </button>
                                        </li>
                                    </ul>
                                </div>
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
<script src="<?= base_url() ?>assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<script>
    $(document).ready(function () {
        $("#wiz-orders").bootstrapWizard({ tabClass: "nav nav-pills nav-justified" });
        $("#billboard").change(function () {
            getBillboards(id = $(this).val())
        })


    });
    const getBillboards = (id) => {
        if (!id) {
            return
        }
        $('.booking-price').html(`<sup class="text-info" ><i>min booking price : 0000 </i></sup>`)

        ajaxCall('<?=route_to('admin.billboard.get.ajax')?>', {
            hording: id
        }).then((response) => {
            if (response.data) {
                $('.booking-price').html(`<sup class="text-info" ><i>min booking price : ${response.data.booking_price} </i></sup>`)
            }

        }).catch(err => {
            console.log(err)
        })
    }

</script>
<?= $this->endSection() ?>