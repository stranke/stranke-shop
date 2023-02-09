<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

if ($arParams["SET_TITLE"] == "Y") {
    $APPLICATION->SetTitle(Loc::getMessage("SOA_ORDER_COMPLETE"));
}
global $app;
?>
<script>
    <?=$app->config->targetsuccessorder?>
</script>
<div class="bx-soa-order wrapper">
    <h1 class="bx-soa-order__title"><?= Loc::getMessage('STRANKE_SOA_TITLE') ?></h1>

    <div class="bx-soa-order__card">


        <? if (!empty($arResult["ORDER"])): ?>

            <div class="container">
                <div class="sucsess_order">
                    <div class="sucsess_order_title"><?= Loc::getMessage("SOA_ORDER_SUC", array(
                            "#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"]->toUserTime()->format('d.m.Y H:i'),
                            "#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]
                        )) ?></div>
                    <div class="sucsess_order_text">
                        <?= Loc::getMessage("SOA_ORDER_SUC_TEXT", array(
                            "#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"]->toUserTime()->format('d.m.Y H:i'),
                            "#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]
                        )) ?>
                    </div>
                    <? if ($arParams['NO_PERSONAL'] !== 'Y'): ?>
                        <br/><br/>
                        <?= Loc::getMessage('SOA_ORDER_SUC1', ['#LINK#' => $arParams['PATH_TO_PERSONAL']]) ?>
                    <? else: ?>
                        <div class="sucsess_order_btn btn bg_main" onclick="window.location=SITE_DIR"> <?= Loc::getMessage('SOA_ORDER_SUC2', ['#LINK#' => $arParams['PATH_TO_PERSONAL']]) ?></div>
                    <? endif; ?>
                </div>
            </div>

            <?
            if ($arResult["ORDER"]["IS_ALLOW_PAY"] === 'Y') {
                if (!empty($arResult["PAYMENT"])) {
                    foreach ($arResult["PAYMENT"] as $payment) {
                        if ($payment["PAID"] != 'Y') {
                            if (!empty($arResult['PAY_SYSTEM_LIST'])
                                && array_key_exists($payment["PAY_SYSTEM_ID"], $arResult['PAY_SYSTEM_LIST'])
                            ) {
                                $arPaySystem = $arResult['PAY_SYSTEM_LIST_BY_PAYMENT_ID'][$payment["ID"]];

                                if (empty($arPaySystem["ERROR"])) {
                                    ?>

                                    <table class="sale_order_full_table">
                                        <tr>
                                            <td>
                                                <? if (strlen($arPaySystem["ACTION_FILE"]) > 0 && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
                                                    <?
                                                    $orderAccountNumber = urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]));
                                                    $paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
                                                    ?>
                                                    <script>
                                                        window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>');
                                                    </script>
                                                <?= Loc::getMessage("SOA_PAY_LINK", array("#LINK#" => $arParams["PATH_TO_PAYMENT"] . "?ORDER_ID=" . $orderAccountNumber . "&PAYMENT_ID=" . $paymentAccountNumber)) ?>
                                                <? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
                                                <br/>
                                                    <?= Loc::getMessage("SOA_PAY_PDF", array("#LINK#" => $arParams["PATH_TO_PAYMENT"] . "?ORDER_ID=" . $orderAccountNumber . "&pdf=1&DOWNLOAD=Y")) ?>
                                                <? endif ?>
                                                <? else: ?>
                                                    <?= $arPaySystem["BUFFERED_OUTPUT"] ?>
                                                <? endif ?>
                                            </td>
                                        </tr>
                                    </table>

                                    <?
                                } else {
                                    ?>
                                    <span style="color:red;"><?= Loc::getMessage("SOA_ORDER_PS_ERROR") ?></span>
                                    <?
                                }
                            } else {
                                ?>
                                <span style="color:red;"><?= Loc::getMessage("SOA_ORDER_PS_ERROR") ?></span>
                                <?
                            }
                        }
                    }
                }
            } else {
                ?>
                <br/><strong><?= $arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR'] ?></strong>
                <?
            }
            ?>

        <? else: ?>

            <table class="sale_order_full_table">
                <tr>
                    <td>
                        <b><?= Loc::getMessage("SOA_ERROR_ORDER") ?></b>
                        <br/><br/>

                        <?= Loc::getMessage("SOA_ERROR_ORDER_LOST", ["#ORDER_ID#" => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"])]) ?>
                        <?= Loc::getMessage("SOA_ERROR_ORDER_LOST1") ?>
                    </td>
                </tr>
            </table>

        <? endif ?>
    </div>
</div>
