<?php if (empty($request)): ?>
    <div class="form-group">
        <div class="alert alert-fill-danger" role="alert">
            <i class="mdi mdi-alert-circle"></i>
            Oh snap! Sorry no request data found.
        </div>
    </div>
<?php else: ?>
    <div class="modal-body p-4">
        <div class="row">
            <input type="hidden" name="requestId" id="requestId"/>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="partnerComment" class="form-label">Comment Added By Partner.</label>
                    <textarea readonly name="partnerComment" class="form-control" id="partnerComment" rows="5"><?=$request['comment']?></textarea>

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
        <div class="col-md-12 submission-cnt p-0 m-0">

            <div id="loader-check">
                <div class="dot-opacity-loader">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <button type="submit" class="btn btn-success mr-2 pull-right btn-sm ml-1" onclick="proceedMigrationRequest('<?=$request['id']?>')">Setup Migration </button>
            <button type="submit" class="btn btn-info mr-2 pull-right btn-sm" data-bs-dismiss="modal" >Close</button>
        </div>
    </div>


<?php endif; ?>