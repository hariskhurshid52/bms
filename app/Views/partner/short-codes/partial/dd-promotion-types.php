<select name="promotionType" id="promotionType"
        class="form-select select2"
        data-placeholder="Select Promotion Type">
    <option></option>
    <?php foreach ($initiations as $k => $value): ?>
        <option
                value="<?= $value['initiationId'] ?>"><?= $value['initiationName'] ?></option>
    <?php endforeach; ?>
</select>