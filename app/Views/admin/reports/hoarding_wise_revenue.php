<?= $this->extend('common/default-nav') ?>
<?= $this->section('styles') ?>
<style>
    .filter-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        padding: 24px 24px 8px 24px;
        margin-bottom: 24px;
        border: 1px solid #e9ecef;
    }
    .filter-card .card-header {
        background: none;
        border: none;
        font-size: 1.2rem;
        font-weight: 600;
        color: #222;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-left: 0;
    }
    .filter-card .form-label {
        font-weight: 500;
        color: #495057;
    }
    .filter-card .form-control, .filter-card .form-select {
        border-radius: 8px;
    }
    .filter-card .input-group-text {
        background: #f1f3f4;
        border: none;
        color: #888;
    }
    .filter-card .filter-actions {
        display: flex;
        align-items: end;
        gap: 10px;
    }
    .filter-card .btn-clear {
        background: #f8f9fa;
        color: #6c757d;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        font-weight: 500;
    }
    .filter-card .btn-clear:hover {
        background: #e9ecef;
        color: #222;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Hoarding Wise Revenue Report</h4>
                <hr />
                <!-- Filter Card -->
                <div class="filter-card mb-4">
                    <div class="card-header pb-0 mb-3">
                        <i class="bi bi-search"></i> Search Filters
                    </div>
                    <form id="filterForm" method="get">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-2">
                                <label for="filterClient" class="form-label">Client</label>
                                <select class="form-select" id="filterClient" name="client">
                                    <option value="">All Clients</option>
                                    <?php foreach ($customers as $customer): ?>
                                        <option value="<?= $customer['id'] ?>" <?= $filters['client'] == $customer['id'] ? 'selected' : '' ?>>
                                            <?= esc($customer['company_name'] ?: ($customer['first_name'] . ' ' . $customer['last_name'])) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="filterHoarding" class="form-label">Hoarding</label>
                                <select class="form-select" id="filterHoarding" name="hoarding">
                                    <option value="">All Hoardings</option>
                                    <?php foreach ($billboards as $billboard): ?>
                                        <option value="<?= $billboard['id'] ?>" <?= $filters['hoarding'] == $billboard['id'] ? 'selected' : '' ?>><?= esc($billboard['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="filterCity" class="form-label">City</label>
                                <select class="form-select" id="filterCity" name="city">
                                    <option value="">All Cities</option>
                                    <?php foreach ($cities as $city): ?>
                                        <option value="<?= $city['id'] ?>" <?= $filters['city'] == $city['id'] ? 'selected' : '' ?>><?= esc($city['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="filterArea" class="form-label">Area</label>
                                <input type="text" class="form-control" id="filterArea" name="area" value="<?= esc($filters['area']) ?>" placeholder="Area">
                            </div>
                            <div class="col-md-2">
                                <label for="filterType" class="form-label">Type</label>
                                <select class="form-select" id="filterType" name="type">
                                    <option value="">All Types</option>
                                    <?php foreach ($types as $type): ?>
                                        <option value="<?= $type['id'] ?>" <?= $filters['type'] == $type['id'] ? 'selected' : '' ?>><?= esc($type['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="filterStatus" class="form-label">Status</label>
                                <select class="form-select" id="filterStatus" name="status">
                                    <option value="">All Status</option>
                                    <option value="active" <?= $filters['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= $filters['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                    <option value="under_maintenance" <?= $filters['status'] == 'under_maintenance' ? 'selected' : '' ?>>Under Maintenance</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="filterDateFrom" class="form-label">Start Date</label>
                                <div class="input-group position-relative datepicker" id="revenueReportStartPicker">
                                    <input autocomplete="off" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-date-container="#revenueReportStartPicker" type="text" class="form-control" id="filterDateFrom" name="date_from" readonly value="<?= esc($filters['date_from']) ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="filterDateTo" class="form-label">End Date</label>
                                <div class="input-group position-relative datepicker" id="revenueReportEndPicker">
                                    <input autocomplete="off" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-date-container="#revenueReportEndPicker" type="text" class="form-control" id="filterDateTo" name="date_to" readonly value="<?= esc($filters['date_to']) ?>">
                                </div>
                            </div>
                            <div class="col-md-2 filter-actions">
                                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Apply</button>
                                <a href="<?= current_url() ?>" class="btn btn-clear w-100 ms-2"><i class="bi bi-x"></i> Clear</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Display</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Total Cost</th>
                                <th>Received</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reportData as $row): ?>
                                <tr>
                                    <td><?= esc($row['client']) ?></td>
                                    <td><?= esc($row['display']) ?></td>
                                    <td><?= date('d-M-y', strtotime($row['start_date'])) ?></td>
                                    <td><?= date('d-M-y', strtotime($row['end_date'])) ?></td>
                                    <td><?= number_format($row['total_cost']) ?></td>
                                    <td><?= number_format($row['received']) ?></td>
                                    <td><?= $row['balance'] > 0 ? number_format($row['balance']) : '-' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr style="font-weight:bold;">
                                <td colspan="4" class="text-end">Total:-</td>
                                <td><?= number_format($totals['total_cost']) ?></td>
                                <td><?= number_format($totals['received']) ?></td>
                                <td><?= number_format($totals['balance']) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 