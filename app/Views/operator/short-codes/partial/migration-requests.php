<div class="modal fade" id="mdMigrationRequest" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" >Migration Request</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div id="migrationContent">
                <div class="modal-body p-4">
                    <div class="row">
                        <input type="hidden" name="requestId" id="requestId"/>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="partnerComment" class="form-label">Comment Added By Partner.</label>
                                <textarea readonly name="partnerComment" class="form-control" id="partnerComment"
                                          rows="5"></textarea>

                            </div>

                        </div>
                    </div>

                    <hr>
                    <div class="row">

                        <div class="form-group">
                            <label class="form-label" for="migrationStatus">Status</label>
                            <select class="form-control " id="migrationStatus" name="partners">
                                <?php foreach (['approved', 'rejected'] as $status): ?>
                                    <option value="<?= $status ?>"><?= ucfirst($status) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="partners">Partners</label>
                            <select class="form-control " id="partners" name="partners">
                                <?php foreach ($partners as $partner): ?>
                                    <option value="<?= $partner['countryAggregatorId'] ?>"><?= $partner['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
</div>
