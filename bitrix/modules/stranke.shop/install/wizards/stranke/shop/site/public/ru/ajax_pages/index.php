<?//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "popup_form", Array(
	"REGISTER_URL" => "/login/?register=yes",	// Страница регистрации
	"FORGOT_PASSWORD_URL" => "/login/?forgot_password=yes",	// Страница забытого пароля
	"PROFILE_URL" => SITE_DIR . "personal/",	// Страница профиля
	"SHOW_ERRORS" => "Y",	// Показывать ошибки
	),
	false
);?>
