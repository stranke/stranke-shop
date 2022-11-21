<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 */

$this->setFrameMode(true);
//$this->addExternalJs(SITE_TEMPLATE_PATH . '/js/product-list.js');
$this->addExternalJs($templateFolder."/js/urlmanager.js");
$this->addExternalJs($templateFolder."/js/guimanager.js");
?>
<?

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

$obSectionProp = CIBlockSection::GetList(
    array(),
    array('IBLOCK_ID' => $arResult['IBLOCK_ID'], 'ID' => $arResult['ID']),
    false,
    array('ID', 'UF_*'),
    false
);
while ($sectionProp = $obSectionProp->GetNext()) {
    $sectionProps = $sectionProp;
}

$countProducts = count($arResult['ITEMS']);
?>
<meta itemprop="name" content="<?= $arResult['NAME'] ?>">
<?
if ($_SERVER['HTTPS'] == 'on') {
    $url = 'https:/' . $_SERVER['REQUEST_URI'];
} else {
    $url = 'http:/' . $_SERVER['REQUEST_URI'];
}
?>
<meta itemprop="url" content="<?= $url ?>">

<? if (!empty($arResult['ITEMS'])): ?>
    <? $productsId = 'products' . randString(); ?>
    <div class="products" id="<?= $productsId ?>">
        <div class="products__item-list">
            <?
            foreach ($arResult['ITEMS'] as $index => $arItem) {
                $countProducts = count($arResult['ITEMS']) - $index;
                $uniqueId = $arItem['ID'] . '_' . md5($this->randString() . $component->getAction());
                $areaId = $this->GetEditAreaId($uniqueId);
                $this->AddEditAction($uniqueId, $arItem['EDIT_LINK'], $elementEdit);
                $this->AddDeleteAction($uniqueId, $arItem['DELETE_LINK'], $elementDelete, $elementDeleteParams);
                ?>

                <div class="products__item" url="<?= $arItem['DETAIL_PAGE_URL'] ?>" id="<?= $this->GetEditAreaId($arItem['ID']); ?>" product_id="<?= $arItem['ID'] ?>">
                    <? include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/includes/product-list/product.php'; ?>
                </div>
            <? } ?>
        </div>
        <script>
            BX.message({
                ST_ADD_TO_BASKET: '<?=GetMessage('ST_ADD_TO_BASKET')?>',
                CT_BCE_CATALOG_SELECT_OFFER: '<?=GetMessage('CT_BCE_CATALOG_SELECT_OFFER')?>',
                CT_BCE_CATALOG_NO_AVAILABLE: '<?=GetMessage('CT_BCE_CATALOG_NO_AVAILABLE')?>',
                CT_BCE_CATALOG_NOT_AVAILABLE: '<?=GetMessage('CT_BCE_CATALOG_NOT_AVAILABLE')?>',
                CT_BCE_CATALOG_COUNT_AVAILABLE: '<?=GetMessage('CT_BCE_CATALOG_COUNT_AVAILABLE')?>',
                CT_BCE_CATALOG_COUNT_IZM: '<?=GetMessage('CT_BCE_CATALOG_COUNT_IZM')?>',
                CT_BCE_CATALOG_ADD: '<?=GetMessage('CT_BCE_CATALOG_ADD')?>',
                CT_BCE_CATALOG_ADDED: '<?=GetMessage('CT_BCE_CATALOG_ADDED')?>',


            });
        </script>
    </div>
<? endif ?>

<? /*if (empty($arResult['SUB_SECTIONS'])): ?>
    <h3><?= GetMessage('ST_CATALOG_EMPTY') ?></h3>
<? else: ?>
    <? foreach ($arResult['SUB_SECTIONS'] as $arSection): ?>
        <? if (!empty($arSection['ITEMS'])): ?>
            <? $productsId = 'products' . randString(); ?>
            <div class="products products_siblings" id="<?= $productsId ?>">
                <? if ($arSection["ID"] !== $arResult['ID']): ?>
                    <? $sectionPage = $arSection['SECTION_PAGE_URL'] ?>
                    <h2 class="products__title h2"><?= $arSection['NAME'] ?></h2>
                <? endif ?>

                <div class="products__item-list">
                    <?
                    foreach ($arSection['ITEMS'] as $index => $arItem) {
                        $countProducts = count($arSection['ITEMS']) - $index;
                        $uniqueId = $arItem['ID'] . '_' . md5($this->randString() . $component->getAction());
                        $areaId = $this->GetEditAreaId($uniqueId);
                        $this->AddEditAction($uniqueId, $arItem['EDIT_LINK'], $elementEdit);
                        $this->AddDeleteAction($uniqueId, $arItem['DELETE_LINK'], $elementDelete, $elementDeleteParams);

                        include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/includes/product-list/product.php';
                    }
                    ?>
                </div>

                <script>
                    BX.message({
                        ST_ADD_TO_BASKET: '<?=GetMessage('ST_ADD_TO_BASKET')?>',
                        ST_DISCOUNT_IS_FINISHED: '<?=GetMessage('ST_DISCOUNT_IS_FINISHED')?>',
                    });

                    $(function () {
                        new ProductList('#<?=$productsId?>');
                    });
                </script>
            </div>
        <? endif ?>
    <? endforeach ?>
<? endif */ ?>

<? if (is_object($arResult["NAV_RESULT"])) {
    $arResult["NAV_RESULT"]->NavRecordCount;
}
?>
<? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
    <br/><?= $arResult["NAV_STRING"] ?>
<? endif; ?>
