<?

use Bitrix\Main\Web\Json;


$arOffers_json = array();
$no_key = array('DISPLAY_PROPERTIES');
foreach ($arOffers as $i => $arOffer) {
    foreach ($arOffer as $key => $val) {
        if (in_array($key, $no_key) || (strpos($key, 'ITEM_') === 0 && is_array($val))) {
            continue;
        }
//        if (!empty($val) && $val !== false)
        $arOffers_json[$i][$key] = $val;
    }
} ?>
<div class="product__offers" itemprop="offers" itemscope itemtype="http://schema.org/AggregateOffer">
    <div class="custom_select with_kwazi_select">
        <select name="product__offer_<? echo $arItem['ID'] ?>" role="product__offer-radio">
            <? foreach ($arOffers as $i => $arOffer): ?>
                <?
                $classProductOffer = '';
                $isAvailable = ($arOffer['CATALOG_AVAILABLE'] === 'Y' && $arOffer['CATALOG_QUANTITY'] > 0) || $arOffer['PRODUCT']['CAN_BUY_ZERO'] == 'Y';
                if (!$isAvailable) {
                    $classProductOffer .= ' disable';
                }
                ?>
                <option value="<?= $arOffer['ID'] ?>" <?= $classProductOffer ?>><?= $arOffer['~NAME'] ?></option>
            <? endforeach ?>
        </select>
        <kwazi_select name="product__offer_<? echo $arItem['ID'] ?>" no_select="Y">
            <items_title>
                <val>

                    <? foreach ($arOffers as $i => $arOffer): ?>
                        <? if ($arItem['OFFER_ID'] == $arOffer['ID']): ?>
                            <input type="radio" name="product__offer_<? echo $arItem['ID'] ?>" value="<? echo $arOffer['ID'] ?>">
                            <label>
                                <? echo $arOffer['NAME'] ?>
                            </label>
                        <? endif; ?>
                    <? endforeach ?>
                </val>
            </items_title>
            <items>
                <? foreach ($arOffers as $i => $arOffer): ?>
                    <kwazi_option value="<? echo $arOffer['ID'] ?>"<? echo $arItem['OFFER_ID'] == $arOffer['ID'] ? ' selected' : '' ?>>
                        <input type="radio" name="product__offer_<? echo $arItem['ID'] ?>" value="<? echo $arOffer['ID'] ?>" id="select_offer_<? echo $arOffer['ID'] ?>">
                        <label for="select_offer_<? echo $arOffer['ID'] ?>">
                            <? echo $arOffer['NAME'] ?>
                        </label>
                    </kwazi_option>
                <? endforeach ?>
            </items>
        </kwazi_select>
        <svg width="10" height="7" viewBox="0 0 10 7" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.83267 -1.54435e-06L5 3.83267L1.16591 -2.03855e-07L2.03855e-07 1.16591L5 6.16591L10 1.16591L8.83267 -1.54435e-06Z" fill="#5E5E5E"/>
        </svg>
    </div>
</div>
<?

if ($arItem['OFFER_INDX'] !== false) {
    $arOffer = $arOffers[$arItem['OFFER_INDX']];
}
?>
