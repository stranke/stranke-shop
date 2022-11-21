<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "В готовом решении Stranke.shop на 1С Битрикс мы переработали визуальную составляющую персонального раздела. Надеемся Вам понравится)");
$APPLICATION->SetPageProperty("keywords", "страница личного кабинета");
$APPLICATION->SetPageProperty("title", "Stranke.shop - Персональный раздел");
$APPLICATION->SetTitle("Stranke.shop - Персональный раздел");
?>
<div class="page-container">
    <?$APPLICATION->IncludeComponent(
        "bitrix:sale.personal.section",
        "",
        array(
            "ACCOUNT_PAYMENT_ELIMINATED_PAY_SYSTEMS" => array(
                0 => "0",
            ),
            "ACCOUNT_PAYMENT_PERSON_TYPE" => "1",
            "ACCOUNT_PAYMENT_SELL_CURRENCY" => "RUB",
            "ACCOUNT_PAYMENT_SELL_SHOW_FIXED_VALUES" => "Y",
            "ACCOUNT_PAYMENT_SELL_TOTAL" => array(
              0 => "100",
              1 => "200",
              2 => "500",
              3 => "1000",
              4 => "5000",
              5 => "",
            ),
            "ACCOUNT_PAYMENT_SELL_USER_INPUT" => "Y",
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "ALLOW_INNER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "3600",
            "CACHE_TYPE" => "A",
            "CHECK_RIGHTS_PRIVATE" => "N",
            "COMPATIBLE_LOCATION_MODE_PROFILE" => "N",
            "COMPOSITE_FRAME_MODE" => "A",
            "COMPOSITE_FRAME_TYPE" => "AUTO",
            "CUSTOM_PAGES" => "",
            "CUSTOM_SELECT_PROPS" => array(
            ),
            "MAIN_CHAIN_NAME" => "",
            "NAV_TEMPLATE" => "",
            "ONLY_INNER_FULL" => "N",
            "ORDERS_PER_PAGE" => "20",
            "ORDER_DEFAULT_SORT" => "STATUS",
            "ORDER_HIDE_USER_INFO" => array(
              0 => "0",
            ),
            "ORDER_HISTORIC_STATUSES" => array(
              0 => "N",
              1 => "F",
            ),
            "ORDER_REFRESH_PRICES" => "N",
            "ORDER_RESTRICT_CHANGE_PAYSYSTEM" => array(
              0 => "0",
            ),
            "PATH_TO_BASKET" => SITE_DIR . "personal/cart/",
            "PATH_TO_CATALOG" => SITE_DIR . "catalog/",
            "PATH_TO_CONTACT" => SITE_DIR . "about/contacts/",
            "PATH_TO_PAYMENT" => SITE_DIR . "personal/order/payment/",
            "PROFILES_PER_PAGE" => "20",
            "PROP_1" => "",
            "PROP_2" => "",
            "PROP_3" => "",
            "SAVE_IN_SESSION" => "Y",
            "SEF_MODE" => "Y",
            "SEND_INFO_PRIVATE" => "N",
            "SET_TITLE" => "Y",
            "SHOW_ACCOUNT_COMPONENT" => "Y",
            "SHOW_ACCOUNT_PAGE" => "N",
            "SHOW_ACCOUNT_PAY_COMPONENT" => "Y",
            "SHOW_BASKET_PAGE" => "N",
            "SHOW_CONTACT_PAGE" => "N",
            "SHOW_ORDER_PAGE" => "Y",
            "SHOW_PRIVATE_PAGE" => "Y",
            "SHOW_PROFILE_PAGE" => "N",
            "SHOW_SUBSCRIBE_PAGE" => "N",
            "USE_AJAX_LOCATIONS_PROFILE" => "N",
            "COMPONENT_TEMPLATE" => "",
            "SEF_FOLDER" => SITE_DIR . "personal/",
            "SEF_URL_TEMPLATES" => array(
              "index" => "index/",
              "orders" => "orders/",
              "account" => "account/",
              "subscribe" => "subscribe/",
              "profile" => "profile/",
              "profile_detail" => "profiles/#ID#/",
              "private" => "private/",
              "order_detail" => "orders/#ID#/",
              "order_cancel" => "cancel/#ID#/",
            )
        ),
        false
    );?>
</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
