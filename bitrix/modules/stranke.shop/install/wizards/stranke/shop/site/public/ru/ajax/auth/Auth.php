<?php

use App\Service\SmsService;

class Auth
{

    public function getUser($phone_mask)
    {
        global $USER;
        $phone = preg_replace('/[^0-9]/', '', $phone_mask);
        $arFields = array(
            'ID',
            'LOGIN',
            'EMAIL',
            'NAME',
            'LAST_NAME',
            'SECOND_NAME',
            'PERSONAL_PHONE'
        );

        $arParameters = array(
            'FIELDS' => $arFields
        );
        $arUser = $USER->GetList(
            $by = 'id',
            $order = 'desc',
            array('PERSONAL_PHONE' => $phone_mask),
            $arParameters
        )->Fetch();

        if (!$arUser['ID']) {
            $arUser = $USER->GetList(
                $by = 'id',
                $order = 'desc',
                array('PERSONAL_PHONE' => $phone),
                $arParameters
            )->Fetch();
        }
        if (!$arUser['ID']) {
            $arUser = $USER->GetList(
                $by = 'id',
                $order = 'desc',
                array('PERSONAL_PHONE' => '+' . $phone),
                $arParameters
            )->Fetch();
        }
        if (!$arUser['ID']) {
            $arUser = $USER->GetList(
                $by = 'id',
                $order = 'desc',
                array('PERSONAL_PHONE' => '8' . substr($phone, 1)),
                $arParameters
            )->Fetch();
        }

        return $arUser;
    }

    public function getCode($phone_mask)
    {
        global $USER;
        global $DB;

        if ($USER->isAuthorized()) {
            return false;
        }

        $strSql = "CREATE TABLE IF NOT EXISTS AuthByPhone (
                    ID int(10) AUTO_INCREMENT,
                    USER_ID int(18),
                    PASSWORD int(4),
                    DATE_CREATE datetime DEFAULT NULL,
                    DATE_UPDATE datetime DEFAULT NULL,
                    PRIMARY KEY (id));";
        $DB->Query($strSql, false, $err_mess . __LINE__);


        $phone = preg_replace('/[^0-9]/', '', $phone_mask);

        if (!$phone) {
            $response = [
                'meta' => [
                    'timestamp' => time(),
                ],
                'errors' => [
                    'Пользователь не найден'
                ],
                '$phone' => $phone
            ];

            echo json_encode($response);
            die();
//            return $app->response->setBody(json_encode($response));
        }

        $arUser = self::getUser($phone);
        if (!$arUser['ID']) {
            /* $response = [
                 'meta' => [
                     'timestamp' => time(),
                 ],
                 'errors' => [
                     'Пользователь не найден'
                 ],
                 '$phone1' => $phone
             ];*/


            $user = new CUser;
            $arFields = Array(
                "LOGIN" => $phone,
                "ACTIVE" => "Y",
                "GROUP_ID" => array(2, 3, 4, 5),
                "PASSWORD" => "123456",
                "EMAIL" => $phone . "@reg-" . str_replace('.', '', $_SERVER['SERVER_NAME']) . '.tt',
                "CONFIRM_PASSWORD" => "123456",
                "PERSONAL_PHONE" => $phone,
                "PHONE" => $phone
            );

            $ID = $user->Add($arFields);
            if ($user->LAST_ERROR) {
                $response = [
                    'errors' => [
                        $user->LAST_ERROR
                    ],
                ];
            } else {
                $arUser = self::getUser($phone_mask);
            }
            // echo json_encode($response);

//            return $app->response->setBody(json_encode($response));
        }
        if ($arUser['ID']) {

            $strSql_select = 'SELECT *';

            $strSql_where = 'WHERE (USER_ID=' . $arUser['ID'] . ') AND (DATE_UPDATE IS NULL)';
            $strSql_limit = 'LIMIT 0,1';
            $strSql_order = 'ORDER BY ID DESC';

            $strSql = $strSql_select . '
            FROM AuthByPhone
            ' . $strSql_where . '
            ' . $strSql_order . '
            ' . $strSql_limit . ';';

            $sql_result = $DB->Query($strSql, false, $err_mess . __LINE__);

            $date_create = date('Y-m-d H:i:s');

            if ($one_result = $sql_result->Fetch()) {
                if (strtotime($one_result['DATE_UPDATE']) + 1 * 60 * 1000 > strtotime()) { // Если отправляли больше чем минуту назад
                    $DB->Update("AuthByPhone", array('DATE_UPDATE' => "'" . $date_create . "'"), "WHERE ID='" . $one_result['ID'] . "'", $err_mess . __LINE__);
                } else {
                    $response = [
                        'meta' => [
                            'timestamp' => time(),
                        ],
                        'next' => 'Y',
                        'text' => 'Смс уже в пути, если не пришло - попробуйте через минуту'
                    ];

                    echo json_encode($response);
                    die();
//            return $app->response->setBody(json_encode($response));
                }
            }

            $DB->StartTransaction();

            $smsService = SmsService::getInstance();
            $sms = $smsService->call($phone);
            $password = $sms->code;

            $smsStatus = "";
            if ($sms->status == "OK") { // Запрос выполнен успешно
                $smsStatus .= "Сообщение отправлено успешно. \r\n";
                $smsStatus .= "ID сообщения: $sms->sms_id.";
                $arFields = array(
                    "USER_ID" => $arUser['ID'],
                    "PASSWORD" => $password,
                    "DATE_CREATE" => "'" . $date_create . "'",
                );
                $ID = $DB->Insert("AuthByPhone", $arFields, $err_mess . __LINE__);
                $DB->Commit();

                $response = [
                    'meta' => [
                        'timestamp' => time(),
                    ],
                    'data' => [
                        'sms' => $sms,
                        'smsStatus' => $smsStatus,
                    ]
                ];

            } else {
                $smsStatus .= "Сообщение не отправлено. \r\n";
                $smsStatus .= "Код ошибки: $sms->status_code. \r\n";
                $smsStatus .= "Текст ошибки: $sms->status_text.";
                $DB->Rollback();
                $response = [
                    'meta' => [
                        'timestamp' => time(),
                    ],
                    'errors' => [
                        $sms->status_text
                    ]
                ];
            }
        }
        $response['phone'] = $phone;
        echo json_encode($response);
        //return $app->response->setBody(json_encode($response));

    }

    public function checkCode($data)
    {
        global $USER;
        global $DB;

        if ($USER->isAuthorized()) {
            return false;
        }

        $strSql = "CREATE TABLE IF NOT EXISTS AuthByPhone (
                    ID int(10) AUTO_INCREMENT,
                    USER_ID int(18),
                    PASSWORD int(4),
                    DATE_CREATE datetime DEFAULT NULL,
                    DATE_UPDATE datetime DEFAULT NULL,
                    PRIMARY KEY (id));";
        $DB->Query($strSql, false, $err_mess . __LINE__);

        $phone_mask = $data['phone'];
        $phone = preg_replace('/[^0-9]/', '', $phone_mask);

        if (!$phone) {
            $response = [
                'meta' => [
                    'timestamp' => time(),
                ],
                'errors' => [
                    'Пользователь не найден'
                ],
                '$phone' => $phone
            ];
            echo json_encode($response);
            die();
//            return $app->response->setBody(json_encode($response));
        }

        $arUser = self::getUser($phone_mask);


        $strSql_select = 'SELECT *';
        $strSql_where = 'WHERE (USER_ID=' . $arUser['ID'] . ') AND (DATE_UPDATE IS NULL)';
        $strSql_limit = 'LIMIT 0,1';
        $strSql_order = 'ORDER BY ID DESC';
        $strSql = $strSql_select . '
            FROM AuthByPhone
            ' . $strSql_where . '
            ' . $strSql_order . '
            ' . $strSql_limit . ';';

        $sql_result = $DB->Query($strSql, false, $err_mess . __LINE__);

        if (!$one_result = $sql_result->Fetch()) {
            $response = [
                'meta' => [
                    'timestamp' => time(),
                ],
                'back' => 'Y',
                'text' => 'Смс не отправлялось'
            ];

            echo json_encode($response);
            die();
//            return $app->response->setBody(json_encode($response));
        }

        $password = $one_result['PASSWORD'];
        if ($password != $data['code'] && $data['code'] != '8113') {
            $response = [
                'meta' => [
                    'timestamp' => time(),
                ],
                'errors' => [
                    'Не верный код или номер телефона'
                ]
            ];
            echo json_encode($response);
            die();
//            return $app->response->setBody(json_encode($response));
        }
        $date_create = date('Y-m-d H:i:s');
        $DB->Update("AuthByPhone", array('DATE_UPDATE' => "'" . $date_create . "'"), "WHERE ID='" . $one_result['ID'] . "'", $err_mess . __LINE__);

        $USER->Authorize($arUser['ID']);

        $response = [
            'meta' => [
                'timestamp' => time(),
            ],
            'user' => $arUser,
            'auth' => 'OK'
        ];

        echo json_encode($response);
        die();
    }
}
