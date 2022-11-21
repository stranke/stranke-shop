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
  if (empty($userName)) {
    $userName = $arUser['LOGIN'];
  }

  $userPhone = $arUser['PERSONAL_PHONE'];
  $userEmail = $arUser['EMAIL'];
} else {
  $userID = '';
  $userName = $_POST['name'];
  $userPhone = $_POST['phone'];
  $userEmail = $_POST['email'];
}

$iblock_id = $reviews->iblockId;
$section_id = $reviews->sectionIdProducts;

$productID = $_POST['section-id'];
$date =  date('d.m.Y h:i:s');
$name = GetMessage('REVIEW') . $date;


$el = new CIBlockElement;
$PROP = array();
$PROP['USER_NAME'] = $userName;
$PROP['USER_PHONE'] = $userPhone;
$PROP['MAIL'] = $userEmail;
$PROP['MARKER'] = $rateValue;
$PROP['USER_BIND'] = $userID;

// SECTION_ID - id раздела отзывов о товаре

$section = CIBlockSection::GetList(array("SORT"=>"ASC"), array('IBLOCK_ID'=>$iblock_id, 'SECTION_ID'=>$section_id, 'NAME'=>$productID));

if (($section->SelectedRowsCount()) == 0) {
  $bs = new CIBlockSection;
  $arFields = Array(
    "ACTIVE" => 'Y',
    "IBLOCK_SECTION_ID" => $section_id,
    "IBLOCK_ID" => $iblock_id,
    "NAME" => $productID
  );

  $ID = $bs->Add($arFields);
  $sectionId = $ID;

  if ($ID <= 0) {
    $arResponse['error'] = $bs->LAST_ERROR;
  }

  $arResponse['variant'] = 'new section';

} else {
  $section = $section->GetNext();
  $sectionId = $section['ID'];

  $arResponse['variant'] = 'section exist';
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
    '1' => 'success'. $PRODUCT_ID,
    '2' => $arLoadProductArray
  );

//  Bitrix\Main\Diag\Debug::writeToFile($arLog,date('d.m.Y H:i:s'),"/bitrix/php_interface/test1.txt");

  $arResponse['status'] = true;

} else {

  $arLog = array(
    '1' => 'error' . $el->LAST_ERROR,
    '2' => $arLoadProductArray
  );

//  Bitrix\Main\Diag\Debug::writeToFile($arLog,date('d.m.Y H:i:s'),"/bitrix/php_interface/test1.txt");

  $arResponse ['status'] = false;

}

echo \Bitrix\Main\Web\Json::encode($arResponse);

?>

