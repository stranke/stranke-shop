<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
  
  global $USER;
  $ID = $USER->GetID();
  $arUser = $USER->GetByID($ID)->Fetch();
  
  if (!empty($arUser)) {
    
    $arFile['del'] = "Y";
    $arFile['old_file'] = $arUser['PERSONAL_PHOTO'];
    $arFile["MODULE_ID"] = "main";
    
    $FIELDS['PERSONAL_PHOTO'] = Array('del' => 'Y', 'old_file' => $arUser['PERSONAL_PHOTO']);
    
    $user = new CUser;
    $user->Update($ID, $FIELDS);
  
    $arResult = array("status"=> true);
  
    echo \Bitrix\Main\Web\Json::encode($arResult);
    
  }