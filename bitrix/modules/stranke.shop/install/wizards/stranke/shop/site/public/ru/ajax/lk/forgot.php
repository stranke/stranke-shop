<? require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php") ?>
<?
  $arLoc = array(
    "e_auth" => "Ошибка авторизации",
    "e_reg" => "Ошибка регистрации",
    "e_empty_login" => "Пустой логин",
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
  
  /** если ошибок нет задаем новый пароль пользователя */
  if(count($arResponse["errors"]) <=0 ){
    global $USER;
    $arResult = $USER->ChangePassword($login, $userCheckword, $password, $confirmPassword);
    $arResponse['method'] = 'forgot';
    $arResponse["status"] = $arResult["TYPE"] == "OK";
    $arResponse["description"] = $arResult["MESSAGE"];
    
    if(!$arResponse["status"]){
      $arResponse["description"] = $arLoc["e_auth"];
      $arResponse["errors"][] = array(
        "name"=>"USER_LOGIN",
        "description"=>$arResult["MESSAGE"]
      );
    }
    
  }
  
  echo \Bitrix\Main\Web\Json::encode($arResponse);
