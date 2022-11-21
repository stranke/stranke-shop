<?php
global $IBLOCK_ID;

function getResult($IBLOCK_CODE)
{
    global $IBLOCK_ID;
    $arResultSections = [];
    $arResultSectionId = [];
    $rsSect = CIBlockSection::GetList(
        ['SORT"=>"ASC'],
//        ['IBLOCK_CODE' => $IBLOCK_CODE, 'UF_MAIN_PAGE' => 1],
        ['IBLOCK_CODE' => $IBLOCK_CODE, 'SECTION_ID' => false],
        false,
        ['IBLOCK_ID', 'ID', 'NAME', 'PICTURE', 'SECTION_PAGE_URL', 'UF_MAIN_PAGE', 'UF_MIN_PRICE'],
        false
    );
    while ($arSect = $rsSect->GetNext()) {
        $arResultSectionId[] = $arSect['ID'];
        $IBLOCK_ID = $arSect['IBLOCK_ID'];
        $arSect['price'] = number_format($arSect["UF_MIN_PRICE"], 0, '.', ' ');
        $arResultSections = addSectionResult($arSect, $arResultSections);
    }

    return $arResultSections;
}

function addSectionResult($arSect, $arResultSections)
{
    $arResultSections[$arSect['ID']] = [
        'name' => $arSect['NAME'],
        'link' => $arSect['SECTION_PAGE_URL'],
    ];
    $arResultSections = updateSectionPicture($arSect, $arResultSections);
    return $arResultSections;
}

function updateSectionPicture($arSect, $arResultSections)
{
    if (!empty($arSect['PICTURE'])) {
        $imgID = $arSect['PICTURE'];
        $img = CFile::ResizeImageGet($imgID, array('width' => 351, 'height' => 213), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    } else {
//        $imgID = $GLOBALS["OPTIONS"]["NO_PHOTO_PRODUCT_PREVIEW"];
        $img = false;
    }

    $arResultSections[$arSect['ID']]['img'] = $img;

    return $arResultSections;
}

$arResult['SECTIONS'] = getResult($arParams['IBLOCK_ID']);

$sectionsCount = 0;
if (count($arResult['SECTIONS'])) {
    $sql = 'select count(*) as VALUE from b_iblock_element where IBLOCK_ID = ' . $IBLOCK_ID . ' OR IBLOCK_ID = ' . $IBLOCK_ID;
    $resSectionCount = $DB->Query($sql);
    $arSectionCount = $resSectionCount->Fetch();
    $sectionsCount = $arSectionCount['VALUE'];
}
$arResult['SECTIONS_COUNT'] = $sectionsCount;
