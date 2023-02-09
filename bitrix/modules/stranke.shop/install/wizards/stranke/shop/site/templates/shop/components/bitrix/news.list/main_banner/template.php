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

use \Bitrix\Main\Page\Asset;
global $app;
$this->setFrameMode(true);

$asset = Asset::getInstance();
//$asset->addJs(SITE_TEMPLATE_PATH . "/js/swiper.js");
//$asset->addCss(SITE_TEMPLATE_PATH . "/styles/swiper.css");

$resSection = CIBlockSection::GetList(
    ['SORT' => 'ASC'],
    ['ACTIVE' => 'Y', 'IBLOCK_ID' => $arResult['IBLOCK_ID'], 'CODE' => 'dopolnitelnyy-banner-vozle-slaydera-na-glavnoy'],
    false,
    ['ID'],
    array('nTopCount' => 1)
);
$arSection_id = 0;
if ($arSection = $resSection->GetNext()) {
    $arSection_id = $arSection['ID'];
}
?>
<?if($app->config->bannertitlefontsize){
    $bannertitlefontsize = 'style="font-size:' . $app->config->bannertitlefontsize . 'px"';
} else {
    $bannertitlefontsize = 'style="font-size:14px"';
}?>
<?if($app->config->bannersubtitlefontsize){
    $bannersubtitlefontsize = 'style="font-size:' . $app->config->bannersubtitlefontsize . 'px"';
} else {
    $bannersubtitlefontsize = 'style="font-size:14px"';
}?>
<? if (!empty($arResult["ITEMS"])) { ?>
    <div class="wrapper">
        <div class="top-banner-on-main">
            <div class="slider-on-main">
                <canvas class="canvas-wide" width="1200" height="400"></canvas>
                <!--            <canvas class="canvas-mobile" width="360" height="294"></canvas>-->
                <div id="main_banner" class="swiper-container">
                    <div class="swiper-wrapper">

                        <? foreach ($arResult["ITEMS"] as $key => $slide) { ?>
                            <? if ($slide['IBLOCK_SECTION_ID'] === $arSection_id) {
                                continue;
                            } ?>
                            <? $title = $slide["FIELDS"]["PREVIEW_TEXT"]; ?>
                            <? $name = $slide["FIELDS"]["DETAIL_TEXT"]; ?>
                            <? $pic = $slide["DETAIL_PICTURE"]; ?>
                            <? $pic2 = $slide["PREVIEW_PICTURE"]; ?>
                            <? $link = $slide["PROPERTIES"]["URL"]["VALUE"] ?>
                            <?
                            $pic = CFile::ResizeImageGet(
                                $pic["ID"],
//                                                array("width"=>1500, "height"=>485),
                                array("width" => 1200, "height" => 400),
                                2
                            );

                            if (!empty($pic2)) {
                                $pic2 = CFile::ResizeImageGet(
                                    $pic2["ID"],
                                    array("width" => 767, "height" => 626),
                                    2
                                );
                            } else {
                                $pic2 = $pic;
                            }

                            ?>

                            <div class="swiper-slide">
                                <div class="swiper-slide__bg">
                                    <canvas class="canvas-wide" width="1200" height="400"></canvas>
                                    <!--                            <canvas class="canvas-mobile" width="360" height="294"></canvas>-->

                                    <? if ($key === 0): ?>
                                        <img class="canvas-wide" src="<?= $pic["src"] ?>" alt="<?= $name ?>">
                                        <!--                                <img class="canvas-mobile" src="--><? //=$pic2["src"]?><!--" alt="--><? //=$name?><!--">-->
                                    <? else: ?>
                                        <img class="canvas-wide" data-lazy-load data-src="<?= $pic["src"] ?>" alt="<?= $name ?>">
                                        <!--                                <img class="canvas-mobile" data-lazy-load data-src="--><? //=$pic2["src"]?><!--" alt="--><? //=$name?><!--">-->
                                    <? endif ?>
                                </div>
                                <div class="swiper-slide__block-content" data-href="<?= $link ?>">
                                    <div class="slider__title" <?=$bannertitlefontsize?>><?= $name ?></div>
                                    <div class="slider__text" <?=$bannersubtitlefontsize?>><?= $title ?></div>
                                </div>
                            </div>

                        <? } ?>

                    </div>
                    <? if (count($arResult["ITEMS"]) > 1) { ?>
                        <!-- If we need pagination -->
                        <div class="swiper-pagination"></div>
                        <!-- If we need navigation buttons -->
                        <div class="swiper-button">
                            <div class="swiper-button-prev">
                                <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="50" height="50" rx="25" transform="matrix(1 0 0 -1 0 50)" fill="white"/>
                                    <path d="M28 31L21 25L28 19" stroke="black" stroke-width="2.04511"/>
                                </svg>

                            </div>
                            <div class="swiper-button-next">
                                <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="50" height="50" rx="25" transform="matrix(-1 0 0 1 50 0)" fill="white"/>
                                    <path d="M22 19L29 25L22 31" stroke="black" stroke-width="2.04511"/>
                                </svg>
                            </div>
                        </div>
                    <? } ?>
                </div>
            </div>

            <? //Prepare additional banner?>
            <?
            if ($arSection_id) {
                $resAB = CIBlockElement::GetList(
                    ['SORT' => 'ASC'],
                    ['ACTIVE' => 'Y', 'IBLOCK_ID' => $arResult['IBLOCK_ID'], 'SECTION_ID' => $arSection_id],
                    false,
                    array('nTopCount' => 1),
                    ['IBLOCK_ID', 'ID', 'NAME', 'PREVIEW_TEXT', 'DETAIL_PICTURE', 'PROPERTIES_URL']
                );
                if ($arAb = $resAB->GetNext()) {
                    $title = $arAb['PREVIEW_TEXT'];
                    $pic = CFile::ResizeImageGet($arAb["DETAIL_PICTURE"], array("width" => 282, "height" => 400), 2);
                    ?>
                    <div class="additional-banner">
                        <canvas width="282" height="400"></canvas>
                        <img src="<?= $pic['src'] ?>" alt="<?= $title ?>">
                        <div class="additional-banner__title"><?= $title ?></div>
                    </div>
                <? } ?>
            <? } ?>
        </div>
    </div>
<? } ?>
