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
?>
<?if (!empty($arResult['SECTIONS'])):?>
    <div class="re-linling">
        <div class="menu__seo-section-container">
            <? foreach ($arResult['SECTIONS'] as $arSection) { ?>
                <a href="<?=$arSection['SECTION_PAGE_URL']?>" class="menu__seo-section">
                    <?=$arSection['NAME']?>
                </a>
            <? } ?>
        </div>
    </div>
<?endif?>