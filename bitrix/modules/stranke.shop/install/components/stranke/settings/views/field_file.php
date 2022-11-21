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
        <input type="file" name="<?=$this->id?>">
    </div>
</div>