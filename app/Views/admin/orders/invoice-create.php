<?= $this->extend('common/default-nav') ?>
<?= $this->section('styles') ?>
<style>
    .invoice-table th, .invoice-table td { vertical-align: middle; }
    .invoice-table input, .invoice-table select { min-width: 80px; }
    .remove-row-btn { color: #dc3545; cursor: pointer; }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h3>Create New Invoice</h3>
    <form id="invoiceForm" method="post" action="/admin/orders/saveInvoice">
        <?= csrf_field() ?>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="client" class="form-label">Bill To (Client)</label>
                <select class="form-select" id="client" name="client_id" required>
                    <option value="">Select Client</option>
                    <?php foreach ($customers as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= esc($c['first_name'] . ' ' . $c['last_name']) ?> - <?= esc($c['company_name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <textarea class="form-control mt-2" id="clientAddress" rows="2" readonly placeholder="Client address will appear here..."></textarea>
            </div>
            <div class="col-md-2">
                <label class="form-label">Date</label>
                <input type="date" class="form-control" name="invoice_date" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Invoice #</label>
                <input type="text" class="form-control" name="invoice_number" value="<?= $nextInvoiceNumber ?? '' ?>" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">P.O</label>
                <input type="text" class="form-control" name="po_number">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered invoice-table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Description</th>
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
            <button type="button" class="btn btn-outline-primary btn-sm" id="addRowBtn"><i class="bi bi-plus"></i> Add Line</button>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <label for="amountWords" class="form-label">Amount In Words</label>
                <input type="text" class="form-control" id="amountWords" name="amount_words" readonly>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th class="text-end">Sub Total</th>
                        <td class="text-end" id="subTotalCell">0</td>
                    </tr>
                    <tr>
                        <th class="text-end">Sales Tax</th>
                        <td class="text-end"><input type="number" class="form-control form-control-sm text-end" id="salesTaxInput" name="sales_tax" value="0"></td>
                    </tr>
                    <tr>
                        <th class="text-end">Grand Total</th>
                        <td class="text-end" id="grandTotalCell">0</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="mt-3 text-end">
            <button type="submit" class="btn btn-success">Create Invoice</button>
        </div>
    </form>
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
</script>
<?= $this->endSection() ?> 