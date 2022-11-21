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
    "e_email" => "Неверный E-Mail",
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

  /** проверка на пустые значения */
  if(empty($email)){
    $arResponse["description"] = $arLoc["e_auth"];
    $arResponse["errors"][] = array(
      "name"=>"USER_EMAIL",
      "description"=>$arLoc["e_empty_field"]
    );
  }

  if(empty($login)){
    $arResponse["description"] = $arLoc["e_auth"];
    $arResponse["errors"][] = array(
      "name"=>"USER_LOGIN",
      "description"=>$arLoc["e_empty_login"]
    );
  }

  if(empty($password)){
    $arResponse["description"] = $arLoc["e_auth"];
    $arResponse["errors"][] = array(
      "name"=>"USER_PASSWORD",
      "description"=>$arLoc["e_empty_pass"]
    );
  }

  if(empty($confirmPassword)){
    $arResponse["description"] = $arLoc["e_auth"];
    $arResponse["errors"][] = array(
      "name"=>"USER_CONFIRM_PASSWORD",
      "description"=>$arLoc["e_empty_pass"]
    );
  }
  
  /** проверяем такой email занят */
  if(!empty($email)) {
    $arFilter = array("=EMAIL" => $email);
    $isEmail = $USER->GetList(($by = ""), ($order = ""), $arFilter)->Fetch();
    if($isEmail){
      $arResponse["description"] = $arLoc["e_reg"];
      $arResponse["errors"][] = array(
        "name"=>"USER_EMAIL",
        "description"=>$arLoc["e_is_email"]
      );
    }
  }
  
  /** проверяем логин занят*/
  if(!empty($login)) {
    $arFilter = array("LOGIN_EQUAL" => $login);
    $isLogin = $USER->GetList(($by = ""), ($order = ""), $arFilter)->Fetch();
    if($isLogin){
      $arResponse["description"] = $arLoc["e_reg"];
      $arResponse["errors"][] = array(
        "name"=>"USER_LOGIN",
        "description"=>$arLoc["e_is_login"]
      );
    }
  }
  
  /** сравниваем пароли */
  if(!empty($password) && !empty($confirmPassword)){
    if(strcmp($password, $confirmPassword) !== 0){
      $arResponse["description"] = $arLoc["e_reg"];
      $arResponse["errors"][] = array(
        "name"=>"USER_PASSWORD",
        "description"=>$arLoc["e_cmp_pass"]
      );
      $arResponse["errors"][] = array(
        "name"=>"USER_CONFIRM_PASSWORD",
        "description"=>$arLoc["e_cmp_pass"]
      );
    }
  }
  
  /** тип пользователя */
  $arType = 2;
  switch($userType){
    case "legal_unit": $arType = 3; break;
  }
  
  /** если ошибок нет регистрируем пользователя */
  if(count($arResponse["errors"]) <=0 ){
    global $USER;
    $arResult = $USER->Register($login, "", "", $password, $confirmPassword, $email);
    $arResponse["status"] = $arResult["TYPE"] === "OK";
    
    $arResponse["arResult"] = $arResult;
    
    if($arResponse["status"]){
      
      $arField = array(
        "UF_USER_TYPE" => $arType
      );
      
      $res = $USER->Update($arResult["ID"], $arField);
      if(!$res){
        $arResponse["LAST_ERROR"] = $USER->LAST_ERROR;
      }
      $arResponse["arField"] = $arField;
      $arResponse["arResult"] = $arResult;
  
      $arResponse["status"] = $USER->Login($login, $password);
  
    } else {
      
      $arResponse["description"] = $arLoc["e_auth"];
      $arResponse["errors"][] = array(
        "name"=>"USER_EMAIL",
        "description"=>$arLoc["e_email"]
      );
      
    }
    
  }
  
  echo \Bitrix\Main\Web\Json::encode($arResponse);
