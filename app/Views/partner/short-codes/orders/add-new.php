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
                        Reserved Short Code | <?= $shortCode['shortCode'] ?>
                        <div class="pull-right">
                            <div class="input-group">
                                <input type="text" class="form-control" id="copyShortCode"
                                       placeholder="Enter code to copy details "
                                       aria-label="Enter code to copy details">

                                <button id="copyShortCodeDetail" class="btn btn-dark waves-effect waves-light"
                                        type="button"><span class="fe-copy"></span></button>
                            </div>
                        </div>
                    </h4>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <div class="p-2">
                                <form class="form-horizontal" role="form" method="post"
                                      action="<?= route_to('partner.shortCode.orders.saveAndUpdate') ?>">
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
                                        ]) ?>

                                    </div>
                                    <div class="row mt-2" id="actionBtn">
                                        <div class="d-flex justify-content-end gap-3">
                                            <?php if (!isset($shortCode['orderId']) || empty($shortCode['orderId'])): ?>

                                                <button id="btnCreateOrder" name="createOrder" class="btn btn-success"
                                                        type="submit">Create
                                                    Order
                                                </button>
                                            <?php endif; ?>
                                            <button id="btnAddDetails" name="addDetails" class="btn btn-info"
                                                    type="submit">Save Details
                                            </button>
                                            <a id="btnExit" class="btn btn-primary"
                                               href="<?= route_to('dashboard') ?>"
                                               type="button">
                                                Return to Dashboard
                                            </a>
                                            <button class="btn btn-warning"
                                                    data-bs-placement="bottom"
                                                    onclick="cancelReservationOrder(<?= $shortCode['shortCodeId'] ?>)"
                                                    type="button">
                                                Cancel Reservation
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


            $("#copyShortCodeDetail").click(function () {
                const copyShortCode = $("#copyShortCode").val();
                if (!copyShortCode) {
                    showDangerToast('Please select a short code to copy');
                    return false;
                }
                $("#pageloader").show();
                ajaxCall('<?=route_to('partner.shortCode.copyShortCodeAdditionalInfo')?>', {
                    shortCode: copyShortCode
                }).then((response) => {
                    $("#pageloader").hide();
                    if (response.status === "success") {
                        $('#shortCodeFormFields').html(response.html);
                        $("#mediaType").change(() => {
                            mediaTypeChange()
                        })
                        initSwitchery()
                    } else {
                        showDangerToast("Short code details not found");
                    }
                }).catch(e => {
                    $("#pageloader").hide();
                    showDangerToast("Failed to complete request");
                    // window.location.reload()
                })
            })
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
        cancelReservationOrder  = (shortCodeId) => {
            if (!shortCodeId) {
                showDangerToast("Please provide valid order")
                return
            }

            Swal.fire({
                title: 'Confirmation',
                text: `Are you sure you wish to cancel this Short Code reservation ? Once cancelled you cannot place an order for this Short Code`,
                icon: "info",
                showCancelButton: true,
                cancelButtonColor: "#1abc9c",
                confirmButtonColor: "#f1556c",
                confirmButtonText: "Cancel Reservation",
                cancelButtonText: "Return to Complete Order",
            }).then(function (t) {
                if (t.value) {
                    $("#pageloader").show();
                    ajaxCall('<?=route_to('partner.shortCode.reservation.cancel')?>', {
                        shortCodeId
                    }).then((response) => {
                        $("#pageloader").hide();
                        if (response.status === "success") {
                            showSuccessToast("Successfully updates order")
                            window.location.href = '/'
                        } else if (response.status === "validation") {
                            showDangerToast(response.message)
                        } else {
                            window.location.reload()
                            showDangerToast("Failed to update order, Please try again");
                        }

                    }).catch(e => {
                        $("#pageloader").hide();
                        showDangerToast("Failed to complete request");
                        window.location.reload()
                    })
                } else {

                }
            });



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