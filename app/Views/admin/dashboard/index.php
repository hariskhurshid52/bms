<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Dashboard</h4>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="text-muted fw-normal mt-0" title="Total Billboards">Total Billboards</h5>
                            <h3 class="mt-3 mb-3"><?= $totalBillboards ?></h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2">
                                    <i class="mdi mdi-arrow-up-bold"></i> <?= round(($activeBillboards / $totalBillboards) * 100) ?>%
                                </span>
                                <span class="text-nowrap">Active Rate</span>
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded bg-primary">
                                <i class="fas fa-billboard fa-2x text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="text-muted fw-normal mt-0" title="Active Billboards">Active Billboards</h5>
                            <h3 class="mt-3 mb-3"><?= $activeBillboards ?></h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2">
                                    <i class="mdi mdi-arrow-up-bold"></i> <?= round(($activeBillboards / $totalBillboards) * 100) ?>%
                                </span>
                                <span class="text-nowrap">Of Total Billboards</span>
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded bg-success">
                                <i class="fas fa-check-circle fa-2x text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="text-muted fw-normal mt-0" title="Total Revenue">Total Revenue</h5>
                            <h3 class="mt-3 mb-3">$<?= number_format($totalRevenue, 2) ?></h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2">
                                    <i class="mdi mdi-arrow-up-bold"></i> <?= round(($monthlyRevenue / $totalRevenue) * 100) ?>%
                                </span>
                                <span class="text-nowrap">This Month</span>
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded bg-info">
                                <i class="fas fa-dollar-sign fa-2x text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="text-muted fw-normal mt-0" title="Monthly Revenue">Monthly Revenue</h5>
                            <h3 class="mt-3 mb-3">$<?= number_format($monthlyRevenue, 2) ?></h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2">
                                    <i class="mdi mdi-arrow-up-bold"></i> <?= round(($monthlyRevenue / $totalRevenue) * 100) ?>%
                                </span>
                                <span class="text-nowrap">Of Total Revenue</span>
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded bg-warning">
                                <i class="fas fa-chart-line fa-2x text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Monthly Bookings Chart -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Monthly Bookings</h4>
                    <canvas id="monthlyBookingsChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Billboard Status Chart -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Billboard Status</h4>
                    <canvas id="billboardStatusChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue and Top Performers Row -->
    <div class="row">
        <!-- Revenue by Billboard Type -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Revenue by Billboard Type</h4>
                    <canvas id="revenueByTypeChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Performing Billboards -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Top Performing Billboards</h4>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Billboard</th>
                                    <th>Type</th>
                                    <th>Bookings</th>
                                    <th>Revenue</th>
                                    <th>Price/Day</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($topPerformingBillboards as $billboard): ?>
                                <tr>
                                    <td><?= $billboard['name'] ?></td>
                                    <td><?= $billboard['type_name'] ?></td>
                                    <td><?= $billboard['total_orders'] ?></td>
                                    <td>$<?= number_format($billboard['total_revenue'], 2) ?></td>
                                    <td>$<?= number_format($billboard['booking_price'], 2) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Billboards -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Active Billboards</h4>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Location</th>
                                    <th>Size</th>
                                    <th>Price/Day</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($billboardDetails as $billboard): ?>
                                <tr>
                                    <td><?= $billboard['name'] ?></td>
                                    <td><?= $billboard['type_name'] ?></td>
                                    <td><?= $billboard['city_name'] ?></td>
                                    <td><?= $billboard['height'] ?> x <?= $billboard['width'] ?> <?= $billboard['size_type'] ?></td>
                                    <td>$<?= number_format($billboard['booking_price'], 2) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $billboard['status'] == 'active' ? 'success' : 'warning' ?>">
                                            <?= ucfirst($billboard['status']) ?>
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

    <!-- Recent Orders -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Recent Orders</h4>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Billboard</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentOrders as $order): ?>
                                <tr>
                                    <td>#<?= $order['id'] ?></td>
                                    <td><?= $order['billboard_name'] ?></td>
                                    <td><?= $order['customer_name'] ?></td>
                                    <td>$<?= number_format($order['amount'], 2) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $order['status_id'] == 1 ? 'success' : 'warning' ?>">
                                            <?= $order['status_name'] ?>
                                        </span>
                                    </td>
                                    <td><?= date('M d, Y', strtotime($order['start_date'])) ?></td>
                                    <td><?= date('M d, Y', strtotime($order['end_date'])) ?></td>
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
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Monthly Bookings Chart
const monthlyBookingsCtx = document.getElementById('monthlyBookingsChart').getContext('2d');
new Chart(monthlyBookingsCtx, {
    type: 'line',
    data: {
        labels: <?= json_encode($monthlyBookings['months']) ?>,
        datasets: [{
            label: 'Bookings',
            data: <?= json_encode($monthlyBookings['bookings']) ?>,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Billboard Status Chart
const billboardStatusCtx = document.getElementById('billboardStatusChart').getContext('2d');
new Chart(billboardStatusCtx, {
    type: 'doughnut',
    data: {
        labels: <?= json_encode(array_column($billboardStatus, 'status')) ?>,
        datasets: [{
            data: <?= json_encode(array_column($billboardStatus, 'count')) ?>,
            backgroundColor: ['#0ab39c', '#f06548', '#f7b84b']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Revenue by Type Chart
const revenueByTypeCtx = document.getElementById('revenueByTypeChart').getContext('2d');
new Chart(revenueByTypeCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($revenueByType, 'type_name')) ?>,
        datasets: [{
            label: 'Revenue',
            data: <?= json_encode(array_column($revenueByType, 'total_revenue')) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgb(54, 162, 235)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<?= $this->endSection() ?> 