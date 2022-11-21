<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

use Bitrix\Catalog\PriceTable;
use Bitrix\Catalog\StoreProductTable;
use Bitrix\Catalog\StoreTable;
use Bitrix\Catalog\GroupTable;
use Bitrix\Catalog\GroupLangTable;


if (!$_SESSION['city_location_id']) {
    if (!$_SESSION['city']) {
        echo 'repeat';
    }
    die();
}

$productId = (int)$_REQUEST['productId'];
$arDelivery = [];

function calcDateDelivery($PRODUCT_ID)
{
    $locationCode = $_SESSION['city_location_id'];

    \Bitrix\Main\Loader::includeModule('sale');
    $order = \Bitrix\Sale\Order::create(SITE_ID, 1);
    $basket = \Bitrix\Sale\Basket::create(SITE_ID);
    $item = $basket->createItem('catalog', $PRODUCT_ID); //$PRODUCT_ID – ИД товара
    $item->setFields(array(
        'QUANTITY' => 1,
        'CURRENCY' => \Bitrix\Currency\CurrencyManager::getBaseCurrency(),
        'LID' => SITE_ID, //Указываем ИД Вашего сайта
        'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
    ));

    /*$properties = array();
    $properties['STORE'] = array(
      'NAME' => 'Склад',
      'CODE' => 'STORE',
      'VALUE' => $storeName,
      'SORT' => 1
    );
    $basketPropertyCollection = $item->getPropertyCollection();
    $basketPropertyCollection->setProperty($properties);*/

    $order->setBasket($basket); // привязываем корзину к заказу
//    $order->setPersonTypeId(3);  //ставим тип плательщика, чтобы пройти ограничения доставки по типу плательщика корректно

    $shipmentCollection = $order->getShipmentCollection();
    $shipment = $shipmentCollection->createItem();
    $shipment->setFields(array(
        'CURRENCY' => 'RUB'
    ));
    $shipmentItemCollection = $shipment->getShipmentItemCollection();

    foreach ($order->getBasket() as $item) {
        $shipmentItem = $shipmentItemCollection->createItem($item);
        $shipmentItem->setQuantity($item->getQuantity());
    }

    $propertyCollection = $order->getPropertyCollection();//получаем коллекцию свойств заказа

    $property = $propertyCollection->getDeliveryLocation();
    if ($property)
        $r = $property->setField('VALUE', $locationCode);

//    $property = $propertyCollection->getItemById(26);//выбираем ту что отвечает за местоположение
//    $property->setValue($locationCode);//передаем местоположение


//    echo '<pre>';
//    print_r($locationCode);
//    echo '</pre>';

    // Далее получаем список доступных для данного местоположения доставок.
    $deliveries = \Bitrix\Sale\Delivery\Services\Manager::getRestrictedObjectsList($shipment);
    // Обрабатываем в цикле все доступные доставки и запускаем расчет стоимости каждой из них. Для расчета каждый раз клонируем заказ и рассчитываем для него доставку.
    $arDeliveries = array();
    foreach ($deliveries as $key => $deliveryObj) {
//        if ($deliveryObj->getCode() !== 'aalyans') continue;
        $clonedOrder = $order->createClone();//клонируем заказ
        $clonedShipment = null;
        foreach ($order->getShipmentCollection() as $shipment) {
            if (!$shipment->isSystem()) {
                $clonedShipment = clone $shipment;
            }
        }

        $clonedShipment->setField('CUSTOM_PRICE_DELIVERY', 'N');
        $arDelivery = array();

        $clonedShipment->setField('DELIVERY_ID', $deliveryObj->getId());
        $clonedOrder->getShipmentCollection()->calculateDelivery();
        $calcResult = $deliveryObj->calculate($clonedShipment);
        $calcOrder = $clonedOrder;


        if ($calcResult->isSuccess()) {

//            if ($deliveryObj->getId() != "1") {
            $arDelivery['name'] = $deliveryObj->getName();//получаем ИД доставки
            $arDelivery['id'] = $deliveryObj->getId();//получаем ИД доставки
            $arDelivery['logo_path'] = $deliveryObj->getLogotipPath();//получаем логотип
            $arDelivery['price'] = \Bitrix\Sale\PriceMaths::roundByFormatCurrency($calcResult->getPrice(), $calcOrder->getCurrency());//получаем стоимость доставки
            $arDelivery['price_formated'] = \SaleFormatCurrency($arDelivery['price'], $calcOrder->getCurrency());//форматируем стоимость в формат сайта


            $currentCalcDeliveryPrice = \Bitrix\Sale\PriceMaths::roundByFormatCurrency($calcOrder->getDeliveryPrice(), $calcOrder->getCurrency());
            if ($currentCalcDeliveryPrice >= 0 && $arDelivery['price'] != $currentCalcDeliveryPrice) {
                $arDelivery['discount_price'] = $currentCalcDeliveryPrice; //стоимость со скидкой
                $arDelivery['discount_price_formated'] = \SaleFormatCurrency($arDelivery['DELIVERY_DISCOUNT_PRICE'], $calcOrder->getCurrency());//стоимость со скидкой в нужной валюте
            }

            if (strlen($calcResult->getPeriodDescription()) > 0) {
                $arDelivery['period_text'] = $calcResult->getPeriodDescription();//время доставки
                if (strpos($arDelivery['period_text'], 'д') === false && strpos($arDelivery['period_text'], 'с') === false) {
                    $day_count = intval($arDelivery['period_text']);
                    $arDelivery['period_text'] = $arDelivery['period_text'] . ' ' . decl($day_count, array('день', 'дня', 'дней'));
                }
                if (strpos($arDelivery['period_text'], 'от ') !== false) {
                    $arDelivery['period_text'] = str_replace('от ', '', $arDelivery['period_text']);
                    $arDelivery['period_text'] = str_replace(' до ', '-', $arDelivery['period_text']);
                }
                $arDelivery['period_text'] = str_replace(array('день', 'дня', 'дней'), 'дн.', $arDelivery['period_text']);
            } else {
                $arDelivery['period_text'] = "0";
            }

            if (method_exists($deliveryObj, 'getCountDays'))
                $arDelivery["countDays"] = $deliveryObj->getCountDays();
            $arDeliveries[] = $arDelivery;//итоговый массив
//            }
        }
    }

    $minDelivery = null;
    foreach ($arDeliveries as $arDelivery) {
        if ($arDelivery['countDays'] < $minDelivery['countDays']) {
            $minDelivery = $arDelivery;
        }
    }

    return $arDeliveries;
}

$arDeliveries = calcDateDelivery($productID);


foreach ($arDeliveries as $arDelivery) {
    if ($arDelivery['id'] == 106) {
        $arDays = str_replace(['дн.', 'от', 'до', ' '], '', $arDelivery['period_text']);
        $arDays = explode('-', $arDays);
        if (count($arDays) > 1) {
            foreach ($arDays as $key => $day) {
                $date = strtolower(FormatDate("d F", strtotime('+' . ((int)$day) . ' day')));
                $arDate = explode(' ', $date);
                $arDateDF[$key]['day'] = $arDate[0];
                $arDateDF[$key]['month'] = $arDate[1];
            }
            if ($arDateDF[0]['month'] == $arDateDF[1]['month']) {
                $arDelivery['date_text'] = $arDateDF[0]['day'] . '-' . $arDateDF[1]['day'] . ' ' . $arDateDF[1]['month'];
            } else {
                $arDelivery['date_text'] = $arDateDF[0]['day'] . ' ' . $arDateDF[0]['month'] . ' - ' . $arDateDF[1]['day'] . ' ' . $arDateDF[1]['month'];
            }
        } else {
            $date = strtolower(FormatDate("d F", strtotime('+' . ((int)$arDays[0]) . ' day')));
            $arDelivery['date_text'] = $date;
        }
    }
    ?>
    <div class="delivery_row" dataId="<?= $arDelivery['id'] ?>" <?
    if ($arDelivery['date_text']){ ?>dataDateCdekText="<?= $arDelivery['date_text'] ?>"<?
    } ?>>
        <div class="delivery_row__name">
            <?= $arDelivery['name']; ?>
        </div>
        <div class="delivery_row__width">
        </div>
        <div class="delivery_row__price">
            <?= !$arDelivery['price'] && !$arDelivery['period_text'] ? 'бесплатно' : ''; ?>
            <?= $arDelivery['price'] ? $arDelivery['price'] . ' р.' : ''; ?>
        </div>
        <div class="delivery_row__days">
            <?= $arDelivery['period_text'] ? '&nbsp;' . $arDelivery['period_text'] : ''; ?>
        </div>
    </div>
    <?
}
