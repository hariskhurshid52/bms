<?= $this->section('styles') ?>
<?= $this->endSection() ?>
<?= $this->extend('common/default-nav') ?> <?= $this->section('content') ?>
<div class="row ">
    <div class="col-12 d-flex align-items-center justify-content-between">
        <h4 class="page-title">Reporting Management</h4>
        <a href="<?= route_to('operator.reports.setup') ?>" class="nav-link float-right">Setup Report</a>
    </div>
    </hr>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?php if (count($reportingTemplates) === 0): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        No templates found
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th>Report Name</th>
                                <th>Additional Recipients</th>
                                <th>Departments</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($reportingTemplates as $template): ?>
                                <tr>
                                    <td><?= $template['name'] ?></td>
                                    <td>
                                        <?php if (count($template['recipients']) == 0): ?>
                                            --
                                        <?php else: ?>
                                            <?php foreach ($template['recipients'] as $email): ?>
                                                <span class="badge bg-info"><?= $email ?></span>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (count($template['roles']) == 0): ?>
                                            --
                                        <?php else: ?>
                                            <?php foreach ($template['roles'] as $role): ?>
                                                <span class="badge bg-info"><?= $role ?></span>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $template['createdAt'] ?></td>
                                    <td>
                                        <button onclick="downloadReportRequest('<?= $template['reportId'] ?>','<?= $template['name'] ?>')"
                                                class="btn btn-sm btn-primary">Send/Download
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Export History</h4>
                </hr>
                <?php if (count($latestExportRequests) === 0): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        No recent exports found
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th>Report Name</th>
                                <th>File Type</th>
                                <th>Departments</th>
                                <th>Recipients</th>
                                <th>Last Downloaded At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($latestExportRequests as $template): ?>
                                <tr>
                                    <td><?= $template['templateName'] ?></td>
                                    <td>CSV</td>
                                    <td>--</td>
                                    <td>--</td>

                                    <td><?= date('d-m-Y', strtotime($template['createdAt'])) ?></td>
                                    <td>
                                        <a href="<?= route_to('operator.reports.download.csv', $template['templateId'], $template['id']) ?>"
                                           class="btn btn-sm btn-primary">Download
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>

<script>
    $(document).ready(() => {

    })
    const downloadReportRequest = (reportId, name) => {
        if (!reportId) {
            return
        }
        Swal.fire({
            title: name,
            text: `What would you like to do with this report ?`,
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#1abc9c",
            cancelButtonColor: "#f1556c",
            confirmButtonText: "Send to recipient list",
            cancelButtonText: "Download a copy",
        }).then(function (t) {
            if (t.value) {
                exportReport(reportId, "email")
            } else {
                exportReport(reportId, "download")
            }
        });
    }

    const exportReport = (reportId, action = "download") => {
        $("#pageloader").show()
        ajaxCall('<?=route_to('operator.reports.exportTemplate')?>', {
            reportId, action
        }).then((response) => {
            $("#pageloader").hide()
            if (response.status === "success") {
                if (action == "download") {
                    window.open(response.downloadUrl, '_blank')
                } else {
                    showSuccessToast("Email request is in process")
                }
            } else {
                showDangerToast("Failed to complete request");
            }
        }).catch(e => {
            $("#pageloader").hide()
            showDangerToast("Failed to complete request");
            // window.location.reload()
        })
    }


</script>
<?= $this->endSection() ?>
