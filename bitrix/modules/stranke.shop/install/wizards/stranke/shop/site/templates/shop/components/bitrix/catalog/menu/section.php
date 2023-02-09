<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */

/** @var CBitrixComponent $component */

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;


$this->setFrameMode(true);
$this->addExternalCss($templateFolder . '/css/catalog-section.css');
$this->addExternalCss($templateFolder . '/css/products-settings.css');
$app = \Stranke\Shop\App::getInstance();
?>
<div class="wrapper catalog-section">
    <div class="catalog-section__main">
        <? $APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "main",
            Array(
                "ADD_SECTIONS_CHAIN" => "N",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "3600",
                "CACHE_TYPE" => "A",
                "COMPONENT_TEMPLATE" => ".default",
                "COUNT_ELEMENTS" => "Y",
                "IBLOCK_ID" => $app->config->iblockIdCatalog,
                "IBLOCK_TYPE" => "catalog",
                "SECTION_FIELDS" => array(0 => "", 1 => "",),
                "SECTION_ID" => '',
                "SECTION_CODE" => '',
                "SECTION_URL" => "",
                "SECTION_USER_FIELDS" => ['UF_*'],
                "SHOW_PARENT_NAME" => "Y",
                "TOP_DEPTH" => "2",
                "VIEW_MODE" => "LINE",
            )
        ); ?>
    </div>

    <h1 class="catalog-section__title"><?= $APPLICATION->ShowTitle(false) ?></h1>

    <?php

    $sectionCode = $arResult['VARIABLES']['SECTION_CODE'];
    $arSectionCode = explode('/', $arResult['VARIABLES']['SECTION_CODE_PATH']);

    $resultBackup = $arResult;
    $HideSect = array();
    $arHdSelect = array("*", "UF_SEO_SECTIONS", "UF_SEO_SECTION", "UF_DAY_SETTING");
    $arHdFilter = array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y", "ID" => $arResult["VARIABLES"]["SECTION_ID"], "CODE" => $arResult["VARIABLES"]["SECTION_CODE"]);
    $rsHdSect = CIBlockSection::GetList(array('sort' => 'asc'), $arHdFilter, false, $arHdSelect);

    $UF_DAY_SETTING = false;

    while ($arHdSect = $rsHdSect->GetNext()) {

        if ($arHdSect["UF_DAY_SETTING"]) {
            $UF_DAY_SETTING = true;
        }

        if ($arHdSect["UF_SEO_SECTION"]) {
            $HideSect[] = $arHdSect;
        }
    }

    $arResult["VARIABLES"]["UF_DAY_SETTING"] = $UF_DAY_SETTING;

    $filterName = $arParams["FILTER_NAME"];
    if (count($HideSect) > 0):
        global $filteredSEO;
        $filteredSEO = array();

        foreach ($HideSect as $hideSect):
            foreach ($hideSect["UF_SEO_SECTIONS"] as $hdSect):
                $seoFilter = Array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y", "SECTION_ID" => $hdSect, "INCLUDE_SUBSECTIONS" => "Y");
                $resSeoItems = CIBlockElement::GetList(Array("sort" => "asc"), $seoFilter, false, false);
                while ($obSeoItem = $resSeoItems->GetNext()) {
                    $filteredSEO["ID"][] = $obSeoItem["ID"];
                    if (!in_array($obSeoItem["IBLOCK_SECTION_ID"], $filteredSEO["SECTION_ID"])) {
                        $filteredSEO["SECTION_ID"][] = $obSeoItem["IBLOCK_SECTION_ID"];
                    }
                }

            endforeach;
        endforeach;

        $filterName = "filteredSEO";
        if (empty($filteredSEO["ID"])) {
            $specfilter = "";
        } else {
            $specfilter = "Y";
        }
        $arParams['FILTER_NAME'] = $filterName;
    endif;

    // TODO: component slider


    if (!empty($HideSect)) {
        $intSectionID = $APPLICATION->IncludeComponent(
            "bitrix:catalog.section",
            "meta",
            array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "ELEMENT_SORT_FIELD" => 'SORT',
                "ELEMENT_SORT_ORDER" => "ASC",
                "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                "PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
                "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                "BASKET_URL" => $arParams["BASKET_URL"],
                "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                "FILTER_NAME" => $arParams["FILTER_NAME"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "SET_TITLE" => $arParams["SET_TITLE"],
                "MESSAGE_404" => $arParams["~MESSAGE_404"],
                "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                "SHOW_404" => $arParams["SHOW_404"],
                "FILE_404" => $arParams["FILE_404"],
                "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
                "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                "PRICE_CODE" => $arParams["~PRICE_CODE"],
                "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

                "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

                "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
                "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                "LAZY_LOAD" => $arParams["LAZY_LOAD"],
                "MESS_BTN_LAZY_LOAD" => $arParams["~MESS_BTN_LAZY_LOAD"],
                "LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],

                "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                "OFFERS_PROPERTY_CODE" => array(
                    'WEIGHT', 'VOLUME'
                ),
                "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
//					"OFFERS_SORT_FIELD" => "SORT",
//					"OFFERS_SORT_ORDER" => "ASC",
                "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

                "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
                "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
                'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],

                'LABEL_PROP' => $arParams['LABEL_PROP'],
                'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
                'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
                'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
                'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
                'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
                'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
                'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
                'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
                'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
                'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
                'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

                'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
                'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
                'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
                'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
                'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
                'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
                'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
                'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
                'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
                'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
                'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
                'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
                'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
                'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
                'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
                'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

                'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
                'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
                'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

                'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                "ADD_SECTIONS_CHAIN" => "N",
                'ADD_TO_BASKET_ACTION' => $basketAction,
                'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
                'COMPARE_PATH' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['compare'],
                'COMPARE_NAME' => $arParams['COMPARE_NAME'],
                'USE_COMPARE_LIST' => 'Y',
                'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
                'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
                'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : '')
            ),
            $component
        );
    }
    ?>
    <div class="subsection-page">
        <div class="left-col">
            <div class="subsection-page__products-top">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section.list",
                    "subsection-page-menu",
                    Array(
                        "ADD_SECTIONS_CHAIN" => "N",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "3600",
                        "CACHE_TYPE" => "A",
                        "COMPONENT_TEMPLATE" => ".default",
                        "COUNT_ELEMENTS" => "Y",
                        "IBLOCK_ID" => $app->config->iblockIdCatalog,
                        "IBLOCK_TYPE" => "catalog",
//                        "SECTION_CODE" => $arSectionCode[0],
                        "SECTION_CODE" => $sectionCode,
                        "SECTION_CODE_PATH" => $arResult['VARIABLES']['SECTION_CODE_PATH'],
                        "SECTION_FIELDS" => array(0 => "", 1 => "",),
                        "SECTION_ID" => '',
                        "SECTION_URL" => "",
                        "SECTION_USER_FIELDS" => ['UF_*'],
                        "SHOW_PARENT_NAME" => "Y",
                        "TOP_DEPTH" => "1",
                        "VIEW_MODE" => "LINE",
                    ),
                    $component
                ); ?>
                <div class="show_mobile">
                    <div class="btn filter_btn" onclick="show_filter(this)">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.2189 0H0.781292C0.34975 0 0 0.349732 0 0.781252C0 2.95685 0.932667 5.03389 2.55888 6.47935L5.98054 9.52044C6.57384 10.0478 6.91413 10.8055 6.91413 11.5995V19.2179C6.91413 19.8404 7.60996 20.2137 8.12864 19.8678L12.7381 16.7951C12.9554 16.6501 13.086 16.4063 13.086 16.1451V11.5995C13.086 10.8055 13.4263 10.0478 14.0196 9.52044L17.4411 6.47935C19.0673 5.03389 20 2.95685 20 0.781252C20 0.349732 19.6502 0 19.2189 0V0ZM16.403 5.31144L12.9815 8.35268C12.0549 9.17635 11.5234 10.3597 11.5234 11.5993V15.727L8.47656 17.7581V11.5995C8.47656 10.3597 7.94507 9.17635 7.0185 8.35268L3.59699 5.3116C2.50044 4.33671 1.80048 3.00095 1.61309 1.56235H18.3869C18.1995 3.00095 17.4997 4.33671 16.403 5.31144V5.31144Z" fill="black"/>
                        </svg>
                        <?= GetMessage('CATALOG_FILTER_BTN') ?>
                        <svg width="7" height="10" viewBox="0 0 7 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M-3.86088e-07 1.16733L3.83267 5L-5.09637e-08 8.83409L1.16591 10L6.16591 5L1.16591 -2.41282e-07L-3.86088e-07 1.16733Z" fill="black"/>
                        </svg>
                    </div>
                </div>
                <? require 'section_sort.php' ?>
            </div>
            <?
            $APPLICATION->IncludeComponent("bitrix:catalog.smart.filter", "smart-filter", Array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],    // Тип инфоблока
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],    // Инфоблок
                "SECTION_ID" => $arCurSection["ID"],    // ID раздела инфоблока
                "FILTER_NAME" => $arParams["FILTER_NAME"],    // Имя выходящего массива для фильтрации
                "PRICE_CODE" => $arParams["PRICE_CODE"],    // Тип цены
                "CONVERT_CURRENCY" => "Y",    // Тип цены
                "CACHE_TYPE" => "A",    // Тип кеширования
                "CACHE_TIME" => "36000000",    // Время кеширования (сек.)
                "CACHE_NOTES" => "",
                "CACHE_GROUPS" => "Y",    // Учитывать права доступа
                "SAVE_IN_SESSION" => "N",    // Сохранять установки фильтра в сессии пользователя
            ),
                false
            ); ?>
            <?

            $request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
            $day = $request->getPost("day");

            $intSectionID = $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "",
                array(
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
//                    "ELEMENT_SORT_FIELD" => 'SORT',
//                    "ELEMENT_SORT_ORDER" => "ASC",
                    "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                    "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                    "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                    "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                    "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                    "PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
                    "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                    "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                    "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                    "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                    "BASKET_URL" => $arParams["BASKET_URL"],
                    "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
//		"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
//		"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                    "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                    "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                    "FILTER_NAME" => $arParams["FILTER_NAME"],
                    "CACHE_TYPE" => $day ? "N" : $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "SET_TITLE" => $arParams["SET_TITLE"],
                    "MESSAGE_404" => $arParams["~MESSAGE_404"],
                    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                    "SHOW_404" => $arParams["SHOW_404"],
                    "FILE_404" => $arParams["FILE_404"],
                    "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                    "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
                    "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                    "PRICE_CODE" => $arParams["~PRICE_CODE"],
                    "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

                    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                    "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                    "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                    "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                    "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

                    "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                    "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                    "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                    "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                    "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                    "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                    "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                    "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                    "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
                    "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                    "LAZY_LOAD" => $arParams["LAZY_LOAD"],
                    "MESS_BTN_LAZY_LOAD" => $arParams["~MESS_BTN_LAZY_LOAD"],
                    "LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],

                    "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                    "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                    "OFFERS_PROPERTY_CODE" => $arParams['LIST_OFFERS_PROPERTY_CODE'],
                    "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                    "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                    "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                    "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                    "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

                    'UF_DAY_SETTING' => $arResult["VARIABLES"]["UF_DAY_SETTING"],
                    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                    "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                    "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
                    "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
                    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                    'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                    'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                    'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],

                    'LABEL_PROP' => $arParams['LABEL_PROP'],
                    'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
                    'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
                    'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
                    'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
                    'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
                    'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
                    'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
                    'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
                    'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
                    'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
                    'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

                    'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
                    'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
                    'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                    'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
                    'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
                    'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
                    'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
                    'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
                    'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
                    'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
                    'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
                    'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
                    'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
                    'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
                    'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
                    'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
                    'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

                    'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
                    'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
                    'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

                    'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                    "ADD_SECTIONS_CHAIN" => "N",
                    'ADD_TO_BASKET_ACTION' => $basketAction,
                    'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
                    'COMPARE_PATH' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['compare'],
                    'COMPARE_NAME' => $arParams['COMPARE_NAME'],
                    'USE_COMPARE_LIST' => 'Y',
                    'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
                    'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
                    'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : '')
                ),
                $component
            ); ?>
        </div>

        <? if ($elementCount > 0 || 1) { ?>
            <div class="right-col">
                <div class="right-col-title">
                    <?= GetMessage('CATALOG_FILTER_BTN') ?>
                    <div class="header-mobile-menu__close-btn js-filterCloseBtn" onclick="show_filter()"></div>
                </div>

                <? $gidLink = $arResult["UF"]["UF_GID_LINK"]; ?>
                <? $gidName = $arResult["UF"]["UF_GID_NAME"]; ?>
                <? if (!empty($gidLink)) { ?>
                    <div class="subsection-page__tip">
                        <a href="<?= $gidLink ?>">
                            <div class="tip">

                                <div class="tip__icon">
                                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.54102 21.2891C9.57744 21.4891 9.57036 21.7268 9.57036 22.0263C9.57036 23.6963 10.8594 25 12.5 25C14.1113 25 15.4297 23.6816 15.4297 22.0703C15.4297 21.7218 15.4228 21.4881 15.4591 21.2891L12.5 19.8242L9.54102 21.2891Z" fill="#E6F7FF"/>
                                        <path d="M15.4297 22.0703C15.4297 21.7217 15.4228 21.4881 15.459 21.2891L12.5 19.8242V25C14.1113 25 15.4297 23.6816 15.4297 22.0703Z" fill="#CCEEFF"/>
                                        <path d="M17.7596 15.0049C16.3387 16.8799 15.533 19.0479 15.4598 21.2891H9.54181C9.45392 19.1211 8.64825 16.9678 7.13946 14.8585C6.12872 13.4522 5.71856 11.7237 5.98224 9.99517C6.56183 6.24713 9.53302 4.44439 12.5008 4.45611C15.7635 4.46783 19.0218 6.6734 19.0916 10.897C19.1042 12.4346 18.6616 13.7971 17.7596 15.0049Z" fill="#FFE666"/>
                                        <path d="M12.5 2.97852C12.0952 2.97852 11.7676 2.65093 11.7676 2.24609V0.732422C11.7676 0.327588 12.0952 0 12.5 0C12.9048 0 13.2324 0.327588 13.2324 0.732422V2.24609C13.2324 2.65093 12.9048 2.97852 12.5 2.97852Z" fill="#FFE666"/>
                                        <path d="M19.4777 7.00665C19.2746 6.65617 19.3948 6.20841 19.7453 6.00602L21.0141 5.2736C21.3646 5.07047 21.8123 5.19064 22.0141 5.54181C22.2172 5.8923 22.097 6.34005 21.7465 6.54244L20.4777 7.27487C20.1241 7.47785 19.6769 7.35421 19.4777 7.00665Z" fill="#FABE2C"/>
                                        <path d="M2.98554 16.5283C2.78241 16.1778 2.90258 15.7301 3.25302 15.5277L4.52191 14.7953C4.87094 14.5936 5.32016 14.713 5.52187 15.0635C5.72499 15.414 5.60483 15.8617 5.25434 16.0641L3.98544 16.7965C3.63217 16.9994 3.1849 16.8761 2.98554 16.5283Z" fill="#FFE666"/>
                                        <path d="M16.5285 4.05804C16.178 3.8556 16.0578 3.4079 16.2609 3.05741L16.9933 1.78925C17.1936 1.43808 17.6428 1.32147 17.9933 1.52104C18.3438 1.72348 18.464 2.17118 18.2608 2.52167L17.5284 3.78983C17.329 4.13876 16.8809 4.26044 16.5285 4.05804Z" fill="#FABE2C"/>
                                        <path d="M7.47186 3.789L6.73944 2.52083C6.53632 2.17034 6.65648 1.72259 7.00697 1.5202C7.35599 1.31849 7.80521 1.43651 8.00692 1.78841L8.73934 3.05657C8.94247 3.40706 8.8223 3.85482 8.47181 4.05721C8.11981 4.25931 7.67147 4.13831 7.47186 3.789Z" fill="#FFE666"/>
                                        <path d="M21.0141 16.7964L19.7453 16.064C19.3948 15.8615 19.2746 15.4138 19.4777 15.0634C19.6794 14.7136 20.13 14.5956 20.4777 14.7951L21.7465 15.5276C22.097 15.73 22.2172 16.1777 22.0141 16.5282C21.8151 16.8753 21.3682 16.9997 21.0141 16.7964Z" fill="#FABE2C"/>
                                        <path d="M4.52191 7.27473L3.25302 6.54231C2.90258 6.33987 2.78241 5.89217 2.98554 5.54168C3.18725 5.19119 3.63642 5.07249 3.98544 5.27347L5.25434 6.00589C5.60483 6.20833 5.72499 6.65603 5.52187 7.00652C5.3226 7.35418 4.87548 7.47771 4.52191 7.27473Z" fill="#FFE666"/>
                                        <path d="M22.7539 11.7676H21.2891C20.8842 11.7676 20.5566 11.44 20.5566 11.0352C20.5566 10.6303 20.8842 10.3027 21.2891 10.3027H22.7539C23.1587 10.3027 23.4863 10.6303 23.4863 11.0352C23.4863 11.44 23.1587 11.7676 22.7539 11.7676Z" fill="#FABE2C"/>
                                        <path d="M3.71094 11.7676H2.24609C1.84126 11.7676 1.51367 11.44 1.51367 11.0352C1.51367 10.6303 1.84126 10.3027 2.24609 10.3027H3.71094C4.11577 10.3027 4.44336 10.6303 4.44336 11.0352C4.44336 11.44 4.11577 11.7676 3.71094 11.7676Z" fill="#FFE666"/>
                                        <path d="M13.2324 2.24609V0.732422C13.2324 0.327588 12.9048 0 12.5 0V2.97852C12.9048 2.97852 13.2324 2.65093 13.2324 2.24609Z" fill="#FABE2C"/>
                                        <path d="M17.7588 15.0049C16.3379 16.8799 15.5322 19.0479 15.459 21.2891H12.5V4.45605C15.7627 4.46777 19.021 6.67334 19.0908 10.897C19.1034 12.4346 18.6608 13.7971 17.7588 15.0049Z" fill="#FABE2C"/>
                                        <path d="M14.4827 10.5173C14.1966 10.2313 13.7331 10.2313 13.447 10.5173L12.5 11.4643L11.553 10.5173C11.2669 10.2312 10.8034 10.2312 10.5173 10.5173C10.2312 10.8034 10.2312 11.2669 10.5173 11.553L11.7676 12.8033V15.4297C11.7676 15.8345 12.0952 16.1621 12.5 16.1621C12.9048 16.1621 13.2324 15.8345 13.2324 15.4297V12.8033L14.4827 11.553C14.7688 11.2669 14.7688 10.8034 14.4827 10.5173Z" fill="#FABE2C"/>
                                        <path d="M13.2324 15.4297V12.8032L14.4827 11.553C14.7687 11.2669 14.7687 10.8034 14.4827 10.5173C14.1966 10.2312 13.7331 10.2312 13.447 10.5173L12.5 11.4643V16.1621C12.9048 16.1621 13.2324 15.8345 13.2324 15.4297Z" fill="#FF9100"/>
                                    </svg>
                                </div>

                                <div class="tip__title">
                                    <?= $gidName ?>
                                </div>

                                <div class="tip__show-icon">
                                    <svg width="7" height="10" viewBox="0 0 7 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M-3.86088e-07 1.16733L3.83267 5L-5.09637e-08 8.83409L1.16591 10L6.16591 5L1.16591 -5.09637e-08L-3.86088e-07 1.16733Z" fill="white"/>
                                    </svg>
                                </div>

                            </div>
                        </a>
                    </div>
                <? } ?>
                <div class="subsection-page__products-filter-block"></div>
                <div class="subsection-page__products-settings">
                    <div class="custom_scrollbar">
                        <div class="products-settings">
                            <? $APPLICATION->ShowViewContent("right_area") ?>
                        </div>
                    </div>
                </div>
            </div>
        <? } ?>
    </div>
    <?
    $APPLICATION->IncludeComponent(
        "bitrix:catalog.section.list",
        "clear",
        array(
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
            "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
            "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
            "TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
            "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
            "VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
            "SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
            "HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
            "ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
        ),
        $component,
        array("HIDE_ICONS" => "Y")
    );
    ?>
</div>

