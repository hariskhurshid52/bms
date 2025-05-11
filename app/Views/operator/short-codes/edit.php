<?= $this->extend('common/default') ?>
<?= $this->section('styles') ?>
    <link href="<?= base_url() ?>assets/minton/assets/libs/mohithg-switchery/switchery.min.css" rel="stylesheet"
          type="text/css"/>

<?= $this->endSection() ?>
<?= $this->section('content') ?>


    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">
                        <?= !empty($shortCode['orderId']) ? 'Reserved' : 'Ordered' ?> Short Code
                        | <?= $shortCode['shortCode'] ?>

                    </h4>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <div class="p-2">
                                <form class="form-horizontal" role="form" method="post"
                                      action="<?= route_to('operator.shortCode.orders.saveAndUpdate') ?>">
                                    <?= csrf_field() ?>
                                    <?= form_hidden('shortCode', $shortCode['id']) ?>
                                    <div id="shortCodeFormFields" class=" mt-3">


                                        <?= view('partner/short-codes/partial/additional-form-fields', [
                                            'shortCode' => $shortCode,
                                            'servicesTypes' => isset($servicesTypes) ? $servicesTypes : [],
                                            'initiations' => isset($initiations) ? $initiations : [],
                                            'netopActions' => isset($netopActions) ? $netopActions : [],
                                            'statuses' => isset($orderStatuses) ? $orderStatuses : [],
                                            'bindNames' => isset($bindNames) ? $bindNames : [],
                                            'pricePoints' => isset($pricePoints) ? $pricePoints : [],
                                        ]) ?>

                                    </div>
                                    <div class="row mt-2" id="actionBtn">
                                        <div class="d-flex justify-content-end gap-3">
                                            <button id="btnAddDetails" name="addDetails" class="btn btn-info"
                                                    type="submit">Save Details
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                    <!-- end row -->
                </div>
            </div> <!-- end card -->
        </div>

    </div>
<?= view('partner/short-codes/partial/merchant-info-modal') ?>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
    <script src="<?= base_url() ?>assets/minton/assets/libs/mohithg-switchery/switchery.min.js"></script>
    <script>
        $(document).ready(function () {
            initSwitchery()


            $("#mediaType").change(() => {
                mediaTypeChange()
            })
        })
        initSwitchery = () => {
            $('[data-plugin="switchery"]').each(function (e, t) {
                new Switchery($(this)[0], $(this).data())
            });
        }
        mediaTypeChange = () => {
            const mediaTypeId = $("#mediaType").val();
            if (!mediaTypeId) {
                return
            }
            loadServicesTypes();
            loadInitiations();
            $('.media-type:not(.d-none)').addClass('d-none');
            $(`[data-mediatype="${mediaTypeId}"`).removeClass('d-none')
        }


        loadServicesTypes = () => {
            const mediaTypeId = $("#mediaType").val();
            $('#cntServiceType').html(MINI_LOADER_HTML)
            ajaxCall('<?=route_to('shortCode.serviceType.getByMediaType')?>', {
                mediaTypeId
            }).then((response) => {

                if (response.status === "success") {
                    $('#cntServiceType').html(response.html)
                    $("#serviceType").select2()
                } else {
                    showDangerToast("Unable to load service types");
                    window.location.reload()
                }
            }).catch(e => {
                showDangerToast("Failed to complete request");
                window.location.reload()
            })
        }
        loadInitiations = () => {
            const mediaTypeId = $("#mediaType").val();
            $('#cntPromotionType').html(MINI_LOADER_HTML)
            ajaxCall('<?=route_to('shortCode.initiation.getByMediaType')?>', {
                mediaTypeId
            }).then((response) => {

                if (response.status === "success") {
                    $('#cntPromotionType').html(response.html)
                    $("#promotionType").select2()
                } else {
                    showDangerToast("Unable to load promotion types");
                    window.location.reload()
                }
            }).catch(e => {
                showDangerToast("Failed to complete request");
                window.location.reload()
            })
        }


    </script>
<?= $this->endSection() ?>