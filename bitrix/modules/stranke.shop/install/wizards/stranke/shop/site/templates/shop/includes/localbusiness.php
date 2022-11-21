<?php
/**
 * Created by PhpStorm.
 * User: vsevset
 * Date: 22.01.19
 * Time: 14:57
 */

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");


//echo "<pre>";
//print_r($GLOBALS['JSON+LD']);
//echo "</pre>";

?>

<?
$localBusiness = [];

// 1 LocalBusiness
$type = 'shopEstablishment'; // тип

// url сайта организации
$url = '';
if ($_SERVER['HTTPS'] == 'on') {
 $url .= 'https://';
} else {
  $url .= 'http://';
}
$url .= SITE_SERVER_NAME; // End url


// name организации
$name = $GLOBALS['JSON+LD']['ORG_NAME']['VALUE'];
// End Name


// 1.1 ContactPoint
$contactPoint = [];
foreach ($GLOBALS["OPTIONS"]["PHONES"] as $phone) {
  $contactPoint[] = [
    "@type"=> "ContactPoint",
    "telephone"=> $phone,
    "contactType"=> "sales"
  ];
}

$jsonContactPoint = json_encode($contactPoint); // End ContactPoint

// Telephone

$phones = [];
foreach ($GLOBALS["OPTIONS"]["PHONES"] as $phone) {
  $phones[] = [
    "telephone"=> $phone,
  ];
}
$phone = $GLOBALS["OPTIONS"]["PHONES"][0];
$phone2 = $GLOBALS["OPTIONS"]["PHONES"][1];

$jsonPhones = json_encode($phones);

// 1.2 Address
$address = [];
$address[] = [
  "@type"=> "PostalAddress",
  "addressLocality"=> $GLOBALS['JSON+LD']['ORG_ADDRESS']['addressLocality']['VALUE'],
  "addressRegion"=> $GLOBALS['JSON+LD']['ORG_ADDRESS']['addressRegion']['VALUE'],
  "streetAddress"=> $GLOBALS['JSON+LD']['ORG_ADDRESS']['streetAddress']['VALUE'],
  "postalCode"=> $GLOBALS['JSON+LD']['ORG_ADDRESS']['postalCode']['VALUE']
];

$jsonAddress = json_encode($address,JSON_UNESCAPED_UNICODE); // End Address

// 1.2 Logo
$logo = '';
$logo .= $url;
$logo .= $GLOBALS["OPTIONS"]["LOGO"]['SRC']; // End Logo
