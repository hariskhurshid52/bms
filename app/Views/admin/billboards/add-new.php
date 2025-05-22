<?= $this->section('styles') ?>
<link href="<?= base_url('assets/libs/dropzone/min/dropzone.min.css') ?>" rel="stylesheet" type="text/css" />
<style>

</style>
<?= $this->endSection() ?>
<?= $this->extend('common/default-nav') ?> <?= $this->section('content') ?>


<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Add New Hording
                    <a href="<?= route_to('admin.billboard.list') ?>" class="btn btn-primary btn-sm pull-right">Go to
                        list</a>
                </h4>
                <hr />

                <form method="POST" action="<?= route_to('admin.billboard.store') ?>">
                    <?= csrf_field(); ?>

                    <!-- BASIC DETAILS -->
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= old('name'); ?>"
                                required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="type" class="form-label">Type</label>
                            <select name="type" id="type" class="form-control" required>
                                <?php foreach ($billboardTypes as $type): ?>
                                    <option value="<?= $type['id'] ?>"><?= $type['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-12 mb-2">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" rows="3" id="description"
                                name="description"><?= old('description'); ?></textarea>
                        </div>
                    </div>

                    <!-- SIZE & DIMENSIONS -->
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="width" class="form-label">Width</label>
                            <input type="number" class="form-control" id="width" name="width"
                                value="<?= old('width'); ?>" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="height" class="form-label">Height</label>
                            <input type="number" class="form-control" id="height" name="height"
                                value="<?= old('height'); ?>" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="size_type" class="form-label">Size Type</label>
                            <select name="size_type" id="size_type" class="form-control" required>
                                <?php foreach (['ft' => 'Feet', 'in' => 'Inches', 'cm' => 'Centimeters', 'm' => 'Meters'] as $k => $v): ?>
                                    <option value="<?= $k ?>"><?= $v ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- LOCATION -->
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="city" class="form-label">City</label>
                            <select name="city" id="city" class="form-control select2" required>
                                <?php foreach ($cities as $v): ?>
                                    <option value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="area" class="form-label">Area/Sector</label>
                            <textarea class="form-control" id="area" name="area"><?= old('area'); ?></textarea>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="address" class="form-label">Complete Address</label>
                            <textarea class="form-control" id="address" name="address"><?= old('address'); ?></textarea>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="traffic_commming_from" class="form-label">Traffic Coming From</label>
                            <textarea class="form-control" id="traffic_commming_from"
                                name="traffic_commming_from"><?= old('traffic_commming_from'); ?></textarea>
                        </div>
                    </div>

                    <!-- CONTRACT & AUTHORITY INFO -->
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="contract_duration" class="form-label">Contract Duration (in years)</label>
                            <input type="number" class="form-control" id="contract_duration" name="contract_duration"
                                value="<?= old('contract_duration', 1); ?>">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="contract_date" class="form-label">Contract Date</label>
                            <div class="input-group datepicker" id="picker_contract_date">
                                <input type="text" class="form-control" id="contract_date" name="contract_date"
                                    data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true"
                                    readonly value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="authority_name" class="form-label">Authority Name</label>
                            <input type="text" class="form-control" id="authority_name" name="authority_name"
                                value="<?= old('authority_name'); ?>">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="installation_date" class="form-label">Installation Date</label>
                            <div class="input-group datepicker" id="picker_installation_date">
                                <input type="text" class="form-control" id="installation_date" name="installation_date"
                                    data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true"
                                    readonly value="<?= date('Y-m-d') ?>">
                                <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- FINANCIALS -->
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="booking_price" class="form-label">Minimum Booking Price</label>
                            <input type="number" class="form-control" id="booking_price" name="booking_price"
                                value="<?= old('booking_price') ?>" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="monthly_rent" class="form-label">Monthly Rent</label>
                            <input type="number" class="form-control" id="monthly_rent" name="monthly_rent"
                                value="<?= old('monthly_rent'); ?>">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="annual_increase" class="form-label">Annual Increase (%)</label>
                            <input type="number" class="form-control" id="annual_increase" name="annual_increase"
                                value="<?= old('annual_increase', 5); ?>">
                        </div>

                    </div>

                    <!-- MEDIA -->
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="image_url" class="form-label">Billboard Image</label>
                            <div id="image-dropzone" class="dropzone"></div>
                            <input type="hidden" name="image_url" id="image_url" value="<?= old('image_url'); ?>">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="video_url" class="form-label">Video URL</label>
                            <input type="text" class="form-control" id="video_url" name="video_url"
                                value="<?= old('video_url'); ?>">
                        </div>
                    </div>

                    <!-- STATUS -->
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control select2" required>
                                <?php foreach (['active' => 'Active', 'inactive' => 'Inactive', 'under_maintenance' => 'Under Maintenance'] as $k => $v): ?>
                                    <option value="<?= $k ?>"><?= $v ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- SUBMIT -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary float-end">Save</button>
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
    var imageDropzone = new Dropzone("#image-dropzone", {
        url: "<?= route_to('admin.billboard.uploadImage') ?>",
        maxFiles: 1,
        acceptedFiles: 'image/*',
        addRemoveLinks: true,
        dictDefaultMessage: "Drag an image here or click to upload",
        params: {
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
        },
        init: function () {
            this.on("success", function (file, response) {
                $('#image_url').val(response.image_url);
                // Store the image URL in the file object for later deletion
                file.imageUrl = response.image_url;
            });
            this.on("removedfile", function (file) {
                if (file.imageUrl) {
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
                $('#image_url').val('');
            });
            this.on("error", function (file, errorMessage) {
                console.error(errorMessage);
                alert(errorMessage.message || 'Error uploading file');
            });
        }
    });
</script>
<?= $this->endSection() ?>