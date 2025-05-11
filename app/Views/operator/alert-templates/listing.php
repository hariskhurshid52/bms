<?= $this->extend('common/default') ?>
<?= $this->section('content') ?>
    <div class="row mt-4 ">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Alert Template <a href="<?=route_to('operator.alertTemplate.create')?>" class="btn btn-primary btn-sm pull-right" role="button">Add New</a></h4>
                    <hr/>
                    <div class="table-responsive">
                        <table class="table table-hover" id="dtTemplates">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Notification on</th>
                                <th>Added By</th>
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
            $('#dtTemplates').DataTable({
                processing: true,
                ordering: false,
                serverSide: true,
                ajax: {
                    url: "<?= route_to('operator.alertTemplate.dtList') ?>",
                    type: "POST",
                    dataType: "json",
                    data: function (d) {
                        d['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
                    }
                },
                columns: [
                    {data: "name", title: "Name"},
                    {data: "type", title: "Type"},
                    {data: "action", title: "Notification on"},
                    {data: "addedByName", title: "Added By"},
                    {data: "createdAt", title: "Created At"},
                    {
                        data: "templateId",
                        title: "Actions",
                        render: function (data, type, row) {
                            const editUrl = "<?= base_url('my/alerts/templates/edit') ?>/" + data;
                            return `
                                <a href="${editUrl}" class="btn btn-sm btn-primary">Edit</a>
                            `;
                        }
                    },
                ],
                order: [[3, 'desc']]
            })
        })
    </script>
<?= $this->endSection() ?>