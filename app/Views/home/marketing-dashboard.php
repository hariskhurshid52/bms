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

    @keyframes blink {
        0% { opacity: 1; }
        50% { opacity: 0; }
        100% { opacity: 1; }
    }

    .blinking-notification {
        animation: blink 1s linear infinite;
        font-size: 0.8rem;
        font-weight: bold;
        color: #ffc107;
        margin-left: 5px;
    }

    /* Hoarding Card Improvements */
    .board-card .card {
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    .board-card .card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    }
    .board-card .card-body {
        padding: 1.25rem;
    }
    .board-card .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }
    .board-card .location-text {
        color: #6c757d;
        font-size: 0.95rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .board-card .btn-success {
        padding: 8px 20px;
        font-weight: 500;
        border-radius: 6px;
    }
    .board-card .btn-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
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
                    <?php if (!empty($board['images'])): ?>
                        <img src="<?= $board['images'][0] ?>" class="board-card-img" data-board="<?= $board['id'] ?>" style="cursor: pointer;" alt="Board Image">
                    <?php else: ?>
                        <img src="<?= base_url('assets/images/placeholder.png') ?>" class="board-card-img" alt="No Image Available">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title">
                            <?= esc($board['name']) ?>
                            <?php
                                $showNotification = false;
                                if (!empty($board['last_booking_end_date'])) {
                                    $endDate = strtotime($board['last_booking_end_date']);
                                    $today = time();
                                    $fiveDaysLater = strtotime('+5 days');
                                    if ($endDate > $today && $endDate <= $fiveDaysLater) {
                                        $showNotification = true;
                                    }
                                }
                            ?>
                            <?php if ($showNotification): ?>
                                <span class="blinking-notification"><i class="bi bi-exclamation-circle-fill"></i> Vacating Soon</span>
                            <?php endif; ?>
                        </h5>
                        <div class="location-text">
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
                            <a href="<?= route_to('admin.order.create') ?>?billboard=<?= $board['id'] ?>" class="btn btn-success">Book Now</a>
                        <?php else: ?>
                            <button class="btn btn-secondary" disabled>Not Available</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Carousel Modal -->
<div class="modal fade" id="imageCarouselModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Board Images</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="carouselImages" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" id="carouselImagesInner"></div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>
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
    // Carousel logic
    const boards = <?= json_encode($boards) ?>;
    $(document).on('click', '.board-card-img', function() {
        const boardId = $(this).data('board');
        const board = boards.find(b => b.id == boardId);
        if (!board || !board.images.length) return;
        let html = '';
        board.images.forEach((img, idx) => {
            html += `<div class="carousel-item${idx==0?' active':''}">
                <img src="${img}" class="d-block w-100" style="max-height:65vh;object-fit:contain;">
            </div>`;
        });
        $('#carouselImagesInner').html(html);
        var carousel = new bootstrap.Carousel(document.getElementById('carouselImages'));
        carousel.to(0);
        $('#imageCarouselModal').modal('show');
    });
</script>
<?= $this->endSection() ?>