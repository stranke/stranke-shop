<? require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php") ?>
<?
  $arLoc = array(
    "e_auth" => "Ошибка авторизации",
    "e_reg" => "Ошибка регистрации",
    "e_empty_login" => "Пустой E-mail",
    "e_empty_field" => "Пустое поле",
    "e_empty_pass" => "Пустой пароль",
    "e_is_email" => "Почта занята",
    "e_is_login" => "Логин занят",
    "e_cmp_pass" => "Пароли не совпадают",
    "e_ln_login" => "Не менее 3 символов",
  );
  
  $arResponse = array(
    "status" => false,
    "description" => "",
    "errors" => array()
  );
  
  $email = $_POST["USER_EMAIL"];
  $login = $_POST["USER_LOGIN"];
  $password = $_POST["USER_PASSWORD"];
  $confirmPassword = $_POST["USER_CONFIRM_PASSWORD"];
  $userType = $_POST["user_type"];
  $userCheckword = $_POST["USER_CHECKWORD"];
  $send = 'N';

  if (check_email($_POST['USER_LOGIN'])) {
    $filter = Array("EMAIL" => $_POST['USER_LOGIN']);
    $rsUsers = CUser::GetList(($by = "id"), ($order = "desc"), $filter);
    $arUsers = $rsUsers->GetNext();
    $rsUser = CUser::GetByID($arUsers['ID']);
    $arUser = $rsUser->Fetch();
    if ($_POST['USER_LOGIN'] == $arUser['EMAIL']) {
//      $arFields['URL'] = '/authorize/?USER_CHECKWORD=' . $arUser['CHECKWORD'] . '&USER_CHANGE_LOGIN=' . $arUser['LOGIN'] . '&ACTION=CHANGE_PASSWORD_FORM_SHOW';
      $arFields['EMAIL'] = $arUser['EMAIL'];
      $arFields['LOGIN'] = $arUser['LOGIN'];
//      $arFields['CHECKWORD'] = $arUser['CHECKWORD'];
//      $send = CEvent::SendImmediate('USER_PASS_REQUEST', 's1', $arFields, "N");
      $send = CUser::SendPassword($arFields['LOGIN'], $arFields['EMAIL'], SITE_ID, $_POST["captcha_word"], $_POST["captcha_sid"]);
      $arResponse['status'] = $send["TYPE"] == "OK";
    }
  } else {
    $filter = Array("LOGIN" => $_POST['USER_LOGIN']);
    $rsUsers = CUser::GetList(($by = "id"), ($order = "desc"), $filter);
    $arUsers = $rsUsers->GetNext();
    $rsUser = CUser::GetByID($arUsers['ID']);
    $arUser = $rsUser->Fetch();
    if ($_POST['USER_LOGIN'] == $arUser['LOGIN']) {
//      $arFields['URL'] = '/authorize/?USER_CHECKWORD=' . $arUser['CHECKWORD'] . '&USER_CHANGE_LOGIN=' . $arUser['LOGIN'] . '&ACTION=CHANGE_PASSWORD_FORM_SHOW';
      $arFields['EMAIL'] = $arUser['EMAIL'];
      $arFields['LOGIN'] = $arUser['LOGIN'];
//      $arFields['CHECKWORD'] = $arUser['CHECKWORD'];
      $send = CUser::SendPassword($arFields['LOGIN'], $arFields['EMAIL'], SITE_ID, $_POST["captcha_word"], $_POST["captcha_sid"]);
//      $send = CEvent::SendImmediate('USER_PASS_REQUEST', 's1', $arFields, "N");
      $arResponse['status'] = $send["TYPE"] == "OK";
//      $arResponse['fields'] = $arFields;
//      $arResponse['userId'] = $arUsers['ID'];
    }
  }

  if($send["TYPE"] == "ERROR") {
      $arResponse['errors'][] = array(
        "name"=>"USER_LOGIN",
        "description"=> 'Сообщение не отправлено'
    );
  }

  if (!$arResponse['status']) {
    $arResponse['errors'][] = array(
      "name"=>"USER_LOGIN",
      "description"=> 'пользователь не найден'
    );
  }

  /** проверка на пустые значения */
  if(empty($login)){
    $arResponse["description"] = $arLoc["e_auth"];
    $arResponse["errors"][] = array(
      "name"=>"USER_LOGIN",
      "description"=>$arLoc["e_empty_login"]
    );
  }
  
  /** проверяем на длину не меньше 3х символов */
  if(!empty($login) && iconv_strlen($login) < 3 ) {
    $arResponse["description"] = $arLoc["e_auth"];
    $arResponse["errors"][] = array(
      "name"=>"USER_LOGIN",
      "description"=>$arLoc["e_ln_login"]
    );
  }


  
  echo \Bitrix\Main\Web\Json::encode($arResponse);
