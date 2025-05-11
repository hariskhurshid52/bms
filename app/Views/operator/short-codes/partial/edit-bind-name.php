<div class="form-group">
    <label class="form-label" for="bindName">Bind Name</label>
    <input type="text" class="form-control" name="bindName" id="bindName" value="<?= isset($bindName['name']) ? $bindName['name'] :'' ?>">
</div>
<input type="hidden" name="bindId" id="bindId" value="<?= isset($bindName['id']) ? $bindName['id'] :'' ?>">     
