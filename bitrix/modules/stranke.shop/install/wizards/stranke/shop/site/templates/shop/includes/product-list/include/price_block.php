<? global $USER; ?>
<div class="product__price" role="price">
    <? if (!empty($arOffer['MIN_PRICE']) && ($arOffer['MIN_PRICE']['DISCOUNT_DIFF'])): ?>
        <div role="price_old" class="product__price-old"><?= $arOffer['MIN_PRICE']['PRINT_VALUE'] ?></div>
    <? endif ?>
    <? if (!empty($arOffer['MIN_PRICE'])): ?>
        <div role="price_value" class="product__price-value"><?= $arOffer['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?></div>
    <? endif ?>
</div>
