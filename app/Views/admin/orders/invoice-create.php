<?= $this->extend('common/default-nav') ?>
<?= $this->section('styles') ?>
<style>
    .invoice-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 16px rgba(56, 142, 60, 0.08);
        padding: 32px 24px;
        margin-bottom: 32px;
    }
    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #388e3c;
        margin-bottom: 16px;
        letter-spacing: 1px;
    }
    .invoice-table th, .invoice-table td {
        vertical-align: middle;
    }
    .invoice-table th {
        background: #e8f5e9;
        color: #388e3c;
        font-weight: 600;
    }
    .invoice-table input, .invoice-table select {
        min-width: 80px;
    }
    .remove-row-btn {
        color: #dc3545;
        cursor: pointer;
        font-size: 1.3rem;
    }
    .summary-card {
        background: #e8f5e9;
        border-radius: 8px;
        padding: 18px 24px;
        margin-top: 12px;
        color: #388e3c;
        font-weight: 500;
    }
    .btn-success {
        background: #388e3c;
        border-color: #388e3c;
    }
    .btn-success:hover {
        background: #256029;
        border-color: #256029;
    }
    .add-row-btn {
        float: right;
        margin-bottom: 10px;
    }
    @media (max-width: 768px) {
        .invoice-card { padding: 16px 4px; }
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="invoice-card">
        <h3 class="mb-4" style="color:#388e3c; font-weight:700;">Create New Invoice</h3>
        <form id="invoiceForm" method="post" action="/admin/orders/saveInvoice">
            <?= csrf_field() ?>
            <div class="section-title">Client Details</div>
            <div class="row mb-3">
                <div class="col-md-6 mb-2">
                    <label for="client" class="form-label">Bill To (Client)</label>
                    <select class="form-select" id="client" name="client_id" required>
                        <option value="">Select Client</option>
                        <?php foreach ($customers as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= esc($c['first_name'] . ' ' . $c['last_name']) ?> - <?= esc($c['company_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <textarea class="form-control mt-2" id="clientAddress" rows="2" readonly placeholder="Client address will appear here..."></textarea>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Date</label>
                    <input type="date" class="form-control" name="invoice_date" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Invoice #</label>
                    <input type="text" class="form-control" name="invoice_number" value="<?= $nextInvoiceNumber ?? '' ?>" required>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">P.O</label>
                    <input type="text" class="form-control" name="po_number">
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Invoice Type</label>
                    <select class="form-select" id="invoiceType" name="invoice_type" required>
                        <option value="with_tax">With Sales Tax</option>
                        <option value="without_tax">Without Sales Tax</option>
                    </select>
                </div>
            </div>
            <div class="section-title">Line Items</div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover invoice-table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Location</th>
                            <th>Size</th>
                            <th>Sq. Ft.</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Amount (Rs)</th>
                            <th style="width:40px;"></th>
                        </tr>
                    </thead>
                    <tbody id="invoiceItemsBody">
                        <tr>
                            <td><input type="text" name="items[0][description]" class="form-control" required></td>
                            <td><input type="text" name="items[0][size]" class="form-control"></td>
                            <td><input type="number" name="items[0][sqft]" class="form-control" min="0"></td>
                            <td><input type="date" name="items[0][from]" class="form-control"></td>
                            <td><input type="date" name="items[0][to]" class="form-control"></td>
                            <td><input type="number" name="items[0][amount]" class="form-control item-amount" min="0" required></td>
                            <td class="text-center"><span class="remove-row-btn" style="display:none;">&times;</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-end mb-3">
                <button type="button" class="btn btn-outline-primary btn-sm add-row-btn" id="addRowBtn"><i class="bi bi-plus"></i> Add Line</button>
            </div>
            <div class="row mt-4">
                <div class="col-md-6 mb-2">
                    <label for="amountWords" class="form-label">Amount In Words</label>
                    <input type="text" class="form-control" id="amountWords" name="amount_words" readonly>
                </div>
                <div class="col-md-6">
                    <div class="summary-card">
                        <div class="row mb-2">
                            <div class="col-6 text-end">Sub Total</div>
                            <div class="col-6 text-end" id="subTotalCell">0</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-end">Sales Tax</div>
                            <div class="col-6 text-end"><input type="number" class="form-control form-control-sm text-end" id="salesTaxInput" name="sales_tax" value="0"></div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-end">Grand Total</div>
                            <div class="col-6 text-end" id="grandTotalCell">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-success btn-lg px-4"><i class="bi bi-check-circle"></i> Create Invoice</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
let itemIndex = 1;
let clientBookings = [];

$('#addRowBtn').on('click', function() {
    let row = `<tr>
        <td><select name="items[${itemIndex}][description]" class="form-control booking-dropdown" data-row="${itemIndex}" required><option value="">Select Booking</option></select></td>
        <td><input type="text" name="items[${itemIndex}][size]" class="form-control size-field"></td>
        <td><input type="number" name="items[${itemIndex}][sqft]" class="form-control sqft-field" min="0"></td>
        <td><input type="date" name="items[${itemIndex}][from]" class="form-control from-field"></td>
        <td><input type="date" name="items[${itemIndex}][to]" class="form-control to-field"></td>
        <td><input type="number" name="items[${itemIndex}][amount]" class="form-control item-amount amount-field" min="0" required></td>
        <td class="text-center"><span class="remove-row-btn">&times;</span></td>
    </tr>`;
    $('#invoiceItemsBody').append(row);
    populateBookingDropdown(itemIndex);
    itemIndex++;
});

function populateBookingDropdown(rowIdx) {
    let $dropdown = $(`select[name='items[${rowIdx}][description]']`);
    $dropdown.empty().append('<option value="">Select Booking</option>');
    clientBookings.forEach(function(b) {
        $dropdown.append(`<option value="${b.id}" data-size="${b.size}" data-from="${b.start_date}" data-to="${b.end_date}" data-amount="${b.amount}" data-sqft="${b.sqft || ''}" data-height="${b.height}" data-width="${b.width}">${b.billboard_name} (${b.size})</option>`);
    });
}

$('#client').on('change', function() {
    var clientId = $(this).val();
    var addr = '';
    <?php foreach ($customers as $c): ?>
    if (clientId == '<?= $c['id'] ?>') addr = `<?= trim(preg_replace('/\s+/', ' ', addslashes($c['company_name'] . "\n" . $c['address_line_1']))) ?>`;
    <?php endforeach; ?>
    $('#clientAddress').val(addr);
    if (!clientId) return;
    // Fetch bookings for this client
    $.get('/admin/orders/getClientBookings/' + clientId, function(response) {
        clientBookings = response.bookings || [];
        // For all rows, replace description input with dropdown
        $('#invoiceItemsBody tr').each(function(idx, tr) {
            let $descCell = $(tr).find('td:first');
            let rowIdx = idx;
            let $dropdown = $('<select class="form-control booking-dropdown" data-row="'+rowIdx+'" name="items['+rowIdx+'][description]" required><option value="">Select Booking</option></select>');
            clientBookings.forEach(function(b) {
                $dropdown.append(`<option value="${b.id}" data-size="${b.size}" data-from="${b.start_date}" data-to="${b.end_date}" data-amount="${b.amount}" data-sqft="${b.sqft || ''}" data-height="${b.height}" data-width="${b.width}">${b.billboard_name} (${b.size})</option>`);
            });
            $descCell.html($dropdown);
        });
    });
});

$(document).on('change', '.booking-dropdown', function() {
    let selected = $(this).find('option:selected');
    let rowIdx = $(this).data('row');
    let height = selected.data('height') || '';
    let width = selected.data('width') || '';
    let size = (height && width) ? `${height}x${width}` : '';
    let sqft = (height && width) ? (parseFloat(height) * parseFloat(width)) : '';
    let from = selected.data('from') || '';
    let to = selected.data('to') || '';
    // Strip time part if present
    from = from ? from.split(' ')[0] : '';
    to = to ? to.split(' ')[0] : '';
    console.log('Setting dates:', from, to);
    let amount = selected.data('amount') || '';
    $(`input[name='items[${rowIdx}][size]']`).val(size);
    $(`input[name='items[${rowIdx}][from]']`).val(from);
    $(`input[name='items[${rowIdx}][to]']`).val(to);
    $(`input[name='items[${rowIdx}][amount]']`).val(amount);
    $(`input[name='items[${rowIdx}][sqft]']`).val(sqft);
    updateTotals();
});

$(document).on('click', '.remove-row-btn', function() {
    $(this).closest('tr').remove();
    updateTotals();
});
$(document).on('input', '.item-amount, #salesTaxInput', function() {
    updateTotals();
});
function updateTotals() {
    let sub = 0;
    $('.item-amount').each(function() {
        let val = parseFloat($(this).val()) || 0;
        sub += val;
    });
    $('#subTotalCell').text(sub.toLocaleString());
    let tax = parseFloat($('#salesTaxInput').val()) || 0;
    let grand = sub + tax;
    $('#grandTotalCell').text(grand.toLocaleString());
    $('#amountWords').val(numToWords(grand));
}
function numToWords(num) {
    // Simple number to words for demo (English, up to 999,999)
    if (num === 0) return 'Zero';
    const a = ['','One','Two','Three','Four','Five','Six','Seven','Eight','Nine','Ten','Eleven','Twelve','Thirteen','Fourteen','Fifteen','Sixteen','Seventeen','Eighteen','Nineteen'];
    const b = ['','','Twenty','Thirty','Forty','Fifty','Sixty','Seventy','Eighty','Ninety'];
    function inWords(n) {
        if (n < 20) return a[n];
        if (n < 100) return b[Math.floor(n/10)] + (n%10 ? ' ' + a[n%10] : '');
        if (n < 1000) return a[Math.floor(n/100)] + ' Hundred' + (n%100 ? ' ' + inWords(n%100) : '');
        if (n < 100000) return inWords(Math.floor(n/1000)) + ' Thousand' + (n%1000 ? ' ' + inWords(n%1000) : '');
        if (n < 1000000) return inWords(Math.floor(n/100000)) + ' Lakh' + (n%100000 ? ' ' + inWords(n%100000) : '');
        return num;
    }
    return inWords(Math.floor(num)) + ' only';
}
$(document).on('input', '.item-amount, #salesTaxInput', updateTotals);
updateTotals();

$('#invoiceType').on('change', function() {
    if ($(this).val() === 'without_tax') {
        $('#salesTaxInput').val(0).closest('.row').hide();
        updateTotals();
    } else {
        $('#salesTaxInput').closest('.row').show();
        updateTotals();
    }
});
$(document).ready(function() {
    $('#invoiceType').trigger('change');
});
</script>
<?= $this->endSection() ?> 