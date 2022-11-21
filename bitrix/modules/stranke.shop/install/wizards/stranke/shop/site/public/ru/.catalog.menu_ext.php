<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $APPLICATION;

use Bitrix\Main\Loader;

$incIBlock = Loader::includeModule("iblock");

$aMenuLinksExt = array();


if ($incIBlock) {
    $arFilter = array(
        "TYPE" => "catalog",
        "SITE_ID" => SITE_ID,
    );

    $dbIBlock = CIBlock::GetList(array('SORT' => 'ASC', 'ID' => 'ASC'), $arFilter);
    $dbIBlock = new CIBlockResult($dbIBlock);

    if ($arIBlock = $dbIBlock->GetNext()) {
        if (defined("BX_COMP_MANAGED_CACHE"))
            $GLOBALS["CACHE_MANAGER"]->RegisterTag("iblock_id_" . $arIBlock["ID"]);

        if ($arIBlock["ACTIVE"] == "Y") {
            $aMenuLinksExt = $APPLICATION->IncludeComponent("stranke:menu.sections", "", array(
                "IS_SEF" => "Y",
                "SEF_BASE_URL" => "",
                "SECTION_PAGE_URL" => $arIBlock['SECTION_PAGE_URL'],
                "DETAIL_PAGE_URL" => $arIBlock['DETAIL_PAGE_URL'],
                "IBLOCK_TYPE" => $arIBlock['IBLOCK_TYPE_ID'],
                "IBLOCK_ID" => $arIBlock['ID'],
                "DEPTH_LEVEL" => "3",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600"
            ), false, Array('HIDE_ICONS' => 'Y'));

        }
    }

    if (defined("BX_COMP_MANAGED_CACHE"))
        $GLOBALS["CACHE_MANAGER"]->RegisterTag("iblock_id_new");
}

$aMenuLinks = array_merge($aMenuLinksExt, $aMenuLinks);
?>
