<?= $this->extend('common/default-nav') ?>

<?= $this->section('styles') ?>
<!-- Add Bootstrap Icons CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --primary-gradient: linear-gradient(45deg, #4158D0, #C850C0);
        --success-gradient: linear-gradient(45deg, #00b09b, #96c93d);
        --warning-gradient: linear-gradient(45deg, #f6d365, #fda085);
        --danger-gradient: linear-gradient(45deg, #ff0844, #ffb199);
        --info-gradient: linear-gradient(45deg, #4facfe, #00f2fe);
    }

    .stat-card {
        border: none;
        border-radius: 20px;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, rgba(255,255,255,0.1), rgba(255,255,255,0));
        pointer-events: none;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        font-size: 24px;
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .stat-icon i {
        font-size: 24px;
    }

    .stat-card:nth-child(1) .stat-icon i {
        color: #4158D0;
    }

    .stat-card:nth-child(2) .stat-icon i {
        color: #00b09b;
    }

    .stat-card:nth-child(3) .stat-icon i {
        color: #f6d365;
    }

    .stat-card:nth-child(4) .stat-icon i {
        color: #4facfe;
    }

    .stat-card:nth-child(5) .stat-icon i {
        color: #ff0844;
    }

    .trend-indicator {
        font-size: 0.85rem;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .text-white-50 {
        opacity: 0.8;
    }

    .activity-item {
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .activity-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .chart-container {
        position: relative;
        height: 300px;
        padding: 20px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .performance-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .card-header {
        background: white;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 20px;
        border-radius: 20px 20px 0 0 !important;
    }

    .card-body {
        padding: 20px;
    }

    .table {
        margin-bottom: 0;
    }

    .table th {
        font-weight: 600;
        color: #6c757d;
        border-top: none;
    }

    .table td {
        vertical-align: middle;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
    }

    .btn-group .btn {
        border-radius: 20px;
        padding: 8px 20px;
        font-weight: 500;
    }

    .btn-group .btn.active {
        background: var(--primary-gradient);
        color: white;
        border: none;
    }

    #map {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .fc-event {
        border-radius: 8px;
        padding: 4px 8px;
        font-size: 0.9rem;
    }

    .fc-toolbar-title {
        font-size: 1.2rem !important;
        font-weight: 600 !important;
    }

    .quick-action-btn {
        padding: 15px;
        border-radius: 15px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s ease;
        background: white;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .quick-action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .quick-action-btn i {
        font-size: 1.2rem;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Statistics Cards Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card stat-card h-100" style="background: linear-gradient(45deg, #4158D0, #C850C0);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">Total Billboards</h6>
                            <h3 class="mb-0 text-white"><?= number_format($totalBillboards) ?></h3>
                            <div class="mt-2">
                                <span class="trend-indicator <?= $billboardGrowth >= 0 ? 'bg-white text-success' : 'bg-white text-danger' ?>">
                                    <i class="bi <?= $billboardGrowth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                                    <?= abs($billboardGrowth) ?>%
                                </span>
                                <small class="text-white-50 ms-2">vs last month</small>
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-signpost-split-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card h-100" style="background: linear-gradient(45deg, #00b09b, #96c93d);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">Active Bookings</h6>
                            <h3 class="mb-0 text-white"><?= number_format($activeBookings) ?></h3>
                            <div class="mt-2">
                                <span class="trend-indicator <?= $bookingGrowth >= 0 ? 'bg-white text-success' : 'bg-white text-danger' ?>">
                                    <i class="bi <?= $bookingGrowth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                                    <?= abs($bookingGrowth) ?>%
                                </span>
                                <small class="text-white-50 ms-2">vs last month</small>
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($isAdmin): ?>
        <div class="col-md-3">
            <div class="card stat-card h-100" style="background: linear-gradient(45deg, #f6d365, #fda085);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">Total Revenue</h6>
                            <h3 class="mb-0 text-white">Rs.<?= number_format($totalRevenue, 2) ?></h3>
                            <div class="mt-2">
                                <span class="trend-indicator <?= $revenueGrowth >= 0 ? 'bg-white text-success' : 'bg-white text-danger' ?>">
                                    <i class="bi <?= $revenueGrowth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                                    <?= abs($revenueGrowth) ?>%
                                </span>
                                <small class="text-white-50 ms-2">vs last month</small>
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="col-md-3">
            <div class="card stat-card h-100" style="background: linear-gradient(45deg, #4facfe, #00f2fe);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">Total Clients</h6>
                            <h3 class="mb-0 text-white"><?= number_format($totalClients) ?></h3>
                            <div class="mt-2">
                                <span class="trend-indicator <?= $clientGrowth >= 0 ? 'bg-white text-success' : 'bg-white text-danger' ?>">
                                    <i class="bi <?= $clientGrowth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                                    <?= abs($clientGrowth) ?>%
                                </span>
                                <small class="text-white-50 ms-2">vs last month</small>
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Expenses Card Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card stat-card h-100" style="background: linear-gradient(45deg, #ff0844, #ffb199);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-2">Total Expenses</h6>
                            <h3 class="mb-0 text-white">Rs.<?= number_format($totalExpenses, 2) ?></h3>
                            <div class="mt-2">
                                <span class="trend-indicator <?= $expenseGrowth >= 0 ? 'bg-white text-danger' : 'bg-white text-success' ?>">
                                    <i class="bi <?= $expenseGrowth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                                    <?= abs($expenseGrowth) ?>%
                                </span>
                                <small class="text-white-50 ms-2">vs last month</small>
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-3 mb-4">
        <?php if ($isAdmin): ?>
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Revenue vs Expenses</h5>
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            This Month
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">This Week</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="revenueExpenseChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Billboard Status Distribution -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Billboard Status</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="billboardStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Expense Analytics Row -->
    <div class="row g-3 mb-4">
        <!-- Expense Overview -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Expense Overview</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>% of Total</th>
                                    <th>Trend</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($expenseCategories['table'] as $category): ?>
                                <tr>
                                    <td>
                                        <span class="performance-indicator" style="background-color: <?= $category['color'] ?>"></span>
                                        <?= $category['name'] ?>
                                    </td>
                                    <td>Rs.<?= number_format($category['amount'], 2) ?></td>
                                    <td><?= number_format($category['percentage'], 1) ?>%</td>
                                    <td>
                                        <span class="trend-indicator <?= $category['trend'] >= 0 ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' ?>">
                                            <i class="bi <?= $category['trend'] >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                                            <?= abs($category['trend']) ?>%
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-light">
                                    <th>Total Expenses</th>
                                    <th>Rs.<?= number_format($totalExpenses, 2) ?></th>
                                    <th>100%</th>
                                    <th>
                                        <span class="trend-indicator <?= $expenseGrowth >= 0 ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' ?>">
                                            <i class="bi <?= $expenseGrowth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                                            <?= abs($expenseGrowth) ?>%
                                        </span>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profitability Analysis -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Profitability Analysis</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="profitabilityChart"></canvas>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="text-center">
                                <h6 class="text-muted mb-2">Net Profit</h6>
                                <h4 class="mb-0 <?= $netProfit >= 0 ? 'text-success' : 'text-danger' ?>">
                                    Rs.<?= number_format(abs($netProfit), 2) ?>
                                </h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h6 class="text-muted mb-2">Profit Margin</h6>
                                <h4 class="mb-0 <?= $profitMargin >= 0 ? 'text-success' : 'text-danger' ?>">
                                    <?= number_format($profitMargin, 1) ?>%
                                </h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h6 class="text-muted mb-2">ROI</h6>
                                <h4 class="mb-0 <?= $roi >= 0 ? 'text-success' : 'text-danger' ?>">
                                    <?= number_format($roi, 1) ?>%
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Billboard Performance Row -->
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Billboard Performance Analysis</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Billboard</th>
                                    <?php if ($isAdmin): ?><th>Revenue</th><?php endif; ?>
                                    <th>Expenses</th>
                                    <?php if ($isAdmin): ?><th>Net Profit</th><th>Profit Margin</th><?php endif; ?>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($billboardPerformance as $billboard): ?>
                                <tr>
                                    <td><?= $billboard['name'] ?></td>
                                    <?php if ($isAdmin): ?><td>Rs.<?= number_format($billboard['revenue'], 2) ?></td><?php endif; ?>
                                    <td>Rs.<?= number_format($billboard['expenses'], 2) ?></td>
                                    <?php if ($isAdmin): ?>
                                    <td class="<?= $billboard['net_profit'] >= 0 ? 'text-success' : 'text-danger' ?>">
                                        Rs.<?= number_format($billboard['net_profit'], 2) ?>
                                    </td>
                                    <td class="<?= $billboard['profit_margin'] >= 0 ? 'text-success' : 'text-danger' ?>">
                                        <?= number_format($billboard['profit_margin'], 1) ?>%
                                    </td>
                                    <?php endif; ?>
                                    <td>
                                        <span class="badge bg-<?= $billboard['status_color'] ?>">
                                            <?= $billboard['status'] ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Analytics Row -->
    <div class="row g-3 mb-4">
        <!-- Booking Analytics -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Booking Analytics</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Count</th>
                                    <?php if ($isAdmin): ?><th>Revenue</th><?php endif; ?>
                                    <th>Trend</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="performance-indicator bg-success"></span> Active</td>
                                    <td><?= number_format($activeBookings) ?></td>
                                    <?php if ($isAdmin): ?><td>Rs.<?= number_format($activeBookings * 1000, 2) ?></td><?php endif; ?>
                                    <td>
                                        <span class="trend-indicator <?= $bookingGrowth >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?>">
                                            <?= $bookingGrowth ?>%
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="performance-indicator bg-primary"></span> Pending</td>
                                    <td><?= number_format($pendingBookings ?? 0) ?></td>
                                    <?php if ($isAdmin): ?><td>Rs.<?= number_format(($pendingBookings ?? 0) * 1000, 2) ?></td><?php endif; ?>
                                    <td>
                                        <span class="trend-indicator bg-secondary-subtle text-secondary">
                                            -
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="performance-indicator bg-warning"></span> Under Review</td>
                                    <td><?= number_format($reviewBookings ?? 0) ?></td>
                                    <?php if ($isAdmin): ?><td>Rs.<?= number_format(($reviewBookings ?? 0) * 1000, 2) ?></td><?php endif; ?>
                                    <td>
                                        <span class="trend-indicator bg-secondary-subtle text-secondary">
                                            -
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Client Distribution -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Client Distribution</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="clientDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities and Top Billboards Row -->
    <div class="row g-3">
        <!-- Recent Activities -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Activities</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($recentActivities)): ?>
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-activity fs-1"></i>
                            <p class="mt-2">No recent activities</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($recentActivities as $activity): ?>
                            <div class="activity-item">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-<?= $activity['type'] ?>-subtle text-<?= $activity['type'] ?> me-3">
                                        <i class="bi bi-<?= $activity['icon'] ?>"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?= $activity['title'] ?></h6>
                                        <p class="mb-0 text-muted"><?= $activity['description'] ?></p>
                                        <small class="text-muted"><?= $activity['time'] ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Top Performing Billboards -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Top Performing Billboards</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Location</th>
                                    <th>Bookings</th>
                                    <th>Revenue</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($topBillboards as $billboard): ?>
                                    <tr>
                                        <td><?= $billboard['location'] ?></td>
                                        <td><?= number_format($billboard['bookings']) ?></td>
                                        <td>Rs.<?= number_format($billboard['revenue'], 2) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $billboard['status_color'] ?>">
                                                <?= $billboard['status'] ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Calendar and Client Analytics Row -->
    <div class="row g-3 mb-4">
        <!-- Booking Calendar -->
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Booking Calendar</h5>
                    <div class="btn-group">
                        <button type="button" class="btn btn-light btn-sm" data-view="month">Month</button>
                        <button type="button" class="btn btn-light btn-sm" data-view="week">Week</button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <!-- Client Analytics -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Client Analytics</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Client Distribution</h6>
                        <div class="chart-container" style="height: 200px;">
                            <canvas id="clientDistributionChart"></canvas>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Top Clients</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Client</th>
                                        <?php if ($isAdmin): ?><th>Revenue</th><?php endif; ?>
                                        <th>Bookings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($topClients as $client): ?>
                                    <tr>
                                        <td><?= $client['name'] ?></td>
                                        <?php if ($isAdmin): ?><td>Rs.<?= number_format($client['revenue'], 2) ?></td><?php endif; ?>
                                        <td><?= $client['bookings'] ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        <h6 class="text-muted mb-3">Client Metrics</h6>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="border rounded p-3 text-center">
                                    <h6 class="text-muted mb-1">Retention Rate</h6>
                                    <h4 class="mb-0"><?= number_format($clientMetrics['retention_rate'], 1) ?>%</h4>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3 text-center">
                                    <h6 class="text-muted mb-1">New Clients</h6>
                                    <h4 class="mb-0"><?= $clientMetrics['new_clients'] ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Analytics Section -->
    <div class="row g-3 mb-4">
        <?php if ($isAdmin): ?>
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Revenue Analysis</h5>
                    <div class="btn-group">
                        <button type="button" class="btn btn-light btn-sm active" data-period="monthly">Monthly</button>
                        <button type="button" class="btn btn-light btn-sm" data-period="quarterly">Quarterly</button>
                        <button type="button" class="btn btn-light btn-sm" data-period="yearly">Yearly</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="revenueAnalysisChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Financial Health Indicators -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Financial Health</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Profit Margin</h6>
                                <h4 class="mb-0 <?= $profitMargin >= 0 ? 'text-success' : 'text-danger' ?>">
                                    <?= number_format($profitMargin, 1) ?>%
                                </h4>
                            </div>
                            <div class="stat-icon bg-success-subtle text-success">
                                <i class="bi bi-graph-up"></i>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">ROI</h6>
                                <h4 class="mb-0 <?= $roi >= 0 ? 'text-success' : 'text-danger' ?>">
                                    <?= number_format($roi, 1) ?>%
                                </h4>
                            </div>
                            <div class="stat-icon bg-info-subtle text-info">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Cash Flow</h6>
                                <h4 class="mb-0 <?= $cashFlow >= 0 ? 'text-success' : 'text-danger' ?>">
                                    Rs.<?= number_format(abs($cashFlow), 2) ?>
                                </h4>
                            </div>
                            <div class="stat-icon bg-warning-subtle text-warning">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Expense Breakdown and Budget Analysis -->
    <div class="row g-3 mb-4">
        <?php if ($isAdmin): ?>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Expense Breakdown</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="expenseBreakdownChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Budget vs Actual -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Budget vs Actual</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="budgetAnalysisChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Metrics Grid -->
    <div class="row g-3 mb-4">
        <?php if ($isAdmin): ?>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Revenue by Billboard Type</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 250px;">
                        <canvas id="revenueByTypeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Cost Analysis -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Cost Analysis</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>% of Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($costCategories as $category): ?>
                                <tr>
                                    <td><?= $category['name'] ?></td>
                                    <td>$<?= number_format($category['amount'], 2) ?></td>
                                    <td><?= number_format($category['percentage'], 1) ?>%</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Ratios -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Financial Ratios</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-3">
                        <div>
                            <h6 class="text-muted mb-1">Current Ratio</h6>
                            <h4 class="mb-0"><?= number_format($currentRatio, 2) ?></h4>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Debt-to-Equity</h6>
                            <h4 class="mb-0"><?= number_format($debtToEquity, 2) ?></h4>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Return on Assets</h6>
                            <h4 class="mb-0"><?= number_format($returnOnAssets, 1) ?>%</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" />

<script>
// Chart.js global defaults
Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(0, 0, 0, 0.8)';
Chart.defaults.plugins.tooltip.padding = 12;
Chart.defaults.plugins.tooltip.cornerRadius = 8;
Chart.defaults.plugins.tooltip.displayColors = false;

// Initialize Map with custom style


// Initialize Calendar with modern theme
const calendarEl = document.getElementById('calendar');
const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek'
    },
    events: <?= json_encode($calendarEvents) ?>,
    eventClick: function(info) {
        showEventDetails(info.event);
    },
    eventDidMount: function(info) {
        info.el.style.borderRadius = '8px';
        info.el.style.padding = '4px 8px';
        info.el.style.fontSize = '0.9rem';
    }
});
calendar.render();

// Revenue vs Expense Chart
const revenueExpenseCtx = document.getElementById('revenueExpenseChart').getContext('2d');
new Chart(revenueExpenseCtx, {
    type: 'line',
    data: {
        labels: <?= json_encode($revenueExpenseTrends['labels']) ?>,
        datasets: [
            {
                label: 'Revenue',
                data: <?= json_encode($revenueExpenseTrends['revenue']) ?>,
                borderColor: '#00b09b',
                backgroundColor: 'rgba(0, 176, 155, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 2
            },
            {
                label: 'Expenses',
                data: <?= json_encode($revenueExpenseTrends['expenses']) ?>,
                borderColor: '#ff0844',
                backgroundColor: 'rgba(255, 8, 68, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 2
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            intersect: false,
            mode: 'index'
        },
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    usePointStyle: true,
                    padding: 20
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `${context.dataset.label}: $${context.parsed.y.toLocaleString()}`;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    drawBorder: false
                },
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Client Distribution Chart
const clientCtx = document.getElementById('clientDistributionChart').getContext('2d');
new Chart(clientCtx, {
    type: 'doughnut',
    data: {
        labels: ['New', 'Active', 'Inactive'],
        datasets: [{
            data: [
                <?= $clientMetrics['new_clients'] ?>,
                <?= $clientMetrics['active_clients'] ?>,
                <?= $clientMetrics['inactive_clients'] ?>
            ],
            backgroundColor: [
                '#4158D0',
                '#00b09b',
                '#ff0844'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    padding: 20
                }
            }
        }
    }
});

// Billboard Status Chart
const statusCtx = document.getElementById('billboardStatusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Active', 'Booked', 'Under Maintenance', 'Inactive'],
        datasets: [{
            data: [30, 25, 15, 30],
            backgroundColor: [
                '#00b09b',
                '#4158D0',
                '#f6d365',
                '#ff0844'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    padding: 20
                }
            }
        }
    }
});

// Profitability Chart
const profitabilityCtx = document.getElementById('profitabilityChart').getContext('2d');
new Chart(profitabilityCtx, {
    type: 'bar',
    data: {
        labels: ['Revenue', 'Expenses', 'Net Profit'],
        datasets: [{
            data: [
                <?= $totalRevenue ?>,
                <?= $totalExpenses ?>,
                <?= $netProfit ?>
            ],
            backgroundColor: [
                '#00b09b',
                '#ff0844',
                <?= $netProfit >= 0 ? "'#00b09b'" : "'#ff0844'" ?>
            ],
            borderRadius: 8,
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `$${context.parsed.y.toLocaleString()}`;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    drawBorder: false
                },
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Helper function to get status color
function getStatusColor(status) {
    const colors = {
        'active': '#00b09b',
        'booked': '#4158D0',
        'under_maintenance': '#f6d365',
        'inactive': '#ff0844'
    };
    return colors[status] || '#6c757d';
}

// Show event details in a modal
function showEventDetails(event) {
    const modal = new bootstrap.Modal(document.getElementById('eventModal'));
    document.getElementById('eventTitle').textContent = event.title;
    document.getElementById('eventDate').textContent = `${event.start.toLocaleDateString()} - ${event.end.toLocaleDateString()}`;
    document.getElementById('eventStatus').textContent = event.extendedProps.status;
    document.getElementById('eventStatus').className = `badge bg-${getStatusColor(event.extendedProps.status.toLowerCase())}`;
    modal.show();
}

// Add hover effects to quick action buttons
document.querySelectorAll('.quick-action-btn').forEach(btn => {
    btn.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-3px)';
    });
    btn.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
    });
});

// Add map view toggle functionality
document.querySelectorAll('[data-view]').forEach(btn => {
    btn.addEventListener('click', function() {
        const view = this.dataset.view;
        document.querySelectorAll('[data-view]').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        // Update map markers based on view
        updateMapView(view);
    });
});

function updateMapView(view) {
    // Update marker colors and popup content based on selected view
    // Implementation depends on your specific requirements
}

// Revenue Analysis Chart
const revenueCtx = document.getElementById('revenueAnalysisChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: <?= json_encode($revenueTrends['labels']) ?>,
        datasets: [
            {
                label: 'Revenue',
                data: <?= json_encode($revenueTrends['revenue']) ?>,
                borderColor: '#00b09b',
                backgroundColor: 'rgba(0, 176, 155, 0.1)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Expenses',
                data: <?= json_encode($revenueTrends['expenses']) ?>,
                borderColor: '#ff0844',
                backgroundColor: 'rgba(255, 8, 68, 0.1)',
                tension: 0.4,
                fill: true
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Expense Breakdown Chart
const expenseCtx = document.getElementById('expenseBreakdownChart').getContext('2d');
new Chart(expenseCtx, {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($expenseCategories['chart']['labels']) ?>,
        datasets: [{
            data: <?= json_encode($expenseCategories['chart']['data']) ?>,
            backgroundColor: <?= json_encode($expenseCategories['chart']['colors']) ?>,
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let label = context.label || '';
                        let value = context.raw || 0;
                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                        let percentage = ((value / total) * 100).toFixed(1);
                        return `${label}: $${value.toLocaleString()} (${percentage}%)`;
                    }
                }
            }
        }
    }
});

// Budget Analysis Chart
const budgetCtx = document.getElementById('budgetAnalysisChart').getContext('2d');
new Chart(budgetCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($budgetAnalysis['labels']) ?>,
        datasets: [
            {
                label: 'Budget',
                data: <?= json_encode($budgetAnalysis['budget']) ?>,
                backgroundColor: '#4158D0'
            },
            {
                label: 'Actual',
                data: <?= json_encode($budgetAnalysis['actual']) ?>,
                backgroundColor: '#00b09b'
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `${context.dataset.label}: Rs.${context.parsed.y.toLocaleString()}`;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rs.' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Revenue by Type Chart
const revenueTypeCtx = document.getElementById('revenueByTypeChart').getContext('2d');
new Chart(revenueTypeCtx, {
    type: 'pie',
    data: {
        labels: <?= json_encode($revenueByType['labels']) ?>,
        datasets: [{
            data: <?= json_encode($revenueByType['data']) ?>,
            backgroundColor: [
                '#4158D0',
                '#00b09b',
                '#f6d365',
                '#ff0844'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'right'
            }
        }
    }
});
</script>
<?= $this->endSection() ?>
