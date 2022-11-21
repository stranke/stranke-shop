<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
require $_SERVER['DOCUMENT_ROOT'] .'/bitrix/components/bitrix/sale.basket.basket/class.php';

use \Bitrix\Main\Application;
use \Bitrix\Sale;
use \Bitrix\Sale\Fuser;

\Bitrix\Main\Loader::includeModule('sale');

$response['success'] = false;

$basket = new CBitrixBasketComponent();
$basketItemData = array('ID' => $_POST['productId']);
$result = $basket->checkQuantity($basketItemData, $_POST['quantity']);

$fuserId = Fuser::getId();
$siteId = Application::getInstance()->getContext()->getSite();

$basketStorage = Sale\Basket\Storage::getInstance($fuserId, $siteId);
$basket = $basketStorage->getBasket();
$res = $basket->save();

if ($res->isSuccess()) {
    $response['success'] = true;
    $response['quantity'] = $_POST['quantity'];
} else {
    $response['error'] = $this->errorCollection->add($res->getErrors());
}

echo json_encode($response);