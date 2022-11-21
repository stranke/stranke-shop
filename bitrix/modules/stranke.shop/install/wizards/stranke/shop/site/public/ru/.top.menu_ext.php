<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$aMenuLinksExt = [];
$cache = Bitrix\Main\Data\Cache::createInstance();
if ($cache->initCache(3600, 'top-menu-ext', '/')) {
    $aMenuLinksExt = $cache->getVars();
} elseif ($cache->startDataCache()) {
    $iblockId = "#PAGES_IBLOCK_ID#";
    $arFilter = ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y', '!CODE' => 'main'];
    $arSelect = ['ID', 'NAME', 'DETAIL_PAGE_URL'];
    $dbElements = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
    while($arElement = $dbElements->GetNext()) {
        $aMenuLinksExt[] = [
            $arElement['NAME'],
            $arElement['DETAIL_PAGE_URL'],
            [],
            [],
            ''
        ];
    }
    $cache->endDataCache($aMenuLinksExt);
}

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
