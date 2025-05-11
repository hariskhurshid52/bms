<?php foreach ($partnerShortCodes as $partner): ?>
    <div class="row">
        <div class="card ribbon-box">
            <div class="card-body">
                <div class="ribbon ribbon-purple float-start"><i class="mdi mdi-access-point me-1"></i>
                    <?= $partner['name'] ?></div>
                <div class="ribbon-content">

                    <table>
                        <?php foreach ($partner['shortCodes'] as $shortCode): ?>
                            <tr>
                                <td>Short Code</td>
                                <td><?= $shortCode['shortCode'] ?></td>
                            </tr>
                            <tr>
                                <td>Media Type</td>
                                <td><?= $shortCode['mediaTypeName'] ?></td>
                            </tr>
                            <tr>
                                <td>Service Type</td>
                                <td><?= $shortCode['serviceTypeName'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    </hr>

                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>