<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main,
	  Bitrix\Main\Localization\Loc,
	  Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/script.js");
Asset::getInstance()->addCss("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/style.css");
//$this->addExternalCss("/bitrix/css/main/bootstrap.css");
CJSCore::Init(array('clipboard', 'fx'));

Loc::loadMessages(__FILE__);

  if (!empty($arResult['ERRORS']['FATAL']))
  {
    foreach($arResult['ERRORS']['FATAL'] as $error)
    {
      ShowError($error);
    }
    $component = $this->__component;
    if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED]))
    {
      $APPLICATION->AuthForm('', false, false, 'N', false);
    }
  } else {

    $message = "";
    
    if (!empty($arResult['ERRORS']['NONFATAL']))
    {
      foreach($arResult['ERRORS']['NONFATAL'] as $error)
      {
        ShowError($error);
      }
    }
    if (!count($arResult['ORDERS']))
    {
      if ($_REQUEST["filter_history"] == 'Y')
      {
        if ($_REQUEST["show_canceled"] == 'Y')
        {
           $message = Loc::getMessage('SPOL_TPL_EMPTY_CANCELED_ORDER');
          
        }
        else
        {
           $message = Loc::getMessage('SPOL_TPL_EMPTY_HISTORY_ORDER_LIST');
        }
      }
      else
      {
         $message = Loc::getMessage('SPOL_TPL_EMPTY_ORDER_LIST');
      }
    }
    ?>

    <h2 class="lk-h2"><?=Loc::getMessage('ST_YOU_ORDERS')?></h2>
    
    <h3 class="lk-message"><?=$message?></h3>

    <div class="lk-orders">


    <? foreach ($arResult['ORDERS'] as $key => $order) { ?>

          <div class="lk-orders__order">

            <div class="lk-order">

              <div class="lk-orders__order-attr">
                <div class="lk-orders__order-attr-name"><?=Loc::getMessage('SPOL_TPL_ORDER')?></div>
                <div class="lk-orders__order-attr-value">
                    <?=Loc::getMessage('ST_ORDER_NUMBER', array(
                        '#ACCOUNT_NUMBER#' => htmlspecialcharsbx($order['ORDER']['ACCOUNT_NUMBER']),
                    ))?>
                </div>
              </div><!--
            --><div class="lk-orders__order-attr">

                <div class="lk-orders__order-attr-name"><?=Loc::getMessage('ST_STATUS')?></div>

                <? $orderHeaderStatus = $order['ORDER']['STATUS_ID']; ?>

                <div class="lk-orders__order-attr-value <?=$orderHeaderStatus?>"><?=htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME'])?></div>

              </div><!--
            --><div class="lk-orders__order-attr">
                <div class="lk-orders__order-attr-name"><?=Loc::getMessage('Сумма заказа')?></div>
                <div class="lk-orders__order-attr-value"><?=$order['PAYMENT'][0]['FORMATED_SUM']?></div>
              </div><!--

            --><a href="<?=$order['ORDER']['URL_TO_DETAIL']?>" class="lk-orders__order-btn">
                <?=Loc::getMessage('ST_DETAIL')?>
              </a>
            </div>
          </div>
    <? } ?>

    </div>

    <div class="clearfix"></div>

    <?
    echo $arResult["NAV_STRING"];

    if ($_REQUEST["filter_history"] !== 'Y') {

      $javascriptParams = array(
        "url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
        "templateFolder" => CUtil::JSEscape($templateFolder),
        "templateName" => $this->__component->GetTemplateName(),
        "paymentList" => $paymentChangeData
      );
      $javascriptParams = CUtil::PhpToJSObject($javascriptParams);
    ?>
      <script>
        BX.Sale.PersonalOrderComponent.PersonalOrderList.init(<?=$javascriptParams?>);
      </script>
    <?
    }
  }
