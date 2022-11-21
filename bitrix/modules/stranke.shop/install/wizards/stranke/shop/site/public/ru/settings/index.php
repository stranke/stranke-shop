<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Центр управления");
?>
<? global $USER; ?>

<? if ($USER->IsAdmin()) { ?>
    <? $APPLICATION->IncludeComponent(
        "stranke:settings",
        "",
        Array(),
        false
    ); ?>
<? } else { ?>
    <?
    CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404", "Y");
    ?>
<? } ?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
