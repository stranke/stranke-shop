<?php
$arResult['SOCIAL_LINKS'] = [];
if ($app->config->telegram) {
    $arResult['SOCIAL_LINKS']['telegram'] = $app->config->telegram;
}
if ($app->config->whatsapp) {
    $arResult['SOCIAL_LINKS']['whatsapp'] = $app->config->whatsapp;
}
if ($app->config->viber) {
    $arResult['SOCIAL_LINKS']['viber'] = $app->config->viber;
}
if ($app->config->vk) {
    $arResult['SOCIAL_LINKS']['vk'] = $app->config->vk;
}
if ($app->config->fb) {
    $arResult['SOCIAL_LINKS']['fb'] = $app->config->fb;
}
if ($app->config->insta) {
    $arResult['SOCIAL_LINKS']['insta'] = $app->config->insta;
}
if ($app->config->youtube) {
    $arResult['SOCIAL_LINKS']['youtube'] = $app->config->youtube;
}
if ($app->config->ya_dzen) {
    $arResult['SOCIAL_LINKS']['ya_dzen'] = $app->config->ya_dzen;
}

?>
<div class="footer_social footer_content_item">
    <? if (!empty($arResult['SOCIAL_LINKS'])): ?>
        <div class="footer_item_header"><?= GetMessage('ST_FOOTER_SOCIAL') ?></div>
        <div class="board-info__social-links">
            <? foreach ($arResult['SOCIAL_LINKS'] as $name => $value): ?>
                <a class="board-info__social-link board-info__social-link_<?= $name ?>"
                   href="<?= $value ?>"
                   target="_blank"
                ><?= $settings->social_icons[$name] ?></a>
            <? endforeach ?>
        </div>
    <? endif ?>
</div>
