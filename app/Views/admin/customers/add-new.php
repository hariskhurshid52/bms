<?= $this->section('styles') ?>
<?= $this->endSection() ?>
<?= $this->extend('common/default-nav') ?> <?= $this->section('content') ?>


    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Customer Registration <a href="<?= route_to('admin.customers.list') ?>"   class="btn btn-primary btn-sm pull-right"  role="button">List All</a></h4>
                    <hr/>
                    <div class="row">
                        <form role="form" method="POST" action="<?= route_to('admin.customer.store') ?>">
                            <?= csrf_field(); ?>
                            <!-- Customer's Personal Information -->
                            <h5 class="mb-3">Personal Information</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="firstName" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="firstName" name="firstName"
                                               value="<?= old('firstName'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                               value="<?= old('email'); ?>" aria-describedby="emailHelp" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                               value="<?= old('phone'); ?>"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="contactPerson" class="form-label">Contact Person</label>
                                        <input type="text" class="form-control" id="contactPerson" name="contactPerson"
                                               value="<?= old('contactPerson'); ?>"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-2">
                                        <label for="billingAddress" class="form-label">Address</label>
                                        <textarea class="form-control" id="billingAddress" name="billingAddress"
                                                  rows="3"><?= old('billingAddress'); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="customerType" class="form-label">Client Type</label>

                                        <select name="customerType" id="customerType" class="form-control" required>
                                            <?php foreach ([ 'customer' => 'Customer','agency' => 'Agency'] as $k => $v): ?>
                                                <option value="<?= $k ?>"><?= $v ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
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