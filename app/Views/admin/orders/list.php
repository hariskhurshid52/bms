<?= $this->section('styles') ?>
<?= $this->endSection() ?>
<?= $this->extend('common/default-nav') ?> <?= $this->section('content') ?>



<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">List All Bookings <a href="<?= route_to('admin.order.create') ?>"
                        class="btn btn-primary btn-sm pull-right" role="button">Add New</a></h4>
                <hr />
                <div class="table-responsive">
                    <table class="table table-hover" id="dtOrders">
                        <thead>
                            <tr>
                                <th>Billboard Name</th>
                                <th>Billboard Area</th>
                                <th>Customer Name</th>
                                <th>Order Status</th>
                                <th>Reservation Start</th>
                                <th>Reservation End</th>
                                <th>Total Cost</th>
                                <th>Paid Amount</th>
                                <th>Order Placed At</th>
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
        $('#dtOrders').DataTable({
            processing: true,
            ordering: false,
            serverSide: true,
            ajax: {
                url: "<?= route_to('admin.orders.dtList') ?>",
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