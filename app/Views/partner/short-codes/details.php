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
                <p class="sub-header">This Short Code has been ordered and will be processed from <code
                            class="code"><?= $shortCode['createdAt'] ?></code></p>
                <hr>

                <div class="row">
                    <div class="col-12">
                        <div class="p-2">


                            <div class="row">
                                <label class="col-md-2 col-form-label" for="country">Country</label>
                                <div class="col-md-10">
                                    <input type="text" readonly="" class="form-control-plaintext" id="country"
                                           value="<?= session()->get('loggedIn')['countryName'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label" for="mno">MNO</label>
                                <div class="col-md-10">
                                    <input type="text" readonly="" class="form-control-plaintext" id="mno"
                                           value="<?= session()->get('loggedIn')['operator'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label" for="partner">Partner</label>
                                <div class="col-md-10">
                                    <input type="text" readonly="" class="form-control-plaintext" id="partner"
                                           value="<?= $shortCode['partnerName'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label" for="merchant">Merchant</label>
                                <div class="col-md-4">
                                    <input type="text" readonly="" class="form-control-plaintext" id="merchantName"
                                           value="<?= $shortCode['merchantName'] ?>">
                                    <input type="text" readonly="" class="form-control-plaintext" id="merchant"
                                           value="<?= $shortCode['cspId'] ?>">
                                </div>
                                <div class="col-md-4">
                                    <button type="button" id="merchantDetails" class="btn btn-sm btn-primary">
                                        See Merchant Details
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label" for="serviceName">Service Name</label>
                                <div class="col-md-10">
                                    <input type="text" id="serviceName" readonly=""
                                           value="<?= $shortCode['serviceName'] ?>"
                                           class="form-control-plaintext" name="serviceName">
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-md-2 col-form-label" for="masterService">Master
                                    Service</label>
                                <div class="col-md-10">
                                    <input type="text" id="masterService" readonly=""
                                           value="<?= $shortCode['masterServiceName'] ?>"
                                           class="form-control-plaintext" name="masterService">

                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label" for="mediaType">Media Type</label>
                                <div class="col-md-10">
                                    <input type="text" id="mediaType" readonly=""
                                           value="<?= strtoupper($shortCode['mediaType']) ?>"
                                           class="form-control-plaintext" name="mediaType">
                                </div>
                            </div>
                            <form class="form-horizontal  mt-4" role="form" method="post"
                                  action="<?= route_to('partner.shortCode.order.create') ?>">
                                <?= csrf_field() ?>
                                <?= form_hidden('shortCode', $shortCode['shortCodeId']) ?>
                                <?php if (isset($shortCode['orderId']) && !empty($shortCode['orderId'])): ?>
                                    <?= form_hidden('orderId', $shortCode['orderId']) ?>
                                <?php endif; ?>
                                <div id="shortCodeFormFields">
                                    <?= view('partner/short-codes/partial/additional-form-fields', [
                                        'shortCode' => $shortCode,
                                        'servicesTypes' => isset($servicesTypes) ? $servicesTypes : [],
                                        'initiations' => isset($initiations) ? $initiations : [],
                                        'netopActions' => isset($netopActions) ? $netopActions : [],
                                        'statuses' => isset($orderStatuses) ? $orderStatuses : [],
                                        'bindNames' => isset($bindNames) ? $bindNames: [],
                                    ]) ?>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- end row -->
            </div>
        </div>
    </div> <!-- end card -->
</div>
<?= view('partner/short-codes/partial/merchant-info-modal') ?>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script src="<?= base_url() ?>assets/minton/assets/libs/mohithg-switchery/switchery.min.js"></script>
<script>
    $(document).ready(function () {
        $('[data-plugin="switchery"]').each(function (e, t) {
            new Switchery($(this)[0], $(this).data())
        });

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
                } else {
                    showDangerToast("Short code details not found");
                }
            }).catch(e => {
                $("#pageloader").hide();
                showDangerToast("Failed to complete request");
                window.location.reload()
            })
        })
    })

    cancelOrder = (orderId) => {
        if (!orderId) {
            showDangerToast("Please provide valid order")
            return
        }
        $("#pageloader").show();
        ajaxCall('<?=route_to('partner.shortCode.orders.cancel')?>', {
            orderId
        }).then((response) => {
            $("#pageloader").hide();
            if (response.status === "success") {
                showSuccessToast("Successfully updates order")
                window.location.reload()
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

    }
</script>
<?= $this->endSection() ?>
