<?= $this->section('styles') ?>
<?= $this->endSection() ?>
<?= $this->extend('common/default-nav') ?> <?= $this->section('content') ?>



<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">List All Bookings <a href="<?= route_to('admin.order.create') ?>"
                        class="btn btn-primary btn-sm pull-right" role="button">Add New</a></h4>
                <hr />
                <div class="table-responsive">
                    <table class="table table-hover" id="dtOrders">
                        <thead>
                            <tr>
                                <th style="display:none;">Order ID</th>
                                <th>Client Name</th>
                                <th>Display</th>
                                <th>Hoarding Name</th>
                                <th>Hoarding Area</th>
                                <th>Booking Status</th>
                                <th>Reservation Start</th>
                                <th>Reservation End</th>
                                <th>Price</th>
                                <th>Total Cost</th>
                                <th>Paid Amount</th>
                                <th>Payment Due Date</th>
                                <th>Booking Placed At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentModalLabel">Manage Payments</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="paymentHistorySection">
          <h6>Payment History</h6>
          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th>Date</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Notes</th>
              </tr>
            </thead>
            <tbody id="paymentHistoryBody">
              <tr><td colspan="4" class="text-center">Loading...</td></tr>
            </tbody>
          </table>
        </div>
        <hr>
        <div id="addPaymentSection">
          <h6>Add Payment</h6>
          <form id="addPaymentForm">
            <input type="hidden" name="order_id" id="paymentOrderId">
            <div class="row g-2">
              <div class="col-md-3">
                <input type="number" step="0.01" min="0" class="form-control" name="amount" placeholder="Amount" required>
              </div>
              <div class="col-md-3">
                <input type="date" class="form-control" name="payment_date" required>
              </div>
              <div class="col-md-3">
                <input type="text" class="form-control" name="payment_method" placeholder="Method (optional)">
              </div>
              <div class="col-md-3">
                <input type="text" class="form-control" name="notes" placeholder="Notes (optional)">
              </div>
            </div>
            <div class="mt-3">
              <button type="submit" class="btn btn-success">Add Payment</button>
            </div>
          </form>
          <div id="addPaymentMsg" class="mt-2"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    $(document).ready(function () {
        var table = $('#dtOrders').DataTable({
            processing: true,
            ordering: false,
            serverSide: true,
            ajax: {
                url: "<?= route_to('admin.orders.dtList') ?>",
                type: "POST",
                dataType: "json",
                data: function (d) {
                    d['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
                },
                error: function (xhr, error, thrown) {
                    console.error('DataTable Error:', error);
                    console.error('Response:', xhr.responseText);
                }
            },
            columns: [
                { data: 0, visible: false }, // Order ID (hidden)
                { data: 1 }, // Client Name
                { data: 2 }, // Display
                { data: 3 }, // Hoarding Name
                { data: 4 }, // Hoarding Area
                { data: 5 }, // Booking Status
                { data: 6 }, // Reservation Start
                { data: 7 }, // Reservation End
                { data: 8 }, // Price
                { data: 9 }, // Total Cost
                { data: 10 }, // Paid Amount
                { data: 11 }, // Payment Due Date
                { data: 12 }, // Booking Placed At
                { 
                    data: 13, // Actions
                    render: function(data, type, row, meta) {
                        var orderId = row[0]; // Get order ID from hidden column
                        var paymentsBtn = '';
                        if (orderId) {
                            paymentsBtn = '<button class="btn btn-sm btn-success ms-1 payments-btn" data-order-id="'+orderId+'" title="Add Payment"><i class="fa fa-plus"></i> Add Payment</button>';
                        }
                        return data + paymentsBtn;
                    }
                }
            ],
            drawCallback: function(settings) {
                console.log('DataTable Draw Callback:', settings);
            },
            initComplete: function(settings, json) {
                console.log('DataTable Init Complete:', settings, json);
            }
        });

        // Handle Payments button click
        $(document).on('click', '.payments-btn', function() {
            var orderId = $(this).data('order-id');
            $('#paymentOrderId').val(orderId);
            $('#addPaymentForm')[0].reset();
            $('#addPaymentMsg').html('');
            loadPaymentHistory(orderId);
            var modal = new bootstrap.Modal(document.getElementById('paymentModal'));
            modal.show();
        });

        // Load payment history
        function loadPaymentHistory(orderId) {
            $('#paymentHistoryBody').html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');
            $.get('<?= base_url('admin/orders/getPayments') ?>/' + orderId, function(resp) {
                if (resp.status === 'success' && resp.payments.length > 0) {
                    var rows = '';
                    resp.payments.forEach(function(p) {
                        rows += '<tr>' +
                            '<td>' + (p.created_at ? p.created_at : '-') + '</td>' +
                            '<td>' + p.amount + '</td>' +
                            '<td>' + (p.payment_method ? p.payment_method : '-') + '</td>' +
                            '<td>' + (p.notes ? p.notes : '-') + '</td>' +
                            '</tr>';
                    });
                    $('#paymentHistoryBody').html(rows);
                } else {
                    $('#paymentHistoryBody').html('<tr><td colspan="4" class="text-center">No payments found.</td></tr>');
                }
            });
        }

        // Handle add payment form submit
        $('#addPaymentForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var data = form.serialize();
            // Add CSRF token
            data += '&<?= csrf_token() ?>=<?= csrf_hash() ?>';
            $('#addPaymentMsg').html('');
            $.post('<?= base_url('admin/orders/addBookingPayment') ?>', data, function(resp) {
                if (resp.status === 'success') {
                    $('#addPaymentMsg').html('<span class="text-success">' + resp.message + '</span>');
                    loadPaymentHistory($('#paymentOrderId').val());
                    form[0].reset();
                } else {
                    $('#addPaymentMsg').html('<span class="text-danger">' + resp.message + '</span>');
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>