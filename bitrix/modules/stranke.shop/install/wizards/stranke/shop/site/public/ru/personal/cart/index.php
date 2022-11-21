<?

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Оформление заказа на нашем сайте.");
$APPLICATION->SetPageProperty("keywords", "Оформление заказа на нашем сайте.");
$APPLICATION->SetTitle("Корзина");
?>
<? global $USER; ?>
<? if (!$USER->IsAuthorized()): ?>
    <? $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "banner_on_main",
        Array(
            "AREA_FILE_SHOW" => "file",
            "AREA_FILE_SUFFIX" => "inc",
            "EDIT_TEMPLATE" => "",
            "PATH" => SITE_DIR . "include/modal-auth.php"
        )
    ); ?>
<? else: ?>
    <? $APPLICATION->IncludeComponent(
        "bitrix:sale.basket.basket",
        "shop",
        array(
            "ACTION_VARIABLE" => "basketAction",
            "ADDITIONAL_PICT_PROP_568" => "-",
            "ADDITIONAL_PICT_PROP_569" => "-",
            "AUTO_CALCULATION" => "Y",
            "BASKET_IMAGES_SCALING" => "adaptive",
            "COLUMNS_LIST_EXT" => array(
                0 => "PREVIEW_PICTURE",
                1 => "DISCOUNT",
                2 => "DELETE",
                3 => "DELAY",
                4 => "SUM",
            ),
            "COLUMNS_LIST_MOBILE" => array(
                0 => "PREVIEW_PICTURE",
                1 => "DISCOUNT",
                2 => "DELETE",
                3 => "DELAY",
                4 => "SUM",
            ),
            "COMPATIBLE_MODE" => "Y",
            "CORRECT_RATIO" => "Y",
            "DEFERRED_REFRESH" => "N",
            "DISCOUNT_PERCENT_POSITION" => "bottom-right",
            "DISPLAY_MODE" => "extended",
            "EMPTY_BASKET_HINT_PATH" => SITE_DIR . "",
            "GIFTS_BLOCK_TITLE" => "Выберите один из подарков",
            "GIFTS_CONVERT_CURRENCY" => "N",
            "GIFTS_HIDE_BLOCK_TITLE" => "N",
            "GIFTS_HIDE_NOT_AVAILABLE" => "N",
            "GIFTS_MESS_BTN_BUY" => "Выбрать",
            "GIFTS_MESS_BTN_DETAIL" => "Подробнее",
            "GIFTS_PAGE_ELEMENT_COUNT" => "4",
            "GIFTS_PLACE" => "BOTTOM",
            "GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
            "GIFTS_PRODUCT_QUANTITY_VARIABLE" => "quantity",
            "GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
            "GIFTS_SHOW_OLD_PRICE" => "N",
            "GIFTS_TEXT_LABEL_GIFT" => "Подарок",
            "HIDE_COUPON" => "N",
            "LABEL_PROP" => array(),
            "OFFERS_PROPS" => array(),
            "PATH_TO_ORDER" => SITE_DIR . "personal/order/make/",
            "PRICE_DISPLAY_MODE" => "N",
            "PRICE_VAT_SHOW_VALUE" => "N",
            "PRODUCT_BLOCKS_ORDER" => "props,sku,columns",
            "QUANTITY_FLOAT" => "N",
            "SET_TITLE" => "Y",
            "SHOW_DISCOUNT_PERCENT" => "Y",
            "SHOW_FILTER" => "N",
            "SHOW_RESTORE" => "N",
            "TEMPLATE_THEME" => "blue",
            "TOTAL_BLOCK_DISPLAY" => array(
                0 => "bottom",
            ),
            "USE_DYNAMIC_SCROLL" => "Y",
            "USE_ENHANCED_ECOMMERCE" => "Y",
            "USE_GIFTS" => "Y",
            "USE_PREPAYMENT" => "N",
            "USE_PRICE_ANIMATION" => "Y",
            "COMPONENT_TEMPLATE" => "shop",
            "DATA_LAYER_NAME" => "dataLayer",
            "BRAND_PROPERTY" => ""
        ),
        false
    ); ?>
<? endif; ?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
