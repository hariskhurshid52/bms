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
<div class="container-fluid" style="margin-top: 32px;">
    <!-- Admin Summary Cards Row (3 per row) -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <a href="<?= route_to('admin.orders.list') ?>" class="card stat-card h-100" style="background: linear-gradient(45deg, #4158D0, #C850C0);">
                <div class="card-body text-white">
                    <h6 class="text-white mb-2">Total Bookings</h6>
                    <h3 class="mb-0 text-white"><?= number_format($totalBookings ?? 0) ?></h3>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="<?= route_to('admin.orders.list') ?>?bookingstatus=active" class="card stat-card h-100" style="background: linear-gradient(45deg, #00b09b, #96c93d);">
                <div class="card-body text-white">
                    <h6 class="text-white mb-2">Active Bookings</h6>
                    <h3 class="mb-0 text-white"><?= number_format($activeBookings ?? 0) ?></h3>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <div class="card stat-card h-100" style="background: linear-gradient(45deg, #ff0844, #ffb199);">
                <a href="<?= route_to('admin.expense.list') ?>" class="card-body text-white">
                    <h6 class="text-white mb-2">Total Expenses</h6>
                    <h3 class="mb-0 text-white">Rs.<?= number_format($totalExpenses ?? 0, 2) ?></h3>
                </a>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card stat-card h-100" style="background: linear-gradient(45deg, #4facfe, #00f2fe);">
                <a href="<?= route_to('admin.billboard.list') ?>" class="card-body text-white">
                    <h6 class="text-white mb-2">Total Hoardings</h6>
                    <h3 class="mb-0 text-white"><?= number_format($totalHoardings ?? 0) ?></h3>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card h-100" style="background: linear-gradient(45deg, #00b09b, #388e3c);">
                <a href="<?= route_to('admin.billboard.list') ?>?status=available" class="card-body text-white">
                    <h6 class="text-white mb-2">Active Hoardings</h6>
                    <h3 class="mb-0 text-white"><?= number_format($activeHoardings ?? 0) ?></h3>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card h-100" style="background: linear-gradient(45deg, #f6d365, #fda085);">
                <a href="<?= route_to('admin.report.hoardingWiseRevenue') ?>" class="card-body text-white">
                    <h6 class="text-white mb-2">Total Revenue</h6>
                    <h3 class="mb-0 text-white">Rs.<?= number_format($totalRevenue ?? 0, 2) ?></h3>
                </a>
            </div>
        </div>
    </div>

    <!-- Admin Charts Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">Bookings Per Month</div>
                <div class="card-body">
                    <canvas id="bookingsPerMonthChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">Expenses Per Month</div>
                <div class="card-body">
                    <canvas id="expensesPerMonthChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">Bookings Per Board</div>
                <div class="card-body">
                    <canvas id="bookingsPerBoardChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">Available vs Booked Boards</div>
                <div class="card-body">
                    <canvas id="boardsStatusChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">Top Customers by Bookings</div>
                <div class="card-body">
                    <canvas id="topBookingCustomersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">Expense Per Board</div>
                <div class="card-body">
                    <canvas id="expensesPerBoardChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">Revenue Per Board</div>
                <div class="card-body">
                    <canvas id="revenuePerBoardChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">Net Profit Per Board</div>
                <div class="card-body">
                    <canvas id="netProfitPerBoardChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Bookings Per Month
const bookingsPerMonth = <?= json_encode($bookingsPerMonth ?? []) ?>;
const bookingsLabels = bookingsPerMonth.map(item => item.month);
const bookingsData = bookingsPerMonth.map(item => item.count);
new Chart(document.getElementById('bookingsPerMonthChart'), {
    type: 'bar',
    data: {
        labels: bookingsLabels,
        datasets: [{
            label: 'Bookings',
            data: bookingsData,
            backgroundColor: '#4158D0'
        }]
    }
});
// Expenses Per Month
const expensesPerMonth = <?= json_encode($expensesPerMonth ?? []) ?>;
const expensesLabels = expensesPerMonth.map(item => item.month);
const expensesData = expensesPerMonth.map(item => item.total);
new Chart(document.getElementById('expensesPerMonthChart'), {
    type: 'bar',
    data: {
        labels: expensesLabels,
        datasets: [{
            label: 'Expenses',
            data: expensesData,
            backgroundColor: '#ff0844'
        }]
    }
});
// Bookings Per Board
const bookingsPerBoard = <?= json_encode($bookingsPerBoard ?? []) ?>;
const bookingsPerBoardLabels = bookingsPerBoard.map(item => item.board_name);
const bookingsPerBoardData = bookingsPerBoard.map(item => item.total_bookings);
new Chart(document.getElementById('bookingsPerBoardChart'), {
    type: 'bar',
    data: {
        labels: bookingsPerBoardLabels,
        datasets: [{
            label: 'Total Bookings',
            data: bookingsPerBoardData,
            backgroundColor: '#00b09b'
        }]
    },
    options: {
        plugins: {
            legend: { display: false },
            title: { display: true, text: 'Bookings Per Board' }
        },
        scales: {
            x: { title: { display: true, text: 'Board Name' } },
            y: { title: { display: true, text: 'Total Bookings' }, beginAtZero: true }
        }
    }
});
// Expense Per Board
const expensesPerBoard = <?= json_encode($expensesPerBoard ?? []) ?>;
const expensesPerBoardLabels = expensesPerBoard.map(item => item.board_name);
const expensesPerBoardData = expensesPerBoard.map(item => item.total_expenses);
new Chart(document.getElementById('expensesPerBoardChart'), {
    type: 'bar',
    data: {
        labels: expensesPerBoardLabels,
        datasets: [{
            label: 'Total Expenses',
            data: expensesPerBoardData,
            backgroundColor: '#ff0844'
        }]
    },
    options: {
        plugins: {
            legend: { display: false },
            title: { display: true, text: 'Expense Per Board' }
        },
        scales: {
            x: { title: { display: true, text: 'Board Name' } },
            y: { title: { display: true, text: 'Total Expenses' }, beginAtZero: true }
        }
    }
});
// Revenue Per Board
const revenuePerBoard = <?= json_encode($revenuePerBoard ?? []) ?>;
const revenuePerBoardLabels = revenuePerBoard.map(item => item.board_name);
const revenuePerBoardData = revenuePerBoard.map(item => item.total_revenue);
new Chart(document.getElementById('revenuePerBoardChart'), {
    type: 'bar',
    data: {
        labels: revenuePerBoardLabels,
        datasets: [{
            label: 'Total Revenue',
            data: revenuePerBoardData,
            backgroundColor: '#00b09b'
        }]
    },
    options: {
        plugins: {
            legend: { display: false },
            title: { display: true, text: 'Revenue Per Board' }
        },
        scales: {
            x: { title: { display: true, text: 'Board Name' } },
            y: { title: { display: true, text: 'Total Revenue' }, beginAtZero: true }
        }
    }
});
// Net Profit Per Board
const netProfitPerBoard = <?= json_encode($netProfitPerBoard ?? []) ?>;
const netProfitPerBoardLabels = netProfitPerBoard.map(item => item.board_name);
const netProfitPerBoardData = netProfitPerBoard.map(item => item.net_profit);
new Chart(document.getElementById('netProfitPerBoardChart'), {
    type: 'bar',
    data: {
        labels: netProfitPerBoardLabels,
        datasets: [{
            label: 'Net Profit',
            data: netProfitPerBoardData,
            backgroundColor: '#4158D0'
        }]
    },
    options: {
        plugins: {
            legend: { display: false },
            title: { display: true, text: 'Net Profit Per Board' }
        },
        scales: {
            x: { title: { display: true, text: 'Board Name' } },
            y: { title: { display: true, text: 'Net Profit' }, beginAtZero: true }
        }
    }
});
// Top Customers by Bookings
const topBookingCustomers = <?= json_encode($topBookingCustomers ?? []) ?>;
const topBookingCustomersLabels = topBookingCustomers.map(item => `${item.first_name} ${item.last_name}`);
const topBookingCustomersData = topBookingCustomers.map(item => item.total_bookings);
new Chart(document.getElementById('topBookingCustomersChart'), {
    type: 'bar',
    data: {
        labels: topBookingCustomersLabels,
        datasets: [{
            label: 'Total Bookings',
            data: topBookingCustomersData,
            backgroundColor: '#4facfe'
        }]
    },
    options: {
        plugins: {
            legend: { display: false },
            title: { display: true, text: 'Top Customers by Bookings' }
        },
        scales: {
            x: { title: { display: true, text: 'Customer Name' } },
            y: { title: { display: true, text: 'Total Bookings' }, beginAtZero: true }
        }
    }
});
// Boards Status Pie Chart
const billboardStatus = <?= json_encode($billboardStatus ?? []) ?>;
new Chart(document.getElementById('boardsStatusChart'), {
    type: 'pie',
    data: {
        labels: ['Available', 'Booked'],
        datasets: [{
            data: [
                billboardStatus.available || 0,
                billboardStatus.booked || 0
            ],
            backgroundColor: ['#00b09b', 'green']
        }]
    },
    options: {
        plugins: {
            legend: { display: true, position: 'top' },
            title: { display: true, text: 'Available vs Booked Boards' }
        }
    }
});
</script>
<?= $this->endSection() ?>
