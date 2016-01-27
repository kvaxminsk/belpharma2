<div class="input-group input-group">
    <input type="text" class="form-control" name="ProductsSearch[<?= $attribute ?>]" placeholder="" value="<?= isset($model) ? $model->getAttribute($attribute) : '' ?> ">
    <span class="input-group-addon" style="padding: 0px 1px;">
        <span class="glyphicon glyphicon-remove-circle clear-input"></span>
    </span>
</div>
