<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Stranke\Shop\SectionProduct;

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

//$component = $this->getComponent();
//$arParams = $component->applyTemplateModifications();

//$arResult['html']['attr']['id'] = $component->GetEditAreaId($arResult['ID']);

//$arResult['related_elements'] = $arResult['PROPERTIES']['RELATED_PRODUCTS']['VALUE'];

$arResult["PROPS"] = array();

foreach ($arResult['DISPLAY_PROPERTIES'] as $code => $arProp) {
    $arResult["PROPS"][$code] = $arProp;
}
$arResult['MORE_PHOTO'] = $arResult['PROPERTIES']['dop_photo']['VALUE'];


if ($arResult['OFFERS']) {
    $arResult['CATALOG_QUANTITY'] = 0;
    $arResult['OFFER_INDX'] = false;
    $arResult['OFFER_ID'] = false;
    foreach ($arResult['OFFERS'] as $key => $aroffer) {
        if ($arResult['OFFER_INDX'] === false && $aroffer['CATALOG_QUANTITY'] > 0) {
            $arResult['OFFER_INDX'] = $key;
        }
        $arResult['CATALOG_QUANTITY'] += ($aroffer['CATALOG_QUANTITY'] > 0 ? $aroffer['CATALOG_QUANTITY'] : 0);
    }
    $arResult['OFFER_INDX'] = $arResult['OFFER_INDX'] ? $arResult['OFFER_INDX'] : 0;
    $arResult['OFFER_ID'] = $arResult['OFFERS'][$arResult['OFFER_INDX']]['ID'];
}




$IPROPERTY_VALUES = $this->__component->arResult["IPROPERTY_VALUES"];
$PARENT_TEMPLATE_PAGE = $this->__component->arResult["ORIGINAL_PARAMETERS"]["PARENT_TEMPLATE_PAGE"];

if ($PARENT_TEMPLATE_PAGE != "element") {
    $ELEMENT_META_TITLE = $IPROPERTY_VALUES["ELEMENT_META_TITLE_" . str_replace("element_", "", $PARENT_TEMPLATE_PAGE)];
    $ELEMENT_META_DESCRIPTION = $IPROPERTY_VALUES["ELEMENT_META_DESCRIPTION_" . str_replace("element_", "", $PARENT_TEMPLATE_PAGE)];
} else {
    $ELEMENT_META_TITLE = $IPROPERTY_VALUES["ELEMENT_META_TITLE"];
    $ELEMENT_META_DESCRIPTION = $IPROPERTY_VALUES["ELEMENT_META_DESCRIPTION"];
}

//echo '<pre>';
//print_r($IPROPERTY_VALUES);
//die();
$this->__component->arResult['META_TAGS']['BROWSER_TITLE'] = $ELEMENT_META_TITLE;
$this->__component->arResult['META_TAGS']['DESCRIPTION'] = $ELEMENT_META_DESCRIPTION;
