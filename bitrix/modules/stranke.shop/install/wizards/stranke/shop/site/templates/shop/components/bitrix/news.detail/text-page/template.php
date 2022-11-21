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


$titleLvl = $arResult['PROPERTIES']['TITLE_LVL']['VALUE']
?>

<div class="text-page">

  <<?=$titleLvl?> class="text-page__title <?=$titleLvl?>">
    <?=$arResult['NAME']?>
  </<?=$titleLvl?> >



    <div class="text-page__text">

        <?=$arResult['DETAIL_TEXT']?>

    </div>

    <? if ($APPLICATION->GetCurPage(false) == '/') { ?>

      <div class="text-page__show-more-btn-container">

        <div class="text-page__show-more-btn">
          <span>Развернуть</span>
          <span class="text-page__show-more-btn-text_pressed">Свернуть</span>
          <i class="fas fa-chevron-down"></i>
        </div>

      </div>

    <? } ?>




</div>
