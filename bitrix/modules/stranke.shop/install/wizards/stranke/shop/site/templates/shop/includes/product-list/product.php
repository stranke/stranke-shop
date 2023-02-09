<?

$arOffers = $arItem['OFFERS'];

if ($arItem['OFFERS']) {
    $arItem['CATALOG_QUANTITY'] = 0;
    $arItem['OFFER_INDX'] = false;
    $arItem['OFFER_ID'] = false;
    foreach ($arItem['OFFERS'] as $key => $aroffer) {
        if ($arItem['OFFER_INDX'] === false && $aroffer['CATALOG_QUANTITY'] > 0) {
            $arItem['OFFER_INDX'] = $key;
        }
        $arItem['CATALOG_QUANTITY'] += ($aroffer['CATALOG_QUANTITY'] > 0 ? $aroffer['CATALOG_QUANTITY'] : 0);
    }
    $arItem['OFFER_INDX'] = $arItem['OFFER_INDX'] ? $arItem['OFFER_INDX'] : 0;
    $arItem['OFFER_ID'] = $arItem['OFFERS'][$arItem['OFFER_INDX']]['ID'];
}
?>
<?php
$arfile = false;
if (empty($arOffers) || !count($arOffers)) {
    if ($arItem["PREVIEW_PICTURE"]) {
        $arfile = $arItem["PREVIEW_PICTURE"];
    }
} else {
    if (empty($ofMass[0]["PREVIEW_PICTURE"])) {
        if ($arItem["PREVIEW_PICTURE"]) {
            $arfile = $arItem["PREVIEW_PICTURE"];
        }
    } else {
        $arfile = $ofMass[0]["PREVIEW_PICTURE"];
    }
}
?>
<?php
if ($arfile) {
    $file = CFile::ResizeImageGet($arfile['ID'], array('width' => 175, 'height' => 150), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    $fileMin = CFile::ResizeImageGet($arfile['ID'], array('width' => 22, 'height' => 17), BX_RESIZE_IMAGE_PROPORTIONAL, true);
}
?>
<div class="image<?= $arfile ? '' : ' no_img' ?>">
    <? require 'product_shilds.php' ?>
    <canvas width="175" height="150"></canvas>
    <? if ($arfile): ?>
    <img class="lazy"
             src="<?= $fileMin['src'] ?>"
             data-src="<? echo $file['src'] ?>"
             data-href="<?= $arItem['DETAIL_PAGE_URL'] ?>"
             data-lazy-load
             itemprop="image"
             title="<? echo $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"] ?>"
             alt="<? echo $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"] ?>"
             onclick="document.location.href = '<?php echo $arItem["DETAIL_PAGE_URL"] ?>'">
    <? else: ?>
        <svg width="77" height="57" viewBox="0 0 77 57" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M69.7708 56.8235H7.22909C3.59344 56.8235 0.645752 53.8736 0.645752 50.2352V14C0.645752 10.3616 3.59344 7.41172 7.22909 7.41172H8.87492C8.87492 5.59337 10.3496 4.1176 12.1666 4.1176H15.4583C17.2753 4.1176 18.7499 5.59337 18.7499 7.41172H22.0416C22.0416 7.41172 23.8931 7.20584 25.3333 5.76466L28.6249 2.47055C28.6249 2.47055 29.9103 0.823486 31.9166 0.823486H45.0833C47.2426 0.823486 48.3749 2.47055 48.3749 2.47055L51.6666 5.76466C53.1067 7.20584 54.9583 7.41172 54.9583 7.41172H69.7708C73.4064 7.41172 76.3541 10.3616 76.3541 14V50.2352C76.3541 53.8736 73.4064 56.8235 69.7708 56.8235ZM73.0624 14C73.0624 12.1816 71.5878 10.7058 69.7708 10.7058L54.5945 10.6844C54.0925 10.6301 51.4855 10.2414 49.3394 8.0936L45.8338 4.58537L45.6626 4.33666C45.6609 4.33502 45.4058 4.1176 45.0833 4.1176H31.9166C31.6648 4.1176 31.2994 4.41078 31.2188 4.49807L31.0953 4.65619L27.6605 8.09196C25.5126 10.2414 22.9056 10.6284 22.4053 10.6828L15.5735 10.6927C15.534 10.696 15.4961 10.7058 15.4583 10.7058H12.1666C12.1435 10.7058 12.1238 10.6993 12.1008 10.6993L7.22909 10.7058C5.41209 10.7058 3.93742 12.1816 3.93742 14V50.2352C3.93742 52.0536 5.41209 53.5294 7.22909 53.5294H69.7708C71.5878 53.5294 73.0624 52.0536 73.0624 50.2352V14ZM38.4999 50.2352C28.5015 50.2352 20.3958 42.1235 20.3958 32.1176C20.3958 22.1117 28.5015 14 38.4999 14C48.4984 14 56.6041 22.1117 56.6041 32.1176C56.6041 42.1235 48.4984 50.2352 38.4999 50.2352ZM38.4999 17.2941C30.3185 17.2941 23.6874 23.9301 23.6874 32.1176C23.6874 40.3051 30.3185 46.9411 38.4999 46.9411C46.6814 46.9411 53.3124 40.3051 53.3124 32.1176C53.3124 23.9301 46.6814 17.2941 38.4999 17.2941ZM38.4999 40.3529C33.9541 40.3529 30.2708 36.6668 30.2708 32.1176C30.2708 27.5684 33.9541 23.8823 38.4999 23.8823C43.0457 23.8823 46.7291 27.5684 46.7291 32.1176C46.7291 36.6668 43.0457 40.3529 38.4999 40.3529ZM38.4999 27.1764C35.7744 27.1764 33.5624 29.3901 33.5624 32.1176C33.5624 34.8468 35.7744 37.0588 38.4999 37.0588C41.2271 37.0588 43.4374 34.8468 43.4374 32.1176C43.4374 29.3901 41.2271 27.1764 38.4999 27.1764ZM15.4583 20.5882H8.87492C7.96477 20.5882 7.22909 19.852 7.22909 18.9411V15.647C7.22909 14.7378 7.96477 14 8.87492 14H15.4583C16.3684 14 17.1041 14.7378 17.1041 15.647V18.9411C17.1041 19.852 16.3684 20.5882 15.4583 20.5882Z" fill="#C5C5C5"/>
        </svg>
    <? endif; ?>
</div>
<? include 'include/product__info.php' ?>
<script>
    init_product_offers(<?= $arItem['ID'] ?>, JSON.parse('<?= json_encode($arOffers_json)?>'))
</script>
