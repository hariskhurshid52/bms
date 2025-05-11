<div class="modal fade" id="mdMigrationRequest" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <h4>Short Code : <span id="shortCode"></span></h4>

                    <h5>Partner:<strong><?= session()->get('loggedIn')['partnerName'] ?></strong></h5>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <div class="row">
                    <input type="hidden" name="shortCodeId" id="shortCodeId"/>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="migrationRequest" class="form-label">Message to Operator</label>
                            <textarea name="migrationRequest" class="form-control" id="migrationRequest"
                                      rows="5"></textarea>

                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel Request</button>
                <button type="submit" onclick="saveMigrationRequest()" class="btn btn-primary" id="btnSaveRequest">Request Migration</button>
            </div>
        </div>
    </div>
</div>