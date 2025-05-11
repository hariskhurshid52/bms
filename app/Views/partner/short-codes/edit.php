<?= $this->extend('common/default') ?>
<?= $this->section('content') ?>


    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Reserved Short Code | <?= $shortCode['shortCode'] ?></h4>


                    <div class="row">
                        <div class="col-12">
                            <div class="p-2">
                                <form class="form-horizontal" role="form" method="post"
                                      action="<?= route_to('partner.shortCode.update.basic') ?>">
                                    <?= csrf_field() ?>
                                    <?= form_hidden('shortCode', $shortCode['id']) ?>
                                    <div class="mb-2 row">
                                        <label class="col-md-2 col-form-label" for="country">Country</label>
                                        <div class="col-md-10">
                                            <input type="text" readonly="" class="form-control-plaintext" id="country"  value="<?=session()->get('loggedIn')['countryName']?>">
                                        </div>
                                    </div>
                                    <div class="mb-2 row">
                                        <label class="col-md-2 col-form-label" for="mno">MNO</label>
                                        <div class="col-md-10">
                                            <input type="text" readonly="" class="form-control-plaintext" id="mno"
                                                   value="<?=session()->get('loggedIn')['operator']?>">
                                        </div>
                                    </div>
                                    <div class="mb-2 row">
                                        <label class="col-md-2 col-form-label" for="partner">Partner</label>
                                        <div class="col-md-10">
                                            <input type="text" readonly="" class="form-control-plaintext" id="partner"
                                                   value="<?= $shortCode['partnerName'] ?>">
                                        </div>
                                    </div>
                                    <div class="mb-2 row">
                                        <label class="col-md-2 col-form-label" for="merchant">Merchant</label>
                                        <div class="col-md-6">
                                            <select class="form-select select2" id="merchant" name="merchant"
                                                    data-placeholder="Select Merchant">
                                                <option></option>
                                                <?php foreach ($csps as $csp): ?>
                                                    <option <?= $csp['countryCspsId'] == $shortCode['countryCspId'] ? 'selected' : '' ?>
                                                            value="<?= $csp['countryCspsId'] ?>"><?= $csp['name'] ?></option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" id="merchantDetails" class="btn btn-sm btn-primary">
                                                See Merchant Details
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-2 row">
                                        <label class="col-md-2 col-form-label" for="serviceName">Service Name</label>
                                        <div class="col-md-10">
                                            <input type="text" id="serviceName" value="<?= $shortCode['serviceName'] ?>"
                                                   class="form-control" name="serviceName">
                                        </div>
                                    </div>


                                    <div class="mb-2 row">
                                        <label class="col-md-2 col-form-label" for="mediaType">Media Type</label>
                                        <div class="col-md-10">
                                            <select class="form-select select2" id="mediaType" name="mediaType">
                                                <?php foreach ($mediaTypes as $k => $val): ?>
                                                    <option <?= $val['id'] == $shortCode['mediaTypeId'] ? 'selected' : '' ?>
                                                            value="<?= $val['id'] ?>"><?= $val['type'] ?></option>

                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="row mt-2">
                                        <div class="d-flex justify-content-end gap-3">
                                            <button id="btnAddDetails" class="btn btn-success" type="submit">Add
                                                Details
                                            </button>
                                            <button id="btnExit" class="btn btn-primary"
                                                    onclick="javascript::window.location.back()" type="button">Exit
                                                Without Updating
                                            </button>
                                            <button class="btn btn-warning" type="button">Request Order Cancellation
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
