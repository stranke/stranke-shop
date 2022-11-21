<?global $APPLICATION;?>
<div class="settings__field-control">
    <div class="settings__field-control">
        <textarea type="text" name="PROP[<?=$this->id?>]"><?=$this->value?></textarea>
    </div>
    <?/*$APPLICATION->IncludeComponent(
        "bitrix:fileman.light_editor",
        "",
        Array(
            "CONTENT" => $this->value,
            "WIDTH" => "100%",
            "HEIGHT" => "150px",
            "ID" => "",
            "INPUT_ID" => "",
            "INPUT_NAME" => "PROP[" . $this->id . "][VALUE]",
            "JS_OBJ_NAME" => "",
            "RESIZABLE" => "N",
            "USE_FILE_DIALOGS" => "N",
            "VIDEO_ALLOW_VIDEO" => "Y",
            "VIDEO_BUFFER" => "20",
            "VIDEO_LOGO" => "",
            "VIDEO_MAX_HEIGHT" => "480",
            "VIDEO_MAX_WIDTH" => "640",
            "VIDEO_SKIN" => "/bitrix/components/bitrix/player/mediaplayer/skins/bitrix.swf",
            "VIDEO_WINDOWLESS" => "Y",
            "VIDEO_WMODE" => "transparent",
        )
    );*/?>
</div>