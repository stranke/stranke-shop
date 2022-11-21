<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>
<?php

if (isset($_REQUEST["ADD_ITEM"]) && $_REQUEST["ADD_ITEM"] == "Y") {
    $productID = intval($_REQUEST["ITEM_ID"]);
    if (\Bitrix\Main\Loader::includeModule("sale") && \Bitrix\Main\Loader::includeModule("catalog") && \Bitrix\Main\Loader::includeModule("iblock")) {
        $offersExist = CCatalogSku::GetProductInfo($productID);

        if (!is_array($offersExist)) {
            $arIblockres = CIBlockElement::GetByID($productID);
            $arIblockItem = $arIblockres->GetNext();
            $productName = $arIblockItem["NAME"];
        } else {
            $arIblockres = CIBlockElement::GetByID($offersExist["ID"]);
            $arIblockOfferres = CIBlockElement::GetByID($productID);
            $arIblockOfferItem = $arIblockOfferres->GetNext();
            $arIblockItem = $arIblockres->GetNext();
            $productName = $arIblockOfferItem["NAME"];
        }
        
        $arIblockres = CIBlockElement::GetByID($productID);
        $arIblockItem = $arIblockres->GetNext();

        $strProductProviderClass = "CCatalogProductProvider";
        $arCallbackPrice = false;
        if (!empty($strProductProviderClass)) {
            if ($productProvider = CSaleBasket::GetProductProvider(array(
                        'MODULE' => 'catalog',
                        'PRODUCT_PROVIDER_CLASS' => $strProductProviderClass))
            ) {
                $providerParams = array(
                    'PRODUCT_ID' => $productID,
                    'QUANTITY' => 1,
                    'CHECK_QUANTITY' => 'N',
                    'RENEWAL' => 'N'
                );
                $arCallbackPrice = $productProvider::GetProductData($providerParams);
                unset($providerParams);
            }
        }
        
        $arPrice_res = CPrice::GetBasePrice($productID);
        if ($arPrice_res["CURRENCY"] != "RUB") {
            $newval = CCurrencyRates::ConvertCurrency($arPrice_res["PRICE"], $arPrice_res["CURRENCY"], "RUB");
        } else {
            $newval = $arPrice_res["PRICE"];
        }
        
        $arFields = array(
            "PRODUCT_ID" => $productID,
            "PRODUCT_PRICE_ID" => 1,
            //"PRICE" => $_REQUEST["PRICE_VALUE"],
            "PRICE" => number_format($newval, 0, '.', ''),
            "CURRENCY" => "RUB",
            "QUANTITY" => 1,
            "LID" => LANG,
            //"CAN_BUY" => "Y",
            "NAME" => $productName,
            //"VAT_RATE" => $arCallbackPrice['VAT_RATE'],
            "VAT_RATE" => 0.18,
        );
        if ($mess = CSaleBasket::Add($arFields)) {
            echo "SUCCESS";
        } else {
            echo "ERROR";
            echo $mess->LAST_ERROR;
        }
    }
}
?>