<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>


<div class="text_pages_gala">
    <div class="left_side">
        <p class="titleH2"><?=GetMessage('ST_ORDER_LIST_CURRENT')?></p>
        <ul>
            <?php if ($USER->IsAuthorized()): ?>
                <li><a href="<?=SITE_DIR?>personal/" ><?=GetMessage('ST_ORDER_LIST_PROFILE')?></a></li>
                <li><a href="<?=SITE_DIR?>personal/order/" class="active"><?=GetMessage('ST_ORDER_LIST_HISTORY')?></a></li>
            <?php endif; ?>
            <li><a href="<?=SITE_DIR?>personal/cart/"><?=GetMessage('ST_ORDER_LIST_BASKET')?></a></li>
            <li><a href="<?=SITE_DIR?>personal/subscribe/"><?=GetMessage('ST_ORDER_LIST_SUBSCRIBE')?></a></li>
            <?php if ($USER->IsAuthorized()): ?>
                <li><a class="log_out_img" href="/logout/"><?=GetMessage('ST_ORDER_LIST_LOGOUT')?></a></li>
            <?php endif; ?>
        </ul>
    </div>
    <?php
    $showCurrentWorks = 0;
    foreach ($arResult["ORDER_BY_STATUS"] as $key => $group) {
        foreach ($group as $k => $order):
            if ($key != "F") {
                $showCurrentWorks++;
            }
        endforeach;
    }
    if ($showCurrentWorks):
        ?>
        <div class="right_side">
            <p class="titleH1"><?=GetMessage('ST_ORDER_LIST_CURRENT')?></p>
            <? if (!empty($arResult['ERRORS']['FATAL'])): ?>
                <? foreach ($arResult['ERRORS']['FATAL'] as $error): ?>
                    <?= ShowError($error) ?>
                <? endforeach ?>
            <? else: ?>
                <? if (!empty($arResult['ERRORS']['NONFATAL'])): ?>
                    <? foreach ($arResult['ERRORS']['NONFATAL'] as $error): ?>
                        <?= ShowError($error) ?>
                    <? endforeach ?>
                <? endif ?>
                <? if (!empty($arResult['ORDERS'])): ?>
                    <table class="orders_table">
                        <thead>
                            <tr>
                                <td class="number_table">№</td>
                                <td class="data_table"><?=GetMessage('ST_ORDER_LIST_DATE')?></td>
                                <td class="structure_table"><?=GetMessage('ST_ORDER_LIST_CONSIST')?></td>
                                <td class="comment_table"><?=GetMessage('ST_ORDER_LIST_COMMENT')?></td>
                                <td class="status_table"><?=GetMessage('ST_ORDER_LIST_STATUS')?></td>
                            </tr>
                        </thead>     
                        <?
                        foreach ($arResult["ORDER_BY_STATUS"] as $key => $group):
                            if ($key != "F"):
                                ?>                       
                                <? foreach ($group as $k => $order): ?>
                                    <tr <? echo $key == "F" ? 'class="gray_row"' : '' ?> id="order_<? echo $order["ORDER"]["ACCOUNT_NUMBER"] ?>">
                                        <td><? echo $order["ORDER"]["ACCOUNT_NUMBER"] ?></td>
                                        <td><? echo $order["ORDER"]["DATE_INSERT_FORMATED"]; ?></td>
                                        <td>
                                            <table class="order_items">
                                                <? foreach ($order["BASKET_ITEMS"] as $item): ?>
                                                    <?
                                                    $offersExist = CCatalogSku::GetProductInfo($item["PRODUCT_ID"]);
                                                    if (!is_array($offersExist)) {
                                                        $arIblockres = CIBlockElement::GetByID($item["PRODUCT_ID"]);
                                                        $arIblockItem = $arIblockres->GetNext();
                                                        $NAME = $arIblockItem["NAME"];
                                                    } else {
                                                        $arIblockres = CIBlockElement::GetByID($offersExist["ID"]);
                                                        $arIblockOfferres = CIBlockElement::GetByID($item["PRODUCT_ID"]);
                                                        $arIblockOfferItem = $arIblockOfferres->GetNext();
                                                        $arIblockItem = $arIblockres->GetNext();
                                                        $NAME = $arIblockItem["NAME"] . " " . $arIblockOfferItem["NAME"];
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <? if (strlen($item["DETAIL_PAGE_URL"]) && $key != "F"): ?>
                                                                <a href="<? echo $arIblockItem["DETAIL_PAGE_URL"] ?>" target="_blank">
                                                                    <? echo $NAME ?>
                                                                </a>
                                                            <? else: ?>
                                                                <? echo $NAME ?>
                                                            <? endif; ?>
                                                            ,&nbsp;<? echo $item['QUANTITY'] ?> шт,&nbsp;
                                                            <? echo CurrencyFormat($item["PRICE"], 'RUB'); ?>
                                                        </td>
                                                    </tr>
                                                <? endforeach; ?>
                                            </table>
                                            <div class="pay_syst"><?php echo $arResult["INFO"]["PAY_SYSTEM"][$order["ORDER"]["PAY_SYSTEM_ID"]]["NAME"]; ?></div>
                                            </br><div class="price_block"><b><span><?=GetMessage('ST_ORDER_LIST_TOTAL')?></span>&nbsp;&nbsp;<? echo $order["ORDER"]["FORMATED_PRICE"] ?></b></div>
                                        </td>
                                        <td style="font-size: 12px;  padding-top: 13px;"><? echo $order["ORDER"]["USER_DESCRIPTION"] ?></td>
                                        <td class="pay_system">
                                            <div><? echo $arResult["INFO"]["STATUS"][$key]["NAME"] ?></div> 

                                            <? if ($order["BASKET_ITEMS"][0]["ORDER_PAYED"] == "Y"): ?>
                                                <div>  <? echo GetMessage('SPOL_PAYED') ?></div>
                                            <? else: ?>
                                                <div class="wrapper_btn">
                                                    <div class="pay_btn">
                                                        <?
                                                        $arPaySys = CSalePaySystem::GetByID($order["ORDER"]["PAY_SYSTEM_ID"], $order["ORDER"]["PERSON_TYPE_ID"]);
                                                        $arPaySysAction = CSalePaySystemAction::GetByID($arPaySys["PSA_ID"]);
                                                        ?>
                                                        <?
                                                        CSalePaySystemAction::InitParamArrays($order, $order["ORDER"]["ID"]);
                                                        //include($_SERVER['DOCUMENT_ROOT'] . $arPaySys["PSA_ACTION_FILE"] . '/payment_list.php');


                                                        include($_SERVER['DOCUMENT_ROOT'] . $arPaySys["PSA_ACTION_FILE"] . '/payment.php');
                                                        ?>
                                                    </div>

                                                    <div class="pay_btn"><?=GetMessage('ST_ORDER_LIST_NOT_PAID')?></div>
                                                    
                                                </div>

                                            <? endif; ?>
                                            <? if ($order["ORDER"]["CANCELED"] != "Y" && $key != "F"): ?>
                                                <div class="remove_order">
                                                    <a href="<?= $order["ORDER"]["URL_TO_CANCEL"] ?>" class="violet_text "><? echo GetMessage('SPOL_CANCEL_ORDER') ?></a>
                                                </div>
                                            <? endif ?>
                                        </td>

                                    </tr>
                                    <?
                                endforeach;
                            endif;
                            ?>            
                        <? endforeach; ?>
                    </table>

                    <? if (strlen($arResult['NAV_STRING'])): ?>
                        <?= $arResult['NAV_STRING'] ?>
                    <? endif ?>
                <? else: ?>
                    <? echo GetMessage('SPOL_NO_ORDERS') ?>
                <? endif ?>
            <? endif; ?>
        </div>
        <?php
    endif;
    $showCompletedWorks = 0;

    foreach ($arResult["ORDER_BY_STATUS"] as $key => $group) {
        foreach ($group as $k => $order):
            if ($key == "F") {
                $showCompletedWorks++;
            }
        endforeach;
    }

    if ($showCompletedWorks > 0):
        ?>

        <div class="right_side">
            <p class="titleH1"><?=GetMessage('ST_ORDER_LIST_FINISHED')?></p>
            <? if (!empty($arResult['ERRORS']['FATAL'])): ?>
                <? foreach ($arResult['ERRORS']['FATAL'] as $error): ?>
                    <?= ShowError($error) ?>
                <? endforeach ?>
            <? else: ?>
                <? if (!empty($arResult['ERRORS']['NONFATAL'])): ?>
                    <? foreach ($arResult['ERRORS']['NONFATAL'] as $error): ?>
                        <?= ShowError($error) ?>
                    <? endforeach ?>
                <? endif ?>

                <? if (!empty($arResult['ORDERS'])): ?>
                    <?php
                    //текущие заказы 
                    $currentWorks = 0;
                    ?>
                    <table class="orders_table">
                        <thead>
                            <tr>
                                <td class="number_table">№</td>
                                <td class="data_table"><?=GetMessage('ST_ORDER_LIST_DATE')?></td>
                                <td class="structure_table"><?=GetMessage('ST_ORDER_LIST_CONSIST')?></td>
                                <td class="comment_table"><?=GetMessage('ST_ORDER_LIST_COMMENT')?></td>
                                <td class="status_table"><?=GetMessage('ST_ORDER_LIST_STATUS')?></td>
                            </tr>
                        </thead>       
                        <?
                        foreach ($arResult["ORDER_BY_STATUS"] as $key => $group):
                            if ($key == "F"):
                                ?>
                                <? foreach ($group as $k => $order): ?>
                                    <tr <? echo $key == "F" ? 'class="gray_row"' : '' ?> id="order_<? echo $order["ORDER"]["ACCOUNT_NUMBER"] ?>">
                                        <td><? echo $order["ORDER"]["ACCOUNT_NUMBER"] ?></td>
                                        <td><? echo $order["ORDER"]["DATE_INSERT_FORMATED"]; ?></td>
                                        <td>
                                            <table class="order_items">
                                                <? foreach ($order["BASKET_ITEMS"] as $item): ?>
                                                    <?
                                                    $offersExist = CCatalogSku::GetProductInfo($item["PRODUCT_ID"]);
                                                    if (!is_array($offersExist)) {
                                                        $arIblockres = CIBlockElement::GetByID($item["PRODUCT_ID"]);
                                                        $arIblockItem = $arIblockres->GetNext();
//                                                $arItems["NAME"] = $arIblockItem["NAME"];
                                                        $NAME = $arIblockItem["NAME"];
                                                    } else {
                                                        $arIblockres = CIBlockElement::GetByID($offersExist["ID"]);
                                                        $arIblockOfferres = CIBlockElement::GetByID($item["PRODUCT_ID"]);
                                                        $arIblockOfferItem = $arIblockOfferres->GetNext();
                                                        $arIblockItem = $arIblockres->GetNext();
                                                        $NAME = $arIblockItem["NAME"] . " " . $arIblockOfferItem["NAME"];
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <? if (strlen($item["DETAIL_PAGE_URL"]) && $key != "F"): ?>
                                                                <a href="<? echo $arIblockItem["DETAIL_PAGE_URL"] ?>" target="_blank">
                                                                    <? echo $NAME ?>
                                                                </a>
                                                            <? else: ?>
                                                                <? echo $NAME ?>
                                                            <? endif; ?>
                                                            ,&nbsp;<? echo $item['QUANTITY'] ?> шт,&nbsp;
                                                            <? echo CurrencyFormat($item["PRICE"], 'RUB'); ?>
                                                        </td>
                                                    </tr>
                                                <? endforeach; ?>
                                            </table>
                                            <div class="pay_syst"><?php echo $arResult["INFO"]["PAY_SYSTEM"][$order["ORDER"]["PAY_SYSTEM_ID"]]["NAME"]; ?></div>
                                            </br><div class="price_block"><b><span><?=GetMessage('ST_ORDER_LIST_TOTAL')?></span>&nbsp;&nbsp;<? echo $order["ORDER"]["FORMATED_PRICE"] ?></b></div>
                                        </td>
                                        <td style="font-size: 12px;  padding-top: 13px;"><? echo $order["ORDER"]["USER_DESCRIPTION"] ?></td>
                                        <td class="pay_system">
                                            <div><? echo $arResult["INFO"]["STATUS"][$key]["NAME"] ?></div> 

                                            <? if ($order["BASKET_ITEMS"][0]["ORDER_PAYED"] == "Y"): ?>
                                                <div>  <? echo GetMessage('SPOL_PAYED') ?></div>
                                            <? else: ?>
                                                <div class="wrapper_btn">
                                                    <div class="pay_btn">
                                                        <?
                                                        $arPaySys = CSalePaySystem::GetByID($order["ORDER"]["PAY_SYSTEM_ID"], $order["ORDER"]["PERSON_TYPE_ID"]);
                                                        $arPaySysAction = CSalePaySystemAction::GetByID($arPaySys["PSA_ID"]);
                                                        ?>
                                                        <?
                                                        CSalePaySystemAction::InitParamArrays($order, $order["ORDER"]["ID"]);
                                                        //  include($_SERVER['DOCUMENT_ROOT'] . $arPaySys["PSA_ACTION_FILE"] . '/payment.php');
                                                        include($_SERVER['DOCUMENT_ROOT'] . $arPaySys["PSA_ACTION_FILE"] . '/payment_list.php');
                                                        //include($_SERVER['DOCUMENT_ROOT'] . "PortKKM_vsevset_gala" . '/payment.php');
                                                        ?>
                                                    </div>
                                                    <div class="pay_btn"><?=GetMessage('ST_ORDER_LIST_NOT_PAID')?></div>
                                                </div>

                                            <? endif; ?>
                                            <? if ($order["ORDER"]["CANCELED"] != "Y" && $key != "F"): ?>
                                                <div class="remove_order">
                                                    <a href="<?= $order["ORDER"]["URL_TO_CANCEL"] ?>" class="violet_text "><? echo GetMessage('SPOL_CANCEL_ORDER') ?></a>
                                                </div>
                                            <? endif ?>
                                        </td>

                                    </tr>
                                    <?
                                endforeach;
                            endif;
                            ?>            
                        <? endforeach; ?>
                    </table>


                    <? if (strlen($arResult['NAV_STRING'])): ?>
                        <?= $arResult['NAV_STRING'] ?>
                    <? endif ?>
                <? else: ?>
                    <? echo GetMessage('SPOL_NO_ORDERS') ?>
                <? endif ?>
            <? endif; ?>
        </div>
    <?php endif; ?>
    <div class="clear"></div>
</div>
