<div class="product__data" product_id="<?= $arResult['ID'] ?>">
    <h1 class="product__title" itemprop="name"><?= $name ?></h1>
    <div class="product__info">
        <div class="product__info-offers">

            <? include 'product__rating.php' ?>
            <div class="product__info_contents_1">
                <? if (empty($arOffers)) { ?>
                    <? $arOffer = $arResult; ?>
                    <? include 'product.php' ?>
                <? } else { ?>
                    <? include 'sku.php' ?>
                    <?
                    if ($arResult['OFFER_INDX'] !== false) {
                        $arOffer = $arOffers[$arResult['OFFER_INDX']];
                    }
                    ?>
                <? } ?>
                <div class="product__info_contents_2">
                    <? include 'price_block.php' ?>
                    <div class="products__item-buyblock-btn-over">
                        <? if ($arResult['CATALOG_AVAILABLE'] === 'Y'): ?>
                            <? if (empty($arResult['OFFERS'])): ?>
                                <? if (empty($arResult['MIN_PRICE'])): ?>
                                    <div role="buy_btn" class="btn bg_main product__buy-btn product__buy-btn_not-available"><?= GetMessage('CT_BCE_CATALOG_NOT_AVAILABLE') ?></div>
                                <? else: ?>
                                    <div role="buy_btn" class="btn bg_main product__buy-btn product__buy-btn_offers_none js-productBtn">
                                        <?= GetMessage('CT_BCE_CATALOG_ADD') ?>
                                    </div>
                                <? endif ?>
                            <? elseif (!$arResult['OFFER_ID']): ?>
                                <div role="buy_btn" class="btn bg_main product__buy-btn product__buy-btn_not-available js-productBtn"><?= GetMessage('CT_BCE_CATALOG_SELECT_OFFER') ?></div>
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

                        <? $av_yes = $arResult["CATALOG_QUANTITY"] > 0; ?>
                        <div class="info-quantity" role="quantity_info">
                            <? if (!$av_yes): ?>
                                <span class="unavailable"><?= GetMessage('CT_BCE_CATALOG_NO_AVAILABLE') ?></span>
                            <? else: ?>
                                <?= GetMessage('CT_BCE_CATALOG_COUNT_AVAILABLE') ?>:
                                <span class="available"><?= $arResult["CATALOG_QUANTITY"]; ?> <?= GetMessage('CT_BCE_CATALOG_COUNT_IZM') ?></span>
                            <? endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product__info-delivery">
            <div class="product__info-delivery-row">
                <?= GetMessage('ST_DELIVERY_IN') ?><? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . '/includes/header/header_city.php') ?>
            </div>
            <div role="delivery_block" class="delivery_block"></div>
            <div class="product_delivery">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR . "include/product_delivery.php",
                        "AREA_FILE_RECURSIVE" => "N",
                        "EDIT_MODE" => "html",
                    ),
                    false,
                    Array('HIDE_ICONS' => 'Y')
                ); ?>
            </div>
            <div class="product__info-delivery-row">
                <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.5712 13.905C12.3935 13.905 12.2158 14.0666 12.2158 14.6078C12.2158 15.1491 12.3935 15.3106 12.5712 15.3106C12.749 15.3106 12.9267 15.1491 12.9267 14.6078C12.9267 14.0666 12.749 13.905 12.5712 13.905Z" fill="#EF4545"/>
                    <path d="M8.42769 11.2395C8.24998 11.2395 8.07227 11.4011 8.07227 11.9423C8.07227 12.4835 8.24998 12.6451 8.42769 12.6451C8.6054 12.6451 8.78312 12.4835 8.78312 11.9423C8.78312 11.4011 8.6054 11.2395 8.42769 11.2395Z" fill="#EF4545"/>
                    <path d="M16.6487 7.45009C14.8682 5.48358 13.8101 3.75247 13.2359 2.64649C12.614 1.44856 12.4102 0.705722 12.4087 0.699811L12.2236 0L11.5625 0.294875C11.4852 0.329318 9.65864 1.1623 8.63518 3.20919C8.12141 4.23676 8.01866 5.38083 8.02297 6.15958C8.02547 6.6128 7.70437 7.00632 7.25949 7.09528C6.94757 7.1576 6.62671 7.06063 6.40158 6.8355L5.17015 5.60407L4.74654 6.1882C4.70257 6.24883 3.66732 7.67657 3.47886 7.96184C2.55851 9.35502 2.07862 10.9779 2.09106 12.6551C2.10772 14.8951 2.98861 16.9937 4.57145 18.5644C6.15421 20.135 8.25955 21 10.4997 21C15.1363 21 18.9084 17.2278 18.9084 12.5912C18.9084 10.9101 18.0848 9.03625 16.6487 7.45009ZM12.5717 16.1833C11.7154 16.1833 11.0691 15.6178 11.0691 14.6081C11.0691 13.6064 11.7154 13.0328 12.5717 13.0328C13.428 13.0328 14.0742 13.6063 14.0742 14.6081C14.0742 15.6178 13.4279 16.1833 12.5717 16.1833ZM11.7477 10.4478H13.1129L9.25157 16.1025H7.88639L11.7477 10.4478ZM6.92512 11.9423C6.92512 10.9406 7.57136 10.3671 8.42766 10.3671C9.28396 10.3671 9.9302 10.9406 9.9302 11.9423C9.9302 12.952 9.28396 13.5175 8.42766 13.5175C7.57136 13.5175 6.92512 12.952 6.92512 11.9423Z" fill="#EF4545"/>
                </svg>
                <?= GetMessage('ST_BUY_SPEC') ?>
            </div>
            <div class="product_spec color_main">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR . "include/product_spec.php",
                        "AREA_FILE_RECURSIVE" => "N",
                        "EDIT_MODE" => "html",
                    ),
                    false,
                    Array('HIDE_ICONS' => 'Y')
                ); ?>
            </div>
        </div>
    </div>
</div>
