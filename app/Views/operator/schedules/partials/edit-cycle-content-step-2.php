<?php if (empty($cycle)): ?>
    <div class="form-group">
        <div class="alert alert-fill-danger" role="alert">
            <i class="mdi mdi-alert-circle"></i>
            Oh snap! Sorry no cycle found.
        </div>
    </div>
<?php else: ?>
    <div class="form-group d-flex justify-content-between mb-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox"
                   id="emailNotification" <?= (($cycle['notificationType'] == "email" || $cycle['notificationType'] == "both") && (($cycle['showToPartner'] == "email" || $cycle['showToPartner'] == "both")) ? 'checked' : '') ?>>
            <label class="form-check-label" for="emailNotification">Send out email to Partners ?</label>
        </div>
        <a href="javascript:void(0)" class="nav-link p-0 m-0  text-primary" onclick="editCycleChangeEmail()" id="editEmail">Edit
            Email</a>

    </div>
    <div class="form-group d-flex justify-content-between">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox"
                   id="alertNotification" <?= (($cycle['notificationType'] == "notification" || $cycle['notificationType'] == "both") && (($cycle['showToPartner'] == "notification" || $cycle['showToPartner'] == "both")) ? 'checked' : '') ?>>
            <label class="form-check-label" for="alertNotification">Add Alert to Partners Dashboard ?</label>
        </div>
        <a href="javascript:void(0)" class="nav-link p-0 m-0 text-primary" onclick="editCycleChangeAlert()" id="editEmail">Edit
            Email</a>

    </div>


<?php endif; ?>