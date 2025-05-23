<?= $this->section('styles') ?>
<link href="<?= base_url('assets/libs/dropzone/min/dropzone.min.css') ?>" rel="stylesheet" type="text/css" />
<style>
    .form-section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #256029;
        border-left: 4px solid #388e3c;
        padding-left: 12px;
        margin-top: 32px;
        margin-bottom: 18px;
        background: linear-gradient(90deg, #e8f5e9 0%, #fff 100%);
        border-radius: 4px;
    }
</style>
<?= $this->endSection() ?>
<?= $this->extend('common/default-nav') ?> <?= $this->section('content') ?>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Update Hoarding Record 
                    <a href="<?= route_to('admin.billboard.list') ?>" class="btn btn-primary btn-sm pull-right" role="button">Go to list</a>
                </h4>
                <hr />
                <form method="POST" action="<?= route_to('admin.billboard.update') ?>">
                    <?= csrf_field(); ?>
                    <?= form_hidden('billboardId', $billboard['id']) ?>

                    <!-- Section: Basic Details -->
                    <div class="form-section-title"><i class="bi bi-card-text"></i> Basic Details</div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="name" class="form-label"> <strong class="text-danger">*</strong> Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $billboard['name']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="type" class="form-label"> <strong class="text-danger">*</strong> Type</label>
                            <select name="type" id="type" class="form-control" required>
                                <?php foreach ($billboardTypes as $type): ?>
                                    <option <?= $billboard['billboard_type_id'] == $type['id'] ? 'selected' : '' ?>
                                            value="<?= $type['id'] ?>"><?= $type['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" rows="3" id="description" name="description"><?= $billboard['description']; ?></textarea>
                        </div>
                    </div>

                    <!-- Section: Size & Dimensions -->
                    <div class="form-section-title"><i class="bi bi-arrows-angle-expand"></i> Size & Dimensions</div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="width" class="form-label"> <strong class="text-danger">*</strong> Width</label>
                            <input type="number" class="form-control" id="width" name="width" value="<?= $billboard['width']; ?>" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="height" class="form-label"> <strong class="text-danger">*</strong> Height</label>
                            <input type="number" class="form-control" id="height" name="height" value="<?= $billboard['height']; ?>" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="size_type" class="form-label"> <strong class="text-danger">*</strong> Size Type</label>
                            <select name="size_type" id="size_type" class="form-control" required>
                                <?php foreach (['ft' => 'Feet', 'in' => 'Inches', 'cm' => 'Centimeters', 'm' => 'Meters'] as $k => $v): ?>
                                    <option <?= $billboard['size_type'] == $k ? 'selected' : '' ?> value="<?= $k ?>"><?= $v ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Section: Location -->
                    <div class="form-section-title"><i class="bi bi-geo-alt"></i> Location</div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="city" class="form-label"> <strong class="text-danger">*</strong> City</label>
                            <select name="city" id="city" class="form-control select2" required>
                                <?php foreach ($cities as $v): ?>
                                    <option <?= $billboard['city_id'] == $v['id'] ? 'selected' : '' ?>
                                            value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="area" class="form-label"> <strong class="text-danger">*</strong> Area/Sector</label>
                            <textarea class="form-control" id="area" name="area"><?= $billboard['area']; ?></textarea>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="address" class="form-label"> <strong class="text-danger">*</strong> Complete Address</label>
                            <textarea class="form-control" id="address" name="address"><?= $billboard['address']; ?></textarea>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="traffic_commming_from" class="form-label"> <strong class="text-danger">*</strong> Traffic Coming From</label>
                            <textarea class="form-control" id="traffic_commming_from" name="traffic_commming_from"><?= $billboard['traffic_commming_from']; ?></textarea>
                        </div>
                    </div>

                    <!-- Section: Contract & Authority Info -->
                    <div class="form-section-title"><i class="bi bi-file-earmark-text"></i> Contract & Authority Info</div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="contract_duration" class="form-label"> <strong class="text-danger">*</strong> Contract Duration (in years)</label>
                            <input type="number" class="form-control" id="contract_duration" name="contract_duration" value="<?= $billboard['contract_duration']; ?>">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="contract_date" class="form-label"> <strong class="text-danger">*</strong> Contract Date</label>
                            <div class="input-group datepicker" id="picker_contract_date">
                                <input type="text" class="form-control" id="contract_date" name="contract_date"
                                       data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true"
                                       readonly value="<?= date('Y-m-d', strtotime($billboard['contract_date'])); ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="authority_name" class="form-label"> <strong class="text-danger">*</strong> Authority Name</label>
                            <input type="text" class="form-control" id="authority_name" name="authority_name" value="<?= $billboard['authority_name']; ?>">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="installation_date" class="form-label"> <strong class="text-danger">*</strong> Installation Date</label>
                            <div class="input-group datepicker" id="picker_installation_date">
                                <input type="text" class="form-control" id="installation_date" name="installation_date"
                                       data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true"
                                       readonly value="<?= date('Y-m-d', strtotime($billboard['installation_date'])); ?>">
                                <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Financials -->
                    <div class="form-section-title"><i class="bi bi-cash-coin"></i> Financials</div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="booking_price" class="form-label"> <strong class="text-danger">*</strong> Minimum Booking Price</label>
                            <input type="number" class="form-control" id="booking_price" name="booking_price" value="<?= $billboard['booking_price']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="monthly_rent" class="form-label"> <strong class="text-danger">*</strong> Monthly Rent</label>
                            <input type="number" class="form-control" id="monthly_rent" name="monthly_rent" value="<?= $billboard['monthly_rent']; ?>">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="annual_increase" class="form-label"> <strong class="text-danger">*</strong> Annual Increase (%)</label>
                            <input type="number" class="form-control" id="annual_increase" name="annual_increase" value="<?= $billboard['annual_increase']; ?>">
                        </div>
                    </div>

                    <!-- Section: Media -->
                    <div class="form-section-title"><i class="bi bi-image"></i> Media</div>
                    <?php if (!empty($billboard['image_url'])): ?>
                        <div class="mb-3">
                            <label class="form-label">Current Image</label>
                            <div class="card" style="max-width: 320px;">
                                <img src="<?= base_url($billboard['image_url']) ?>" alt="Billboard Image" class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="image_urls" class="form-label">Billboard Images</label>
                            <div id="image-dropzone" class="dropzone"></div>
                            <input type="hidden" name="image_urls" id="image_urls" value='<?= json_encode(array_column($billboardImages, "image_url")) ?>'>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="video_url" class="form-label">Video URL</label>
                            <input type="text" class="form-control" id="video_url" name="video_url" value="<?= $billboard['video_url']; ?>">
                        </div>
                    </div>

                    <!-- Section: Status -->
                    <div class="form-section-title"><i class="bi bi-info-circle"></i> Status</div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="status" class="form-label"> <strong class="text-danger">*</strong> Status</label>
                            <select name="status" id="status" class="form-control select2" required>
                                <?php foreach (['active' => 'Active', 'inactive' => 'Inactive', 'under_maintenance' => 'Under Maintenance'] as $k => $v): ?>
                                    <option <?= $billboard['status'] == $k ? 'selected' : '' ?> value="<?= $k ?>"><?= $v ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- SUBMIT -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary float-end">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/libs/dropzone/min/dropzone.min.js') ?>"></script>
<script>
Dropzone.autoDiscover = false;
var uploadedImages = <?= json_encode(array_column($billboardImages, "image_url")) ?>;
var imageDropzone = new Dropzone("#image-dropzone", {
    url: "<?= route_to('admin.billboard.uploadImage') ?>",
    maxFiles: null,
    acceptedFiles: 'image/*',
    addRemoveLinks: true,
    dictDefaultMessage: "Drag images here or click to upload",
    params: {
        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
    },
    init: function () {
        // Show all existing images as previews
        <?php foreach ($billboardImages as $img): ?>
        var mockFile = { name: "<?= basename($img['image_url']) ?>", size: 12345 };
        this.emit("addedfile", mockFile);
        this.emit("thumbnail", mockFile, "<?= base_url($img['image_url']) ?>");
        this.emit("complete", mockFile);
        mockFile.imageUrl = "<?= $img['image_url'] ?>";
        this.files.push(mockFile);
        <?php endforeach; ?>
        this.on("success", function (file, response) {
            if (response.image_url) {
                uploadedImages.push(response.image_url);
                $('#image_urls').val(JSON.stringify(uploadedImages));
                file.imageUrl = response.image_url;
            }
        });
        this.on("removedfile", function (file) {
            if (file.imageUrl) {
                uploadedImages = uploadedImages.filter(function(url) { return url !== file.imageUrl; });
                $('#image_urls').val(JSON.stringify(uploadedImages));
                ajaxCall('<?= route_to('admin.billboard.deleteImage') ?>', {
                    image_url: file.imageUrl,
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                }).then((response) => {
                    if (response.status === 'error') {
                        console.error('Failed to delete file:', response.message);
                    }
                }).catch(err => {
                    console.error('Error deleting file:', err);
                });
            }
        });
        this.on("error", function (file, errorMessage) {
            console.error(errorMessage);
            alert(errorMessage.message || 'Error uploading file');
        });
    }
});
</script>
<?= $this->endSection() ?>