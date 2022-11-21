<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

require __DIR__ . "/Auth.php";

global $sms_auth_setting;
$sms_auth_setting = json_decode($settings->properties['sms_auth']['~VALUE'], true);
$sms_auth_setting = is_array($sms_auth_setting) ? $sms_auth_setting : array();
if ($sms_auth_setting['type'] == 'smsru') {
    require "sms.ru.php";
    require "SmsService.php";
}
IF ($_REQUEST['method'] == 'get_code') {
    Auth::getCode($_REQUEST['phone']);


} elseif ($_REQUEST['method'] == 'check_code') {
    Auth::checkCode(array('phone' => $_REQUEST['phone'],
        'code' => $_REQUEST['code'],
    ));
}
?>
