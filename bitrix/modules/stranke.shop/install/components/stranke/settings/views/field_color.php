<div class="settings__field-control">
    <input type="hidden" name="PROP[<?=$this->code?>]" value="<?=$this->value?>">

    <div class="pickr pickr_preset">
        <?foreach ($this->colors as $color): ?>
            <?
            $className = 'pcr-button';
            if ($this->value === $color) {
                $className .= ' pcr-button_active';
            }
            ?>
            <button class="<?=$className?>"
                    style="color: <?=$color?>;"
                    type="button"></button>
        <?endforeach?>
    </div>

    <div class="color-picker ccc" data-default="<?=$this->value?>"></div>
</div>
