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
<?= $this->extend('common/default-nav');?> <?= $this->section('content') ?>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">New Booking <a href="<?= route_to('admin.orders.list') ?>"
                                                                      class="btn btn-primary btn-sm pull-right"
                                                                      role="button">List All Bookings</a></h4>
                    <hr/>
                    <form action="<?= route_to('admin.order.store') ?>" method="POST"
                          class="tab-content twitter-bs-wizard-tab-content">
                        <?= csrf_field() ?>
                        <!-- Section: Booking Details -->
                        <div class="form-section-title"><i class="bi bi-clipboard-check"></i> Booking Details</div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="billboard" class="form-label"> <strong class="text-danger">*</strong> Select Hoarding</label>
                                <select class="form-control select2" id="billboard" data-placeholder="Select hoarding" name="billboard">
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
                            <div class="col-md-6 mb-2">
                                <label for="display" class="form-label">Display (Brand/Campaign)</label>
                                <input type="text" class="form-control" id="display" name="display" value="<?= old('display') ?>"/>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="customer" class="form-label"> <strong class="text-danger">*</strong> Select Client</label>
                                <select class="form-control select2" id="customer" name="customer">
                                    <?php foreach ($customers as $customer): ?>
                                        <option value="<?= $customer['id'] ?>" <?= old('customer') == $customer['id'] ? 'selected' : '' ?>>
                                            <?= $customer['first_name'] . ' ' . ($customer['customer_type'] === "agency" ? ' (Agency) ':'') ?>
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
                                    <input autocomplete="off" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-date-container="#resSPicker" type="text" class="form-control" id="reservationStart" name="reservationStart" readonly value="<?= old('reservationStart', date('Y-m-d', strtotime('now'))) ?>">
                                    <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="reservationEnd" class="form-label"> <strong class="text-danger">*</strong> Reservation End At</label>
                                <div class="input-group position-relative datepicker" id="resEPicker">
                                    <input autocomplete="off" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-date-container="#resEPicker" type="text" class="form-control" id="reservationEnd" name="reservationEnd" readonly value="<?= old('reservationEnd', date('Y-m-d', strtotime('+10 days'))) ?>">
                                    <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                                </div>
                            </div>
                        </div>
                        <!-- Section: Additional Information -->
                        <div class="form-section-title"><i class="bi bi-info-circle"></i> Additional Information</div>
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label for="addtionalInformatoin" class="form-label"> <strong class="text-danger">*</strong> Additional Information</label>
                                <textarea class="form-control" id="addtionalInformatoin" name="addtionalInformatoin"><?= old('addtionalInformatoin') ?></textarea>
                            </div>
                        </div>
                        <!-- Section: Payment Information -->
                        <div class="form-section-title"><i class="bi bi-cash-coin"></i> Payment Information</div>
                        <div class="row">
                            <div class="col-md-5 mb-2">
                                <label for="totalCost" class="form-label"> <strong class="text-danger">*</strong> Total Cost For Selected Time Period <span class="booking-price"><sup class="text-info"><i>min booking price : 0000 </i></sup></span></label>
                                <input type="number" class="form-control" id="totalCost" name="totalCost" value="<?= old('totalCost', '0.00') ?>"/>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="taxAmount" class="form-label"> <strong class="text-danger">*</strong> Tax 16(%)</label>
                                <input type="number" step="0.01" readonly class="form-control" id="taxAmount" name="taxAmount" value="<?= old('taxAmount', '0.00') ?>"/>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="totalPriceInclTax" class="form-label"> <strong class="text-danger">*</strong> Total Price Including Tax</label>
                                <input type="number" step="0.01" readonly class="form-control" id="totalPriceInclTax" name="totalPriceInclTax" value="<?= old('totalPriceInclTax', '0.00') ?>"/>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="paymentMethod" class="form-label"> <strong class="text-danger">*</strong> Payment Method</label>
                                <select class="form-control" name="paymentMethod" id="paymentMethod">
                                    <?php foreach ([ 'full' => 'Full Payment Cash', 'installment' => 'Installment', 'cross_cheque' => 'Through Cross Cheque'] as $k => $v): ?>
                                        <option value="<?= $k ?>" <?= old('paymentMethod') == $k ? 'selected' : '' ?>><?= $v ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="advPayment" class="form-label"> <strong class="text-danger">*</strong> Advance Payment</label>
                                <input type="number" class="form-control" id="advPayment" name="advPayment" value="<?= old('advPayment')?? '0.00' ?>"/>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="paymentDueDate" class="form-label"> <strong class="text-danger">*</strong> Payment Due Date</label>
                                <div class="input-group position-relative datepicker" id="resDueDate">
                                    <input autocomplete="off" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-date-container="#resDueDate" type="text" class="form-control" id="paymentDueDate" name="paymentDueDate" readonly value="<?= old('paymentDueDate', date('Y-m-d', strtotime('+10 days'))) ?>">
                                    <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary float-end">Create Booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script src="<?= base_url() ?>assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
    <script>
        $(document).ready(function () {

            $("#billboard").change(function () {
                getBillboards(id = $(this).val())
            })

            <?php if (old('billboard')): ?>
            getBillboards(id = '<?= old('billboard') ?>')
            <?php elseif(isset($billboards[array_keys($billboards)[0]][0]['id'])): ?>
            getBillboards('<?=$billboards[array_keys($billboards)[0]][0]['id'] ?>')
            <?php endif; ?>

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
                
            })
        });

        const getBillboards = (id) => {
            if (!id) {
                return
            }
            $('.booking-price').html(`<sup class="text-info" ><i>min booking price : 0000 </i></sup>`)

            ajaxCall('<?=route_to('admin.billboard.get.ajax')?>', {
                hoarding: id
            }).then((response) => {
                if (response.data) {
                    $('.booking-price').html(`<sup class="text-info" ><i>min booking price : ${response.data.booking_price} PKR </i></sup>`)

                    
                }

            }).catch(err => {
                console.log(err)
            })
        }


    </script>
<?= $this->endSection() ?>