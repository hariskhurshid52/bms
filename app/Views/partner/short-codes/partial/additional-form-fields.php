<div class="mb-2 row">
    <label class="col-md-2 col-form-label" for="country">Country</label>
    <div class="col-md-10">
        <input type="text" readonly="" class="form-control-plaintext"
               id="country"
               value="<?= session()->get('loggedIn')['countryName'] ?>">
    </div>
</div>
<div class="mb-2 row">
    <label class="col-md-2 col-form-label" for="mno">MNO</label>
    <div class="col-md-10">
        <input type="text" readonly="" class="form-control-plaintext" id="mno"
               value="<?= session()->get('loggedIn')['operator'] ?>">
    </div>
</div>
<div class="mb-2 row">
    <label class="col-md-2 col-form-label" for="partner">Partner</label>
    <div class="col-md-10">
        <input type="text" readonly="" class="form-control-plaintext"
               id="partner"
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
        <button type="button" id="merchantDetails"
                class="btn btn-sm btn-primary">
            See Merchant Details
        </button>
    </div>
</div>
<div class="mb-2 row">
    <label class="col-md-2 col-form-label" for="serviceName">Service
        Name</label>
    <div class="col-md-10">
        <input type="text" id="serviceName"
               value="<?= $shortCode['serviceName'] ?>"
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
<div class="row">
    <div class="col-md-6">
        <h4 class="header-title text-muted">Service Information</h4>
        <hr>
        <div  data-mediaType="1" class="media-type form-group row mt-2 <?=empty($shortCode['mediaTypeId']) || $shortCode['mediaTypeId'] == 1 ? '':'d-none'?>" >
            <label class="col-md-3 col-form-label" for="bindName">Bind Name</label>
            <div class="col-md-9">

                <select class="form-control select2" id="bindName" name="bindName">
                    <option></option>
                    <?php foreach ($bindNames as $names) : ?>
                        <option <?= $shortCode['bindName'] === $names['id'] ? 'selected' : '' ?>
                                value="<?= $names['id'] ?>"><?= $names['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div  data-mediaType="2" class="media-type form-group row mt-2  <?=!empty($shortCode['mediaTypeId']) && $shortCode['mediaTypeId'] ==2 ? '':'d-none'?>" >
            <label class="col-md-3 col-form-label" for="ddi">DDI</label>
            <div class="col-md-9">

               <input class="form-control" type="text" id="ddi" name="ddi" value="<?=$shortCode['ddi']?>">
            </div>
        </div>

        <div class="form-group row mt-2">
            <label class="col-md-3 col-form-label" for="serviceDescription">Description
                of service</label>
            <div class="col-md-9">
                                                    <textarea cols="4" rows="4" id="serviceDescription"
                                                              class="form-control"
                                                              name="serviceDescription"><?= $shortCode['serviceDescription'] ?></textarea>
            </div>
        </div>
        <div class="form-group row mt-2">
            <label class="col-md-3 col-form-label" for="serviceType">Service
                Type</label>
            <div class="col-md-9" id="cntServiceType">
                <select name="serviceType" id="serviceType"
                        class="form-select select2"
                        data-placeholder="Select Service Type">
                    <option></option>
                    <?php foreach ($servicesTypes as $k => $serviceType): ?>
                        <option <?= $shortCode['serviceType'] == $serviceType['id'] ? 'selected' : '' ?>
                                value="<?= $serviceType['id'] ?>"><?= $serviceType['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group row mt-2">
            <label class="col-md-3 col-form-label" for="promotionType">How is
                service is promoted?</label>
            <div class="col-md-9" id="cntPromotionType">
                <select name="promotionType" id="promotionType"
                        class="form-select select2"
                        data-placeholder="Select Promotion Type">
                    <option></option>
                    <?php foreach ($initiations as $k => $value): ?>
                        <option <?= $shortCode['promotionType'] == $value['initiationId'] ? 'selected' : '' ?>
                                value="<?= $value['initiationId'] ?>"><?= $value['initiationName'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group row mt-2">
            <label class="col-md-3 col-form-label" for="accessControl">Access
                Controls (18+)</label>
            <div class="col-md-9">
                <select name="accessControl" id="accessControl"
                        class="form-select select2"
                        data-placeholder="Select Access Control">
                    <option></option>
                    <?php foreach ([
                                       'yes' => 'Yes',
                                       'no' => 'No'
                                   ] as $k => $value): ?>
                        <option <?= $shortCode['accessControl'] == $k ? 'selected' : '' ?>
                                value="<?= $k ?>"><?= $value ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <h4 class="header-title text-muted">Customer Care Information</h4>
        <hr>
        <div class="form-group row mt-2">
            <label class="col-md-3 col-form-label" for="contactEmail">End User
                Customer Care Contact Email</label>
            <div class="col-md-9">
                <input type="email" id="contactEmail"
                       value="<?= $shortCode['contactEmail'] ?>"
                       class="form-control" name="contactEmail">
            </div>
        </div>
        <div class="form-group row mt-2">
            <label class="col-md-3 col-form-label" for="contactPhone">End User
                Customer Care Number</label>
            <div class="col-md-9">
                <input type="text" id="contactPhone"
                       value="<?= $shortCode['contactPhone'] ?>"
                       class="form-control" name="contactPhone">

            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <h4 class="header-title text-muted">Price Point</h4>

                </div>
                <hr>
                <div data-mediaType="1" class="media-type <?=empty($shortCode['mediaTypeId']) || $shortCode['mediaTypeId'] == 1 ? '':'d-none'?>">
                    <div class="form-group row mt-2">
                        <label class="col-md-5 col-form-label" for="moPrice">MO Price (inc
                            VAT)</label>
                        <div class="col-md-7">
                            <?php if(isset($pricePoints['MO']) && count($pricePoints['MO']) >0): ?>
                            <select class="form-control select2" name="moPrice" id="moPrice" data-placeholder="-.--">

                                <?php foreach ($pricePoints['MO'] as $price): ?>
                                <option <?=$shortCode['moPrice'] == $price ? 'selected':''?>  value="<?=$price?>"><?=$price?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php else: ?>
                                <input type="text" id="moPrice" value="<?= $shortCode['moPrice'] ?>"
                                       class="form-control" name="moPrice">
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="form-group row mt-2 ">
                        <label class="col-md-5 col-form-label" for="mtPrice">MT Price (inc
                            VAT)
                            <label class="form-label pull-right" for="isCharity">
                                <small> Is Charity</small>
                                <input type="checkbox" <?= $shortCode['isCharity'] == 'yes' ? 'checked' : '' ?>
                                       data-plugin="switchery"
                                       data-size="small" value="yes" id="isCharity" name="isCharity"
                                       data-color="#039cfd"/>
                            </label>
                        </label>
                        <div class="col-md-7">

                            <?php if(isset($pricePoints['MT']) && count($pricePoints['MT']) >0): ?>
                                <select class="form-control select2" name="mtPrice" id="mtPrice"  data-placeholder="-.--">
                                    <?php foreach ($pricePoints['MT'] as $price): ?>
                                        <option <?=$shortCode['mtPrice'] == $price ? 'selected':''?> value="<?=$price?>"><?=$price?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else: ?>
                                <input type="text" id="mtPrice" value="<?= $shortCode['mtPrice'] ?>"
                                       class="form-control" name="mtPrice">
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
                <div data-mediaType="2" class="media-type  <?=!empty($shortCode['mediaTypeId']) && $shortCode['mediaTypeId'] ==2 ? '':'d-none'?>">
                    <div class="form-group row mt-2">
                        <label class="col-md-3 col-form-label" for="price">Price Per Min (inc
                            VAT)</label>
                        <div class="col-md-9">
                            <select class="form-control select2" name="price" id="price"   data-placeholder="-.--">
                                <?php foreach ($pricePoints['PPM'] as $price): ?>
                                    <option <?=$shortCode['price'] == $price ? 'selected':''?> value="<?=$price?>"><?=$price?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label class="col-md-3 col-form-label" for="dropCharge">Drop Charge (inc </label>
                        <div class="col-md-9">
                            <select class="form-control select2" name="dropCharge" id="dropCharge"   data-placeholder="-.--">
                                <?php foreach ($pricePoints['DC'] as $price): ?>
                                    <option <?=$shortCode['dropCharge'] == $price ? 'selected':''?> value="<?=$price?>"><?=$price?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

</div>

