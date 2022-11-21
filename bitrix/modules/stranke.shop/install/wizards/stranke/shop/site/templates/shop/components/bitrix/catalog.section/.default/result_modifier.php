<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use \Stranke\Shop\SectionProduct;
/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

$arSectionItem = array();


/*if (!empty($arResult['ITEMS'])) {
    $arItems = $arResult['ITEMS'];
    $arResult['ITEMS'] = [];

    $arSubSections = [];
    $arFilter = [
        'IBLOCK_ID' => $arResult['IBLOCK_ID'],
        '>=LEFT_MARGIN' => $arResult['LEFT_MARGIN'],
        '<=RIGHT_MARGIN' => $arResult['RIGHT_MARGIN'],
    ];
    $dbSections = CIBlockSection::GetList([], $arFilter, false, ['ID', 'NAME']);
    while($arSection = $dbSections->Fetch()) {
        $arSubSections[] = $arSection['ID'];
    }

    $listItemId = [];
    foreach ($arItems as $index => $arItem) {
        $sectionProduct = new SectionProduct($arItem);
        $arItems[$index] = $sectionProduct->prepare();
        $listItemId[$arItem['ID']] = $index;
    }

    $dbItemSections = CIBlockElement::GetElementGroups(array_keys($listItemId), true);
    while($arItemSections = $dbItemSections->Fetch()) {
        if (!in_array($arItemSections['ID'], $arSubSections)) continue;

        $index = $listItemId[$arItemSections['IBLOCK_ELEMENT_ID']];
        $arItems[$index]['SECTIONS'][] = $arItemSections['ID'];
    }

    $arOrder = array('SORT' => 'ASC', 'NAME' => 'ASC');
//    $arFilter = array('ID' => array_keys($arSectionItem));
    $arFilter = array('ID' => ($arItemSections));
    $dbSections = CIBlockSection::GetList($arOrder, $arFilter);

    $arSections = array();
    while ($arSection = $dbSections->GetNext()) {
        if (!in_array($arSection['ID'], $arSubSections)) continue;

        foreach ($arItems as $sectionElement) {
            if (!in_array($arSection['ID'], $sectionElement['SECTIONS'])) continue;

            if ($arSection['ID'] === $arResult['ID']) {
                $arResult['ITEMS'][] = $sectionElement;
            } else {
                $arSection['ITEMS'][] = $sectionElement;
            }
        }

        $arSections[] = $arSection;
    }

    //  unset($arResult['ITEMS']);

    $arResult['SUB_SECTIONS'] = $arSections;
}*/
