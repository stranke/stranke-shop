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


$titleLvl = $arParams['TITLE_LVL'];
$titleLvl = $titleLvl ? $titleLvl : 1;
?>

<div class="wrapper text-page">

    <? if ($titleLvl > 0) { ?>
        <h<?= $titleLvl ?> class="text-page__title h<?= $titleLvl ?>">
            <?= $arResult['NAME'] ?>
        </h<?= $titleLvl ?> >
    <? } ?>


    <div class="text-page__text">

        <?= $arResult['DETAIL_TEXT'] ?>

    </div>

    <? if ($APPLICATION->GetCurPage(false) == '/') { ?>

        <div class="text-page__show-more-btn-container">

            <div class="text-page__show-more-btn">
                <span><?= GetMessage("ST_TEXT_SHOW_MORE") ?></span>
                <span class="text-page__show-more-btn-text_pressed"><?= GetMessage("ST_TEXT_SHOW_MORE_") ?></span>
                <i class="fas fa-chevron-down"></i>
            </div>

        </div>

    <? } ?>


</div>
