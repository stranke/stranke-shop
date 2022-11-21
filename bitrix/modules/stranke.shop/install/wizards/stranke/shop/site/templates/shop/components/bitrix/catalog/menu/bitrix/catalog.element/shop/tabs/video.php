<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/** @var array $arResult */

$datetime = new DateTime($arResult['TIMESTAMP_X']);
$uploadDate = $datetime->format(DateTime::ATOM);
$youTubeCode = $arResult['PROPERTIES']['YOUTUBE_CODE']['VALUE'];?>
<?php if (strlen($youTubeCode)) { ?>
    <div class="product__video">
        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "VideoObject",
                "name": "<?=$arResult['IPROPERTY_VALUES']['ELEMENT_META_TITLE']?>",
                "description": "<?=$arResult['IPROPERTY_VALUES']['ELEMENT_META_DESCRIPTION']?>",
                "thumbnailUrl": [
                    "https://img.youtube.com/vi/<?=$youTubeCode?>/default.jpg"
                ],
                "uploadDate": "<?=$uploadDate?>",
                "embedUrl": "//www.youtube.com/embed/<?=$youTubeCode ?>?feature=player_detailpage"
            }
        </script>

        <h2 class="product__subtitle h2"><?=GetMessage('ST_PRODUCT_DETAIL_BOTTOM_VIDEO')?></h2>
        <a name="video_r"></a>
        <div id="video_container" class="product__video-item">
            <iframe id="frame" class="video_frame" width="640" height="480" src="//www.youtube.com/embed/<?=$youTubeCode ?>?rel=0" frameborder="0" allow='autoplay' allowfullscreen></iframe>
        </div>

    </div>
<? } ?>