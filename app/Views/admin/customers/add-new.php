<?= $this->section('styles') ?>
<?= $this->endSection() ?>
<?= $this->extend('common/default-nav') ?> <?= $this->section('content') ?>



<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Customer Registration <a href="<?= route_to('admin.customer.create') ?>"
                        class="btn btn-primary btn-sm pull-right" role="button">Add New</a></h4>
                <hr />
                <div class="row">
                    <form role="form" method="POST" action="<?= route_to('admin.customer.store') ?>">
                        <?= csrf_field(); ?>
                        <!-- Customer's Personal Information -->
                        <h5 class="mb-3">Personal Information</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="firstName"
                                        value="<?= old('firstName'); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName"
                                        value="<?= old('lastName'); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= old('email'); ?>" aria-describedby="emailHelp" required>
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>

                        <div class="mb-2">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= old('phone'); ?>"
                                required>
                        </div>

                        <div class="mb-2">
                            <label for="cnic" class="form-label">CNIC Number</label>
                            <input type="text" class="form-control" id="cnic" name="cnic" value="<?= old('cnic'); ?>"
                                required>
                        </div>

                        <div class="mb-2">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <div class="input-group position-relative datepicker" id="dobPicker">
                                    <input autocomplete="off" data-provide="datepicker" data-date-format="yyyy-mm-dd"
                                        data-date-autoclose="true" data-date-container="#dobPicker"
                                        type="text" class="form-control" id="dateOfBirth" name="dateOfBirth"
                                        readonly value="<?= date('Y-m-d',strtotime('-18 years')) ?>">
                                    <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                                </div>
                        </div>

                        <!-- Customer's Company Information -->
                        <h5 class="mt-4 mb-3">Company Information (Optional)</h5>

                        <div class="mb-2">
                            <label for="companyName" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="companyName" name="companyName"
                                value="<?= old('companyName'); ?>">
                        </div>

                        <!-- Customer's Address Information -->
                        <h5 class="mt-4 mb-3">Address Information</h5>

                        <div class="mb-2">
                            <label for="address1" class="form-label">Address Line 1</label>
                            <input type="text" class="form-control" id="address1" name="address1"
                                value="<?= old('address1'); ?>">
                        </div>

                        <div class="mb-2">
                            <label for="address2" class="form-label">Address Line 2</label>
                            <input type="text" class="form-control" id="address2" name="address2"
                                value="<?= old('address2'); ?>">
                        </div>
                        
                        <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="country" class="form-label">Country</label>
                                <select class="form-control select2" id="country" name="country">
                                <option></option>
                                    <?php foreach ($countries as $country) : ?>
                                        <option value="<?= $country['id']; ?>" <?= old('country') == $country['id'] ? 'selected' : ''; ?>><?= $country['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="state" class="form-label">State</label>
                                    <select class="form-control select2" id="state" name="state">
                                        <option></option>
                                        <?php foreach ($states as $state) : ?>
                                            <option value="<?= $state['id']; ?>" <?= old('state') == $state['id'] ? 'selected' : ''; ?>><?= $state['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                   
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="city" class="form-label">City</label>
                                    <select class="form-control select2" id="city" name="city">
                                    <option></option>
                                        <?php foreach ($cities as $city) : ?>
                                            <option value="<?= $city['id']; ?>" <?= old('city') == $city['id'] ? 'selected' : ''; ?>><?= $city['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="postalCode" class="form-label">Postal Code</label>
                                    <input type="text" class="form-control" id="postalCode" name="postalCode"
                                        value="<?= old('postalCode'); ?>">
                                </div>
                            </div>
                        </div>

                        

                        <!-- Customer's Billing Information -->
                        <h5 class="mt-4 mb-3">Billing Information</h5>

                        <div class="mb-2">
                            <label for="billingAddress" class="form-label">Billing Address</label>
                            <textarea class="form-control" id="billingAddress" name="billingAddress"
                                rows="3"><?= old('billingAddress'); ?></textarea>
                        </div>




                        <!-- Customer's Status -->
                        <h5 class="mt-4 mb-3">Account Status</h5>

                        <div class="mb-2">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control select2" id="status" name="status">
                                <option value="active" <?= old('status') == 'active' ? 'selected' : ''; ?>>Active</option>
                                <option value="inactive" <?= old('status') == 'inactive' ? 'selected' : ''; ?>>Inactive
                                </option>
                                <option value="suspended" <?= old('status') == 'suspended' ? 'selected' : ''; ?>>Suspended
                                </option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary pull-right ">Register Customer</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>