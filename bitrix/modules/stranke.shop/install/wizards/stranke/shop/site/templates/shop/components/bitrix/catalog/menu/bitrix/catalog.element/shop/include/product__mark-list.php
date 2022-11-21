<div class="product__mark-list mark-list">
    <?if ($arResult['IS_DISCOUNT']):?>
        <span class="mark-list__item mark-list__item_discount"><?=GetMessage('ST_PRODUCT_DETAIL_MARK_DISCOUNT')?></span>
    <?endif?>

    <?if ($arResult['PROPERTIES']['ST_SHILD_NEW']['VALUE']):?>
        <span class="mark-list__item mark-list__item_new"><?=GetMessage('ST_PRODUCT_DETAIL_MARK_NEW')?></span>
    <?endif?>

    <?if ($arResult['PROPERTIES']['ST_SHILD_HIT']['VALUE']):?>
        <span class="mark-list__item mark-list__item_hit"><?=GetMessage('ST_PRODUCT_DETAIL_MARK_HIT')?></span>
    <?endif?>
</div>