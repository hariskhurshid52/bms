<?= $this->section('styles') ?>
<?= $this->endSection() ?>
<?= $this->extend('common/default-nav') ?> <?= $this->section('content') ?>



<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Hording Listing <a href="<?= route_to('admin.billboard.create') ?>"
                        class="btn btn-primary btn-sm pull-right" role="button">Add New</a></h4>
                <hr />
                <div class="table-responsive">
                    <table class="table table-hover" id="dtBillboard">
                        <thead>
                            <tr>
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
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    $(document).ready(function () {
        $('#dtBillboard').DataTable({
            processing: true,
            ordering: false,
            serverSide: true,
            ajax: {
                url: "<?= route_to('admin.billboard.dtList') ?>",
                type: "POST",
                dataType: "json",
                data: function (d) {
                    d['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
                }
            },

        })
    })
</script>
<?= $this->endSection() ?>