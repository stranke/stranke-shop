<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
use Bitrix\Sale\Location\GeoIp;
use Bitrix\Sale\Location\GeoIp\Manager;
use Bitrix\Sale\Location\Name\LocationTable;

global $DB;
//$arUser = CUser::GetByID($USER->GetID())->Fetch();

/*echo '<pre>';
print_r($_SESSION['CART']);
die();*/

$is_bot = preg_match(
    "~(Google|Yahoo|Rambler|Bot|Yandex|Spider|Snoopy|Crawler|Finder|Mail|curl)~i", $_SERVER['HTTP_USER_AGENT']
);
$_COOKIE['city'] = $APPLICATION->get_cookie('city');
if ($_SESSION['city_table']['LOCATION_ID']) {
    if (CModule::IncludeModule("sale")) {
        $item = \Bitrix\Sale\Location\LocationTable::getById($_SESSION['city_table']['LOCATION_ID'])->fetch();
    }
}
if (!$_SESSION['city_table']['LOCATION_ID']) {
    $item['CODE'] = $_SESSION['city_table']['CODE'];
}

$strSql = "create table IF NOT EXISTS location_city_counter (
                            ID int(10),
                            NAME  varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                            COUNTER int(18),
                            PRIMARY KEY (id));";
$res = $DB->Query($strSql, false, $err_mess . __LINE__);

$city = $_SESSION['city'] ? $_SESSION['city'] : $_COOKIE['city'];
if ((!$city) && !$is_bot) {
    $ipAddress = \Bitrix\Main\Service\GeoIp\Manager::getRealIp();
//    $details = geoip_record_by_name($ipAddress);


    if (CModule::IncludeModule("sale")) {

        $obBitrixGeoIPResult = \Bitrix\Main\Service\GeoIp\Manager::getDataResult($ipAddress, 'ru');
        if ($obBitrixGeoIPResult !== null) {
            if ($obResult = $obBitrixGeoIPResult->getGeoData()) {
                $result = get_object_vars($obResult);
            }
        }

        $city_id = intval(\Bitrix\Sale\Location\GeoIp::getLocationId($ipAddress, LANGUAGE_ID));
        if (!$city_id) {
            $city_en = geoip_record_by_name($ipAddress)['city'];
            $city = $_POST['location_name'];
            $arCity = LocationTable::getList(array("filter" => array("NAME_UPPER" => strtoupper($city_en))))->fetch();
            $city_id = intval($arCity['LOCATION_ID']);
        }

        if ($city_id) {
            $arCity = LocationTable::getList(array("filter" => array("LOCATION_ID" => $city_id, 'LANGUAGE_ID' => LANGUAGE_ID)))->fetch();
            $city = $arCity['NAME'];
            $_SESSION['city_table'] = $arCity;
            $_SESSION['city_location_id'] = $city_id;
            $item = \Bitrix\Sale\Location\LocationTable::getById($_SESSION['city_table']['LOCATION_ID'])->fetch();

            $strSql_select = 'SELECT COUNTER';
            $strSql_where = 'WHERE (ID=' . $city_id . ')';
            $strSql = $strSql_select . '
            FROM location_city_counter 
            ' . $strSql_where . ' ORDER BY ID DESC LIMIT 0,1;';

            $sql_result = $DB->Query($strSql, false, $err_mess . __LINE__);
            if ($one_result = $sql_result->Fetch()) {
                $arFields = array(
                    "COUNTER" => $one_result['COUNTER'] + 1,
                );
                $DB->Update("location_city_counter", $arFields, 'WHERE ID=' . $city_id, $err_mess . __LINE__);
            } else {
                $arFields = array(
                    "ID" => $city_id,
                    "NAME" => '"' . $city . '"',
                    "COUNTER" => 1,
                );
                $DB->Insert("location_city_counter", $arFields, $err_mess . __LINE__);
            }
//        $result = \Bitrix\Main\Service\GeoIp\Manager::getDataResult($ipAddress, "ru");
//        $ipAddress = \Bitrix\Main\Service\GeoIp\Manager::getCityName('78.81.165.248');
        }
    } else {
        $city = \Bitrix\Main\Service\GeoIp\Manager::getCityName($ipAddress, LANGUAGE_ID);
    }

    if (!$city) {
        $city = 'Выберите город';
    }
}
$_SESSION['city'] = $city;
$_COOKIE['city'] = $city;

echo json_encode(array('ID' => $city_id, 'NAME' => $city, 'CODE' => $item['CODE']));
