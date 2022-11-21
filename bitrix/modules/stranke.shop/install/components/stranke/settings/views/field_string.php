<?if (!$this->isMultiple):?>
    <div class="settings__field-control">
        <input type="text" name="PROP[<?=$this->id?>]" value="<?=$this->value?>">
    </div>
<?else:?>
    <?foreach ($this->value as $v):?>
        <div class="settings__field-control">
            <input type="text" name="PROP[<?=$this->id?>][]" value="<?=$v?>">
        </div>
    <?endforeach?>

    <div class="settings__field-control">
        <input type="text" name="PROP[<?=$this->id?>][]" value="">
    </div>

    <div class="settings__field-control">
        <div class="btn btn_primary js-addFieldControl"><?=GetMessage('ST_SETTINGS_ADD_FIELD_CONTROL')?></div>
    </div>
<?endif?>