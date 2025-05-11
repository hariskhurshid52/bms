<h4 class="card-title">Select users from list</h4>
<div class="form-group">
    <select name="users[]" id="users" class="form-control select2" multiple  data-placeholder="Select users form list">
        <?php foreach ($users as $user): ?>
            <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
        <?php endforeach; ?>
    </select>
</div>