<?php

namespace App\Service;


use \Bitrix\Main\Diag\Debug;
final class SmsService
{
    private static $instance;
    private $smsClient;

    public static function getInstance(): SmsService
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function send($phone, $text)
    {
        $data = new \stdClass();
        $data->to = $this->normalizePhone($phone);
        $data->text = $text;

        $sms = $this->smsClient->send_one($data);

        $arLog = [
            'phone' => $phone,
            'text' => $text,
            '$sms' => $sms,
        ];
        $logFileName = 'api/v2/log/SmsService.log';
        Debug::writeToFile($arLog, date('d.m.Y H:i:s'), $logFileName);

        return $sms;
    }

    public function call($phone)
    {
        $data = new \stdClass();
        $data->phone = $this->normalizePhone($phone);

        $sms = $this->smsClient->call($data);

        $arLog = [
            'phone' => $phone,
            '$sms' => $sms,
        ];
        //$logFileName = 'api/v2/log/SmsServiceCall.log';
        //Debug::writeToFile($arLog, date('d.m.Y H:i:s'), $logFileName);

        return $sms;
    }

    private function __construct()
    {

        global $sms_auth_setting;

        $this->smsClient = new \SMSRU($sms_auth_setting['SMSRU_API_KEY']);
    }

    private function normalizePhone($phone)
    {
        return str_replace([' ', '(', ')', '-', '+'], '', $phone);
    }

}
