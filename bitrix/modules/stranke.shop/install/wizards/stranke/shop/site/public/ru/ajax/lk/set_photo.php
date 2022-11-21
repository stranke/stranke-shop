<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
  
  global $USER;
  $ID = $USER->GetID();
  $arUser = $USER->GetByID($ID)->Fetch();
  
  if (!empty($_FILES['file']['tmp_name'])) {
    
    move_uploaded_file($_FILES["file"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . '/upload/tmp/'. $_FILES["file"]["name"]);
    
    $arFile = CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'] . '/upload/tmp/'. $_FILES["file"]["name"]);
  
    CFile::ResizeImage(
      $arFile,
      array("width"=>132, "height"=>132),
      BX_RESIZE_IMAGE_EXACT
    );
    
    $arFile['del'] = "Y";
    $arFile['old_file'] = $arUser['PERSONAL_PHOTO'];
    $arFile["MODULE_ID"] = "main";
    
    $FIELDS['PERSONAL_PHOTO'] = $arFile;

    $user = new CUser;
    $user->Update($ID, $FIELDS);
    
    $arResult = array("status"=> true);
    
    echo \Bitrix\Main\Web\Json::encode($arResult);

  }

  
  
  
  
