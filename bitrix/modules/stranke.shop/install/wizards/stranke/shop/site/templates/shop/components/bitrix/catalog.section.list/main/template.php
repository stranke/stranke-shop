<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
<div class="menu">
    <div class="menu__section-list">
        <?foreach ($arResult['SECTIONS'] as $arSection):?>
            <?
            $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
            $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
            ?>
            <a class="menu__section" href="<?=$arSection['SECTION_PAGE_URL']?>">
                <span class="menu__section-img" id="<?=$this->GetEditAreaId($arSection['ID'])?>">

                    <canvas class="menu__section-canvas menu__section-canvas_mobile" width="1" height="1"></canvas>
                    <canvas class="menu__section-canvas menu__section-canvas_desktop" width="374" height="187"></canvas>

                    <img src="<?=$arSection['IMG']['SRC']?>"
                         alt="<?=$arSection['IMG']['ALT']?>"
                         title="<?=$arSection['IMG']['TITLE']?>">
                </span>

                <span class="menu__section-name"><?=$arSection['NAME']?></span>

                <?if ($arSection['MIN_PRICE']):?>
                    <span class="menu__section-min-price"><?=$arSection['MIN_PRICE']?></span>
                <?endif?>
            </a>
        <?endforeach?>
    </div>
</div>
