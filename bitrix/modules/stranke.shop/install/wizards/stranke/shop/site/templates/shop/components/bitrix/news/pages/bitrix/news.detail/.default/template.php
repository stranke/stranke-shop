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
<div class="page-container page-container_wide">
    <div class="text-page">
        <h1 class="text-page__title"><?=$arResult['NAME']?></h1>

        <div class="text-page__text">
            <?if (!empty($arResult['DETAIL_PICTURE']['SRC'])):?>
                <div class="text-page__img">
                    <canvas width="2" height="1"></canvas>
                    <img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="<?=$arResult['DETAIL_PICTURE']['NAME']?>">
                </div>
            <?endif?>

            <?=$arResult['DETAIL_TEXT']?>

            <? if (!empty($arResult['PROPERTIES']['PAGE_LINK']['VALUE']) || !empty($arResult['PROPERTIES']['DOWNLOAD_LINK']['VALUE']))  { ?>
                <div class="dostavka-i-oplata__item-links">
                    <? if (!empty($arResult['PROPERTIES']['PAGE_LINK']['VALUE'])) { ?>
                        <a href="<?=$arResult['PROPERTIES']['PAGE_LINK']['VALUE']?>" class="dostavka-i-oplata__link-btn">
                            <?=$arResult['PROPERTIES']['PAGE_LINK_NAME']['VALUE']?>
                        </a>
                    <? } ?>

                    <? if (!empty($arResult['PROPERTIES']['DOWNLOAD_LINK']['VALUE'])) { ?>
                        <a href="<?=$arResult['PROPERTIES']['DOWNLOAD_LINK']['VALUE']?>" class="dostavka-i-oplata__link-btn dostavka-i-oplata__link-btn_download">
                            <?=$arResult['PROPERTIES']['DOWNLOAD_LINK_NAME']['VALUE']?>
                        </a>
                    <? } ?>
                </div>
            <? } ?>
        </div>
    </div>
</div>