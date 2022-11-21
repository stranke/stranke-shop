<?php

$arCards = array();
$parentCode = false;

$item_parent = false;
foreach ($arResult as $key => $item) {

    if ($item["DEPTH_LEVEL"] == 1) {

        if ($item["IS_PARENT"]) {
            $parentCode = $key + 3000;
            $item["PARENT_CODE"] = $parentCode;
            $item_parent = $item;
        }
        $arCards[0][] = $item;

    }

    if ((!isset($arResult[$key + 1]) || $arResult[$key + 1]["DEPTH_LEVEL"] < $item["DEPTH_LEVEL"]) && $item["DEPTH_LEVEL"] == 3) {
        $item['DOWN_LEVEL'] = 'Y';
    }
    if ((isset($arResult[$key + 1]) && $arResult[$key + 1]["DEPTH_LEVEL"] > $item["DEPTH_LEVEL"]) && $item["DEPTH_LEVEL"] == 2) {
        $item['UP_LEVEL'] = 'Y';
    }
    if ($item["DEPTH_LEVEL"] == 2 || $item["DEPTH_LEVEL"] == 3) {
        $item['PARENT'] = $item_parent;
        $item['PARENT_TEXT'] = $item_parent['TEXT'];
        $arCards[$parentCode][] = $item;
    }

}

$arResult['MAIN'] = $arCards[0];
unset($arCards[0]);

$arResult['CARDS'] = $arCards;
