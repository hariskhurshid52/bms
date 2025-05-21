<?= $this->extend('common/default-nav') ?>

<?= $this->section('styles') ?>
<style>
    .stat-card {
        border-radius: 15px;
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
    .activity-item {
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }
    .activity-item:hover {
        background: rgba(0,0,0,0.02);
    }
    .chart-container {
        position: relative;
        height: 300px;
    }
    .performance-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }
    .trend-indicator {
        font-size: 0.8rem;
        padding: 2px 8px;
        border-radius: 12px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Statistics Cards Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Billboards</h6>
                            <h3 class="mb-0"><?= number_format($totalBillboards) ?></h3>
                            <div class="mt-2">
                                <span class="trend-indicator <?= $billboardGrowth >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?>">
                                    <i class="bi <?= $billboardGrowth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                                    <?= abs($billboardGrowth) ?>%
                                </span>
                                <small class="text-muted ms-2">vs last month</small>
                            </div>
                        </div>
                        <div class="stat-icon bg-primary-subtle text-primary">
                            <i class="bi bi-signpost-split-fill fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Active Bookings</h6>
                            <h3 class="mb-0"><?= number_format($activeBookings) ?></h3>
                            <div class="mt-2">
                                <span class="trend-indicator <?= $bookingGrowth >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?>">
                                    <i class="bi <?= $bookingGrowth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                                    <?= abs($bookingGrowth) ?>%
                                </span>
                                <small class="text-muted ms-2">vs last month</small>
                            </div>
                        </div>
                        <div class="stat-icon bg-success-subtle text-success">
                            <i class="bi bi-calendar-check-fill fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Revenue</h6>
                            <h3 class="mb-0">$<?= number_format($totalRevenue, 2) ?></h3>
                            <div class="mt-2">
                                <span class="trend-indicator <?= $revenueGrowth >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?>">
                                    <i class="bi <?= $revenueGrowth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                                    <?= abs($revenueGrowth) ?>%
                                </span>
                                <small class="text-muted ms-2">vs last month</small>
                            </div>
                        </div>
                        <div class="stat-icon bg-warning-subtle text-warning">
                            <i class="bi bi-currency-dollar fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Clients</h6>
                            <h3 class="mb-0"><?= number_format($totalClients) ?></h3>
                            <div class="mt-2">
                                <span class="trend-indicator <?= $clientGrowth >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?>">
                                    <i class="bi <?= $clientGrowth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                                    <?= abs($clientGrowth) ?>%
                                </span>
                                <small class="text-muted ms-2">vs last month</small>
                            </div>
                        </div>
                        <div class="stat-icon bg-info-subtle text-info">
                            <i class="bi bi-people-fill fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-3 mb-4">
        <!-- Revenue Overview -->
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
                                <?php foreach ($expenseCategories as $category): ?>
                                <tr>
                                    <td>
                                        <span class="performance-indicator" style="background-color: <?= $category['color'] ?>"></span>
                                        <?= $category['name'] ?>
                                    </td>
                                    <td>$<?= number_format($category['amount'], 2) ?></td>
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
                                    <th>$<?= number_format($totalExpenses, 2) ?></th>
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
                                    $<?= number_format(abs($netProfit), 2) ?>
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
                                    <th>Revenue</th>
                                    <th>Expenses</th>
                                    <th>Net Profit</th>
                                    <th>Profit Margin</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($billboardPerformance as $billboard): ?>
                                <tr>
                                    <td><?= $billboard['name'] ?></td>
                                    <td>$<?= number_format($billboard['revenue'], 2) ?></td>
                                    <td>$<?= number_format($billboard['expenses'], 2) ?></td>
                                    <td class="<?= $billboard['net_profit'] >= 0 ? 'text-success' : 'text-danger' ?>">
                                        $<?= number_format($billboard['net_profit'], 2) ?>
                                    </td>
                                    <td class="<?= $billboard['profit_margin'] >= 0 ? 'text-success' : 'text-danger' ?>">
                                        <?= number_format($billboard['profit_margin'], 1) ?>%
                                    </td>
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
                                    <th>Revenue</th>
                                    <th>Trend</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="performance-indicator bg-success"></span> Active</td>
                                    <td><?= number_format($activeBookings) ?></td>
                                    <td>$<?= number_format($activeBookings * 1000, 2) ?></td>
                                    <td>
                                        <span class="trend-indicator <?= $bookingGrowth >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?>">
                                            <?= $bookingGrowth ?>%
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="performance-indicator bg-primary"></span> Pending</td>
                                    <td><?= number_format($pendingBookings ?? 0) ?></td>
                                    <td>$<?= number_format(($pendingBookings ?? 0) * 1000, 2) ?></td>
                                    <td>
                                        <span class="trend-indicator bg-secondary-subtle text-secondary">
                                            -
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="performance-indicator bg-warning"></span> Under Review</td>
                                    <td><?= number_format($reviewBookings ?? 0) ?></td>
                                    <td>$<?= number_format(($reviewBookings ?? 0) * 1000, 2) ?></td>
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
                                        <td>$<?= number_format($billboard['revenue'], 2) ?></td>
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
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
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
                borderColor: '#198754',
                tension: 0.4,
                fill: false
            },
            {
                label: 'Expenses',
                data: <?= json_encode($revenueExpenseTrends['expenses']) ?>,
                borderColor: '#dc3545',
                tension: 0.4,
                fill: false
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
                '#198754',
                '#dc3545',
                <?= $netProfit >= 0 ? "'#198754'" : "'#dc3545'" ?>
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
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

// Billboard Status Chart
const statusCtx = document.getElementById('billboardStatusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Active', 'Booked', 'Under Maintenance', 'Inactive'],
        datasets: [{
            data: [30, 25, 15, 30],
            backgroundColor: [
                '#198754',
                '#0d6efd',
                '#ffc107',
                '#dc3545'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Client Distribution Chart
const clientCtx = document.getElementById('clientDistributionChart').getContext('2d');
new Chart(clientCtx, {
    type: 'bar',
    data: {
        labels: ['New', 'Active', 'Inactive'],
        datasets: [{
            label: 'Clients',
            data: [15, 25, 10],
            backgroundColor: [
                '#0d6efd',
                '#198754',
                '#dc3545'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<?= $this->endSection() ?>
