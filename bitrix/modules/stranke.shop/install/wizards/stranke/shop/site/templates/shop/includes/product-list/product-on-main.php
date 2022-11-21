<div class="goods__item">
    <?
    if ($arItem['PREVIEW_PICTURE'] > 0) {
        $file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width' => 237, 'height' => 196), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    } else {
        $file = CFile::ResizeImageGet($arItem['DETAIL_PICTURE'], array('width' => 237, 'height' => 196), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    }
    ?>
    <div onclick="document.location.href = '<? echo $arItem["DETAIL_PAGE_URL"] ?>'" class="goods__item-photo image_loading">
        <? require 'product_shilds.php'?>
        <canvas width="237" height="196"></canvas>
        <img src="<?= $file['src'] ?>" alt="">
    </div>
    <div class="goods__item-name">
        <a href="<? echo $arItem["DETAIL_PAGE_URL"] ?>" class="bx_rcm_view_link" data-product-id="<?= $arItem['ID'] ?>"><? echo $arItem["NAME"] ?></a>
    </div>
    <div class="goods__item-info">
    </div>
    <div class="goods__item-price">
        <? if ($arItem['HAS_OFFERS'] || !empty($arItem["OFFERS"])) {
            echo GetMessage('ST_PRODUCT_PRICE_FROM');
        } ?>
        <? if (!empty($arItem["OFFERS"])): ?>
            <?php echo $arItem["OFFERS"][0]["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"]; ?>
        <? elseif (is_array($arItem["PRICE"])): ?>
            <?php echo $arItem["PRICE"]["RESULT_PRICE"]["PRINT_DISCOUNT_VALUE"]; ?>
        <? elseif (is_array($arItem["MIN_PRICE"])): ?>
            <?php echo $arItem["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"]; ?>
        <? else: ?>
            <?php echo GetMessage('ST_NO_PRODUCT_PRICE') ?>
        <? endif; ?>
    </div>
</div>
