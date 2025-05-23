<?= $this->section('styles') ?>
<style>
    .form-section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #256029;
        border-left: 4px solid #388e3c;
        padding-left: 12px;
        margin-top: 32px;
        margin-bottom: 18px;
        background: linear-gradient(90deg, #e8f5e9 0%, #fff 100%);
        border-radius: 4px;
    }
</style>
<?= $this->endSection() ?>
<?= $this->extend('common/default-nav') ?> <?= $this->section('content') ?>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Client Registration <a href="<?= route_to('admin.customers.list') ?>"   class="btn btn-primary btn-sm pull-right"  role="button">List All</a></h4>
                    <hr/>
                    <form role="form" method="POST" action="<?= route_to('admin.customer.store') ?>">
                        <?= csrf_field(); ?>
                        <!-- Section: Personal Information -->
                        <div class="form-section-title"><i class="bi bi-person"></i> Personal Information</div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="firstName" class="form-label"> <strong class="text-danger">*</strong> First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" value="<?= old('firstName'); ?>" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="email" class="form-label"> <strong class="text-danger">*</strong> Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= old('email'); ?>" aria-describedby="emailHelp" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="phone" class="form-label"> <strong class="text-danger">*</strong> Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?= old('phone'); ?>" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="contactPerson" class="form-label">Contact Person</label>
                                <input type="text" class="form-control" id="contactPerson" name="contactPerson" value="<?= old('contactPerson'); ?>">
                            </div>
                        </div>
                        <!-- Section: Client Details -->
                        <div class="form-section-title"><i class="bi bi-building"></i> Client Details</div>
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label for="address_line_1" class="form-label"> <strong class="text-danger">*</strong> Billing Address</label>
                                <textarea class="form-control" id="address_line_1" name="address_line_1" rows="3" required><?= old('address_line_1'); ?></textarea>
                                <input type="hidden" name="address_line_1_fallback" id="address_line_1_fallback" value="">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="customerType" class="form-label">Client Type</label>
                                <select name="customerType" id="customerType" class="form-control" required>
                                    <?php foreach ([ 'customer' => 'Client','agency' => 'Agency'] as $k => $v): ?>
                                        <option value="<?= $k ?>"><?= $v ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary float-end">Register Client</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
// Ensure address_line_1 is always enabled and value is sent
$(function() {
    $('form').on('submit', function() {
        var val = $('#address_line_1').val();
        $('#address_line_1_fallback').val(val);
        $('#address_line_1').prop('disabled', false);
    });
});
</script>
<?= $this->endSection() ?>