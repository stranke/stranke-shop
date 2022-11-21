<?php

if(empty($_POST)) die();

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$url = $_POST['url'];



$message = GetMessage('ST_NEW_REVIEW_FORM_NAME').": $name;\r\n";
$message .= GetMessage('ST_NEW_REVIEW_FORM_PHONE').":$phone;\r\n";
$message .= "E-mail: $email;\r\n";
$message .= "Url: $url";



$to = "auto-viko@mail.ru"; //куда отправлять письмо
$from = 'info@auto-viko.ru'; // от кого
$subject = GetMessage('ST_NEW_REVIEW_FORM_CHECK_EMAIL'); //тема
$headers = "Content-type: text/html; charset=UTF-8 \r\n";
$headers .= "From: <info@auto-viko.ru>\r\n";
$result = mail($to, $subject, $message, $headers);

if ($result){
  echo GetMessage('ST_NEW_REVIEW_SUCCESS');
}