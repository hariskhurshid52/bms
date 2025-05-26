<?= $this->extend('common/default-nav') ?>
<?= $this->section('styles') ?>
<style>
    .invoice-box { max-width: 900px; margin: 0 auto; border: 1px solid #eee; padding: 32px; background: #fff; }
    .invoice-header { border-bottom: 2px solid #333; margin-bottom: 24px; }
    .invoice-title { font-size: 2rem; font-weight: bold; }
    .invoice-table th, .invoice-table td { vertical-align: middle; }
    .invoice-summary { font-size: 1.1rem; }
    @media print { .no-print { display: none; } }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="invoice-box">
    <div class="invoice-header mb-4">
        <div class="text-start">
            <div class="invoice-title" style="color:#388e3c;">
                <?= (isset($invoice['invoice_type']) && $invoice['invoice_type'] === 'with_tax') ? 'SALES TAX INVOICE' : 'INVOICE' ?>
            </div>
            <?php if (isset($invoice['invoice_type']) && $invoice['invoice_type'] === 'with_tax'): ?>
            <div style="font-weight:600; color:#222;">NTN# 3705552-6</div>
            <?php endif; ?>
            <div><strong>Date:</strong> <?= date('d-M-y', strtotime($invoice['invoice_date'])) ?></div>
            <div><strong>Invoice #:</strong> <?= esc($invoice['invoice_number']) ?></div>
            <div><strong>P.O:</strong> <?= esc($invoice['po_number']) ?></div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-7">
            <strong>BILL TO:</strong><br>
            <?= esc($customer['company_name']) ?><br>
            <?= esc($customer['address_line_1']) ?><br>
            <?= esc($customer['city'] ?? '') ?>
        </div>
    </div>
    <table class="table table-bordered invoice-table align-middle mt-3">
        <thead class="table-light">
            <tr>
                <th>Location</th>
                <th>Size</th>
                <th>Sq. Ft.</th>
                <th>From</th>
                <th>To</th>
                <th>Amount (Rs)</th>
            </tr>
        </thead>
        <tbody>
            <?php $sub = 0; foreach ($items as $item): $sub += $item['amount']; ?>
            <tr>
                <td><?= esc($item['description']) ?></td>
                <td><?= esc($item['size']) ?></td>
                <td><?= esc($item['sqft']) ?></td>
                <td><?= date('d-M-y', strtotime($item['from_date'])) ?></td>
                <td><?= date('d-M-y', strtotime($item['to_date'])) ?></td>
                <td><?= number_format($item['amount'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="row mt-4">
        <div class="col-md-6">
            <strong>Amount In words:</strong> <?= esc($invoice['amount_words']) ?>
        </div>
        <div class="col-md-6">
            <table class="table table-borderless invoice-summary float-end">
                <tr>
                    <th class="text-end">Sub Total</th>
                    <td class="text-end"><?= number_format($invoice['sub_total'], 2) ?></td>
                </tr>
                <?php if (isset($invoice['invoice_type']) && $invoice['invoice_type'] === 'with_tax'): ?>
                <tr>
                    <th class="text-end">Sales Tax</th>
                    <td class="text-end"><?= number_format($invoice['sales_tax'], 2) ?></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <th class="text-end">Grand Total</th>
                    <td class="text-end"><?= number_format($invoice['grand_total'], 2) ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="mt-4 no-print text-end">
        <button class="btn btn-primary" onclick="window.print()"><i class="bi bi-printer"></i> Print Invoice</button>
    </div>
</div>
<?= $this->endSection() ?> 