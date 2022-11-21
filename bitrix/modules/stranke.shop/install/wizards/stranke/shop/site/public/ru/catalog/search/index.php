<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Готовое решение для доставки еды на 1С Битрикс от интернет агенства Stranke!");
$APPLICATION->SetPageProperty("keywords", "готовый сайт, интернет магазин, Битрикс");
$APPLICATION->SetPageProperty("title", "Stranke.shop - Поиск по каталогу");
$APPLICATION->SetTitle("");

$dbResult = CIBlock::GetList([], ['code' => 'catalog_products_%']);
$IBLOCK_ID = 250; // Default
while ($arIblock = $dbResult->GetNext()) {
    $IBLOCK_ID = $arIblock['ID'];
}
?><?$APPLICATION->IncludeComponent(
    "bitrix:catalog.search",
    "",
    Array(
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => $IBLOCK_ID,
        "ACTION_VARIABLE" => "action",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "BASKET_URL" => "/personal/basket.php",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "N",
        "CONVERT_CURRENCY" => "N",
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_COMPARE" => "N",
        "DISPLAY_TOP_PAGER" => "N",
        "ELEMENT_SORT_FIELD" => "sort",
        "ELEMENT_SORT_FIELD2" => "id",
        "ELEMENT_SORT_ORDER" => "asc",
        "ELEMENT_SORT_ORDER2" => "desc",
        "HIDE_NOT_AVAILABLE" => "L",
        "HIDE_NOT_AVAILABLE_OFFERS" => "N",
        "LINE_ELEMENT_COUNT" => "3",
        "NO_WORD_LOGIC" => "N",
        "OFFERS_CART_PROPERTIES" => array(),
        "OFFERS_FIELD_CODE" => array("NAME",""),
        "OFFERS_LIMIT" => "5",
        "OFFERS_PROPERTY_CODE" => array("CML2_LINK",""),
        "OFFERS_SORT_FIELD" => "sort",
        "OFFERS_SORT_FIELD2" => "id",
        "OFFERS_SORT_ORDER" => "asc",
        "OFFERS_SORT_ORDER2" => "desc",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Товары",
        "PAGE_ELEMENT_COUNT" => "30",
        "PRICE_CODE" => array("BASE"),
        "PRICE_VAT_INCLUDE" => "Y",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRODUCT_PROPERTIES" => array(),
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
        "PROPERTY_CODE" => array("DISCOUNT",""),
        "RESTART" => "N",
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "SECTION_URL" => "",
        "SHOW_PRICE_COUNT" => "1",
        "USE_LANGUAGE_GUESS" => "Y",
        "USE_PRICE_COUNT" => "N",
        "USE_PRODUCT_QUANTITY" => "N",
        "USE_SEARCH_RESULT_ORDER" => "N",
        "USE_TITLE_RANK" => "N"
    )
);?><?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
