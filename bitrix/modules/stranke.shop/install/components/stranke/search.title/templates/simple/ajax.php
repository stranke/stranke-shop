<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if (!empty($arResult["CATEGORIES"]) && CModule::includeModule("sale")): ?>
    <div class="central-block-search__found-items-list">
        <div class="found-items-list">
            <? global $USER; ?>
            <? foreach ($arResult["CATEGORIES"] as $category_id => $arCategory): ?>
                <? foreach ($arCategory["ITEMS"] as $i => $arItem): ?>
                    <? if ($category_id === "all"): ?>
                        <a class="found-items-list__all-found-items-btn"
                           href="<?php echo $arItem["URL"] ?>"><?php echo $arItem["NAME"] ?>
                        </a>
                    <? elseif (isset($arResult["ELEMENTS"][$arItem["ITEM_ID"]])):
                        $arElement = $arResult["ELEMENTS"][$arItem["ITEM_ID"]];
                        ?>
                        <div class="found-items-list__item"
                             onclick="document.location.href = '<? echo $arItem["URL"] ?>'">

                            <div class="found-items-list__item-photo">
                                <canvas width="80" height="66"></canvas>
                                <? if (is_array($arElement["PICTURE"])): ?>
                                    <img align="left" src="<? echo $arElement["PICTURE"]["src"] ?>"/>
                                <? endif; ?>
                            </div>
                            <div class="found-items-list__item-info">
                                <div class="found-items-list__item-text">
                                    <? echo $arItem["NAME"] ?>
                                </div>

                                <div class="found-items-list__item-price">
                                    <?
                                    $ITEM_ID = $arElement['ID'];
                                    $QUANTITY = 1;
                                    if (CCatalogSKU::IsExistOffers($ITEM_ID)) {
                                        $arInfo = $arInfo ? $arInfo : CCatalogSKU::GetInfoByProductIBlock($arElement['IBLOCK_ID']);

                                        $res = CIBlockElement::GetList(array(), array('IBLOCK_ID' => $arInfo['IBLOCK_ID'], 'ACTIVE' => 'Y', 'PROPERTY_' . $arInfo['SKU_PROPERTY_ID'] => $ITEM_ID));
                                        $price = 0;
                                        while ($arOrrer = $res->GetNext()) {
                                            if ($arOrrer['ACTIVE'] == 'Y') {
                                                $arPrice = CCatalogProduct::GetOptimalPrice($arOrrer['ID'], $QUANTITY, $USER->GetUserGroupArray(), 'N');
                                                $arAnswer = array("PRICE" => $arPrice["RESULT_PRICE"]["BASE_PRICE"], "DISCOUNT" => $arPrice["RESULT_PRICE"]["DISCOUNT"]);
                                            }

                                            ?>

                                            <?
                                            if (is_array($arElement["PRICES"])):
                                                foreach ($arElement["PRICES"] as $code => $arPrice):
                                                    if ($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):
                                                        if ($price > 0) {
                                                            if ($arPrice["DISCOUNT_VALUE"] < $price) {
                                                                $price = $arPrice["PRINT_DISCOUNT_VALUE"];
                                                            }
                                                        } else {
                                                            $price = $arPrice["PRINT_DISCOUNT_VALUE"];
                                                        }
                                                    else:
                                                        if ($price > 0) {
                                                            if ($arPrice["PRINT_VALUE"] < $price) {
                                                                $price = $arPrice["PRINT_VALUE"];
                                                            }
                                                        } else {
                                                            $price = $arPrice["PRINT_VALUE"];
                                                        }
                                                    endif;
                                                endforeach;
                                            else:
                                                if ($price > 0) {
                                                    if ($arAnswer["PRICE"] < $price) {
                                                        $price = $arAnswer["PRICE"];
                                                    }
                                                } else {
                                                    $price = $arAnswer["PRICE"];
                                                }
                                            endif;
                                        }
                                        ?>

                                        <? //TODO: price "ot"?>
                                        <? echo GetMessage('CT_PRODUCT_PRICE_FROM').' '.FormatCurrency(round($price), "RUB") ?>
                                        <?
                                    } else {
                                        $arPrice = CCatalogProduct::GetOptimalPrice($ITEM_ID, $QUANTITY, $USER->GetUserGroupArray(), 'N');
                                        if (!$arPrice || count($arPrice) <= 0) {
                                            if ($nearestQuantity = CCatalogProduct::GetNearestQuantityPrice($ITEM_ID, $QUANTITY, $USER->GetUserGroupArray())) {
                                                $QUANTITY = $nearestQuantity;
                                                $arPrice = CCatalogProduct::GetOptimalPrice($ITEM_ID, $QUANTITY, $USER->GetUserGroupArray(), 'N');
                                            }
                                        }
                                        $arAnswer = array("PRICE" => $arPrice["RESULT_PRICE"]["BASE_PRICE"], "DISCOUNT" => $arPrice["RESULT_PRICE"]["DISCOUNT"]);
                                        $arElement["PRICES"] = FormatCurrency(round($arAnswer["PRICE"]), "RUB");
                                        ?>
                                        <? if (is_array($arElement["PRICES"])): ?>
                                            <? foreach ($arElement["PRICES"] as $code => $arPrice): ?>
                                                <? if ($arPrice["CAN_ACCESS"]): ?>
                                                    <p class="title-search-price">
                                                        <? echo $arResult["PRICES"][$code]["TITLE"]; ?>:&nbsp;&nbsp;
                                                        <? if ($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]): ?>
                                                            <small><? echo $arPrice["PRINT_VALUE"] ?></small>
                                                            <span class="catalog-price"><? echo $arPrice["PRINT_DISCOUNT_VALUE"] ?></span>
                                                        <? else: ?>
                                                            <span class="catalog-price"><? echo $arPrice["PRINT_VALUE"] ?></span>
                                                        <? endif; ?>
                                                    </p>
                                                <? endif; ?>
                                            <? endforeach; ?>
                                        <? else: ?>
                                            <? //TODO: price "ot"?>
                                            <? echo str_replace('Р', 'р.', $arElement["PRICES"]) ?>
                                        <? endif; ?>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                    <? endif; ?>
                <? endforeach; ?>
            <? endforeach; ?>
        </div>
    </div>
<? endif; ?>
