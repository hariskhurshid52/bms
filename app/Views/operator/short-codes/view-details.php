<?= $this->extend('common/default') ?>
<?= $this->section('content') ?>


<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">
                    <?= !empty($shortCode['orderId']) ? 'Ordered' : 'Reserved' ?> Short Code
                    | <?= $shortCode['shortCode'] ?>
                </h4>
                <?php if (isset($cycle)): ?>
                    <?php if ($cycle['mode'] === "processed"): ?>
                        <p class="sub-header">This Short Code has been ordered is due to be processed on <strong class="text-pink"><?= $cycle['date'] ?></strong></p>
                    <?php else: ?>
                        <p class="sub-header">This Short Code Order is being processed and is due to Go Live on <strong class="text-pink"><?= $cycle['date'] ?></strong></p>
                    <?php endif; ?>
                <?php endif; ?>
                <hr>

                <div class="row">
                    <div class="col-12">
                        <div class="p-2">
                            <div class="row">
                                <label class="col-md-2 col-form-label" for="country">Country</label>
                                <div class="col-md-10">
                                    <input type="text" readonly="" class="form-control-plaintext" id="country"
                                           value="UK">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label" for="mno">MNO</label>
                                <div class="col-md-10">
                                    <input type="text" readonly="" class="form-control-plaintext" id="mno"
                                           value="EE">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label" for="partner">Partner</label>
                                <div class="col-md-10">
                                    <input type="text" readonly="" class="form-control-plaintext" id="partner"
                                           value="<?= session()->get('loggedIn')['name'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label" for="merchant">Merchant</label>
                                <div class="col-md-4">
                                    <input type="text" readonly="" class="form-control-plaintext" id="merchantName"
                                           value="<?= $shortCode['merchantName'] ?>">
                                    <input type="hidden" readonly="" class="form-control-plaintext" id="merchant"
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
                                <label class="col-md-2 col-form-label" for="mediaType">Media Type</label>
                                <div class="col-md-10">
                                    <input type="text" id="mediaType"
                                           value="<?= strtoupper($shortCode['mediaType']) ?>"
                                           class="form-control-plaintext" readonly="" name="mediaType">
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <h4 class="header-title text-muted">Service Information</h4>
                                    <hr>
                                    <?php if($shortCode['mediaTypeId'] == 1): ?>
                                        <div class="form-group row mt-2">
                                            <label class="col-md-5 col-form-label" for="bindName">Bind Name</label>
                                            <div class="col-md-7">
                                                <input type="text" id="bindName" value="<?= $shortCode['bindName'] ?>"
                                                       class="form-control-plaintext" readonly="" name="bindName">
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="form-group row mt-2">
                                            <label class="col-md-5 col-form-label" for="ddi">DDI</label>
                                            <div class="col-md-7">
                                                <input type="text" id="ddi" value="<?= $shortCode['ddi'] ?>"
                                                       class="form-control-plaintext" readonly="" name="ddi">
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-group row mt-2">
                                        <label class="col-md-5 col-form-label" for="serviceDescription">Description
                                            of service</label>
                                        <div class="col-md-7">
                                            <p class="form-control-plaintext"><?= $shortCode['serviceDescription'] ?></p>

                                        </div>
                                    </div>
                                    <div class="form-group row mt-2">
                                        <label class="col-md-5 col-form-label" for="serviceType">Service
                                            Type</label>
                                        <div class="col-md-7">
                                            <input type="text" id="serviceType"
                                                   value="<?= $shortCode['serviceTypeName'] ?>"
                                                   class="form-control-plaintext" readonly="" name="serviceType">


                                        </div>
                                    </div>
                                    <div class="form-group row mt-2">
                                        <label class="col-md-5 col-form-label" for="promotionType">How is
                                            service is promoted?</label>
                                        <div class="col-md-7">
                                            <input type="text" id="promotionType"
                                                   value="<?= $shortCode['promotionTypeName'] ?>"
                                                   class="form-control-plaintext" readonly="" name="promotionType">

                                        </div>
                                    </div>
                                    <div class="form-group row mt-2">
                                        <label class="col-md-5 col-form-label" for="accessControl">Access
                                            Controls (18+)</label>

                                        <div class="col-md-7">
                                            <input type="text" id="accessControl"
                                                   value="<?= [
                                                       'yes' => 'Yes',
                                                       'no' => 'No'
                                                   ][$shortCode['accessControl']] ?>"
                                                   class="form-control-plaintext" readonly="" name="accessControl">

                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="header-title text-muted">Customer Care Information</h4>
                                    <hr>
                                    <div class="form-group row mt-2">
                                        <label class="col-md-5 col-form-label" for="contactEmail">End User
                                            Customer Care Contact Email</label>
                                        <div class="col-md-7">
                                            <input type="email" id="contactEmail"
                                                   value="<?= $shortCode['contactEmail'] ?>"
                                                   class="form-control-plaintext" readonly="" name="contactEmail">
                                        </div>
                                    </div>
                                    <div class="form-group row mt-2">
                                        <label class="col-md-5 col-form-label" for="contactPhone">End User
                                            Customer Care Number</label>
                                        <div class="col-md-7">
                                            <input type="text" id="contactPhone"
                                                   value="<?= $shortCode['contactPhone'] ?>"
                                                   class="form-control-plaintext" readonly="" name="contactPhone">

                                        </div>
                                    </div>
                                    <h4 class="header-title text-muted mt-4">Administration</h4>
                                    <hr>
                                    <div class="form-group row mt-2">
                                        <label class="col-md-5 col-form-label" for="netopAction">Action Required
                                            by Network Operator</label>
                                        <div class="col-md-7">
                                            <input type="text" id="netopAction"
                                                   value="<?= $shortCode['netopActionName'] ?>"
                                                   class="form-control-plaintext" readonly="" name="netopAction">
                                        </div>
                                    </div>

                                    <div class="form-group row mt-2">
                                        <label class="col-md-5 col-form-label" for="orderStatus">Order Status</label>
                                        <div class="col-md-7">
                                            <input type="text" id="orderStatus"
                                                   value="<?= $shortCode['orderStatusName'] ?>"
                                                   class="form-control-plaintext" readonly="" name="orderStatus">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row  mt-4">
                                <div class="col-md-12">
                                    <h4 class="header-title text-muted">Price Point</h4>
                                    <hr>
                                    <?php if ($shortCode['mediaTypeId'] == 1): ?>
                                        <div class="form-group row mt-2">
                                            <label class="col-md-2 col-form-label" for="moPrice">MO Price (inc
                                                VAT)</label>
                                            <div class="col-md-10">
                                                <input type="text" readonly id="moPrice"
                                                       value="<?= $shortCode['moPrice'] ?>"
                                                       class="form-control-plaintext pp-text" name="moPrice">

                                                <?php if (isset($zoneMappings['MO']) && !empty($zoneMappings['MO'])): ?>
                                                    <div class="d-flex justify-content-between zone-mappings mt-2">
                                                        <span>Corp Price : <?= $zoneMappings['MO']['corporatePrice'] ?></span>
                                                        <span>Tariff Class : <?= $zoneMappings['MO']['tariffClass'] ?></span>
                                                        <span>Zone Band(PAYM) : <?= $zoneMappings['MO']['paym'] ?></span>
                                                        <span>Zone Band(PAYG) : <?= $zoneMappings['MO']['payg'] ?></span>
                                                        <span>Service ID : <?= !empty($shortCode['moServiceRange']) ? $shortCode['moServiceRange'] : '---' ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="form-group row mt-2">
                                            <label class="col-md-2 col-form-label" for="mtPrice">MT Price (inc
                                                VAT)</label>
                                            <div class="col-md-10">
                                                <input type="text" readonly id="mtPrice"
                                                       value="<?= $shortCode['mtPrice'] ?>"
                                                       class="form-control-plaintext pp-text" name="mtPrice">
                                                <?php if (isset($zoneMappings['MT']) && !empty($zoneMappings['MT'])): ?>
                                                    <div class="d-flex justify-content-between zone-mappings mt-2">
                                                        <span>Is Charity : <?= ucwords($shortCode['isCharity']) ?></span>
                                                        <span>Corp Price : <?= $zoneMappings['MT']['corporatePrice'] ?></span>
                                                        <span>Tariff Class : <?= $zoneMappings['MT']['tariffClass'] ?></span>
                                                        <span>Zone Band(PAYM) : <?= $zoneMappings['MT']['paym'] ?></span>
                                                        <span>Zone Band(PAYG) : <?= $zoneMappings['MT']['payg'] ?></span>
                                                        <span>Service ID : <?= !empty($shortCode['moServiceRange']) ? $shortCode['mtServiceRange'] : '---' ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="form-group row mt-2">
                                            <label class="col-md-2 col-form-label" for="price">Price Per Min (inc
                                                VAT)</label>
                                            <div class="col-md-10">
                                                <input type="text" readonly id="price"
                                                       value="<?= $shortCode['price'] ?>"
                                                       class="form-control-plaintext pp-text" name="price">
                                                <?php if (isset($zoneMappings['PPM']) && !empty($zoneMappings['PPM'])): ?>
                                                    <div class="d-flex justify-content-between zone-mappings mt-2">

                                                        <span>Crop Price : <?= $zoneMappings['PPM']['corporatePrice'] ?></span>
                                                        <span>Tariff Class : <?= $zoneMappings['PPM']['tariffClass'] ?></span>
                                                        <span>Zone Based(PAYM) : <?= $zoneMappings['PPM']['paym'] ?></span>
                                                        <span>Zone Based(PAYG) : <?= $zoneMappings['PPM']['payg'] ?></span>
                                                    </div>
                                                <?php endif; ?>

                                            </div>
                                        </div>
                                        <div class="form-group row mt-2">
                                            <label class="col-md-2 col-form-label" for="dropCharge">Drop Charge (inc
                                                VAT)</label>
                                            <div class="col-md-10">
                                                <input type="text" readonly id="dropCharge"
                                                       value="<?= $shortCode['dropCharge'] ?>"
                                                       class="form-control-plaintext pp-text" name="dropCharge">
                                                <?php if (isset($zoneMappings['DC']) && !empty($zoneMappings['DC'])): ?>
                                                    <div class="d-flex justify-content-between zone-mappings mt-2">

                                                        <span>Crop Price : <?= $zoneMappings['DC']['corporatePrice'] ?></span>
                                                        <span>Tariff Class : <?= $zoneMappings['DC']['tariffClass'] ?></span>
                                                        <span>Zone Based(PAYM) : <?= $zoneMappings['DC']['paym'] ?></span>
                                                        <span>Zone Based(PAYG) : <?= $zoneMappings['DC']['payg'] ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>


                                </div>
                            </div>
                            <div class="row mt-4 mb-4">
                                <div class="d-flex justify-content-end gap-3">

                                    <a id="btnExit" class="btn btn-primary"
                                       href="<?= route_to('dashboard') ?>"
                                       type="button">
                                        Return to Dashboard
                                    </a>

                                    <?php if (isset($shortCode['orderId']) && !empty($shortCode['orderId'])): ?>
                                        <?php if ($shortCode['orderStatusId'] == 5): ?>
                                            <button class="btn btn-info"
                                                    onclick="migrationRequest('<?= $shortCode['shortCodeId'] ?>','<?= $shortCode['shortCode'] ?>')"
                                                    type="button">
                                                Request Migration
                                            </button>
                                        <?php endif; ?>
                                        <?php if ($shortCode['orderStatusId'] == 2): ?>
                                            <button class="btn btn-info"
                                                    onclick="markSelectedInProgress('<?= $shortCode['orderId'] ?>')"
                                                    type="button">
                                                Accept Order
                                            </button>
                                        <?php endif; ?>
                                        <?php if ($shortCode['orderStatusId'] == 3): ?>
                                            <button class="btn btn-info"
                                                    onclick="markSelectedLive('<?= $shortCode['orderId'] ?>')"
                                                    type="button">
                                                Go Live
                                            </button>
                                        <?php endif; ?>
                                        <?php if ($shortCode['orderStatusId'] != 4): ?>

                                            <a class="btn btn-info"
                                               href="<?= route_to('operator.shortCode.edit', $shortCode['shortCodeId']) ?>"
                                               type="button">
                                                Edit
                                            </a>
                                        <?php endif; ?>

                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- end row -->
            </div>
        </div>
    </div> <!-- end card -->
</div>
<?= view('partner/short-codes/partial/merchant-info-modal') ?>
<?= view('operator/short-codes/partial/migration-requests') ?>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    <?php if (isset($shortCode['orderId']) && !empty($shortCode['orderId'])): ?>

    migrationRequest = (requestId, shortCode) => {
        $("#mdMigrationRequest #requestId").val('')
        $("#mdMigrationRequest #partnerComment").val('')
        if (!requestId) {
            showDangerToast("Your request cannot be completed");
            return
        }

        $("#mdMigrationRequest .modal-title").html(`Migration Request : ${shortCode}`)
        $("#mdMigrationRequest #migrationContent").html(` <div class="d-flex justify-content-center">
                                            <div class="spinner-border" role="status"></div>
                                        </div>`);

        $("#mdMigrationRequest").modal('show');
        ajaxCall('<?=route_to('operator.shortCode.migration.content')?>', {
            requestId
        }).then((response) => {
            $("#pageloader").hide();
            if (response.status === "success") {
                $("#mdMigrationRequest #migrationContent").html(response.html);
            } else {
                window.location.reload()
                showDangerToast("Failed to get request details, Please try again");
            }

        }).catch(e => {
            $("#pageloader").hide();
            showDangerToast("Failed to complete request");
            window.location.reload()
        })
    }
    proceedMigrationRequest = (requestId) => {
        const status = $("#mdMigrationRequest #migrationStatus").val(),
            partnerId = $("#mdMigrationRequest #partners").val();
        if (!requestId) {
            showDangerToast("Your request cannot be completed");
            return
        }
        $("#pageloader").show();
        ajaxCall('<?=route_to('operator.shortCode.migration.proceed')?>', {
            requestId, partnerId, status
        }).then((response) => {
            $("#pageloader").hide();
            if (response.status === "success") {
                $("#mdMigrationRequest").modal("hide");
                showSuccessToast("Shortcode successfully migrated")
            } else if (response.status === "validation") {
                showInfoToast(response.message)
            } else {
                net
                showDangerToast("Failed to update request details, Please try again");
            }
            // window.location.reload()

        }).catch(e => {
            $("#pageloader").hide();
            showDangerToast("Failed to complete request");
            // window.location.reload()
        })
    }

    markSelectedInProgress = (orderId) => {
        if (!orderId) {
            return;
        }
        $("#pageloader").show();
        ajaxCall('<?= route_to('operator.shortCode.orders.selected.inProgress') ?>', {
            orders: [orderId]
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
    markSelectedLive = (orderId) => {
        if (!orderId) {
            return;
        }
        $("#pageloader").show();
        ajaxCall('<?= route_to('operator.shortCode.orders.selected.live') ?>', {
            orders: [orderId]
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
    <?php endif; ?>
</script>
<?= $this->endSection() ?>
