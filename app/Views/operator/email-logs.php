<?= $this->extend('common/default-nav') ?>
<?= $this->section('content') ?>
<div class="row mt-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">
                    Email Log
                </h4>
                <hr />
                <div class="table-responsive">
                    <table class="table table-hover" id="tblEmail">
                        <thead>
                            <tr>
                                <th style="width: 10%;">#</th>
                                <th style="width: 20%;">Subject</th>
                                <th style="width: 30%;">To</th>
                                <th style="width: 30%;">Cc</th>
                                <th style="width: 10%;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($emails as $k => $email): ?>
                                <tr>
                                    <td><?= ++$k ?></td>
                                    <td><?= $email['subject'] ?></td>
                                    <td>
                                        <?php foreach ($email['to'] as $to): ?>
                                            <span class="bg-email">
                                                <span class="name"><?= $to['name'] ?></span>
                                                <span class="email"><?= $to['email'] ?></span>
                                            </span>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>
                                        <?php foreach ($email['cc'] as $to): ?>
                                            <span class="bg-email">
                                                <span class="name"><?= $to['name'] ?></span>
                                                <span class="email"><?= $to['email'] ?></span>
                                            </span>
                                        <?php endforeach; ?>
                                    </td>
                                    <td><?= ucwords($email['status']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    $(document).ready(() => {
        $("#tblEmail").DataTable()
    })

</script>
<?= $this->endSection() ?>