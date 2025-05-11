<?= $this->extend('common/default-nav') ?>
<?= $this->section('content') ?>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">
                        Bind Names Mappings
                        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                id="btnNew">Add New
                        </button>
                    </h4>
                    <hr/>
                    <div class="table-responsive">
                        <table class="table table-hover" id="dtBindNames">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Bind Name</th>
                                <th>Partner Name</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($bindNameMappings as $k => $mapping): ?>
                                <tr>
                                    <td><?= ++$k ?></td>
                                    <td><?= $mapping['name'] ?></td>
                                    <td><?= $mapping['partnerName'] ?></td>
                                    <td><?= strtoupper($mapping['status']) ?></td>
                                    <td><?= $mapping['createdAt'] ?></td>
                                    <td>
                                        <?php if ($mapping['status'] === "active"): ?>
                                            <button type="button"
                                                    onclick="updateStatus('<?= $mapping['id'] ?>','deactivate')"
                                                    class="btn btn-danger btn-xs">De Activate
                                            </button>
                                        <?php else: ?>
                                            <button type="button"
                                                    onclick="updateStatus('<?= $mapping['id'] ?>','activate')"
                                                    class="btn btn-success btn-xs">Activate
                                            </button>

                                        <?php endif; ?>
                                        <button type="button" onclick="updateStatus('<?= $mapping['id'] ?>','remove')"
                                                class="btn btn-warning btn-xs">Delete
                                        </button>
                                        <button type="button" onclick="updateModal('<?= $mapping['id'] ?>')"
                                                class="btn btn-info btn-xs">Edit
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mdNewMappings" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Bind Name Mappings</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body p-4">
                    <div class="row">
                        <div class="form-group">
                            <label class="form-label" for="partner">Select Partner</label>
                            <select id="partner" name="partner" class="form-control " id="partner">
                                <option></option>
                                <?php foreach ($partners as $partner): ?>
                                    <option value="<?= $partner['countryAggregatorId'] ?>"><?= $partner['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group mt-3" id="cntBindName">
                            <label class="form-label" for="reservedNotification">Bind Name</label>
                            <div class="repeater" data-repeater="bindName">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div data-repeater-list="bindName">
                                            <div data-repeater-item class="row mb-2">
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control"
                                                           name="name"/>
                                                </div>

                                                <div class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                                                    <button data-repeater-delete type="button"
                                                            class="btn btn-danger btn-xs"><i
                                                                class="mdi mdi-trash-can"></i></button>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-md-2 d-flex align-items-start align-items-center">
                                        <button data-repeater-create type="button"
                                                class="btn btn-success btn-xs"><i class="mdi mdi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="save">Add</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mdUpdateMappings" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Bind Name</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body p-4">
                    <div class="row">
                        <div class="form-group mt-3" id="cntBindName">
                        <div class="d-flex justify-content-center">  <div class="spinner-border" role="status"></div>   </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"  data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" onclick="update()" >Update</button>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
    <script src="<?= base_url() ?>assets/js/jquery.repeater.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#dtBindNames').DataTable({})
            $('#btnNew').click(() => {
                $("#mdNewMappings").modal("show")
            })
            $('#save').click(() => {
                saveBindNames()
            })
            $('#partner').change(() => {
                let partnerId = $('#partner').val();
                if (!partnerId) {
                    return
                }
                $("#mdNewMappings #cntBindName").html(MINI_LOADER_HTML)

                ajaxCall('<?=route_to('operator.shortCode.binds.partnerContent')?>', {
                    partnerId: $("#mdNewMappings #partner").val()
                }).then(response => {
                    $("#pageloader").hide()
                    if (response.status === "success") {
                        $("#mdNewMappings #cntBindName").html(response.html)
                        $('.repeater').repeater({
                            initEmpty: false,
                            isFirstItemUndeletable: true
                        })
                    } else {
                        showDangerToast(response.message);
                        window.location.reload()
                    }


                }).catch(err => {
                    showDangerToast("Invalid server response, Please try again")
                    window.location.reload()
                })


            })
            $('.repeater').repeater({
                initEmpty: false,
                isFirstItemUndeletable: true
            })
        })
        saveBindNames = () => {
            const repBindName = $('#mdNewMappings [data-repeater="bindName"]').repeaterVal();
            let bindNames = [];
            for (const input of repBindName.bindName) {
                if (input.name) {
                    bindNames.push(input.name);
                }
            }
            if (bindNames.length === 0) {
                showDangerToast("Please provide valid bind names");
                return;
            }

            ajaxCall('<?=route_to('operator.shortCode.binds.store')?>', {
                bindNames,
                partnerId: $("#mdNewMappings #partner").val()

            }).then(response => {
                $("#pageloader").hide()
                if (response.status === "success") {
                    showSuccessToast(response.message);
                    setTimeout(() => {
                        window.location.reload()
                    }, 2000)
                } else {
                    showDangerToast(response.message);
                }


            }).catch(err => {
                $("#pageloader").hide()
                showDangerToast("Invalid server response, Please try again")
            })
        }
        updateStatus = (id, status) => {
            $("#pageloader").show();

            ajaxCall('<?=route_to('operator.shortCode.binds.updateStatus')?>', {
                id,
                status

            }).then(response => {
                $("#pageloader").hide()
                if (response.status === "success") {
                    showSuccessToast(response.message);
                    setTimeout(() => {
                        window.location.reload()
                    }, 2000)
                } else {
                    showDangerToast(response.message);
                }


            }).catch(err => {
                $("#pageloader").hide()
                showDangerToast("Invalid server response, Please try again")
            })
        }
        updateModal = (id)=>{
            if(!id){
                return
            }
            $("#mdUpdateMappings #cntBindName").html(MINI_LOADER_HTML)
            $("#mdUpdateMappings").modal('show')
            ajaxCall('<?=route_to('operator.shortCode.binds.edit.content')?>', {
                    bindId: id
                }).then(response => {
                    $("#pageloader").hide()
                    if (response.status === "success") {
                        $("#mdUpdateMappings #cntBindName").html(response.html)
                        
                    } else {
                        showDangerToast(response.message);
                        window.location.reload()
                    }


                }).catch(err => {
                    showDangerToast("Invalid server response, Please try again")
                    window.location.reload()
                })
        }
        update = ()=>{
            const id = $("#mdUpdateMappings #bindId").val(),
            name = $("#mdUpdateMappings #bindName").val()
            if(!id){
                return
            }
            else if(!name){
                showDangerToast("Please provide valid bind name")
                return
            }
            $("#pageloader").show();
            ajaxCall('<?=route_to('operator.shortCode.bind.update')?>', {
                    bindId: id,
                    name
                }).then(response => {
                    $("#pageloader").hide()
                    if (response.status === "success") {
                       showSuccessToast("Successfully updated bind name")
                       setTimeout(() => {
                           window.location.reload()
                       })
                        
                    } else {
                        showDangerToast(response.message);
                        window.location.reload()
                    }


                }).catch(err => {
                    showDangerToast("Invalid server response, Please try again")
                    window.location.reload()
                })
        }
    </script>
<?= $this->endSection() ?>