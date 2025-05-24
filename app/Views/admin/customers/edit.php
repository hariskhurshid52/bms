<?= $this->section('styles') ?>
<?= $this->endSection() ?>
<?= $this->extend('common/default-nav') ?> <?= $this->section('content') ?>


    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Client Record Edit <a href="<?= route_to('admin.customer.create') ?>"
                                                                     class="btn btn-primary btn-sm pull-right"
                                                                     role="button">Add New</a></h4>
                    <hr/>
                    <div class="row">
                        <form role="form" method="POST" action="<?= route_to('admin.customer.update') ?>">
                            <?= csrf_field() ?>
                            <?= form_hidden('customerId', $customerInfo['id']) ?>
                            <!-- Client's Personal Information -->
                            <h5 class="mb-3">Client Information</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="firstName" class="form-label"> <strong class="text-danger">*</strong> Client Name</label>
                                        <input type="text" class="form-control" id="firstName" name="firstName"
                                               value="<?= $customerInfo['first_name'] ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="email" class="form-label"> <strong class="text-danger">*</strong> Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                               value="<?= $customerInfo['email'] ?>" aria-describedby="emailHelp"
                                               required>
                                        <div id="emailHelp" class="form-text">We'll never share your email with anyone
                                            else.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="phone" class="form-label"> <strong class="text-danger">*</strong> Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                               value="<?= $customerInfo['phone'] ?>"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">

                                        <label for="contactPerson" class="form-label">Contact Person</label>
                                        <input type="text" class="form-control" id="contactPerson" name="contactPerson"
                                               value="<?= $customerInfo['contact_person']; ?>"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-2">
                                        <label for="address_line_1" class="form-label"> <strong class="text-danger">*</strong> Billing Address</label>
                                        <textarea class="form-control" id="address_line_1" name="address_line_1"
                                                  rows="3"><?= $customerInfo['address_line_1']; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="customerType" class="form-label">Client Type</label>

                                        <select name="customerType" id="customerType" class="form-control" required>
                                            <?php foreach ([ 'customer' => 'Client','agency' => 'Agency', 'advertisor' => 'Advertisor'] as $k => $v): ?>
                                                <option <?= $customerInfo['customer_type'] == $k ? 'selected' : '' ?> value="<?= $k ?>"><?= $v ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>




                            <!-- Submit Button -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary pull-right">Update Client</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>