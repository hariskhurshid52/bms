<?= $this->extend('common/default-nav') ?>
<?= $this->section('content') ?>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="header-title">Order Details #<?= $order['id'] ?>
                        <span class="badge bg-<?= $order['status_id'] == 5 ? 'success' : ($order['status_id'] == 4 ? 'danger' : 'warning') ?> ms-2">
                            <?= $order['status_name'] ?>
                        </span>
                    </h4>
                    <div>
                        <a href="<?= route_to('admin.orders.list') ?>" class="btn btn-secondary btn-sm">Back to List</a>
                        <a href="<?= route_to('admin.orders.edit', $order['id']) ?>" class="btn btn-primary btn-sm">Edit Order</a>
                    </div>
                </div>

                <!-- Order Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Amount</h5>
                                <h3 class="mb-0">RS <?= number_format($order['total_price'], 2) ?></h3>
                                <small>Including Tax</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Paid Amount</h5>
                                <h3 class="mb-0">RS <?= number_format($totalPaid, 2) ?></h3>
                                <small>Paid Amount</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h5 class="card-title">Remaining Balance</h5>
                                <h3 class="mb-0">RS <?= number_format($order['total_price'] - $totalPaid, 2) ?></h3>
                                <small>Due Amount</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title">Duration</h5>
                                <h3 class="mb-0"><?= date_diff(date_create($order['start_date']), date_create($order['end_date']))->days ?> Days</h3>
                                <small>Booking Period</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Details -->
                <div class="row">
                    <!-- Basic Information -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Basic Information</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Order Date</th>
                                        <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Start Date</th>
                                        <td><?= date('M d, Y', strtotime($order['start_date'])) ?></td>
                                    </tr>
                                    <tr>
                                        <th>End Date</th>
                                        <td><?= date('M d, Y', strtotime($order['end_date'])) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Payment Method</th>
                                        <td><?= ucfirst($order['payment_method']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Payment Due Date</th>
                                        <td><?= date('M d, Y', strtotime($order['payment_due_date'])) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Display Text</th>
                                        <td><?= $order['display'] ?? 'N/A' ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Details -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Financial Details</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Base Amount</th>
                                        <td>RS <?= number_format($order['amount'], 2) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tax Rate</th>
                                        <td><?= $order['tax_percent'] ?>%</td>
                                    </tr>
                                    <tr>
                                        <th>Tax Amount</th>
                                        <td>RS <?= number_format($order['tax_amount'], 2) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Total Amount</th>
                                        <td>RS <?= number_format($order['total_price'], 2) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Paid Amount</th>
                                        <td>RS <?= number_format($totalPaid, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Remaining Balance</th>
                                        <td>RS <?= number_format($order['total_price'] - $totalPaid, 2) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Additional Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Hoarding Details</h6>
                                        <table class="table table-borderless">
                                            <tr>
                                                <th width="40%">Name</th>
                                                <td><?= $billboard['name'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Type</th>
                                                <td><?= $billboard['typeName'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Area</th>
                                                <td><?= $billboard['area'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Minimum Price</th>
                                                <td>$<?= number_format($billboard['booking_price'], 2) ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Client Details</h6>
                                        <table class="table table-borderless">
                                            <tr>
                                                <th width="40%">Name</th>
                                                <td><?= $customer['first_name'] . ' ' . $customer['last_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Company</th>
                                                <td><?= $customer['company_name'] ?? 'N/A' ?></td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td><?= $customer['email'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Phone</th>
                                                <td><?= $customer['phone'] ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <?php if (!empty($order['addtional_info'])): ?>
                                <div class="mt-3">
                                    <h6>Additional Notes</h6>
                                    <p class="mb-0"><?= nl2br($order['addtional_info']) ?></p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment History -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Payment History</h5>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                                    Add Payment
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Added By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($payments as $payment): ?>
                                            <tr>
                                                <td><?= date('M d, Y', strtotime($payment['created_at'])) ?></td>
                                                <td>RS<?= number_format($payment['amount'], 2) ?></td>
                                                <td><?= $payment['addtional_info'] ?></td>
                                                <td>
                                                    <span class="badge bg-<?= $payment['status_id'] == 1 ? 'success' : 'warning' ?>">
                                                        <?= $payment['status_id'] == 1 ? 'Completed' : 'Pending' ?>
                                                    </span>
                                                </td>
                                                <td><?= $payment['added_by_name'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Payment Modal -->
<div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPaymentModalLabel">Add New Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= route_to('admin.orders.addPayment') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" required step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="payment_type" class="form-label">Payment Type</label>
                        <select class="form-select" id="payment_type" name="payment_type" required>
                            <option value="Advance Payment">Advance Payment</option>
                            <option value="Installment">Installment</option>
                            <option value="Final Payment">Final Payment</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Add Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?> 