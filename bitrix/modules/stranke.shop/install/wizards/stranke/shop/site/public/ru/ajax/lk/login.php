<? require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php") ?>
<?
$arLoc = array(
"e_auth" => "Ошибка авторизации",
"e_empty_login" => "Пустой логин",
"e_empty_pass" => "Пустой пароль",
"e_pass" => "Неверный логин или пароль",
"e_not_find" => "Логин или Email не найден",
);

$arResponse = array(
"status" => false,
"description" => "",
"errors" => array()
);

$login = $_POST["USER_LOGIN"];
$password = $_POST["USER_PASSWORD"];

/** проверка на пустые значения */
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

/** проверяем наличие логина */
if(!empty($login)) {
$arFilter = array("LOGIN_EQUAL" => $login);
$arUser = $USER->GetList(($by = ""), ($order = ""), $arFilter)->Fetch();
if(empty($arUser)){
  $arFilter = array("=EMAIL" => $email);
  $arUser = $USER->GetList(($by = ""), ($order = ""), $arFilter)->Fetch();
  if(!empty($arUser)){
    $login = $arUser["LOGIN"];
  }else{
    $arResponse["description"] = $arLoc["e_reg"];
    $arResponse["errors"][] = array(
      "name"=>"USER_EMAIL",
      "description"=>$arLoc["e_not_find"]
    );
  }
}

}

if(count($arResponse["errors"]) <=0 ){
    $arResult = $USER->Login($login, $password);
    $arResponse['method'] = 'auth';
//    $arResponse["arResult"] = $arResult;
    $arResponse["status"] = ($arResult["TYPE"] == "OK") || ($arResult === true) ;

    if(!$arResponse["status"]){
      $arResponse["description"] = $arLoc["e_auth"];
      $arResponse["errors"][] = array(
        "name"=>"USER_LOGIN",
        "description"=>$arLoc["e_pass"]
      );
    }
}

echo \Bitrix\Main\Web\Json::encode($arResponse);