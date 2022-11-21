<?

require $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php';
global $USER;

use \Stranke\Shop\Reviews;
$reviews = Reviews::getInstance();

$arResponse = array("status"=> false);

$text = $_POST['msg'];
$rateValue = $_POST['rating'];

if ($USER->IsAuthorized()){
  $userID = $USER->GetID();

  $rsUser = CUser::GetByID($userID);
  $arUser = $rsUser->Fetch();

  $userName = $arUser['NAME'];
  $userPhone = $arUser['PERSONAL_PHONE'];
  $userEmail = $arUser['EMAIL'];
} else {
  $userID = '';
  $userName = $_POST['name'];
  $userPhone = $_POST['phone'];
  $userEmail = $_POST['email'];
}

$iblock_id = $reviews->iblockId;
$sectionId = $reviews->sectionIdCommon;

$date =  date('d.m.Y h:i:s');
$name = GetMessage('REVIEW') . $date;

$el = new CIBlockElement;
$PROP = array();
$PROP['USER_NAME'] = $userName;
$PROP['USER_PHONE'] = $userPhone;
$PROP['MAIL'] = $userEmail;
$PROP['MARKER'] = $rateValue;
$PROP['USER_BIND'] = $userID;

// ID - id раздела общих отзывов

$section = CIBlockSection::GetList(array("SORT"=>"ASC"), array('IBLOCK_ID'=>$iblock_id, 'ID'=> $sectionId));

if (empty($section->SelectedRowsCount())) {
  $bs = new CIBlockSection;
  $arFields = Array(
    "ACTIVE" => 'Y',
    "ID" => $sectionId,
    "IBLOCK_ID" => $iblock_id,

  );

  $ID = $bs->Add($arFields);
  $sectionId = $ID;

} else {
	$section = $section->GetNext();
  	$sectionId = $section['ID'];
}

$arLoadProductArray = Array(
  "ACTIVE_FROM"    => $date,
  "MODIFIED_BY"    => $userID,
  "IBLOCK_SECTION_ID" => $sectionId,
  "IBLOCK_ID"      => $iblock_id,
  "PROPERTY_VALUES"=> $PROP,
  "NAME"           => $name,
  "ACTIVE"         => "N",            // не   активен
  "PREVIEW_TEXT"   => "$text",
  "DETAIL_TEXT"    => "",
);

if($PRODUCT_ID = $el->Add($arLoadProductArray)) {

  $arLog = array (
    '1' => 'success',
    '2' => $arLoadProductArray,
    '3' => $PRODUCT_ID
  );

  $arResponse ['status'] = true;
} else {

  $arLog = array(
    '1' => 'error',
    '2' => $arLoadProductArray
  );

  $arResponse['status'] = false;
  $arResponse['error'] = $el->LAST_ERROR;
}
header('Content-Type: application/json; charset=utf-8');
echo \Bitrix\Main\Web\Json::encode($arResponse,  null);

