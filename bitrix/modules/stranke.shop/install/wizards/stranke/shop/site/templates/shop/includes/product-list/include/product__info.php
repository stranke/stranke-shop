<?global $app?>
<div class="product__info_contents_2">
    <div class="product__info">
        <div class="products__item-data">
            <div class="product__info_contents_3">
                <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="name">
                    <?= $arItem['~NAME'] ?>
                </a>
            </div>
            <div class="product__info_contents_1">
                <? if (empty($arOffers)) { ?>
                    <? include 'product.php' ?>
                <? } else { ?>
                    <? include 'sku.php' ?>
                <? } ?>

                <div class="description">
                    <?= $arItem['~PREVIEW_TEXT'] ?>
                </div>
            </div>
            <? if ($arItem['PROPERTIES']['PROMO']['VALUE']): ?>
                <div class="product__info-promo">
                    <?= $arItem['PROPERTIES']['PROMO']['~VALUE'] ?>
                </div>
            <? endif; ?>
        </div>
        <div class="products__item-buyblock">
            <? include 'price_block.php' ?>
            <div class="products__item-buyblock-btn-over">
                <? if ($arItem['CATALOG_AVAILABLE'] === 'Y'): ?>
                    <? if (empty($arItem['OFFERS'])): ?>
                        <? if (empty($arItem['MIN_PRICE'])): ?>
                            <div role="buy_btn" class="btn bg_main product__buy-btn product__buy-btn_not-available"><?= GetMessage('CT_BCE_CATALOG_NOT_AVAILABLE') ?></div>
                        <? else: ?>
                            <div role="buy_btn" class="btn bg_main product__buy-btn product__buy-btn_offers_none js-productBtn">
                                <svg width="21" height="26" viewBox="0 0 21 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.9282 25H1.53333C1.24615 25 1 24.7538 1 24.4666V7.68714C1 7.39996 1.24615 7.15381 1.53333 7.15381H18.9282C19.2154 7.15381 19.4615 7.39996 19.4615 7.68714V24.4666C19.4615 24.7538 19.2154 25 18.9282 25Z" stroke="white" stroke-width="1.23" stroke-miterlimit="10"/>
                                    <path d="M4.89746 7.15385C4.89746 1 10.2308 1 10.2308 1C10.2308 1 15.5641 1 15.5641 7.15385" stroke="white" stroke-width="1.23" stroke-miterlimit="10"/>
                                    <line x1="10.5" y1="13" x2="10.5" y2="20" stroke="white"/>
                                    <line x1="7" y1="16.5" x2="14" y2="16.5" stroke="white"/>
                                </svg>
                                <?= GetMessage('CT_BCE_CATALOG_ADD') ?>
                            </div>
                        <? endif ?>
                    <? elseif (!$arItem['OFFER_ID']): ?>
                        <div role="buy_btn" class="btn bg_main product__buy-btn product__buy-btn_offers_none js-productBtn"><?= GetMessage('CT_BCE_CATALOG_SELECT_OFFER') ?></div>
                    <? elseif ($arOffer['CATALOG_QUANTITY'] > 0 || $arOffer['PRODUCT']['CAN_BUY_ZERO'] == 'Y'): ?>
                        <div role="buy_btn" class="btn bg_main product__buy-btn js-productBtn">
                            <svg width="21" height="26" viewBox="0 0 21 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.9282 25H1.53333C1.24615 25 1 24.7538 1 24.4666V7.68714C1 7.39996 1.24615 7.15381 1.53333 7.15381H18.9282C19.2154 7.15381 19.4615 7.39996 19.4615 7.68714V24.4666C19.4615 24.7538 19.2154 25 18.9282 25Z" stroke="white" stroke-width="1.23" stroke-miterlimit="10"/>
                                <path d="M4.89746 7.15385C4.89746 1 10.2308 1 10.2308 1C10.2308 1 15.5641 1 15.5641 7.15385" stroke="white" stroke-width="1.23" stroke-miterlimit="10"/>
                                <line x1="10.5" y1="13" x2="10.5" y2="20" stroke="white"/>
                                <line x1="7" y1="16.5" x2="14" y2="16.5" stroke="white"/>
                            </svg>
                            <?= GetMessage('CT_BCE_CATALOG_ADD') ?></div>
                    <? else: ?>
                        <div role="buy_btn" class="btn bg_main product__buy-btn product__buy-btn_not-available js-productBtn"><?= GetMessage('CT_BCE_CATALOG_NO_AVAILABLE') ?></div>
                    <? endif ?>
                <? else: ?>
                    <div role="buy_btn" class="btn bg_main product__buy-btn"><?= GetMessage('CT_BCE_CATALOG_NOT_AVAILABLE') ?></div>
                <? endif ?>


                <?if($app->config->stock_balance == 'Y'){?>
                    <? $av_yes = $arItem["CATALOG_QUANTITY"] > 0; ?>
                    <div class="info-quantity" role="quantity_info">
                        <? if (!$av_yes): ?>
                            <span class="unavailable"><?= GetMessage('CT_BCE_CATALOG_NO_AVAILABLE') ?></span>
                        <? else: ?>
                            <?= GetMessage('CT_BCE_CATALOG_COUNT_AVAILABLE') ?>:
                            <span class="available"><?= $arItem["CATALOG_QUANTITY"]; ?> <?= GetMessage('CT_BCE_CATALOG_COUNT_IZM') ?></span>
                        <? endif; ?>
                    </div>
                <?}?>

            </div>
        </div>
    </div>
</div>
<script>
    function targetaddtobasket (){
        <?=$app->config->targetaddtobasket?>
    }
</script>