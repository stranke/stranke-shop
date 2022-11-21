<div class="settings__field">
    <?
    $value = '';
    if (!empty($PROP['GOOGLE_TAG_MANAGER']['VALUE'])) {
        $value = $PROP['GOOGLE_TAG_MANAGER']['VALUE']['TEXT'];
    }
    ?>
    <div  class="settings__field-title">Код google tag manager</div>

    <div class="settings__field-control">
        <textarea type="text" class="admin-settings__form-textarea" name="PROP[GOOGLE_TAG_MANAGER][VALUE]"><?=$value?></textarea>
    </div>
</div>