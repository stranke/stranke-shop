<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
$arErors = array();

$IBLOCK_ID = 13;
//$IBLOCK_SECTION_ID = 6416;
$fields = array('COMMENT', 'USERPHONE', 'URL');
$req_fields = array('USERPHONE');


$data = array();
foreach ($fields as $key) {
    $input = strip_tags($_POST[$key]);
    $input = htmlspecialchars($input);
    $data[$key] = $input;
}
foreach ($req_fields as $key) {
    if (empty($data[$key]))
        $arErors["ERROR"][] = $key . "=Заполните поле";
}

$key = 'USEREMAIL';
if (!empty($data[$key])) {
    if (filter_var($data[$key], FILTER_VALIDATE_EMAIL) === false)
        $arErors["ERROR"][] = $key . "=Заполните поле правильно";
}
if (!empty($arErors)) {
    echo json_encode($arErors);
} else {
    if (CModule::IncludeModule("iblock")) {
        $input_coment = $_POST['COMMENT'];
        $el = new CIBlockElement;
        $arLoadProductArray = Array(
            "IBLOCK_SECTION_ID" => $IBLOCK_SECTION_ID,
            "IBLOCK_ID" => $IBLOCK_ID,
            "NAME" =>$_POST['USERPHONE'] .' - '. $_POST['FORM'],
            "ACTIVE" => "N",
            "ACTIVE_FROM" => date('d.m.Y G:i:s'),
            "PREVIEW_TEXT" => $input_coment
        );

        if ($PRODUCT_ID = $el->Add($arLoadProductArray)) {
            CIBlockElement::SetPropertyValues($PRODUCT_ID, $IBLOCK_ID, $data);

            $elUpd = new CIBlockElement;
            $arUpdProductArray = Array(
                "CODE" => "job_" . $PRODUCT_ID
            );
            $resUpd = $elUpd->Update($PRODUCT_ID, $arUpdProductArray);



            $input_coment .= '<br><br>Для просмотра информации пройдите по ссылке: <a target="_blank" href="' . $_SERVER['HTTP_X_FORWARDED_PROTO'] . '://' . $_SERVER['HTTP_HOST'] . '/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=' . $IBLOCK_ID . '&type=order&ID=' . $PRODUCT_ID . '&lang=ru&find_section_section=' . $IBLOCK_SECTION_ID . '&WF=Y' . '">новый заказ звонка</a>';
            $arMail = $data;
            $arMail["TEXT"] = $input_coment;

            $dataToMail = [
                'CALLBACK_TITLE' => 'заказа звонка с главной страницы',
                'AUTHOR_PHONE' => $_POST['USERPHONE']
            ];

            if ($emlsend = CEvent::Send('CALLBACK_CALL', 's1', $dataToMail, "Y", 53)) {
                $arans["SUCCESS"][] = "Заявка принята=Наш администратор свяжется<br>с Вами в ближайшее время";
                echo json_encode($arans);
            } else {
                $arans["SUCCESS"][] = "Ошибка отправки=В данное время сообщение не может быть отправлено";
                echo json_encode($arans);
            }
        } else {
            $arans["SUCCESS"][] = "Ошибка отправки=В данное время сообщение не может быть отправлено.";
            echo json_encode($arans);
        }
    }
}
?>
