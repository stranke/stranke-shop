<?if($this->code == 'LOGO'){?>
<div class="settings__field-control">
    <div class="settings__field-img">
        <canvas width="130" height="80"></canvas>
        <?if (!empty($this->value['SRC'])):?>
            <img src="<?=$this->value['SRC']?>" alt="">
        <?else:?>
            <i class="far fa-file-image"></i>
        <?endif?>
    </div>


    <div class="settings__field-file">
        <div class="settings__field-file_delete" onclick="delLOGO('<?=$this->id?>')">
            <?= GetMessage('DELETE_FILE') ?>
        </div>
        <input type="file" id="input__file" name="<?=$this->id?>">
        <label for="input__file"><?= GetMessage('LOAD_FILE') ?></label>
    </div>

</div>
<?} else {?>
    <div class="settings__field-control">
        <div class="settings__field-img">
            <canvas width="130" height="80"></canvas>
            <?if (!empty($this->value['SRC'])):?>
                <img src="<?=$this->value['SRC']?>" alt="">
            <?else:?>
                <i class="far fa-file-image"></i>
            <?endif?>
        </div>
        <div class="settings__field-file">
            <input type="file" id="input__file" name="<?=$this->id?>">
            <label for="input__file"><?= GetMessage('LOAD_FILE') ?></label>
        </div>
    </div>
<?}?>
