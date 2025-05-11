<?= $this->extend('common/default-nav') ?>
<?= $this->section('content') ?>
<div class="row mt-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">
                    In Progress Orders
                    <button class="btn btn-sm btn-primary pull-right" disabled id="btnMarkActive">Mark Selected
                        Live</button>
                </h4>
                <hr />
                <div class="table-responsive">
                    <table class="table table-hover" id="dtShortCodeOrders">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Short Code</th>
                                <th>Partner Name</th>
                                <th class="">Media Type</th>
                                <th>Service Name</th>

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
                url: "<?= route_to('operator.shortCode.dtShortCodeInProgressOrdersList') ?>",
                type: "POST",
                dataType: "json",
                data: function (d) {
                    d['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
                }
            },
            order: [[5, 'desc']],
        })

        $('#dtShortCodeOrders tbody').on('change', 'input[type="checkbox"]', function () {
            let checked = $("[name='shortCodeOrder[]']:checked").map(function () {
                return $(this).val();
            }).get()
            $("#btnMarkActive").prop('disabled', !(checked.length > 0));
        });

        $("#btnMarkActive").click(function () {
            markSelectedLive()

        });
    })


    markSelectedLive = () => {
        const orders = $("[name='shortCodeOrder[]']:checked").map(function () { return $(this).val(); }).get()
        if (orders.length === 0) {
            showDangerAlert("Please select at least one order");
            return;
        }
        $("#pageloader").show();
        ajaxCall('<?= route_to('operator.shortCode.orders.selected.live') ?>', {
            orders: orders
        }).then((response) => {
            $("#pageloader").hide();
            if (response.status === "success") {
                showSuccessToast("Successfully updated order")
                window.location.reload()
            } else {
                showDangerToast(response.message)
            }
        }).catch(e => {
            $("#pageloader").hide();
            showDangerToast("Failed to complete request");
            window.location.reload()
        })
    }
</script>
<?= $this->endSection() ?>