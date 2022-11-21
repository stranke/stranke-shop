<?

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Настройки пользователя");
?>

<?

if ($_REQUEST["change_password"] && $_REQUEST["change_password"] == "yes"):
    $USER_LOGIN = $_REQUEST["USER_LOGIN"];
    $USER_ID = Intval($_REQUEST["USER_ID"]);
    $USER_CHECKWORD = $_REQUEST["USER_CHECKWORD"];
    $rsUser = CUser::GetByLogin($USER_LOGIN);
    $arUser = $rsUser->Fetch();
    $rsUserLog = CUser::GetByID($USER_ID);
    $arUserLog = $rsUserLog->Fetch();

    if ($arUser["CHECKWORD"] == $arUserLog["CHECKWORD"]) {
        global $USER;
        if ($USER->Authorize($USER_ID)) {
            LocalRedirect(SITE_DIR . "personal/");
        }
    }
    ?>

<? endif; ?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>