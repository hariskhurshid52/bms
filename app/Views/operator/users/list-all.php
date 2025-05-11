<?= $this->extend('common/default') ?>
<?= $this->section('content') ?>


    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">List All Users <a href="<?=route_to('operator.users.create')?>" class="btn btn-primary btn-sm pull-right" role="button">Add New</a></h4>
                    <hr/>
                    <div class="table-responsive">
                        <table class="table table-hover" id="dtUser">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
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
            $('#dtUser').DataTable({
                processing: true,
                ordering: false,
                serverSide: true,
                ajax: {
                    url: "<?= route_to('operator.users.dtList') ?>",
                    type: "POST",
                    dataType: "json",
                    data: function (d) {
                        d['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
                    }
                },
                columns: [
                    {data: "name", title: "Name"},
                    {data: "email", title: "Email"},
                    {data: "roleName", title: "Role"},
                    {data: "createdAt", title: "Created At"},
                    {
                        data: "userId",
                        title: "Actions",
                        render: function (data, type, row) {
                            const editUrl = "<?= base_url('my/users/edit') ?>/" + data;
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