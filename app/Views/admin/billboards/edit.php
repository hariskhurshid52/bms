<?= $this->section('styles') ?>
<?= $this->endSection() ?>
<?= $this->extend('common/default-nav') ?> <?= $this->section('content') ?>


    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Update Hording Record<a href="<?= route_to('admin.billboard.list') ?>"
                                                                     class="btn btn-primary btn-sm pull-right"
                                                                     role="button">Go to list</a></h4>
                    <hr/>
                    <div class="row">
                        <form role="form" method="POST" action="<?= route_to('admin.billboard.update') ?>">
                            <?= csrf_field(); ?>
                            <?= form_hidden('billboardId', $billboard['id']) ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                               value="<?= $billboard['name'] ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="type" class="form-label">Type</label>

                                        <select name="type" id="type" class="form-control" required>
                                            <?php foreach ($billboardTypes as $type): ?>
                                                <option <?= $billboard['billboard_type_id'] == $type['id'] ? 'selected' : '' ?>
                                                        value="<?= $type['id'] ?>"><?= $type['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-2">
                                        <label for="description" class="form-label">Description</label>

                                        <textarea class="form-control" rows="4" id="description"
                                                  name="description"><?= $billboard['description'] ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label for="width" class="form-label">Width</label>

                                        <input type="number" class="form-control" id="width" name="width"
                                               value="<?= $billboard['width'] ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label for="height" class="form-label">Height</label>

                                        <input type="number" class="form-control" id="height" name="height"
                                               value="<?= $billboard['height'] ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label for="height" class="form-label">Size Type</label>

                                        <select name="size_type" id="size_type" class="form-control" required>
                                            <?php foreach (['ft' => 'Feet', 'in' => 'Inches', 'cm' => 'Centimeters', 'm' => 'Meters'] as $k => $v): ?>
                                                <option <?= $billboard['size_type'] == $k ? 'selected' : '' ?>
                                                        value="<?= $k ?>"><?= $v ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2 mt-2">
                                        <label for="booking_price" class="form-label">Minimum Booking Price</label>

                                        <input type="number" class="form-control" id="booking_price" name="booking_price"  value="<?= $billboard['booking_price']?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2 mt-2">
                                        <label for="city" class="form-label">City</label>

                                        <select name="city" id="city" class="form-control select2" required>
                                            <?php foreach ($cities as $v): ?>
                                                <option <?= $billboard['city_id'] == $v['id'] ? 'selected' : '' ?>
                                                        value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2 mt-2">
                                        <label for="city" class="form-label">Specify Area/Sector</label>
                                        <textarea type="text" class="form-control" id="area"
                                                  name="area"><?= $billboard['area'] ?></textarea>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2 mt-2">
                                        <label for="city" class="form-label">Complete Address</label>
                                        <textarea type="text" class="form-control" id="address"
                                                  name="address"><?= $billboard['address'] ?></textarea>

                                    </div>
                                </div>


                                <div class="col-md-6">

                                    <label for="installation_date" class="form-label">Installation Date</label>

                                    <div class="input-group position-relative datepicker" id="picker_installation_date">
                                        <input autocomplete="off" data-provide="datepicker"
                                               data-date-format="yyyy-mm-dd"
                                               data-date-autoclose="true"
                                               data-date-container="#picker_installation_date"
                                               type="text" class="form-control" id="installation_date"
                                               name="installation_date"
                                               readonly
                                               value="<?= date('Y-m-d', strtotime($billboard['installation_date'])) ?>">
                                        <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2 mt-2">
                                        <label for="status" class="form-label">Status</label>

                                        <select name="status" id="status" class="form-control select2" required>
                                            <?php foreach (['active' => 'Active', 'inactive' => 'In Active', 'under_maintaince' => 'Under Maintaince'] as $k => $v): ?>
                                                <option <?= $billboard['status'] == $k ? 'selected' : '' ?>
                                                        value="<?= $k ?>"><?= $v ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                            </div>


                            <!-- Submit Button -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary pull-right ">Update</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>