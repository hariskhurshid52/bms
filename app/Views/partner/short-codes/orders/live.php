<?= $this->extend('common/default-nav') ?>
<?= $this->section('content') ?>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Live Orders</h4>
                    <hr/>
                    <div class="table-responsive">
                        <table class="table table-hover" id="dtShortCodeOrders">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Short Code</th>
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
<?= view('partner/short-codes/partial/migration-modal') ?>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
    <script>
        $(document).ready(function () {
            $('#dtShortCodeOrders').DataTable({
                processing: true,
                ordering: false,
                serverSide: true,
                ajax: {
                    url: "<?= route_to('partner.shortCode.dtShortCodeLiveOrdersList') ?>",
                    type: "POST",
                    dataType: "json",
                    data: function (d) {
                        d['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
                    }
                },
                order: [[5, 'desc']]
            })
            // $("#mdMigrationRequest  #btnSaveRequest").click(() => {
            //     saveMigrationRequest()
            // })
        })

        migrationRequest = (shortCodeId,shortCode) => {
            if (!shortCodeId) {
                showDangerToast("Your request cannot be processed");
                return;
            }
            $("#mdMigrationRequest #shortCode").html(shortCode)
            $("#mdMigrationRequest #shortCodeId").val(shortCodeId)
            $("#mdMigrationRequest").modal('show');

        }
        saveMigrationRequest = () => {
            const shortCodeId =  $("#mdMigrationRequest #shortCodeId").val()
            if (!shortCodeId) {
                showDangerToast("Your request cannot be processed");
                $("#mdMigrationRequest").modal('hide');
                $('#dtShortCodeOrders').DataTable().ajax.reload()
                return;
            }
            const comment = $("#mdMigrationRequest #migrationRequest").val();
            if (!comment) {
                showDangerToast("Please write your comments in details");
                return;
            }

            ajaxCall('<?=route_to('partner.shortCode.migration.store')?>',{
                shortCodeId,comment
            }).then(response=>{
                if(response.status === "success"){
                    showSuccessToast("Migration request submitted successfully")
                    $("#mdMigrationRequest").modal('hide');
                    $("#mdMigrationRequest #migrationRequest").val('')
                    $("#mdMigrationRequest #shortCodeId").val('')

                }
                else if(response.status == "validation"){
                    showDangerToast("Request data is not valid")
                }
                else{
                    showDangerToast("Failed to save migration request")
                }
            }).catch(e=>{
                showDangerToast("Your request cannot be processed");
                window.location.reload()
            })
        }
    </script>
<?= $this->endSection() ?>