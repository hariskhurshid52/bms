<?= $this->extend('common/default-nav') ?>
<?= $this->section('content') ?>


    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Reserved Short Codes
                        <button  type="button" class="btn btn-sm btn-primary pull-right" id="btnDummyShortCode" data-toggle="modal" data-target="#mdDummyShortCode">Create Dummy Short
                            Code
                        </button>
                    </h4>
                    <hr/>
                    <div class="table-responsive">
                        <table class="table table-hover" id="dtShortCodes">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Email Text</th>
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
    <div class="modal fade" id="mdDummyShortCode" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Dummy Short Code </h4>


                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="shortCode" class="form-label">Write shortcode</label>
                                <input type="text" name="shortCode" id="shortCode" class="form-control">

                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel </button>
                    <button type="submit" onclick="save()" class="btn btn-primary" id="btnSaveRequest">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
    <script>
        $(document).ready(function () {
            $('#dtShortCodes').DataTable({
                processing: true,
                ordering: false,
                serverSide: true,
                ajax: {
                    url: "<?= route_to('partner.shortCode.dtReservedShortCodeList') ?>",
                    type: "POST",
                    dataType: "json",
                    data: function (d) {
                        d['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
                    }
                },
                columns: [
                    {data: "code", title: "Code"},
                    {data: "emailText", title: "Email Text"},
                    {data: "createdAt", title: "Created At"},
                    {
                        data: "shortCodeId",
                        title: "Actions",
                        render: function (data, type, row) {
                            const editUrl = "<?= base_url('my/short-codes/order/new') ?>/" + data,
                                viewUrl = "<?= base_url('my/short-codes/view-details') ?>/" + data;
                            return `
                                <a href="${editUrl}" class="btn btn-sm btn-primary">Order</a>
                               
                            `;
                        }
                    },
                ],
                order: [[2, 'desc']]
            })
            $("#btnDummyShortCode").click(()=>{
                $("#mdDummyShortCode").modal("show")
            })
        })
        save = ()=>{
            const shortCode =  $("#mdDummyShortCode #shortCode").val()
            if(!shortCode){
                showDangerToast("Please provide valid short code");
                return;
            }
            ajaxCall('<?=route_to('partner.shortCode.dummy.store')?>',{
                shortCode
            }).then(response=>{
                if(response.status === "success"){
                    showSuccessToast("Shortcode saved successfully")
                    $('#dtShortCodes').DataTable().ajax.reload()
                    $("#mdDummyShortCode").modal("hide")
                }
                else if(response.status == "validation"){
                    showDangerToast("Request data is not valid")
                }
                else{
                    showDangerToast("Failed to save short code")
                }
            }).catch(e=>{
                showDangerToast("Your request cannot be processed");
                window.location.reload()
            })
        }
    </script>
<?= $this->endSection() ?>