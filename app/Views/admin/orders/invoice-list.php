<?= $this->extend('common/default-nav') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Invoices</h3>
        <div class="d-flex align-items-center">
            <label for="invoiceTypeFilter" class="me-2 fw-semibold">Type:</label>
            <select id="invoiceTypeFilter" class="form-select form-select-sm" style="width:180px;">
                <option value="all">All</option>
                <option value="with_tax">With Sales Tax</option>
                <option value="without_tax">Without Sales Tax</option>
            </select>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle" id="invoiceTable">
            <thead class="table-light">
                <tr>
                    <th>Invoice #</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>PO Number</th>
                    <th>Grand Total</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoices as $inv): ?>
                    <tr data-type="<?= esc($inv['invoice_type'] ?? 'with_tax') ?>">
                        <td><?= esc($inv['invoice_number']) ?></td>
                        <td><?= esc($inv['customer']['first_name'] ?? '') ?> <?= esc($inv['customer']['last_name'] ?? '') ?><br><small><?= esc($inv['customer']['company_name'] ?? '') ?></small></td>
                        <td><?= date('d-M-Y', strtotime($inv['created_at'])) ?></td>
                        <td><?= esc($inv['po_number']) ?></td>
                        <td><?= number_format($inv['grand_total'], 2) ?></td>
                        <td>
                            <?php if (($inv['invoice_type'] ?? 'with_tax') === 'with_tax'): ?>
                                <span class="badge bg-success">With Sales Tax</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Without Sales Tax</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/orders/invoice-view/' . urlencode($inv['invoice_number'])) ?>" class="btn btn-sm btn-primary" target="_blank">View/Print</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    document.getElementById('invoiceTypeFilter').addEventListener('change', function() {
        var type = this.value;
        var rows = document.querySelectorAll('#invoiceTable tbody tr');
        rows.forEach(function(row) {
            if (type === 'all' || row.getAttribute('data-type') === type) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
<?= $this->endSection() ?> 