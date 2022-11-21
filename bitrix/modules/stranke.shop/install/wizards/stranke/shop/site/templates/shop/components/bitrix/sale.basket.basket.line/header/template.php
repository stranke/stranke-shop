<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<? $this->setFrameMode(true); ?>
<div id="basket_items_block">
    <?php $frame = $this->createFrame("basket_items_block", false)->begin(); ?>
    <?
    global $arBasketItems;
    $arBasketItems = array();
    $cart_price = intval(str_replace(array(' ', 'Р', 'р'), '', $arResult['TOTAL_PRICE']));
    $cart_count = 0;
    $dbBasketItems = CSaleBasket::GetList(array("NAME" => "ASC", "ID" => "ASC"), array('ACTIVE' => 'Y', 'CAN_BUY' => "Y", "FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL"), false, false, array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "DELAY", "CAN_BUY", "PRICE", "WEIGHT", 'ACTIVE', 'DISCOUNT_PRICE'));
    while ($arbasketItems = $dbBasketItems->Fetch()) {
        $arBasketItems[] = $arbasketItems;
        $cart_count += $arbasketItems["QUANTITY"];
    }
    $_SESSION['cart_price'] = $cart_price;
    $APPLICATION->set_cookie('cart_price', $cart_price);
    ?>
    <a href="javascript:void(0)" onclick="window.location.href = '<?php echo $arParams['PATH_TO_BASKET'] ?>'" class="cart_link plavno <? echo $arResult["NUM_PRODUCTS"] > 0 ? ' have_items' : '' ?>">
        <div class="right-block__basket-btn">
            <div class="right-block__login-btn-user-icon">
                <svg width="21" height="26" viewBox="0 0 21 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18.9282 25H1.53333C1.24615 25 1 24.7538 1 24.4666V7.68714C1 7.39996 1.24615 7.15381 1.53333 7.15381H18.9282C19.2154 7.15381 19.4615 7.39996 19.4615 7.68714V24.4666C19.4615 24.7538 19.2154 25 18.9282 25Z" stroke="black" stroke-width="1.23" stroke-miterlimit="10"/>
                    <path d="M4.8974 7.15385C4.8974 1 10.2307 1 10.2307 1C10.2307 1 15.5641 1 15.5641 7.15385" stroke="black" stroke-width="1.23" stroke-miterlimit="10"/>
                </svg>
                <? if ($cart_count > 0): ?>
                    <span class="right-block__basket-num_products"><?= $cart_count//$arResult['NUM_PRODUCTS']             ?></span>
                <? endif; ?>
            </div>
            <? if ($cart_count > 0) { ?>
                <div class="right-block__basket-price">
                    <? /*<div class="right-block__basket-num"><?= GetMessage("TSB1_YOUR_CART_1") ?>:
                        <span class="right-block__basket-num_products"><?= $cart_count//$arResult['NUM_PRODUCTS']         ?></span>
                    </div>
                    <div class="right-block__basket-price"><?= GetMessage("TSB1_YOUR_CART_2") ?>
                        <span class="right-block__basket-total_price"><?= $arResult['TOTAL_PRICE'] ?></span>
                    </div>*/ ?>
                    <?= $arResult['TOTAL_PRICE'] ?>
                    <?
                    $this->SetViewTarget('basket_price');
                    echo $arResult['TOTAL_PRICE'];
                    $this->EndViewTarget();
                    ?>
                    <?
                    $this->SetViewTarget('basket_count');
                    echo $cart_count . ' ' . decl($cart_count, array(GetMessage("TSB1_YOUR_TOVAR_1"), GetMessage("TSB1_YOUR_TOVAR_2"), GetMessage("TSB1_YOUR_TOVAR_5")));
                    $this->EndViewTarget();
                    ?>
                </div>
            <? } else { ?>
                <span class="show_desktop"><?= GetMessage("TSB1_NO_CART") ?></span>
                <span class="show_mobile"><?= GetMessage("TSB1_NO_CART_mobule") ?></span>
            <? } ?>
        </div>
    </a>
    <?php $frame->beginStub(); ?>
    <a href="javascript:void(0)" onclick="window.location.href = '<?php echo $arParams['PATH_TO_BASKET'] ?>'" class="cart_link no_item">
        <div class="right-block__basket-btn">
            <div class="right-block__login-btn-user-icon">
                <svg width="21" height="26" viewBox="0 0 21 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.2 21.126C9.06133 21.126 8.19333 20.692 7.596 19.824C7.008 18.9467 6.714 17.6913 6.714 16.058C6.714 14.9473 6.84467 14.0187 7.106 13.272C7.37667 12.5253 7.76867 11.9607 8.282 11.578C8.80467 11.1953 9.444 11.004 10.2 11.004C11.348 11.004 12.216 11.4333 12.804 12.292C13.392 13.1413 13.686 14.392 13.686 16.044C13.686 17.136 13.5507 18.06 13.28 18.816C13.0187 19.572 12.6313 20.146 12.118 20.538C11.6047 20.93 10.9653 21.126 10.2 21.126ZM10.2 20.02C10.9467 20.02 11.502 19.698 11.866 19.054C12.23 18.41 12.412 17.4067 12.412 16.044C12.412 14.6813 12.23 13.6873 11.866 13.062C11.5113 12.4273 10.956 12.11 10.2 12.11C9.45333 12.11 8.898 12.4273 8.534 13.062C8.17 13.6873 7.988 14.6813 7.988 16.044C7.988 17.4067 8.17 18.41 8.534 19.054C8.898 19.698 9.45333 20.02 10.2 20.02Z" fill="black"/>
                    <path d="M18.9282 25H1.53333C1.24615 25 1 24.7538 1 24.4666V7.68714C1 7.39996 1.24615 7.15381 1.53333 7.15381H18.9282C19.2154 7.15381 19.4615 7.39996 19.4615 7.68714V24.4666C19.4615 24.7538 19.2154 25 18.9282 25Z" stroke="black" stroke-width="1.23" stroke-miterlimit="10"/>
                    <path d="M4.89746 7.15385C4.89746 1 10.2308 1 10.2308 1C10.2308 1 15.5641 1 15.5641 7.15385" stroke="black" stroke-width="1.23" stroke-miterlimit="10"/>
                </svg>

            </div>

            <? if ($arResult['NUM_PRODUCTS'] > 0) { ?>

                <div class="right-block__basket-price">

                </div>

            <? } else { ?>
                <span class="show_desktop"><?= GetMessage("TSB1_NO_CART") ?></span>
                <span class="show_mobile"><?= GetMessage("TSB1_NO_CART_mobule") ?></span>
            <? } ?>
        </div>
    </a>
    <?php $frame->end(); ?>
</div>
