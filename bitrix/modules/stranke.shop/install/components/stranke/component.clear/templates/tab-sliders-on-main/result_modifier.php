<?

global $USER;
$arResult = [
    'POPULAR' => [],
    'NEW' => [],
];

//prepare popular
$res = CIBlockElement::GetList(
    ['SHOW_COUNTER' => 'DESC'],
    ['IBLOCK_CODE' => $arParams['IBLOCK_ID'], 'ACTIVE' => 'Y'],
    false,
    ['nTopCount' => 10],
    ['*', 'PROPERTY_SHILD_NEW', 'PROPERTY_BESTSELLER']
);
while ($arItem = $res->GetNext()) {
    if ($arItem['PREVIEW_PICTURE'] > 0) {
        $file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width' => 237, 'height' => 196), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    } else {
        $file = CFile::ResizeImageGet($arItem['DETAIL_PICTURE'], array('width' => 237, 'height' => 196), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    }


    $arPrice = CCatalogProduct::GetOptimalPrice($arItem['ID'], 1, $USER->GetUserGroupArray(), 'N');
    if ($arPrice)
        $arPrice['RESULT_PRICE']['PRINT_DISCOUNT_VALUE'] = CurrencyFormat($arPrice["RESULT_PRICE"]["DISCOUNT_PRICE"], $arPrice["RESULT_PRICE"]["CURRENCY"]);

    $arResult['POPULAR'][$arItem['ID']] = [
        'ID' => $arItem['ID'],
        'IBLOCK_ID' => $arItem['IBLOCK_ID'],
        'PREVIEW_PICTURE' => $arItem['PREVIEW_PICTURE'],
        'DETAIL_PICTURE' => $arItem['DETAIL_PICTURE'],
        'DATE_CREATE' => $arItem['DATE_CREATE'],
        'NAME' => $arItem['NAME'],
        'DETAIL_PAGE_URL' => $arItem['DETAIL_PAGE_URL'],
        'PICTURE' => $file,
        'SHOW_COUNTER' => $arItem['SHOW_COUNTER'],
        'PRICE' => $arPrice,
        'SHILD_NEW' => $arItem['PROPERTY_SHILD_NEW_VALUE'],
        'BESTSELLER' => $arItem['PROPERTY_BESTSELLER_VALUE'],
    ];
    if (CCatalogSKU::IsExistOffers($arItem['ID'], $arItem['IBLOCK_ID'])) {
        $arResult['POPULAR'][$arItem['ID']]['HAS_OFFERS'] = 'Y';
    }
}

//prepare new
$res = CIBlockElement::GetList(
    ['DATE_CREATE' => 'DESC'],
    ['IBLOCK_CODE' => $arParams['IBLOCK_ID'], 'ACTIVE' => 'Y'],
    false,
    ['nTopCount' => 10],
    ['*', 'PROPERTY_SHILD_NEW', 'PROPERTY_BESTSELLER']
);
while ($arItem = $res->GetNext()) {
    $arPrice = CCatalogProduct::GetOptimalPrice($arItem['ID'], 1, $USER->GetUserGroupArray(), 'N');
    if ($arPrice)
        $arPrice['RESULT_PRICE']['PRINT_DISCOUNT_VALUE'] = CurrencyFormat($arPrice["RESULT_PRICE"]["DISCOUNT_PRICE"], $arPrice["RESULT_PRICE"]["CURRENCY"]);
    $arResult['NEW'][$arItem['ID']] = [
        'ID' => $arItem['ID'],
        'IBLOCK_ID' => $arItem['IBLOCK_ID'],
        'PREVIEW_PICTURE' => $arItem['PREVIEW_PICTURE'],
        'DETAIL_PICTURE' => $arItem['DETAIL_PICTURE'],
        'DATE_CREATE' => $arItem['DATE_CREATE'],
        'NAME' => $arItem['NAME'],
        'DETAIL_PAGE_URL' => $arItem['DETAIL_PAGE_URL'],
        'SHOW_COUNTER' => $arItem['SHOW_COUNTER'],
        'PRICE' => $arPrice,
        'SHILD_NEW' => $arItem['PROPERTY_SHILD_NEW_VALUE'],
        'BESTSELLER' => $arItem['PROPERTY_BESTSELLER_VALUE'],
    ];
    if (CCatalogSKU::IsExistOffers($arItem['ID'], $arItem['IBLOCK_ID'])) {
        $arResult['NEW'][$arItem['ID']]['HAS_OFFERS'] = 'Y';
    }
}
?>
