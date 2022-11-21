<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
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
$this->createFrame()->begin();
?>
<?php if (!empty($arResult['ITEMS'])): ?>

    <div id="product_hit-goods" class="swiper">
        <div class="swiper-wrapper">
            <?
            /*$arGlushakSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "DETAIL_PICTURE");
            $arGlushakFilter = Array("IBLOCK_ID" => 11, "ID" => 329);
            $resGlushak = CIBlockElement::GetList(Array(), $arGlushakFilter, false, Array(), $arGlushakSelect);
            while ($ob = $resGlushak->GetNextElement()) {
              $arGlushakFields = $ob->GetFields();
            }
            $arGlushakfile = CFile::GetFileArray($arGlushakFields["DETAIL_PICTURE"]);*/
            ?>
            <?php foreach ($arResult['ITEMS'] as $arItem) { ?>
                <div class="swiper-slide">
                    <? include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/includes/product-list/product-on-main.php'; ?>
                </div>
            <? } ?>
        </div>
        <div class="swiper-button-prev">
            <svg width="10" height="14" viewBox="0 0 10 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 1L2 7L9 13" stroke="" stroke-width="2.04511"/>
            </svg>
        </div>
        <div class="swiper-button-next">
            <svg width="10" height="14" viewBox="0 0 10 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 1L8 7L1 13" stroke="" stroke-width="2.04511"/>
            </svg>
        </div>
        <div class="swiper-scrollbar"></div>
    </div>

<?php endif; ?>
