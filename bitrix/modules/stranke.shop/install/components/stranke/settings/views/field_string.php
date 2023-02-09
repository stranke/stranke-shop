<? if (!$this->isMultiple): ?>
    <? $social_img = array('Telegram', 'Whatsapp', 'Viber', 'Vkontakte', 'Facebook', 'Instagram', 'Youtube', 'AppStore', 'Google Play', 'AppGallery') ?>
    <? $social_img_pl = array('Telegram', 'Whatsapp', 'Viber') ?>

    <? if (in_array($this->name, $social_img)) { ?>
        <? if (in_array($this->name, $social_img_pl)) {
            $placeinputsoc = GetMessage('NUMBER_PHONE');
        } else {
            $placeinputsoc = GetMessage('TEXT_URL');
        } ?>
        <div class="settings__field-control" style="display: flex; gap: 6px;align-items: center">
            <? $nameclasssocial = str_replace(' ', '', $this->name); ?>
            <div class="board-info__social-link_<?= $nameclasssocial ?>"></div>
            <input type="text" name="PROP[<?= $this->id ?>]" value="<?= $this->value ?>"
                   placeholder="<?= $placeinputsoc ?>">
        </div>
    <? } else { ?>
        <div class="settings__field-control">
            <input type="text" name="PROP[<?= $this->id ?>]" value="<?= $this->value ?>">
        </div>
    <? } ?>
<? else: ?>
    <? foreach ($this->value as $v): ?>
        <div class="settings__field-control">
            <input type="text" name="PROP[<?= $this->id ?>][]" value="<?= $v ?>">
        </div>
    <? endforeach ?>

    <div class="settings__field-control">
        <input type="text" name="PROP[<?= $this->id ?>][]" value="">
    </div>

    <div class="settings__field-control">
        <div class="btn btn_primary js-addFieldControl"><?= GetMessage('ST_SETTINGS_ADD_FIELD_CONTROL') ?></div>
    </div>
<? endif ?>

