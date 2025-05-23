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
<?= $this->extend('common/default-nav') ?> <?= $this->section('content') ?>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Hording Listing <a href="<?= route_to('admin.billboard.create') ?>"
                        class="btn btn-primary btn-sm pull-right" role="button">Add New</a></h4>
                <hr />
                <!-- Modern Filter Card Section -->
                <div class="filter-card mb-4">
                    <div class="card-header pb-0 mb-3">
                        <i class="bi bi-search"></i> Search Filters
                    </div>
                    <form id="filterForm">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label for="filterCity" class="form-label">City</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" class="form-control" id="filterCity" name="city" placeholder="City">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="filterArea" class="form-label">Area</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-signpost"></i></span>
                                    <input type="text" class="form-control" id="filterArea" name="area" placeholder="Area">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="filterType" class="form-label">Type</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-columns-gap"></i></span>
                                    <select class="form-select" id="filterType" name="type">
                                        <option value="">All Types</option>
                                        <option value="1">Digital</option>
                                        <option value="2">Static</option>
                                        <option value="3">LED</option>
                                        <option value="4">Banner</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="filterStatus" class="form-label">Status</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-info-circle"></i></span>
                                    <select class="form-select" id="filterStatus" name="status">
                                        <option value="">All Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="under_maintenance">Under Maintenance</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 filter-actions">
                                <button type="button" class="btn btn-primary w-100" id="applyFilters"><i class="bi bi-funnel"></i> Apply</button>
                                <button type="button" class="btn btn-clear w-100 ms-2" id="clearFilters"><i class="bi bi-x"></i> Clear</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="dtBillboard">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Booking Price</th>
                                <th>City</th>
                                <th>Area</th>
                                <th>Dimension</th>
                                <th>Status</th>
                                <th>Installation Date</th>
                                <th>Added At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Image Preview Modal with Carousel -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imagePreviewModalLabel">Billboard Images</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="billboardCarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner" id="carouselImagesContainer">
            <!-- Images will be injected here -->
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#billboardCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#billboardCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script>
    $(document).ready(function () {
        var table = $('#dtBillboard').DataTable({
            processing: true,
            ordering: false,
            serverSide: true,
            ajax: {
                url: "<?= route_to('admin.billboard.dtList') ?>",
                type: "POST",
                dataType: "json",
                data: function (d) {
                    d['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
                    d.type = $('#filterType').val();
                    d.status = $('#filterStatus').val();
                    d.city = $('#filterCity').val();
                    d.area = $('#filterArea').val();
                }
            },
            columnDefs: [
                {
                    targets: 0,
                    render: function(data, type, row, meta) {
                        var srcMatch = data.match(/src=["']([^"']+)["']/);
                        var src = srcMatch ? srcMatch[1] : '';
                        return '<a href="#" class="preview-image-link" data-row="'+meta.row+'">'+data+'</a>';
                    }
                }
            ]
        });
        $('#applyFilters').on('click', function() {
            table.ajax.reload();
        });
        $('#clearFilters').on('click', function() {
            $('#filterForm')[0].reset();
            table.ajax.reload();
        });
        $(document).on('click', '.preview-image-link', function(e) {
            e.preventDefault();
            var rowIdx = $(this).data('row');
            var rowData = table.row(rowIdx).data();
            var imageUrls = rowData[rowData.length - 1]; // last column
            var $carousel = $('#carouselImagesContainer');
            $carousel.empty();
            if (imageUrls && imageUrls.length > 0) {
                imageUrls.forEach(function(url, idx) {
                    $carousel.append('<div class="carousel-item'+(idx===0?' active':'')+'"><img src="'+url+'" class="d-block w-100 rounded" style="max-height:65vh;object-fit:contain;" alt="Billboard Image '+(idx+1)+'"></div>');
                });
            } else {
                $carousel.append('<div class="carousel-item active"><img src="<?= base_url('assets/images/no-image.png') ?>" class="d-block w-100 rounded" style="max-height:65vh;object-fit:contain;" alt="No Image"></div>');
            }
            var carousel = new bootstrap.Carousel(document.getElementById('billboardCarousel'));
            carousel.to(0); // always start at first image
            $('#imagePreviewModal').modal('show');
        });
    });
</script>
<?= $this->endSection() ?>