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
            <div class="card stat-card h-100" style="background: linear-gradient(45deg, #4158D0, #C850C0);">
                <div class="card-body text-white">
                    <h6 class="text-white-50 mb-2">Total Bookings</h6>
                    <h3 class="mb-0 text-white"><?= number_format($totalBookings ?? 0) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card h-100" style="background: linear-gradient(45deg, #00b09b, #96c93d);">
                <div class="card-body text-white">
                    <h6 class="text-white-50 mb-2">Active Bookings</h6>
                    <h3 class="mb-0 text-white"><?= number_format($activeBookings ?? 0) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card h-100" style="background: linear-gradient(45deg, #ff0844, #ffb199);">
                <div class="card-body text-white">
                    <h6 class="text-white-50 mb-2">Total Expenses</h6>
                    <h3 class="mb-0 text-white">Rs.<?= number_format($totalExpenses ?? 0, 2) ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card stat-card h-100" style="background: linear-gradient(45deg, #4facfe, #00f2fe);">
                <div class="card-body text-white">
                    <h6 class="text-white-50 mb-2">Total Hoardings</h6>
                    <h3 class="mb-0 text-white"><?= number_format($totalHoardings ?? 0) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card h-100" style="background: linear-gradient(45deg, #00b09b, #388e3c);">
                <div class="card-body text-white">
                    <h6 class="text-white-50 mb-2">Active Hoardings</h6>
                    <h3 class="mb-0 text-white"><?= number_format($activeHoardings ?? 0) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card h-100" style="background: linear-gradient(45deg, #f6d365, #fda085);">
                <div class="card-body text-white">
                    <h6 class="text-white-50 mb-2">Total Revenue</h6>
                    <h3 class="mb-0 text-white">Rs.<?= number_format($totalRevenue ?? 0, 2) ?></h3>
                </div>
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
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">Booking Status</div>
                <div class="card-body">
                    <canvas id="bookingStatusChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">Expense Type Breakdown</div>
                <div class="card-body">
                    <canvas id="expenseTypesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

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
// Booking Status
const bookingStatus = <?= json_encode($bookingStatus ?? []) ?>;
const bookingStatusLabels = bookingStatus.map(item => 'Status ' + item.status_id);
const bookingStatusData = bookingStatus.map(item => item.count);
new Chart(document.getElementById('bookingStatusChart'), {
    type: 'doughnut',
    data: {
        labels: bookingStatusLabels,
        datasets: [{
            data: bookingStatusData,
            backgroundColor: ['#00b09b', '#4158D0', '#f6d365', '#ff0844']
        }]
    }
});
// Expense Types
const expenseTypes = <?= json_encode($expenseTypes ?? []) ?>;
const expenseTypesLabels = expenseTypes.map(item => item.type);
const expenseTypesData = expenseTypes.map(item => item.total);
new Chart(document.getElementById('expenseTypesChart'), {
    type: 'doughnut',
    data: {
        labels: expenseTypesLabels,
        datasets: [{
            data: expenseTypesData,
            backgroundColor: ['#4158D0', '#00b09b', '#f6d365', '#ff0844']
        }]
    }
});
</script>
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
