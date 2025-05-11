<?= $this->extend('common/default-nav') ?>
<?= $this->section('content') ?>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Short Codes Migrations</h4>
                    <hr/>
                    <div class="table-responsive">
                        <table class="table table-hover" id="dtShortCodeMigrations">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Short Code</th>
                                <th> Status</th>
                                <th>Created At</th>
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
            $('#dtShortCodeMigrations').DataTable({
                processing: true,
                ordering: false,
                serverSide: true,
                ajax: {
                    url: "<?= route_to('partner.shortCode.dtShortCodeMigrations') ?>",
                    type: "POST",
                    dataType: "json",
                    data: function (d) {
                        d['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
                    }
                },
                order: [[3, 'desc']]
            })
        })
    </script>
<?= $this->endSection() ?>