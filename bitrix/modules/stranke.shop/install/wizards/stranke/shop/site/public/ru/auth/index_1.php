<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>
<?

$APPLICATION->IncludeComponent("bitrix:system.auth.form", "header_register_form", Array(
    "REGISTER_URL" => "", // Страница регистрации
    "FORGOT_PASSWORD_URL" => "", // Страница забытого пароля
    "PROFILE_URL" => "", // Страница профиля
    "SHOW_ERRORS" => "Y", // Показывать ошибки
        ), false
);
?>