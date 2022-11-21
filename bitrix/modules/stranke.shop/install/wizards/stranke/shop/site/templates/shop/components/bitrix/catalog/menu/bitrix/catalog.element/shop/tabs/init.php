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
 * @var string $templateFolder
 */

$this->setFrameMode(true);

//$this->addExternalJs(SITE_TEMPLATE_PATH . "/js/lightbox.js");
//$this->addExternalJs(SITE_TEMPLATE_PATH . "/js/lib/photoswipe/photoswipe.js");
//$this->addExternalJs(SITE_TEMPLATE_PATH . "/js/lib/photoswipe/photoswipe-ui-default.js");

$arProp = $arResult['PROPERTIES'];
$arPhotoElementsID = $arProp['dop_photo']['VALUE'];
?>

<div class="product__bottom-block">
    <? if ($arParams['TYPE'] == 'description') { ?>

        <!--  ��������    -->
        <div class="product__description">

            <? if ($arResult['PREVIEW_TEXT'] !== '' && !$arResult['DETAIL_TEXT']) { ?>
                <div class="product__description-consist">
                    <h2 class="product__subtitle h2"><?= GetMessage('ST_PRODUCT_DETAIL_BOTTOM_SUBTITLE_CONSIST') ?></h2>
                    <span><?= $arResult['PREVIEW_TEXT'] ?></span>
                </div>
            <? } ?>

            <? if (!empty($arResult['DETAIL_TEXT'])) { ?>
                <h2 class="product__subtitle h2"><?= GetMessage('ST_PRODUCT_DETAIL_BOTTOM_SUBTITLE_DESCRIPTION') ?></h2>
                <?= $arResult['DETAIL_TEXT']; ?>
            <? } ?>

        </div>
        <? include "properties.php"; ?>
        <!--  /��������    -->

        <!--  ����    -->
        <? /* if (count($arPhotoElementsID) > 1 || ($arPhotoElementsID[0] !== null)) { ?>
            <div class="product__photo">

                <?
                $picAlt = $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'];
                $picTitle = $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'];
                ?>

                <h2 class="product__subtitle h2"><?= GetMessage('ST_PRODUCT_DETAIL_BOTTOM_PHOTOS') ?></h2>

                <div class="product__photo-list">

                    <? foreach ($arPhotoElementsID as $photoID) { ?>

                        <div class="product__photo-element-container">
                            <?
                            $picOrigin = CFile::GetFileArray($photoID);
                            $pic = CFile::ResizeImageGet($photoID, ['width' => 118, 'height' => 72], BX_RESIZE_IMAGE_EXACT);
                            ?>
                            <div class="product__photo-element js-photo-swipe-btn">
                                <canvas width="118" height="72"></canvas>
                                <img src="<?= $pic['src'] ?>"
                                     alt="<?= $picAlt ?>"
                                     title="<?= $picTitle ?>"
                                     data-originalSrc="<?= $picOrigin["SRC"] ?>"
                                     data-originalWidth="<?= $picOrigin["WIDTH"] ?>"
                                     data-originalHeight="<?= $picOrigin["HEIGHT"] ?>"
                                >
                            </div>


                            <script type="application/ld+json">
             {
              "@context": "http://schema.org",
              "@type": "ImageObject",
              "contentUrl": "<?= $pic['src'] ?>",
              "name": "<?= $arResult['NAME'] ?>",
              "description": "<?= $picAlt ?>"
              }



                            </script>


                        </div>

                    <? } ?>
                </div>


            </div>
        <? } */ ?>
        <!--  /����    -->
        <? include "video.php"; ?>
        <? // include "reviews.php" ?>

    <? } elseif ($arParams['TYPE'] == 'properties') { ?>
        <? include "properties.php"; ?>
    <? } elseif ($arParams['TYPE'] == 'photo') { ?>

        <!--  ����    -->
        <? if (count($arPhotoElementsID) > 1 || ($arPhotoElementsID[0] !== null)) { ?>
            <div class="product__photo">

                <?
                $picAlt = $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'];
                $picTitle = $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'];
                ?>

                <h2 class="product__subtitle h2"><?= GetMessage('ST_PRODUCT_DETAIL_BOTTOM_PHOTOS') ?></h2>

                <div class="product__photo-list">

                    <? foreach ($arPhotoElementsID as $photoID) { ?>

                        <div class="product__photo-element-container">

                            <?
                            $picOrigin = CFile::GetFileArray($photoID);
                            $pic = CFile::ResizeImageGet(
                                $photoID,
                                array('width' => 118, 'height' => 72),
                                2
                            );
                            ?>

                            <div class="product__photo-element js-photo-swipe-btn">
                                <canvas width="118" height="72"></canvas>
                                <img src="<?= $pic['src'] ?>"
                                     alt="<?= $picAlt ?>"
                                     title="<?= $picTitle ?>"
                                     data-originalSrc="<?= $picOrigin["SRC"] ?>"
                                     data-originalWidth="<?= $picOrigin["WIDTH"] ?>"
                                     data-originalHeight="<?= $picOrigin["HEIGHT"] ?>"
                                >
                            </div>

                        </div>

                    <? } ?>
                </div>

            </div>
        <? } ?>
    <? } elseif ($arParams['TYPE'] == 'video') { ?>
        <!--  �����    -->
        <? include "video.php"; ?>
        <!--  /�����    -->

    <? } elseif ($arParams['TYPE'] == 'reviews') { ?>

        <!--  ������  -->
        <? include "reviews.php"; ?>
        <!--  /������  -->

    <? } elseif ($arParams['TYPE'] == 'related-products') { ?>

    <? } ?>
</div>

