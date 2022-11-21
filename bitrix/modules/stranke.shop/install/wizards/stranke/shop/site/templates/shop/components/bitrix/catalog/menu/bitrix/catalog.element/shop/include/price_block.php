<? global $USER; ?>

<div class="product-card__price-reduction">
    <a href="javascript:void(0)" class="price-reduction js-openModalCheaper">
        <div class="price-reduction__text">
            <?= GetMessage('ST_PRICE_REDUCTION') ?>
        </div>
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 16C12.4112 16 16 12.4112 16 8C16 3.58877 12.4112 0 8 0C3.58877 0 0 3.58877 0 8C0 12.4112 3.58877 16 8 16ZM8 0.713376C12.0179 0.713376 15.2866 3.98209 15.2866 8C15.2866 12.0179 12.0179 15.2866 8 15.2866C3.98209 15.2866 0.713376 12.0179 0.713376 8C0.713376 3.98209 3.98209 0.713376 8 0.713376Z" fill="#1CB43D"/>
            <path d="M6.02789 7.28059C6.84377 7.28059 7.505 6.61917 7.505 5.80348C7.5052 4.9876 6.84377 4.32617 6.02789 4.32617C5.21201 4.32617 4.55078 4.9876 4.55078 5.80328C4.55158 6.61877 5.21241 7.2796 6.02789 7.28059ZM6.02789 5.03955C6.44967 5.03955 6.79163 5.38151 6.79163 5.80328C6.79182 6.22526 6.44987 6.56721 6.02789 6.56721C5.60612 6.56721 5.26416 6.22526 5.26416 5.80328C5.26456 5.38171 5.60631 5.04014 6.02789 5.03955Z" fill="#1CB43D"/>
            <path d="M8.40527 10.2859C8.40527 11.1018 9.0667 11.763 9.88238 11.763C10.6983 11.763 11.3597 11.1018 11.3597 10.2859C11.3597 9.47002 10.6983 8.80859 9.88238 8.80859C9.0669 8.80959 8.40627 9.47042 8.40527 10.2859ZM10.6463 10.2859C10.6463 10.7077 10.3044 11.0496 9.88238 11.0496C9.4606 11.0496 9.11865 10.7077 9.11865 10.2859C9.11865 9.86413 9.4606 9.52217 9.88238 9.52197C10.3042 9.52257 10.6457 9.86413 10.6463 10.2859Z" fill="#1CB43D"/>
            <path d="M5.28397 12.1638C5.44898 12.2715 5.67012 12.2249 5.7776 12.0599L10.8198 4.32862C10.8897 4.22174 10.8972 4.08579 10.8397 3.97194C10.782 3.85808 10.6679 3.78364 10.5405 3.77687C10.4132 3.7701 10.2917 3.83181 10.2223 3.93889L5.18007 11.6702C5.07239 11.8354 5.11897 12.0563 5.28397 12.1638Z" fill="#1CB43D"/>
        </svg>
    </a>
</div>
<div class="product__price" role="price">
    <? if (!empty($arOffer['MIN_PRICE']) && ($arOffer['MIN_PRICE']['DISCOUNT_DIFF'])): ?>
        <div role="price_old" class="product__price-old"><?= $arOffer['MIN_PRICE']['PRINT_VALUE'] ?></div>
    <? endif ?>
    <? if (!empty($arOffer['MIN_PRICE'])): ?>
        <div role="price_value" class="product__price-value"><?= $arOffer['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?></div>
    <? endif ?>
</div>
