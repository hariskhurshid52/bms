<?php if (!isset($csp) || empty($csp)): ?>
    <div class="form-group">
        <div class="alert alert-fill-danger" role="alert">
            <i class="mdi mdi-alert-circle"></i>
            Oh snap! Sorry no merchant details found.
        </div>
    </div>
<?php else: ?>
    <div class="mb-2 row">
        <label class="col-md-4 col-form-label">Name</label>
        <div class="col-md-8">
            <p class="form-control-plaintext"><?= $csp['name'] ?></p>
        </div>
    </div>
    <div class="mb-2 row">
        <label class="col-md-4 col-form-label">Country</label>
        <div class="col-md-8">
            <p class="form-control-plaintext"><?=session()->get('loggedIn')['countryName']?></p>
        </div>
    </div>
    <div class="mb-2 row">
        <label class="col-md-4 col-form-label">Emails</label>
        <div class="col-md-8">
            <p class="form-control-plaintext"><?= ($csp['email'] ? str_replace(',', '<br/>', $csp['email']) : '') ?> </p>
        </div>
    </div>
    <div class="mb-2 row">
        <label class="col-md-4 col-form-label">Applicable Registration</label>
        <div class="col-md-8">
            <p class="form-control-plaintext"><?=$csp['registrationAuthority']?> <span class="badge badge-inverse-light"><?=$csp['registrationAuthority']?></span></p>
        </div>
    </div>
    <div class="mb-2 row">
        <label class="col-md-4 col-form-label">Authority Registration Number #</label>
        <div class="col-md-8">
            <p class="form-control-plaintext"><?=$csp['authorityRegistrationNumber']?> </p>
        </div>
    </div>
    <div class="mb-2 row">
        <label class="col-md-4 col-form-label">Regulatory Authority License Number #</label>
        <div class="col-md-8">
            <p class="form-control-plaintext"><?=$csp['regulatoryAuthorityLicenseNumber']?> </p>
        </div>
    </div>
    <div class="mb-2 row">
        <label class="col-md-4 col-form-label">Company Registration #</label>
        <div class="col-md-8">
            <p class="form-control-plaintext"><?=$csp['companyRegNumber']?> </p>
        </div>
    </div>
    <div class="mb-2 row">
        <label class="col-md-4 col-form-label">Registered Company Name</label>
        <div class="col-md-8">
            <p class="form-control-plaintext"><?=$csp['regCompanyName']?> </p>
        </div>
    </div>
    <div class="mb-2 row">
        <label class="col-md-4 col-form-label">Company VAT #</label>
        <div class="col-md-8">
            <p class="form-control-plaintext"><?=$csp['companyVatNumber']?> </p>
        </div>
    </div>
    <div class="mb-2 row">
        <label class="col-md-4 col-form-label">Company Address Line 1</label>
        <div class="col-md-8">
            <p class="form-control-plaintext"><?=$csp['addressLine1']?>  </p>
        </div>
    </div>
    <div class="mb-2 row">
        <label class="col-md-4 col-form-label">Company Address Line 2</label>
        <div class="col-md-8">
            <p class="form-control-plaintext"><?=$csp['addressLine2']?>  </p>
        </div>
    </div>
    <div class="mb-2 row">
        <label class="col-md-4 col-form-label">City</label>
        <div class="col-md-8">
            <p class="form-control-plaintext"><?=$csp['city']?>  </p>
        </div>
    </div>
    <div class="mb-2 row">
        <label class="col-md-4 col-form-label">County</label>
        <div class="col-md-8">
            <p class="form-control-plaintext"><?=$csp['county']?>  </p>
        </div>
    </div>
    <div class="mb-2 row">
        <label class="col-md-4 col-form-label">country</label>
        <div class="col-md-8">
            <p class="form-control-plaintext"><?=$csp['country']?>  </p>
        </div>
    </div>
    <div class="mb-2 row">
        <label class="col-md-4 col-form-label">ZIP Code/Post Code</label>
        <div class="col-md-8">
            <p class="form-control-plaintext"><?=$csp['zipCodePostCode']?>  </p>
        </div>
    </div>
    <div class="mb-2 row">
        <label class="col-md-4 col-form-label">Link to CSP Privacy Policy</label>
        <div class="col-md-8">
            <p class="form-control-plaintext"><?=$csp['privacyPolicy']?>  </p>
        </div>
    </div>
    <div class="mb-2 row">
        <label class="col-md-4 col-form-label">Company Website</label>
        <div class="col-md-8">
            <p class="form-control-plaintext"><?=$csp['corporateWebsite']?> </p>
        </div>
    </div>
    <?php if(false):?>
        <div class="mb-2 ">
            <label class="col-md-4 col-form-label">History</label>
            <div class="col-md-12">
                <ol class="list-group list-group-numbered">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">City <small class="text-muted">Updated By</small></div>
                            <i class="fe-user me-1"></i>Adrina martin da Silva
                        </div>
                        <span class="badge bg-primary rounded-pill"> <?= date('Y-m-d H:i:s') ?></span>
                    </li>

                </ol>
            </div>
        </div>
    <?php endif;?>

<?php endif; ?>
