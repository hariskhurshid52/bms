<?= $this->section('styles') ?>

<?= $this->endSection() ?>
<?= $this->extend('common/default') ?>
<?= $this->section('content') ?>
<?php

?>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Manage Schedule
                </h4>
                <hr />
                <div class="table-responsive">
                    <table class="table table-hover" id="dtCycles">
                        <thead>
                            <tr>
                                <th>Submission Date</th>
                                <th>Delivery Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cycles as $cycle):

                                $currentTimestamp = strtotime('now');
                                $todayTimestamp = strtotime($today);
                                $submissionTimestamp = strtotime($cycle['submissionDate']);
                                $submissionClass = ($currentTimestamp > $submissionTimestamp) ? 'passed' : '';
                                if ($submissionTimestamp == $todayTimestamp) {
                                    $submissionClass = 'current';
                                }
                                if ($cycle['submissionDate'] == $recent['submission']) {
                                    $submissionClass = 'recent';
                                }

                                $deliveryTimestamp = strtotime($cycle['deliveryDate']);
                                $deliveryClass = ($currentTimestamp > $deliveryTimestamp) ? 'passed' : '';
                                if ($cycle['deliveryDate'] == $recent['delivery']) {
                                    $deliveryClass = 'recent';
                                }
                                if ($deliveryTimestamp == $todayTimestamp) {
                                    $deliveryClass = 'current';
                                }

                                ?>
                                <tr data-cycle="<?=$submissionClass === "passed"  && $deliveryClass === "passed" ? 'passed':'' ?>" class="<?=$submissionClass === "passed"  && $deliveryClass === "passed" ? 'd-none':'' ?>">
                                    <td>
                                        <span class="cycle cycle-<?= $submissionClass ?>"><?= date('d-m-Y', strtotime($cycle['submissionDate'])) ?></span>
                                        <?=strtotime('now') > strtotime($cycle['submissionDate']) ? '<sup class="passed">Passed</sup>':''  ?>
                                    </td>
                                    <td class="cycle cycle-<?= $deliveryClass ?> ">
                                        <?= date('d-m-Y', strtotime($cycle['deliveryDate'])) ?>
                                    </td>
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
    $("#dtCycles").DataTable({
        pageLength: 20,
        ordering: false,
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, 100]],
        dom: 'Bfrtip',  // Include the Buttons in the DOM layout
        buttons: [
            {
                text: 'Toggle Passed Schedule',
                className :'btn btn-sm',
                action: function (e, dt, node, config) {
                    $("[data-cycle='passed']").toggleClass('d-none')
                }
            }
        ]

    })
</script>
<?= $this->endSection() ?>