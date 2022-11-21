<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>
<? global $USER ?>
<div class="header-mobile-menu__logo">
    <? include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/includes/header/header_logo.php' ?>
</div>
<div class="header_choise_city">
    <? require $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/includes/header/header_city.php' ?>
</div>
<div class="wrapper">
    <div class="central-block__search">
        <?php
        $APPLICATION->IncludeComponent(
            "stranke:search.title",
            "simple",
            array(
                "NUM_CATEGORIES" => "1",
                "TOP_COUNT" => "5",
                "ORDER" => "rank",
                "USE_LANGUAGE_GUESS" => "Y",
                "CHECK_DATES" => "Y",
                "SHOW_OTHERS" => "N",
                "PAGE" => "/catalog/search/",
                "CATEGORY_0" => array(
                    0 => "iblock_catalog",
                ),
                "SHOW_INPUT" => "Y",
                "INPUT_ID" => "mobile-title-search-input",
                "CONTAINER_ID" => "mobile-title-search",
                "PRICE_CODE" => array(
                    0 => "BASE",
                ),
                "PRICE_VAT_INCLUDE" => "Y",
                "PREVIEW_TRUNCATE_LEN" => "150",
                "SHOW_PREVIEW" => "Y",
                "PREVIEW_WIDTH" => "75",
                "PREVIEW_HEIGHT" => "75",
                "CONVERT_CURRENCY" => "Y",
                "CURRENCY_ID" => "RUB",
                "COMPONENT_TEMPLATE" => "",
                "CATEGORY_0_iblock_catalog" => array(
                    0 => "all",
                ),
                "COMPOSITE_FRAME_MODE" => "A",
                "COMPOSITE_FRAME_TYPE" => "AUTO",
                "CATEGORY_OTHERS_TITLE" => ""
            ),
            false
        );
        ?>
    </div>
</div>
<div class="header-mobile-menu-main header-mobile-menu__item-list">
    <a href="<?= SITE_DIR ?>catalog/" class="header-mobile-menu__item has_icon">
        Каталоги
    </a>
</div>
<?php
$APPLICATION->IncludeComponent(
    "bitrix:menu", "main_menu_mobile", array(
    "ROOT_MENU_TYPE" => "catalog",
    "MENU_CACHE_TYPE" => "A",
    "MENU_CACHE_TIME" => "36000",
    "MENU_CACHE_USE_GROUPS" => "Y",
    "MENU_CACHE_GET_VARS" => array(),
    "MAX_LEVEL" => "2",
    "CHILD_MENU_TYPE" => "left_menu_2018",
    "USE_EXT" => "Y",
    "DELAY" => "N",
    "ALLOW_MULTI_SELECT" => "N",
    "COMPONENT_TEMPLATE" => "main_menu_mobile",
    "COMPOSITE_FRAME_MODE" => "N",
    "COMPOSITE_FRAME_TYPE" => "AUTO",
    "MENU_THEME" => "site"
), false
);
?>
<div class="header-mobile-menu-main">
    <?php
    $APPLICATION->IncludeComponent(
        "bitrix:menu", "main_menu_mobile", array(
        "ROOT_MENU_TYPE" => "top",
        "MENU_CACHE_TYPE" => "A",
        "MENU_CACHE_TIME" => "36000",
        "MENU_CACHE_USE_GROUPS" => "Y",
        "MENU_CACHE_GET_VARS" => array(),
        "MAX_LEVEL" => "2",
        "CHILD_MENU_TYPE" => "",
        "USE_EXT" => "Y",
        "DELAY" => "N",
        "ALLOW_MULTI_SELECT" => "N",
        "COMPONENT_TEMPLATE" => "main_menu_mobile",
        "COMPOSITE_FRAME_MODE" => "N",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "MENU_THEME" => "site"
    ), false
    );
    ?>
</div>
<div class="header-mobile-container-flex"></div>
<div class="header-mobile-menu__phone">
    <? require $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/includes/header/header_phone.php' ?>
</div>
<div class="header-mobile-menu__other_data">
    <? require $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/includes/footer/social_links.php' ?>
</div>
