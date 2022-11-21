<? $arSetting = array(
    'type' => array(
        'NAME' => GetMessage('ST_FIELD_SMS_AUTH_TYPE'),
        'TYPE' => 'select',
        'VALUES' => array(
            'smsru' => 'sms.ru',
//                    'mango' => 'Mango',
        )
    ),
    'SMSRU' => array(
        'NAME' => 'sms.ru',
        'TYPE' => 'row',
    ),
    'SMSRU_API_KEY' => array(
        'NAME' => 'Api_id',
        'TYPE' => 'API_KEY',
    ),
    /*'SMSRU_AUTH_CALL' => array(
        'NAME' => 'Вход через звонок',
        'TYPE' => 'row',
        'DESCR' => 'На указанный номер телефона покупателя поступит входящий звонок, последние 4 цифры которого будут являться кодом для входа',
    ),
    'SMSRU_AUTH_SMS' => array(
        'NAME' => 'Вход через sms',
        'TYPE' => 'row',
        'DESCR' => 'На указанный номер телефона покупателя поступит SMS с кодом для входа',
    ),*/
);

$setting = json_decode($this->__component->fields['sms_auth']['~VALUE'], true);
$setting = is_array($setting) ? $setting : array();
?>
<? foreach ($arSetting as $key => $val): ?>
    <? $section = explode('_', $key)[0] ?>
    <? $section = strtoupper($section) === $section ? strtolower($section) : false; ?>
    <? if ($val['TYPE'] == 'row') : ?>
        <div class="settings__field" <?= $section ? (' field_section="' . $section . '"') : '' ?>>
            <div class="settings__field-title"><?= $val['NAME'] ?></div>
        </div>
        <? continue; ?>
    <? endif; ?>
    <div class="settings__field" <?= $section ? (' field_section="' . $section . '"') : '' ?>>
        <div class="settings__field-title">
            <?= $val['NAME'] ?>
        </div>
        <div class="settings__field-control">
            <?
            switch ($val['TYPE']) {
                case 'checkbox':
                    ?>
                    <input type='checkbox' value='Y' name="PROP[sms_auth][<? echo $key ?>]"<? echo $setting[$key] ? ' checked' : '' ?>/>
                    <?
                    break;
                case 'select':
                    ?>
                    <select class='form-control' name="PROP[sms_auth][<? echo $key ?>]">
                        <?
                        $k = '';
                        $v = GetMessage('ST_FIELD_SELECT_NO_CHOISE');
                        ?>
                        <option value='<?= $k ?>'<?= $k == $setting[$key] ? ' selected' : '' ?>><?= $v ?></option>
                        <? foreach ($val['VALUES'] as $k => $v): ?>
                            <option value='<?= $k ?>'<?= $k == $setting[$key] ? ' selected' : '' ?>><?= $v ?></option>
                        <? endforeach; ?>
                    </select>
                    <?
                    break;
                default:
                    ?>
                    <input class='form-control' type='text' value='<? echo htmlspecialchars($setting[$key]) ?>' name="PROP[sms_auth][<? echo $key ?>]"/>
                <?
            }
            ?>
        </div>
    </div>
<? endforeach; ?>
<script>
    $(document).on('change', '[name="PROP[sms_auth][type]"]', function (e) {
        show_field_section()
    })

    function show_field_section() {
        var val = $('[name="PROP[sms_auth][type]"]').val();
        $('[field_section]').css({'display': 'none'})
        $('[field_section="' + val + '"]').removeAttr('style')
    }

    show_field_section();
</script>
