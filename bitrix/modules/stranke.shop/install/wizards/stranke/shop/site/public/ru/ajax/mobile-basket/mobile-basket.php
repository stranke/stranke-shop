<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?// IncludeTemplateLangFile(__FILE__); ?>

<div class="mobile-basket">

  <?$APPLICATION->IncludeComponent(
    "bitrix:sale.basket.basket.line",
    "user-order-mobile",
    Array(
      "COMPONENT_TEMPLATE" => ".default",
      "HIDE_ON_BASKET_PAGES" => "N",
      "PATH_TO_AUTHORIZE" => "",
      "PATH_TO_BASKET" => SITE_DIR . "personal/cart/",
      "PATH_TO_ORDER" => SITE_DIR . "personal/order/make/",
      "PATH_TO_PERSONAL" => SITE_DIR . "personal/",
      "PATH_TO_PROFILE" => SITE_DIR . "personal/",
      "PATH_TO_REGISTER" => SITE_DIR . "login/",
      "POSITION_FIXED" => "N",
      "SHOW_AUTHOR" => "N",
      "SHOW_DELAY" => "N",
      "SHOW_EMPTY_VALUES" => "Y",
      "SHOW_IMAGE" => "Y",
      "SHOW_NOTAVAIL" => "N",
      "SHOW_NUM_PRODUCTS" => "Y",
      "SHOW_PERSONAL_LINK" => "Y",
      "SHOW_PRICE" => "Y",
      "SHOW_PRODUCTS" => "Y",
      "SHOW_REGISTRATION" => "N",
      "SHOW_SUMMARY" => "Y",
      "SHOW_TOTAL_PRICE" => "Y"
    )
  );?>

</div>
