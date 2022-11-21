<?php

$app = Stranke\Shop\App::getInstance();

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

$lat = 65.19732548124925;
$lon = 61.44784562698361;

[$lat,$lon] = explode(',', $GLOBALS["OPTIONS"]["STANDART_MAP"]["VALUE"]);

$mapData = [
    'yandex_lat' => $lat,
    'yandex_lon' => $lon,
    'yandex_scale' => 16,
    'PLACEMARKS' => [
        [
            'LAT' => $lat,
            'LON' => $lon,
            'TEXT' => "<span>" . $GLOBALS['JSON+LD']['ORG_NAME']['VALUE'] . "</span>",
        ]
    ]
];

$arResult['MAP_DATA'] = serialize($mapData);
