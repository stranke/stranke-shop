<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$APPLICATION->IncludeComponent("bitrix:news.detail", "banner_head_page", Array(
"IBLOCK_TYPE" => "site_banners",	// ��� ��������������� ����� (������������ ������ ��� ��������)
"IBLOCK_ID" => "13",	// ��� ��������������� �����
"ELEMENT_ID" => "360",	// ID �������
"ELEMENT_CODE" => "",	// ��� �������
"CHECK_DATES" => "Y",	// ���������� ������ �������� �� ������ ������ ��������
"FIELD_CODE" => array(	// ����
0 => "",
1 => "",
),
"PROPERTY_CODE" => array(	// ��������
0 => "",
1 => "",
),
"IBLOCK_URL" => "",	// URL �������� ��������� ������ ��������� (�� ��������� - �� �������� ���������)
"AJAX_MODE" => "N",	// �������� ����� AJAX
"AJAX_OPTION_JUMP" => "N",	// �������� ��������� � ������ ����������
"AJAX_OPTION_STYLE" => "Y",	// �������� ��������� ������
"AJAX_OPTION_HISTORY" => "N",	// �������� �������� ��������� ��������
"CACHE_TYPE" => "A",	// ��� �����������
"CACHE_TIME" => "3600",	// ����� ����������� (���.)
"CACHE_GROUPS" => "Y",	// ��������� ����� �������
"META_KEYWORDS" => "-",	// ���������� �������� ����� �������� �� ��������
"META_DESCRIPTION" => "-",	// ���������� �������� �������� �� ��������
"BROWSER_TITLE" => "-",	// ���������� ��������� ���� �������� �� ��������
"SET_STATUS_404" => "N",	// ������������� ������ 404, ���� �� ������� ������� ��� ������
"SET_TITLE" => "N",	// ������������� ��������� ��������
"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// �������� �������� � ������� ���������
"ADD_SECTIONS_CHAIN" => "N",	// �������� ������ � ������� ���������
"ADD_ELEMENT_CHAIN" => "N",	// �������� �������� �������� � ������� ���������
"ACTIVE_DATE_FORMAT" => "",	// ������ ������ ����
"USE_PERMISSIONS" => "N",	// ������������ �������������� ����������� �������
"PAGER_TEMPLATE" => "",	// ������ ������������ ���������
"DISPLAY_TOP_PAGER" => "N",	// �������� ��� �������
"DISPLAY_BOTTOM_PAGER" => "N",	// �������� ��� �������
"PAGER_TITLE" => "��������",	// �������� ���������
"PAGER_SHOW_ALL" => "N",	// ���������� ������ "���"
"DISPLAY_DATE" => "N",	// �������� ���� ��������
"DISPLAY_NAME" => "N",	// �������� �������� ��������
"DISPLAY_PICTURE" => "Y",	// �������� ��������� �����������
"DISPLAY_PREVIEW_TEXT" => "N",	// �������� ����� ������
"USE_SHARE" => "N",	// ���������� ������ ���. ��������
"AJAX_OPTION_ADDITIONAL" => "",	// �������������� �������������
),
false
);?>


<div class="text_pages">
    <div class="left_side">
        <h2>������ �������</h2>
        <ul>
            <li><a href="<?=SITE_DIR?>personal/">������ �������</a></li>
            <li><a href="<?=SITE_DIR?>personal/order/" class="active">������ �������</a></li>
            <li><a href="<?=SITE_DIR?>personal/cart/">�������</a></li>
            <li><a href="<?=SITE_DIR?>personal/subscribe/">���������� ���������</a></li>
        </ul>
    </div>
    <div class="right_side">
        <h1>������� �������</h1>

        <?if(!empty($arResult['ERRORS']['FATAL'])):?>

        <?foreach($arResult['ERRORS']['FATAL'] as $error):?>
        <?= ShowError($error) ?>
        <?endforeach?>

        <?else:?>

        <?if(!empty($arResult['ERRORS']['NONFATAL'])):?>

        <?foreach($arResult['ERRORS']['NONFATAL'] as $error):?>
        <?= ShowError($error) ?>
        <?endforeach?>

        <?endif?>

        <div class="bx_my_order_switch">
            <?$nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);?>
            <?if($nothing || $_REQUEST["show_all"] == "Y"):?>
            <a class="bx_mo_link active" href="<?= $arResult["CURRENT_PAGE"] ?>?show_all=Y"><?= GetMessage('SPOL_ORDERS_ALL') ?></a>
            <?else:?>
            <a class="bx_mo_link" href="<?= $arResult["CURRENT_PAGE"] ?>?show_all=Y"><?= GetMessage('SPOL_ORDERS_ALL') ?></a>
            <?endif?>

            <?if($_REQUEST["filter_history"] == 'Y' || $_REQUEST["show_all"] == 'N'):?>
            <a class="bx_mo_link active" href="<?= $arResult["CURRENT_PAGE"] ?>?filter_history=N"><?= GetMessage('SPOL_CUR_ORDERS') ?></a>
            <?else:?>
            <a class="bx_mo_link" href="<?= $arResult["CURRENT_PAGE"] ?>?filter_history=Y"><?= GetMessage('SPOL_CUR_ORDERS') ?></a>
            <?endif?>
        </div>

        <?if(!empty($arResult['ORDERS'])):?>

        <?foreach($arResult["ORDER_BY_STATUS"] as $key => $group):?>

        <?foreach($group as $k => $order):?>

        <?if(!$k):?>

        <div class="bx_my_order_status_desc">

            <h2><?= GetMessage("SPOL_STATUS") ?> "<?= $arResult["INFO"]["STATUS"][$key]["NAME"] ?>"</h2>
            <div class="bx_mos_desc"><?= $arResult["INFO"]["STATUS"][$key]["DESCRIPTION"] ?></div>

        </div>

        <?endif?>

        <div class="bx_my_order">

            <table class="bx_my_order_table">
                <thead>
                    <tr>
                        <td><?= GetMessage('SPOL_ORDER') ?> <?= GetMessage('SPOL_NUM_SIGN') ?><?= $order["ORDER"]["ACCOUNT_NUMBER"] ?> <?= GetMessage('SPOL_FROM') ?> <?= $order["ORDER"]["DATE_INSERT_FORMATED"]; ?></td>
                        <td style="text-align: right;">
                            <a href="<?= $order["ORDER"]["URL_TO_DETAIL"] ?>" class="button"><?= GetMessage('SPOL_ORDER_DETAIL') ?></a>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong><?= GetMessage('SPOL_PAY_SUM') ?>:</strong> <?= $order["ORDER"]["FORMATED_PRICE"] ?> <br />

                            <strong><?= GetMessage('SPOL_PAYED') ?>:</strong> <?= GetMessage('SPOL_' . ($order["ORDER"]["PAYED"] == "Y" ? 'YES' : 'NO')) ?> <br />

                            <? // PAY SYSTEM ?>
                            <?if(intval($order["ORDER"]["PAY_SYSTEM_ID"])):?>
                            <strong><?= GetMessage('SPOL_PAYSYSTEM') ?>:</strong> <?= $arResult["INFO"]["PAY_SYSTEM"][$order["ORDER"]["PAY_SYSTEM_ID"]]["NAME"] ?> <br />
                            <?endif?>

                            <? // DELIVERY SYSTEM ?>
                            <?if($order['HAS_DELIVERY']):?>

                            <strong><?= GetMessage('SPOL_DELIVERY') ?>:</strong>

                            <?if(intval($order["ORDER"]["DELIVERY_ID"])):?>

                            <?= $arResult["INFO"]["DELIVERY"][$order["ORDER"]["DELIVERY_ID"]]["NAME"] ?> <br />

                            <?elseif(strpos($order["ORDER"]["DELIVERY_ID"], ":") !== false):?>

                            <?$arId = explode(":", $order["ORDER"]["DELIVERY_ID"])?>
                            <?= $arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["NAME"] ?> (<?= $arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["PROFILES"][$arId[1]]["TITLE"] ?>) <br />

                            <?endif?>

                            <?endif?>

                            <strong><?= GetMessage('SPOL_BASKET') ?>:</strong>
                            <ul class="bx_item_list">

                                <?foreach ($order["BASKET_ITEMS"] as $item):?>

                                <li>
                                    <?if(strlen($item["DETAIL_PAGE_URL"])):?>
                                    <a href="<?= $item["DETAIL_PAGE_URL"] ?>" target="_blank">
                                        <?endif?>
                                        <?= $item['NAME'] ?>
                                        <?if(strlen($item["DETAIL_PAGE_URL"])):?>
                                    </a> 
                                    <?endif?>
                                <nobr>&nbsp;&mdash; <?= $item['QUANTITY'] ?> <?= (isset($item["MEASURE_NAME"]) ? $item["MEASURE_NAME"] : GetMessage('SPOL_SHT')) ?></nobr>
                                </li>

                                <?endforeach?>

                            </ul>

                        </td>
                        <td>
                            <?= $order["ORDER"]["DATE_STATUS_FORMATED"]; ?>
                            <div class="bx_my_order_status <?= $arResult["INFO"]["STATUS"][$key]['COLOR'] ?><?/*yellow*/ /*red*/ /*green*/ /*gray*/?>"><?= $arResult["INFO"]["STATUS"][$key]["NAME"] ?></div>

                            <?if($order["ORDER"]["CANCELED"] != "Y"):?>
                            <a href="<?= $order["ORDER"]["URL_TO_CANCEL"] ?>" style="min-width:105px"class="chancel bx_big bx_bt_button_type_2 bx_cart bx_order_action"><?= GetMessage('SPOL_CANCEL_ORDER') ?></a>
                            <?endif?>

                            <a href="<?= $order["ORDER"]["URL_TO_COPY"] ?>" style="min-width:105px"class="bx_big bx_bt_button_type_2 bx_cart bx_order_action"><?= GetMessage('SPOL_REPEAT_ORDER') ?></a>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

        <?endforeach?>

        <?endforeach?>

        <?if(strlen($arResult['NAV_STRING'])):?>
        <?= $arResult['NAV_STRING'] ?>
        <?endif?>

        <?else:?>
        <?= GetMessage('SPOL_NO_ORDERS') ?>
        <?endif?>

        <?endif?>
    </div>
    <div class="clear"></div>
</div>