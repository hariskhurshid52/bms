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
                                                <option value="<?= $billboard['id'] ?>" <?= (isset($selected_billboard) && $selected_billboard == $billboard['id']) || old('billboard') == $billboard['id'] ? 'selected' : '' ?>>
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
                                <div class="input-group">
                                    <select class="form-control select2" id="customer" name="customer">
                                        <?php foreach ($customers as $customer): ?>
                                            <option value="<?= $customer['id'] ?>" <?= old('customer') == $customer['id'] ? 'selected' : '' ?>>
                                                <?= $customer['first_name'] . ' ' . ($customer['customer_type'] === "agency" ? ' (Agency) ':'') ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="button" class="btn btn-primary btn-sm mt-1" data-bs-toggle="modal" data-bs-target="#addClientModal">
                                        <i class="bi bi-plus-circle"></i> Add Client
                                    </button>
                                </div>
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
                                <label for="taxPerc" class="form-label"> <strong class="text-danger">*</strong> Tax %</label>
                                <select class="form-control" id="taxPerc" name="taxPerc">
                                    <?php foreach ([0,16, 17, 18, 19, 20] as $tax): ?>
                                        <option value="<?= $tax ?>" <?= old('taxPerc') == $tax ? 'selected' : '' ?>><?= $tax ?>%</option>
                                    <?php endforeach; ?>
                                </select>
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

<!-- Add Client Modal -->
<div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClientModalLabel">Add New Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="quickAddClientForm">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="firstName" class="form-label"> <strong class="text-danger">*</strong> Client Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label"> <strong class="text-danger">*</strong> Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label"> <strong class="text-danger">*</strong> Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="contactPerson" class="form-label">Contact Person</label>
                        <input type="text" class="form-control" id="contactPerson" name="contactPerson">
                    </div>
                    <div class="mb-3">
                        <label for="address_line_1" class="form-label"> <strong class="text-danger">*</strong> Billing Address</label>
                        <textarea class="form-control" id="address_line_1" name="address_line_1" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="customerType" class="form-label">Client Type</label>
                        <select name="customerType" id="customerType" class="form-control" required>
                                    <?php foreach ([ 'customer' => 'Client','agency' => 'Agency', 'advertisor' => 'Advertisor'] as $k => $v): ?>
                                        <option value="<?= $k ?>"><?= $v ?></option>
                                    <?php endforeach; ?>
                                </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveClientBtn">Save Client</button>
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
                getBillboards('<?= old('billboard') ?>');
            <?php elseif (!empty($billboards)): ?>
                <?php
                $firstType = array_key_first($billboards);
                $firstBillboard = !empty($billboards[$firstType]) ? $billboards[$firstType][0]['id'] : null;
                if ($firstBillboard): ?>
                    getBillboards('<?= $firstBillboard ?>');
                <?php endif; ?>
            <?php endif; ?>

            $('#totalCost').keyup(function(){
                calculateTotalPrice();
            })
            $('#taxPerc').change(function(){
                calculateTotalPrice();
            })

            // Handle quick add client form submission
            $('#saveClientBtn').click(function() {
                const formData = new FormData($('#quickAddClientForm')[0]);
                
                $.ajax({
                    url: '<?= route_to('admin.customer.store.ajax') ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            // Add new option to select
                            const newOption = new Option(
                                response.data.first_name + ' ' + (response.data.customer_type === 'agency' ? ' (Agency) ' : ''),
                                response.data.id,
                                true,
                                true
                            );
                            $('#customer').append(newOption).trigger('change');
                            
                            // Close modal and reset form
                            $('#addClientModal').modal('hide');
                            $('#quickAddClientForm')[0].reset();
                            
                            // Show success message
                            showSuccessToast('Client added successfully');
                        } else {
                            showDangerToast(response.message || 'Failed to add client');
                        }
                    },
                    error: function(xhr) {
                        showDangerToast('An error occurred while adding the client');
                    }
                });
            });

            // Reset form when modal is closed
            $('#addClientModal').on('hidden.bs.modal', function () {
                $('#quickAddClientForm')[0].reset();
            });
        });

        const calculateTotalPrice = () => {
            const totalCost = parseFloat($("#totalCost").val());
            const taxPerc = $('#taxPerc').val();
            if (!isNaN(totalCost)) {
                const tax = (totalCost * taxPerc / 100).toFixed(2);            
                const totalWithTax = (totalCost + parseFloat(tax)).toFixed(2); 
                $('#totalPriceInclTax').val(totalWithTax);
            } else {
                $('#totalPriceInclTax').val('0.00');
            }
        }

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