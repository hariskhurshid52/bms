<?= $this->extend('common/default-nav') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h3>Invoices</h3>
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Invoice #</th>
                <th>Client</th>
                <th>Date</th>
                <th>PO Number</th>
                <th>Grand Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoices as $inv): ?>
                <tr>
                    <td><?= esc($inv['invoice_number']) ?></td>
                    <td><?= esc($inv['customer']['first_name'] ?? '') ?> <?= esc($inv['customer']['last_name'] ?? '') ?><br><small><?= esc($inv['customer']['company_name'] ?? '') ?></small></td>
                    <td><?= date('d-M-Y', strtotime($inv['created_at'])) ?></td>
                    <td><?= esc($inv['po_number']) ?></td>
                    <td><?= number_format($inv['grand_total'], 2) ?></td>
                    <td>
                        <a href="<?= base_url('admin/orders/invoice-view/' . urlencode($inv['invoice_number'])) ?>" class="btn btn-sm btn-primary" target="_blank">View/Print</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?> 