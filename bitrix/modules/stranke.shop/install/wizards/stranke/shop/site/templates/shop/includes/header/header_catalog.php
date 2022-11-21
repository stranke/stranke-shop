<? use \Stranke\Base\Url; ?>
<div class="header__header-catalog">
    <div class="header-catalog">
        <div class="header-catalog__menu js-headerCatalogMenu">
            <div class="header-mobile-menu">
                <div class="header-catalog-menu">
                    <div class="header-mobile-menu__title">
                        <? require 'header_logo.php' ?>
                        <div class="header_choise_city">
                            <? require 'header_city.php' ?>
                        </div>
                    </div>
                    <div class="header-mobile-menu__phone">
                        <? require 'header_phone.php' ?>
                    </div>
                    <div class="header-mobile-menu__submenu-container header-mobile-menu__submenu-container_main" data-name="mobile-main-menu">
                        <?php
                        $APPLICATION->IncludeComponent(
                            "bitrix:menu", "main_menu_mobile", array(
                            "NO_SHOW_SUB" => "Y",
                            "ROOT_MENU_TYPE" => "catalog",
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
                </div>
                <div class="header-catalog__right_data">
                    <div class="header-mobile-menu__close-btn js-headerCatalogMenuCloseBtn"></div>
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
                                "INPUT_ID" => "catalog-title-search-input",
                                "CONTAINER_ID" => "catalog-title-search",
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
                    <?php
                    $APPLICATION->IncludeComponent(
                        "bitrix:menu", "main_menu_mobile", array(
                        "NO_SHOW_LIST" => "Y",
                        "ROOT_MENU_TYPE" => "catalog",
                        "MENU_CACHE_TYPE" => "N",
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
            </div>
        </div>
    </div>
</div>
