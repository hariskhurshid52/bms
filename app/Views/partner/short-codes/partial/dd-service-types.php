<select name="serviceType" id="serviceType"
        class="form-select select2"
        data-placeholder="Select Service Type">
    <option></option>
    <?php foreach ($servicesTypes as $k => $serviceType): ?>
        <option value="<?= $serviceType['id'] ?>"><?= $serviceType['name'] ?></option>
    <?php endforeach; ?>
</select>