<?= $this->extend('common/default-nav') ?>

<?= $this->section('styles') ?>
<style>
    .board-card-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 12px 12px 0 0;
    }
    .board-status-badge {
        font-size: 0.95rem;
        border-radius: 8px;
        padding: 4px 12px;
        font-weight: 600;
    }
    .card-footer {
        background: #f8f9fa;
        border-top: 1px solid #eee;
        border-radius: 0 0 12px 12px;
    }
    .stat-card {
        border: none;
        border-radius: 20px;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
        color: #fff;
        min-height: 110px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        padding: 24px 32px;
        font-size: 1.1rem;
    }
    .stat-card.total { background: linear-gradient(45deg, #4158D0, #C850C0); }
    .stat-card.available { background: linear-gradient(45deg, #00b09b, #96c93d); }
    .stat-card.booked { background: linear-gradient(45deg, #ff0844, #ffb199); }
    .stat-card.inactive { background: linear-gradient(45deg, #4facfe, #00f2fe); }
    .stat-card.maintenance { background: linear-gradient(45deg, #f6d365, #fda085); }
    .stat-card .stat-label { font-size: 1.05rem; opacity: 0.8; margin-bottom: 6px; }
    .stat-card .stat-value { font-size: 2.1rem; font-weight: 700; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid" style="margin-top: 32px;">
    <!-- Status Summary Cards -->
    <div class="row mb-4">
        <div class="col">
            <div class="stat-card total">
                <div class="stat-label">Total</div>
                <div class="stat-value"><?= $statusCounts['total'] ?></div>
            </div>
        </div>
        <div class="col">
            <div class="stat-card available">
                <div class="stat-label">Available</div>
                <div class="stat-value"><?= $statusCounts['available'] ?></div>
            </div>
        </div>
        <div class="col">
            <div class="stat-card booked">
                <div class="stat-label">Booked</div>
                <div class="stat-value"><?= $statusCounts['booked'] ?></div>
            </div>
        </div>
        <div class="col">
            <div class="stat-card inactive">
                <div class="stat-label">Inactive</div>
                <div class="stat-value"><?= $statusCounts['inactive'] ?></div>
            </div>
        </div>
        <div class="col">
            <div class="stat-card maintenance">
                <div class="stat-label">Under Maintenance</div>
                <div class="stat-value"><?= $statusCounts['under_maintenance'] ?></div>
            </div>
        </div>
    </div>
    <!-- Filter Bar -->
    <div class="row mb-3">
        <div class="col-md-3">
            <select class="form-select" id="statusFilter">
                <option value="">All Status</option>
                <option value="active">Available</option>
                <option value="booked">Booked</option>
                <option value="inactive">Inactive</option>
                <option value="under_maintenance">Under Maintenance</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" id="areaFilter" placeholder="Search by Area/Location">
        </div>
    </div>
    <!-- Board Cards Grid -->
    <div class="row" id="boardsGrid">
        <?php foreach ($boards as $board): ?>
            <div class="col-md-4 mb-4 board-card" data-status="<?= $board['status'] ?>" data-area="<?= strtolower($board['address']) ?>">
                <div class="card h-100">
                    <img src="<?= $board['image_url'] ?? base_url('assets/images/placeholder.png') ?>" class="board-card-img" alt="Board Image">
                    <div class="card-body">
                        <h5 class="card-title mb-1"><?= esc($board['name']) ?></h5>
                        <div class="mb-2 text-muted" style="font-size:0.97rem;">
                            <i class="bi bi-geo-alt"></i> <?= esc($board['address']) ?>
                        </div>
                        <span class="board-status-badge bg-<?=
                            $board['status'] == 'active' ? 'success' :
                            ($board['status'] == 'booked' ? 'warning' :
                            ($board['status'] == 'inactive' ? 'secondary' : 'info'))
                        ?> text-white">
                            <?=
                                $board['status'] == 'active' ? 'Available' :
                                ($board['status'] == 'booked' ? 'Booked' :
                                ($board['status'] == 'inactive' ? 'Inactive' : 'Under Maintenance'))
                            ?>
                        </span>
                    </div>
                    <div class="card-footer text-center">
                        <?php if ($board['status'] == 'active'): ?>
                            <button class="btn btn-success">Book Now</button>
                        <?php else: ?>
                            <button class="btn btn-secondary" disabled>Not Available</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Simple client-side filtering
    document.getElementById('statusFilter').addEventListener('change', function() {
        filterBoards();
    });
    document.getElementById('areaFilter').addEventListener('input', function() {
        filterBoards();
    });
    function filterBoards() {
        const status = document.getElementById('statusFilter').value;
        const area = document.getElementById('areaFilter').value.toLowerCase();
        document.querySelectorAll('.board-card').forEach(card => {
            const matchesStatus = !status || card.getAttribute('data-status') === status;
            const matchesArea = !area || card.getAttribute('data-area').includes(area);
            card.style.display = (matchesStatus && matchesArea) ? '' : 'none';
        });
    }
</script>
<?= $this->endSection() ?>