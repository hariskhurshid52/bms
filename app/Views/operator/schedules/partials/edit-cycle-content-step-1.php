<?php if (empty($cycle)): ?>
    <div class="form-group">
        <div class="alert alert-fill-danger" role="alert">
            <i class="mdi mdi-alert-circle"></i>
            Oh snap! Sorry no cycle found.
        </div>
    </div>
<?php else: ?>
    <?= form_hidden('cycleId', $cycle['id'] ?? '') ?>
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="submissionDate" class="form-label">Submission Date</label>
                <div class="input-group position-relative datepicker" id="submissionDatePicker">
                    <input autocomplete="off" data-provide="datepicker"
                           data-date-format="yyyy-mm-dd" data-date-autoclose="true"
                           data-date-container="#submissionDatePicker" type="text"
                           class="form-control" id="submissionDate" name="submissionDate"
                           readonly
                           value="<?= $cycle['submissionDate'] ?>">
                    <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                </div>

            </div>
            <div class="mb-3">
                <label for="deliveryDate" class="form-label">Delivery Date</label>
                <div class="input-group position-relative datepicker" id="deliveryDatePicker">
                    <input autocomplete="off" data-provide="datepicker"
                           data-date-format="yyyy-mm-dd" data-date-autoclose="true"
                           data-date-container="#deliveryDatePicker" type="text" name="deliveryDate"
                           class="form-control" id="deliveryDate"
                           readonly
                           value="<?= $cycle['deliveryDate'] ?>">
                    <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                </div>

            </div>
        </div>
    </div>


<?php endif; ?>