<?php if (empty($template)): ?>
    <div class="form-group">
        <div class="alert alert-fill-danger" role="alert">
            <i class="mdi mdi-alert-circle"></i>
            Oh snap! Sorry no template found.
        </div>
    </div>
<?php else: ?>
    <div class="form-group">
        <textarea class="form-control" id="<?=$template['type']?>Editor" name="editor" rows="15"><?= $template['html'] ?></textarea>
    </div>
    <div class="model-footer mt-4">
        <button id="updateTemplate" type="submit" class="btn btn-primary pull-right" onclick="updateTemplate('<?=$template['id']?>')" >Update Template</button>
    </div>
<?php endif; ?>