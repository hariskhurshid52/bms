<?php if (empty($cycle)): ?>
    <div class="form-group">
        <div class="alert alert-fill-danger" role="alert">
            <i class="mdi mdi-alert-circle"></i>
            Oh snap! Sorry no cycle found.
        </div>
    </div>
<?php else: ?>
    <div class="col-md-12 mt-4">
        <div class="form-group row">
            <label for="submissionDate" class="col-sm-3 col-form-label">Submission Date</label>
            <div class="col-sm-9">
                <div id="datepicker-popup" class="input-group date datepicker">
                    <input id="submissionDate" name="submissionDate" type="text" class="form-control"
                        value="<?= $cycle['submissionDate'] ?>">
                    <span class="input-group-addon input-group-append border-left">
                        <span class="mdi mdi-calendar input-group-text"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="deliveryDate" class="col-sm-3 col-form-label">Delivery Date</label>
            <div class="col-sm-9">
                <div id="datepicker-popup" class="input-group date datepicker">
                    <input id="deliveryDate" name="deliveryDate" value="<?= $cycle['deliveryDate'] ?>" type="text"
                        class="form-control">
                    <span class="input-group-addon input-group-append border-left">
                        <span class="mdi mdi-calendar input-group-text"></span>
                    </span>
                </div>
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
            <button type="submit" class="btn btn-success mr-2 pull-right" id="validate">Confirm
            </button>
        </div>
    </div>



<?php endif; ?>