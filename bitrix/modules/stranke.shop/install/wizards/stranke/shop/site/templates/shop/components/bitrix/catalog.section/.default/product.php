<?
/**
 * @var $arItem
 */
?>
<div class="products__item" itemscope itemtype="http://schema.org/Product">
    <div class="products__item-img"
         data-href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
        <canvas width="2" height="1"></canvas>
        <img itemprop="image"
             src="<?=$arItem['IMG']['src']?>"
             alt="<?=$arItem['IMG']['ALT']?>"
             title="<?=$arItem['IMG']['TITLE']?>"
        >

        <?include 'include/products__item-stars.php'?>
        <?include 'include/products__mark-list.php'?>
    </div>

    <div class="products__item-info">
        <div class="products__item-info-block-1">
            <div class="products__item-name">
                <a itemprop="url" href="<?=$arItem['DETAIL_PAGE_URL']?>">
                    <span itemprop="name"><?=$arItem["NAME"]?></span>
                </a>
            </div>

            <?if (empty($arItem['OFFERS'])):?>
                <div class="products__item-offer-list">
                    <?if (empty($arItem['OFFERS'])):?>
                        <div class="products__item-offer-price products__item-offer-price_product">
                            <?if (!empty($arItem['DISPLAY_OLD_PRICE'])):?>
                                <span class="products__item-offer-price-old"><?=$arItem['DISPLAY_OLD_PRICE']?></span>
                            <?endif?>

                            <?if (!empty($arItem['DISPLAY_PRICE'])):?>
                                <span><?=$arItem['DISPLAY_PRICE']?></span>
                            <?endif?>
                        </div>
                    <?endif?>

                    <div class="products__item-offer products__item-offer_selected"
                         data-productid="<?= $arItem['ID'] ?>">
                        <?if (!empty($arItem['CATALOG_WEIGHT'])):?>
                            <div class="products__item-offer-weight">
                                <span>
                                    <?=$arItem['CATALOG_WEIGHT']?>
                                    <?=$arItem['CATALOG_MEASURE_NAME']?>
                                </span>
                            </div>
                        <?endif?>
                    </div>
                </div>
            <?else:?>
                <div class="products__item-offer-list">
                    <?foreach ($arItem['OFFERS'] as $index => $arOffer):?>
                        <?
                        $className = 'products__item-offer';
                        if ($index === 0) {
                            $className .= ' products__item-offer_selected';
                        }
                        ?>
                        <div class="<?=$className?>"
                             itemprop="offers" itemscope itemtype="http://schema.org/Offer"
                             data-productid="<?= $arOffer['ID'] ?>"
                             role="offer"
                        >
                            <?if ($_SERVER['HTTPS'] == 'on') { $http = 'https://'; } else { $http = 'http://'; }?>
                            <meta itemprop="url" content="<?= $http.$_SERVER['SERVER_NAME'].$arItem['DETAIL_PAGE_URL']?>">

                            <span class="products__item-offer-icon"></span>
                            <div class="products__item-offer-weight">
                                <span><?=$arOffer['DISPLAY_NAME']?></span>
                            </div>

                            <div class="products__item-offer-price">
                                <meta itemprop="price" content="<?=$arOffer['MIN_PRICE']['VALUE']?>">
                                <meta itemprop="priceCurrency" content="RUB">
                                <link style="display: none;" itemprop="availability" href="http://schema.org/InStock">

                                <?if (!empty($arOffer['DISPLAY_OLD_PRICE'])):?>
                                    <span class="products__item-offer-price-old"><?=$arOffer['DISPLAY_OLD_PRICE']?></span>
                                <?endif?>

                                <?if (!empty($arOffer['DISPLAY_PRICE'])):?>
                                    <span><?=$arOffer['DISPLAY_PRICE']?></span>
                                <?endif?>
                            </div>
                        </div>
                    <?endforeach?>
                </div>
            <?endif?>
        </div>

        <div class="products__item-info-block-2">
            <?if ($arItem['CATALOG_AVAILABLE'] === 'Y'):?>
                <?if (empty($arItem['MIN_PRICE'])):?>
                    <div class="products__item-not-available">
                        <?=GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE')?>
                    </div>
                <?else:?>
                    <div class="products__item-btn js-productBtn">
                        <div class="products__item-btn-text"><?=GetMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET')?></div>
                    </div>
                <?endif?>
            <?else:?>
                <div class="products__item-not-available">
                    <?=GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE')?>
                </div>
            <?endif?>

            <?
            $ingredients = $arItem['PREVIEW_TEXT'];
            $time = $arItem['PROPERTIES']['TIME']['VALUE'];
            ?>
            <div class="products__item-properties">
                <? if (!empty($ingredients)) { ?>
                    <div class="products__item-consist-btn js-productConsistBtn">
                        <span><?=GetMessage('ST_CATALOG_SECTION_CONSIST')?></span>
                        <i class="fas fa-chevron-down"></i>
                    </div>

                    <div class="products__item-consist">
                        <span><?=$ingredients?></span>
                    </div>
                <? } ?>

                <? if (!empty($time)) { ?>
                    <div class="products__item-time-btn js-productTimeBtn">
                        <i class="far fa-clock"></i>
                        <span><?=$time?></span>
                    </div>

                    <div class="products__item-time">
                        <span><?=GetMessage('ST_CATALOG_SECTION_TIME')?> - <?= $time ?></span>
                    </div>
                <? } ?>

            </div>
        </div>
    </div>
</div>