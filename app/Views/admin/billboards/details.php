<?= $this->extend('common/default-nav') ?>
<?= $this->section('content') ?>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title">Billboard Detail
                    <a href="<?= route_to('admin.billboard.list') ?>" class="btn btn-primary btn-sm float-end">Back to List</a>
                </h4>
                <hr/>

                <!-- BASIC DETAILS -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Name:</strong>
                        <p class="form-control-plaintext"><?= esc($billboard['name']) ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Type:</strong>
                        <p><?= esc($billboard['typeName'] ?? 'N/A') ?></p>
                    </div>

                    <div class="col-md-12 mb-3">
                        <strong>Description:</strong>
                        <p><?= nl2br(esc($billboard['description'])) ?></p>
                    </div>
                </div>

                <!-- SIZE & DIMENSIONS -->
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <strong>Width:</strong>
                        <p><?= esc($billboard['width']) ?></p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Height:</strong>
                        <p><?= esc($billboard['height']) ?></p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Size Type:</strong>
                        <p><?= strtoupper(esc($billboard['size_type'])) ?></p>
                    </div>
                </div>

                <!-- LOCATION -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>City:</strong>
                        <p><?= esc($billboard['cityName']) ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Area / Sector:</strong>
                        <p><?= esc($billboard['area']) ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Complete Address:</strong>
                        <p><?= esc($billboard['address']) ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Traffic Coming From:</strong>
                        <p><?= esc($billboard['traffic_commming_from']) ?></p>
                    </div>
                </div>

                <!-- CONTRACT & AUTHORITY INFO -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Contract Duration (in years):</strong>
                        <p><?= esc($billboard['contract_duration']) ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Contract Date:</strong>
                        <p><?= date('d M, Y', strtotime($billboard['contract_date'])) ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Authority Name:</strong>
                        <p><?= esc($billboard['authority_name']) ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Installation Date:</strong>
                        <p><?= date('d M, Y', strtotime($billboard['installation_date'])) ?></p>
                    </div>
                </div>

                <!-- FINANCIALS -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Minimum Booking Price:</strong>
                        <p><?= number_format($billboard['booking_price'], 2) ?> PKR</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Monthly Rent:</strong>
                        <p><?= number_format($billboard['monthly_rent'], 2) ?> PKR</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Annual Increase (%):</strong>
                        <p><?= esc($billboard['annual_increase']) ?>%</p>
                    </div>
                </div>

                <!-- MEDIA -->
                <?php if (!empty($billboard['image_url'])): ?>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Image:</strong>
                            <div><img src="<?= esc($billboard['image_url']) ?>" class="img-fluid rounded" alt="Billboard Image"/></div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($billboard['video_url'])): ?>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Video:</strong>
                            <div class="ratio ratio-16x9">
                                <iframe src="<?= esc($billboard['video_url']) ?>" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- STATUS -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Status:</strong>
                        <p>
                            <?php
                            $statusLabels = [
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'under_maintenance' => 'Under Maintenance'
                            ];
                            echo esc($statusLabels[$billboard['status']] ?? $billboard['status']);
                            ?>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>
