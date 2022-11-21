<?
IncludeTemplateLangFile(__FILE__);

$arProps = array(
    'SHILD_NEW',
    'BESTSELLER',
);
$shilds = [];
foreach ($arProps as $key) {
    $arProp = $arItem['PROPERTIES'][$key];
    if ($arProp['VALUE'] || $arItem[$key])
        $shilds[$key] = GetMessage('ST_PRODUCT_DETAIL_MARK_' . $key);

}

if ($arItem['OFFERS']) {
    foreach ($arItem['OFFERS'] as $arOffer) {
        if (!empty($arOffer['MIN_PRICE']) && ($arOffer['MIN_PRICE']['DISCOUNT_DIFF'])) {
            $shilds['DISCOUNT'] = GetMessage('ST_PRODUCT_DETAIL_MARK_DISCOUNT');
            break;
        }
    }
} else {
    $arOffer = $arItem;
    if (!empty($arOffer['MIN_PRICE']) && ($arOffer['MIN_PRICE']['DISCOUNT_DIFF']) || $arOffer['PRICE'] && $arOffer['PRICE']['DISCOUNT_PRICE'] < $arOffer['PRICE']['PRICE']['PRICE']) {
        $shilds['DISCOUNT'] = GetMessage('ST_PRODUCT_DETAIL_MARK_DISCOUNT');
    }
}
?>
<? if (count($shilds)): ?>
    <div class="product-shilds">
        <? foreach ($shilds as $key => $text) { ?>
            <div class="product-shild" <?= $key ?>><?= $text ?></div>
        <? } ?>
    </div>
<? endif; ?>
