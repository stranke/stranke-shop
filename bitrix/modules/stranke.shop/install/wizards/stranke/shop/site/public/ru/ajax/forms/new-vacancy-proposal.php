<? require $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php';
// TODO: NOT USED!!! REMOVE
$arResponse = array("status"=> false);

$IBLOCK_ID = 51;

$data = array();
$test = 0;

$data['FIO'] = $_POST['fio'];
$data['CITY'] = $_POST['city'];
$data['PHONE'] = $_POST['phone'];
$data['EMAIL'] = $_POST['email'];

$data['FILE'] = $_FILES['file'];
$name = $data['FILE']['name'];

if (CModule::IncludeModule("iblock")) {
//  $input_coment = $_POST['COMMENT'];
  $el = new CIBlockElement;
  $test = 1;
  $arLoadProductArray = Array(
    "IBLOCK_ID" => $IBLOCK_ID,
    'IBLOCK_SECTION_ID'=> false,
    "NAME" => 'Заявка от ' . date('d.m.Y G:i:s'),
    "ACTIVE" => "N",
    "ACTIVE_FROM" => date('d.m.Y G:i:s'),
    "PREVIEW_TEXT" => ''
  );

  if ($PRODUCT_ID = $el->Add($arLoadProductArray)) {
    $test = 2;

    CIBlockElement::SetPropertyValues($PRODUCT_ID, $IBLOCK_ID, $data);

    $elUpd = new CIBlockElement;
    $arUpdProductArray = Array(
      "CODE" => "job_" . $PRODUCT_ID
    );
    $resUpd = $elUpd->Update($PRODUCT_ID, $arUpdProductArray);

    $input_coment .= 'Для просмотра информации пройдите по ссылке: <a target="_blank" href="' . $_SERVER['HTTP_X_FORWARDED_PROTO'] . '://' . $_SERVER['HTTP_HOST'] . '/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=' . $IBLOCK_ID . '&type=order&ID=' . $PRODUCT_ID . '&WF=Y' . '">новый заказ звонка</a>';
    $arMail = $data;
    $arMail["TEXT"] = $input_coment;

    if ($emlsend = CEvent::Send('VACANCY_FORM', 's1', $arMail, "Y", 91)) {
      $arLog = array(
        'success'=> 'true',
        'post'=>$_POST,
        'file'=>$_FILES['FILE'],
        'data'=> $data
      );
      $arResponse = array("status"=> true, 'title'=>'Ваша заявка принята.', 'text'=>'Наш администратор свяжется с Вами в ближайшее время.' );
    } else {
      $arLog = array(
        'success'=> 'false',
        'post'=>$_POST,
        'file'=>$_FILES['FILE'],
        'data'=> $data
      );
      $arResponse = array("status"=> false, 'title'=>'Ошибка отправки.', 'text'=>'Повторите отправку позже.');
    }

  } else {
    $arLog = array(
      'success'=> 'false',
      'post'=>$_POST,
      'file'=>$_FILES['FILE'],
      'data'=> $data
    );
    $arResponse = array("status"=> false);
  }
}
echo \Bitrix\Main\Web\Json::encode($arResponse);