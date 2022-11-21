<div class="settings__field">
    <div class="settings__field-title"><?=$this->name?></div>
    <?if (!empty($this->hint)):?>
        <div class="settings__field-hint"><?=$this->hint?></div>
    <?endif?>

    <?include $this->typeTemplate?>
</div>