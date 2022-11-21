<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
use Bitrix\Sale\Location\GeoIp;
use Bitrix\Sale\Location\Name\LocationTable;

global $DB;

if ($_POST['locationId']) {
    if (CModule::IncludeModule("sale")) {
        $city_id = $_POST['locationId'];
        $arCity = \Bitrix\Sale\Location\LocationTable::getList(array("filter" => array("ID" => $city_id, '=NAME.LANGUAGE_ID' => LANGUAGE_ID,), 'select' => array(
            'NAME',
            'CITY_ID',
            '*'
        )))->fetch();
        $arCity['NAME'] = $arCity['SALE_LOCATION_LOCATION_NAME_NAME'];
        $city = $arCity['NAME'];
        $_SESSION['city'] = $city;
        $_COOKIE['city'] = $city;
        $_SESSION['city_table'] = $arCity;
        $_SESSION['city_location_id'] = $city_id;
        $_SESSION['CART']['LOCATION_ID'] = $city_id;
        $_SESSION['CART']['LOCATION_CODE'] = $arCity['CODE'];
        if($arCity['CODE']){
            $item['CODE'] = $arCity['CODE'];
        } else {
            $item = \Bitrix\Sale\Location\LocationTable::getById($arCity['LOCATION_ID'])->fetch();
        }
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

        echo json_encode(array('ID' => $city_id, 'NAME' => $city , 'CODE' => $item['CODE']));

    }
}
if ($_POST['location_name']) {
    if (CModule::IncludeModule("sale")) {
        $city = $_POST['location_name'];
        $arCity = LocationTable::getList(array("filter" => array("NAME_UPPER" => strtoupper($city))))->fetch();
        $city_id = $arCity['LOCATION_ID'];
        $city = $arCity['NAME'];
        $_SESSION['city'] = $city;
        $_COOKIE['city'] = $city;
        $_SESSION['city_table'] = $arCity;
        $_SESSION['city_location_id'] = $city_id;
        $_SESSION['CART']['LOCATION_ID'] = $city_id;

        $item = \Bitrix\Sale\Location\LocationTable::getById($arCity['LOCATION_ID'])->fetch();

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

        echo json_encode(array('ID' => $city_id, 'NAME' => $city, 'CODE' => $item['CODE']));

    }
}
