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

<div class="page-container">

  <div class="dostavka-i-oplata">

    <? $i = 0; ?>

    <? foreach ($arResult['SECTIONS'] as $arSection) { ?>

      <? if ($i == 0) { ?>
        <h1 class="dostavka-i-oplata__title h1"><?=$arSection['NAME']?></h1>
      <? } else { ?>
        <h2 class="dostavka-i-oplata__title h1"><?=$arSection['NAME']?></h2>
      <? } ?>

      <div class="dostavka-i-oplata__item-list">

       <?
        $APPLICATION->IncludeComponent(
         "bitrix:news.list",
         "dostavka-i-oplata",
         Array(
           "ACTIVE_DATE_FORMAT" => "d.m.Y",
           "ADD_SECTIONS_CHAIN" => "N",
           "AJAX_MODE" => "N",
           "AJAX_OPTION_ADDITIONAL" => "",
           "AJAX_OPTION_HISTORY" => "N",
           "AJAX_OPTION_JUMP" => "N",
           "AJAX_OPTION_STYLE" => "Y",
           "CACHE_FILTER" => "N",
           "CACHE_GROUPS" => "Y",
           "CACHE_TIME" => "3600",
           "CACHE_TYPE" => "A",
           "CHECK_DATES" => "Y",
           "DETAIL_URL" => "",
           "DISPLAY_BOTTOM_PAGER" => "Y",
           "DISPLAY_DATE" => "Y",
           "DISPLAY_NAME" => "Y",
           "DISPLAY_PICTURE" => "Y",
           "DISPLAY_PREVIEW_TEXT" => "Y",
           "DISPLAY_TOP_PAGER" => "N",
           "FIELD_CODE" => array("DETAIL_PICTURE",""),
           "FILTER_NAME" => "",
           "HIDE_LINK_WHEN_NO_DETAIL" => "N",
           "IBLOCK_ID" => "9",
           "IBLOCK_TYPE" => "content",
           "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
           "INCLUDE_SUBSECTIONS" => "Y",
           "MESSAGE_404" => "",
           "NEWS_COUNT" => "20",
           "PAGER_BASE_LINK_ENABLE" => "N",
           "PAGER_DESC_NUMBERING" => "N",
           "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
           "PAGER_SHOW_ALL" => "N",
           "PAGER_SHOW_ALWAYS" => "N",
           "PAGER_TEMPLATE" => ".default",
           "PAGER_TITLE" => "Новости",
           "PARENT_SECTION" => $arSection['ID'],
           "PARENT_SECTION_CODE" => "",
           "PREVIEW_TRUNCATE_LEN" => "",
           "PROPERTY_CODE" => array("CLAUSE","DOWNLOAD_LINK","PAGE_LINK",""),
           "SET_BROWSER_TITLE" => "Y",
           "SET_LAST_MODIFIED" => "N",
           "SET_META_DESCRIPTION" => "Y",
           "SET_META_KEYWORDS" => "Y",
           "SET_STATUS_404" => "N",
           "SET_TITLE" => "Y",
           "SHOW_404" => "N",
           "SORT_BY1" => "SORT",
           "SORT_BY2" => "ID",
           "SORT_ORDER1" => "ASC",
           "SORT_ORDER2" => "ASC",
           "STRICT_SECTION_CHECK" => "N"
         )
       );
       ?>

     </div>

      <? if (!empty($arSection['DESCRIPTION'])) { ?>

        <div class="dostavka-i-oplata__description">
          <?=$arSection['DESCRIPTION']?>
        </div>

      <? } ?>

      <? $i++ ?>
    <? } ?>

  </div>

</div>