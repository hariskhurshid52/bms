<?= $this->extend('common/default') ?>
<?= $this->section('content') ?>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Short Codes Orders</h4>
                    <hr/>
                    <div class="table-responsive">
                        <table class="table table-hover" id="dtShortCodeOrders">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Short Code</th>
                                <th class="">Media Type</th>
                                <th>Service Name</th>
                                <th>Order Status</th>
                                <th>Created By</th>
                                <th>Created At</th>
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
            $('#dtShortCodeOrders').DataTable({
                processing: true,
                ordering: false,
                serverSide: true,
                ajax: {
                    url: "<?= route_to('partner.shortCode.dtShortCodeOrdersList') ?>",
                    type: "POST",
                    dataType: "json",
                    data: function (d) {
                        d['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
                    }
                },
                order: [[5, 'desc']]
            })
        })
    </script>
<?= $this->endSection() ?>