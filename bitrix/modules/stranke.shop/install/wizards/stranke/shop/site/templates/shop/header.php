<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Page\Asset;
use \Stranke\Shop\App;

Loc::loadLanguageFile(__FILE__);


if (!Loader::includeModule('stranke.shop')) {
    echo Loc::getMessage('ST_HEADER_TEMPLATE_ERROR');
    die();
}


$url = $APPLICATION->GetCurPage(false);
global $app, $settings;

include 'options.php';


$asset = Asset::getInstance();
//$asset->addCss(SITE_TEMPLATE_PATH . "/styles/main.css?v=" . mktime());
$asset->addCss(SITE_TEMPLATE_PATH . "/styles/settings.css");
$asset->addCss(SITE_TEMPLATE_PATH . "/styles/lb.css?v=" . mktime());

CJSCore::Init(array("jquery2"));

$asset->addJs(SITE_TEMPLATE_PATH . "/js/input_phone.js");
$asset->addJs(SITE_TEMPLATE_PATH . "/js/choise_city.js");
$asset->addJs(SITE_TEMPLATE_PATH . "/js/actions.js");

if (!function_exists('showIcons')) {
    function showIcons()
    {
        $icons = $GLOBALS['ICONS'];
        foreach ($icons as $icon) {

            switch ($icon['type']) {
                case 'apple':
                    echo '<link rel="apple-touch-icon" sizes="' . $icon['size'] . '" href="' . $icon['src'] . '">';
                    break;
                case 'favicon':
                    echo '<link rel="icon" type="image/x-icon" href="' . $icon['src'] . '">';
                    break;
                case 'win8':
                    echo '<meta name="msapplication-TileColor" content="' . $icon['color'] . '">';
                    echo '<meta name="msapplication-TileImage" content="' . $icon['src'] . '">';
                    break;
            }

        }
    }
}
?>
<!doctype html>
<html class="no-js" lang="">
<head>
    <?
    if (!$USER->isAdmin()) {
        $settings->insertGtm();
    }
    ?>

    <meta charset="<?= LANG_CHARSET ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="theme-color" content="#333333">

    <title><? $APPLICATION->ShowTitle() ?></title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&display=swap&subset=cyrillic" rel="stylesheet">
    <? /*<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">*/ ?>
    <?
    showIcons();

    $APPLICATION->ShowHead();
    $app->opengraph->show();
    ?>


    <? include 'color.php' ?>
    <script type="text/javascript">
        BX.message({
            ST_ADDED: '<?=GetMessage('ST_JS_ADDED')?>',
        });
        window.strankeConfig = <?=$app->config->getJs()?>;
        window.SITE_DIR = '<?=SITE_DIR?>';
    </script>
</head>

<body class="page" itemscope="" itemtype="http://schema.org/WebPage">
<? $APPLICATION->ShowPanel() ?>
<header id="header" class="header">
    <div class="wrapper header_wrapper">
        <div class="header-mobile__left-block">
            <div class="header-mobile__menu-btn js-headerMobileMenuBtn">
                <svg width="20" height="17" viewBox="0 0 20 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <line x1="1.5" y1="1.5" x2="18.5" y2="1.5" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="1.5" y1="8.5" x2="18.5" y2="8.5" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="1.5" y1="15.5" x2="18.5" y2="15.5" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
        <div class="header__top-row">
            <? include 'includes/header/header_logo.php' ?>
            <div class="header-desctop-content">
                <div class="header_choise_city">
                    <? require 'includes/header/header_city.php' ?>
                </div>
                <div class="header__phones">
                    <? require 'includes/header/header_phone.php' ?>
                </div>
                <div class="header__menu-nav-bar" itemscope itemtype="http://www.schema.org/SiteNavigationElement">
                    <div class="main-nav-bar">
                        <?
                        $APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "main-menu",
                            array(
                                "ALLOW_MULTI_SELECT" => "N",
                                "CHILD_MENU_TYPE" => "",
                                "DELAY" => "N",
                                "MAX_LEVEL" => "1",
                                "MENU_CACHE_GET_VARS" => array(),
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_THEME" => "site",
                                "ROOT_MENU_TYPE" => "top",
                                "USE_EXT" => "Y",
                                "COMPONENT_TEMPLATE" => "main-menu",
                                "COMPOSITE_FRAME_MODE" => "A",
                                "COMPOSITE_FRAME_TYPE" => "AUTO"
                            ),
                            false
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="header__bottom-row">
            <div class="header-desctop-content">
                <div class="header-bottom-menu__header-catalog">
                    <div class="header-catalog">
                        <div class="header-catalog__btn bg_main btn js-headerCatalogMenuBtn">
                            <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 12H18V10H0V12ZM0 7H18V5H0V7ZM0 0V2H18V0H0Z" fill="white"/>
                            </svg>
                            <span><?= GetMessage('ST_CATALOG_BTN') ?></span>
                            <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.25 0L3.538 2.712L0.825 0L0 0.825L3.538 4.363L7.076 0.825L6.25 0Z" fill="white"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="header__search central-block__search">
                    <?php
                    $APPLICATION->IncludeComponent(
                        "stranke:search.title",
                        'simple',
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
                            "INPUT_ID" => "title-search-input",
                            "CONTAINER_ID" => "title-search",
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
            <div class="header__user-order" role="header_cart">
                <? require 'includes/header/header_cart.php' ?>
            </div>
        </div>
    </div>
    <? require 'includes/header/header_catalog.php' ?>
    <div class="header-mobile__menu js-headerMobileMenu">

        <div class="header-mobile-menu">
            <div class="header-mobile-menu__close-btn js-headerCatalogMenuCloseBtn"></div>
            <div class="header-mobile-menu__submenu-container header-mobile-menu__submenu-container_main" data-name="mobile-main-menu">
                <div class="js-headerMobileMenuContent header-mobile-container"></div>
            </div>
        </div>
    </div>
</header>

<main class="main">
    <? if (($APPLICATION->GetCurPage(false) !== "/") && (!defined("ERROR_404")) && (strpos($APPLICATION->GetCurPage(false), 'personal') == '')): ?>
        <?
        $APPLICATION->IncludeComponent(
            "bitrix:breadcrumb",
            "",
            array(
                "COMPOSITE_FRAME_MODE" => "A",
                "COMPOSITE_FRAME_TYPE" => "AUTO",
                "PATH" => "",
                "SITE_ID" => "s1",
                "START_FROM" => "0",
            ),
            false
        );
        ?>
    <? endif ?>
