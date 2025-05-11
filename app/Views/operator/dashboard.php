<?= $this->section('styles') ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.3.0/css/fixedColumns.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<?= $this->endSection() ?>
<?= $this->extend('common/default-nav') ?> <?= $this->section('content') ?>
<div class="row mt-2 dashboard">
    <div class="col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="header-title">Migration Requests</h4>

                    <div class="d-flex flex-column align-items-end">
                        <a class="nav-link" href="<?= route_to('operator.shortCode.migration.requests') ?>">View All</a>
                        <span class="badge badge-outline-primary"> <i class="fe-arrow-right"></i> </span>
                    </div>

                </div>
                <hr/>
                <div class="table-responsive dashboard-widget">
                    <table class="table table-sm table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Short Code</th>
                            <th>Partner</th>
                            <th>Operator Action</th>
                            <th>Source</th>
                            <th>Requested On</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($topMigrationRequests as $request): ?>
                            <td><?= $request['shortCode'] ?></td>
                            <td><?= $request['partnerName'] ?></td>
                            <td><?= $request['netopActionName'] ?></td>
                            <td><?= ucfirst($request['source']) ?></td>
                            <td><?= $request['createdAt'] ?></td>

                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="header-title">New Orders</h4>
                    <div class="d-flex flex-column align-items-end">
                        <a href="<?=route_to('operator.shortCode.orders.new.list')?>">To accept for processing</a>
                        <span class="badge badge-outline-primary"> <i class="fe-calendar"></i> <?=$nextCycle['submissionDate']?></span>
                    </div>
                </div>
                <hr/>
                <div class="table-responsive  dashboard-widget">
                    <table class="table table-sm table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Short Code</th>
                            <th>Partner</th>
                            <th>Order Started</th>
                            <th>Source</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (count($newOrders) == 0): ?>
                            <tr>
                                <td colspan="4">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        No new orders found
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($newOrders as $shortCode): ?>
                                <tr>
                                    <td>
                                        <a href="<?= route_to('operator.shortCode.view', $shortCode['shortCodeId']) ?>"><?= $shortCode['shortCode'] ?></a>
                                    </td>
                                    <td><a><?= $shortCode['partnerName'] ?></a></td>
                                    <td><a><?= ($shortCode['orderStarted']) ?></a></td>
                                    <td><a><?= ucfirst($shortCode['source']) ?></a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="header-title">Processing Orders</h4>
                    <div class="d-flex flex-column align-items-end">
                        <a  href="<?=route_to('operator.shortCode.orders.in-progress.list')?>">To Go Live</a>
                        <span class="badge badge-outline-primary"> <i class="fe-calendar"></i> <?=$nextCycle['deliveryDate']?></span>
                    </div>
                </div>
                <hr/>
                <div class="table-responsive  dashboard-widget">
                    <table class="table table-sm table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Short Code</th>
                            <th>Partner</th>
                            <th>Order Started</th>
                            <th>Source</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (count($processingOrders) == 0): ?>
                            <tr>
                                <td colspan="4">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        No orders found in processing
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($processingOrders as $shortCode): ?>
                                <tr>
                                    <td>
                                        <a href="<?= route_to('operator.shortCode.view', $shortCode['shortCodeId']) ?>"><?= $shortCode['shortCode'] ?></a>
                                    </td>
                                    <td><a><?= $shortCode['partnerName'] ?></a></td>
                                    <td><a><?= ($shortCode['orderStarted']) ?></a></td>
                                    <td><a><?= ucfirst($shortCode['source']) ?></a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" id="mediaTypesShortCodes">
                    <li class="nav-item">
                        <a href="#tabAllShortCodeList" data-bs-toggle="tab" aria-expanded="false"
                           class="nav-link active">
                            <span class="d-inline-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                            <span class="d-none d-sm-inline-block">All Short codes</span>
                        </a>
                    </li>
                    <?php foreach ($mediaTypes as $type): ?>
                        <li class="nav-item">
                            <a href="#tabAllShortCodeList" data-media-type="<?= $type['id'] ?>"
                               data-loaded="false" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                <span class="d-inline-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                                <span class="d-none d-sm-inline-block"><?= $type['type'] ?> Short codes</span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active show" id="tabAllShortCodeList">
                        <div class="table-responsive">
                            <table class="table table-sm data-table" id="shortCodesTable">
                                <thead>
                                <tr>
                                    <th style="min-width: 100px;">Media Type</th>
                                    <th style="min-width: 100px;">Short Code</th>
                                    <th style="min-width: 100px;">Partner</th>
                                    <th>Merchant</th>
                                    <th>Service Name</th>
                                    <th>Merchant PSA</th>
                                    <th>Network Operator Action</th>
                                    <th>MO Price <small><sup>Inc VAT</sup></small></th>
                                    <th>MT Price <small><sup>Inc VAT</sup></small></th>
                                    <th>Bind Name</th>
                                    <th>Service Description</th>
                                    <th>Service Type</th>
                                    <th>Service Initiated</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script type="text/javascript" charset="utf-8" src="https://cdn.datatables.net/fixedcolumns/3.3.0/js/dataTables.fixedColumns.min.js"></script>

<script>
    $(document).ready(() => {
        initDataTable()
        $('#mediaTypesShortCodes a').on('shown.bs.tab', function (e) {
            $('#shortCodesTable').DataTable().ajax.reload();
        })
    })
    const initDataTable = () => {
        $('#shortCodesTable').DataTable().destroy();
        const table = $('#shortCodesTable').DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 100]],
            fixedColumns: {
                left: 3,
                leftColumns: 3,
            },
            ordering:false,
            paging: true,
            scrollCollapse: false,
            scrollX: true,
            scrollY: false,
            processing: true,
            serverSide: true,
            buttons: [
                {extend: "copy", className: "btn-light"}, {
                    extend: "print",
                    className: "btn-light"
                }, {extend: "pdf", className: "btn-light"}],
            ajax: {
                url: '<?= route_to("operator.dashboard.dtMediaTypeLiveShortCodes") ?>',
                type: 'POST',
                data: function (d) {
                    d['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
                    d.mediaType = $("#mediaTypesShortCodes a.active").attr('data-media-type');
                },
            },

        });
    };


</script>
<?= $this->endSection() ?>
