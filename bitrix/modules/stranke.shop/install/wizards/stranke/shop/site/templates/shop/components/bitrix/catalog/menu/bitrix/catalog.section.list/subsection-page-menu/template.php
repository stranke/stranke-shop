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
$this->setFrameMode(true);
$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));
?>
<? if (!empty($arResult['SECTIONS'])): ?>
    <div class="catalog-section__menu">
        <div class="catalog-section-menu">
            <div class="catalog-section-menu__section-list">
                <? /*if ($arResult['IS_ROOT']): ?>
                    <span class="catalog-section-menu__section catalog-section-menu__section_root catalog-section-menu__section_selected">
                        <span class="catalog-section-menu__section-name"><?= GetMessage('ST_CSM_SECTION_ALL') ?></span>
                    </span>
                <? else: ?>
                    <a class="catalog-section-menu__section catalog-section-menu__section_root" href="<?= $arResult['SECTION']['SECTION_PAGE_URL'] ?>">
                        <span class="catalog-section-menu__section-name"><?= GetMessage('ST_CSM_SECTION_ALL') ?></span>
                    </a>
                <? endif */?>

                <? foreach ($arResult['SECTIONS'] as $arSection): ?>
                    <?
                    $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
                    $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
                    $className = 'catalog-section-menu__section';
                    if ($arSection['IS_SELECTED']) {
                        $className .= '  catalog-section-menu__section_selected';
                    }
                    ?>

                    <a class="<?= $className ?>" href="<?= $arSection['SECTION_PAGE_URL'] ?>" id="<?= $this->GetEditAreaId($arSection['ID']) ?>">
                        <span class="catalog-section-menu__section-name"><?= $arSection['NAME'] ?></span>
                    </a>
                <? endforeach ?>
            </div>
        </div>
    </div>
<? endif ?>
