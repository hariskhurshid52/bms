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
                                <th style="white-space:nowrap;">Add Payment</th>
                                <th style="display:none;">Order ID</th>
                                <th style="white-space:nowrap;">Client Name</th>
                                <th style="white-space:nowrap;">Display</th>
                                <th style="white-space:nowrap;">Hoarding Name</th>
                                <th style="white-space:nowrap;">Hoarding Area</th>
                                <th style="white-space:nowrap;">Booking Status</th>
                                <th style="white-space:nowrap;">Reservation Start</th>
                                <th style="white-space:nowrap;">Reservation End</th>
                                <th style="white-space:nowrap;">Price</th>
                                <th style="white-space:nowrap;">Total Cost</th>
                                <th style="white-space:nowrap;">Paid Amount</th>
                                <th style="white-space:nowrap;">Payment Due Date</th>
                                <th style="white-space:nowrap;">Booking Placed At</th>
                                <th style="white-space:nowrap;">Actions</th>
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

<!-- Change Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="statusModalLabel">Change Booking Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="changeStatusForm">
          <input type="hidden" name="order_id" id="statusOrderId">
          <div class="mb-3">
            <label for="statusSelect" class="form-label">Select Status</label>
            <select class="form-select" id="statusSelect" name="status_id" required>
              <option value="">Loading...</option>
            </select>
          </div>
          <div id="changeStatusMsg" class="mb-2"></div>
          <button type="submit" class="btn btn-primary">Update Status</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    // Assume userRole is available as a JS variable (e.g., 'admin', 'sales')
    var userRole = "<?= session()->get('loggedIn')['role'] ?? '' ?>";
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
                { data: 0 }, // Add Payment button
                { data: 1, visible: false }, // Order ID (hidden)
                { data: 2 }, // Client Name
                { data: 3 }, // Display
                { data: 4 }, // Hoarding Name
                { data: 5 }, // Hoarding Area
                { data: 6 }, // Booking Status
                { data: 7 }, // Reservation Start
                { data: 8 }, // Reservation End
                { data: 9 }, // Price
                { data: 10 }, // Total Cost
                { data: 11 }, // Paid Amount
                { data: 12 }, // Payment Due Date
                { data: 13 }, // Booking Placed At
                { data: 14 } // Actions
            ],
            drawCallback: function(settings) {
                console.log('DataTable Draw Callback:', settings);
            },
            initComplete: function(settings, json) {
                console.log('DataTable Init Complete:', settings, json);
            }
        });

        // Add Change Status button to each row (after table draw)
        table.on('draw', function() {
            $('#dtOrders tbody tr').each(function() {
                var $row = $(this);
                var orderId = $row.find('td:eq(1)').text(); // hidden Order ID
                // Add Payment button only for admin, superadmin, or supper admin (case-insensitive)
                if (!["admin", "superadmin", "supper admin"].includes(userRole.toLowerCase())) {
                    $row.find('.payments-btn').hide();
                }
                // Add Change Status button if not already present
                if ($row.find('.change-status-btn').length === 0 && orderId) {
                    var btn = '<button class="btn btn-sm btn-primary change-status-btn ms-1" data-order-id="' + orderId + '" title="Change Status"><i class="fa fa-exchange-alt"></i> Change Status</button>';
                    $row.find('td:last').append(btn);
                }
            });
        });

        // Handle Change Status button click
        $(document).on('click', '.change-status-btn', function() {
            var orderId = $(this).data('order-id');
            $('#statusOrderId').val(orderId);
            $('#changeStatusMsg').html('');
            // Load statuses
            $.get('<?= base_url('admin/orders/getOrderStatuses') ?>', function(resp) {
                if (resp.status === 'success') {
                    var options = '';
                    resp.statuses.forEach(function(s) {
                        options += '<option value="' + s.id + '">' + s.name + '</option>';
                    });
                    $('#statusSelect').html(options);
                    // Optionally, set current status as selected (if you have it in the row)
                } else {
                    $('#statusSelect').html('<option value="">Unable to load statuses</option>');
                }
            });
            var modal = new bootstrap.Modal(document.getElementById('statusModal'));
            modal.show();
        });

        // Handle status change form submit
        $('#changeStatusForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var data = form.serialize();
            data += '&<?= csrf_token() ?>=<?= csrf_hash() ?>';
            $('#changeStatusMsg').html('');
            $.post('<?= base_url('admin/orders/updateOrderStatus') ?>', data, function(resp) {
                if (resp.status === 'success') {
                    $('#changeStatusMsg').html('<span class="text-success">' + resp.message + '</span>');
                    setTimeout(function() {
                        $('#statusModal').modal('hide');
                        table.ajax.reload(null, false);
                    }, 1000);
                } else {
                    $('#changeStatusMsg').html('<span class="text-danger">' + resp.message + '</span>');
                }
            });
        });

        // Handle .payments-btn click
        $(document).on('click', '.payments-btn', function() {
            var orderId = $(this).data('order-id');
            $('#paymentOrderId').val(orderId);
            $('#addPaymentMsg').html('');
            // Load payment history via AJAX
            $('#paymentHistoryBody').html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');
            $.get('<?= base_url('admin/orders/getPayments') ?>/' + orderId, function(response) {
                if (response.status === 'success') {
                    var rows = '';
                    if (response.payments.length) {
                        response.payments.forEach(function(payment) {
                            rows += '<tr>' +
                                '<td>' + (payment.created_at ? payment.created_at.substr(0, 10) : '') + '</td>' +
                                '<td>' + payment.amount + '</td>' +
                                '<td>' + (payment.payment_method || payment.addtional_info || '') + '</td>' +
                                '<td>' + (payment.notes || '') + '</td>' +
                                '</tr>';
                        });
                    } else {
                        rows = '<tr><td colspan="4" class="text-center">No payments found.</td></tr>';
                    }
                    $('#paymentHistoryBody').html(rows);
                } else {
                    $('#paymentHistoryBody').html('<tr><td colspan="4" class="text-danger">Error loading payments.</td></tr>');
                }
            });
            $('#paymentModal').modal('show');
        });
    });
</script>
<?= $this->endSection() ?>