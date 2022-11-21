<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>

<?php

$APPLICATION->IncludeComponent("bitrix:form.result.new", "comment_form", Array(
    "WEB_FORM_ID" => "1", // ID веб-формы
    "IGNORE_CUSTOM_TEMPLATE" => "N", // Игнорировать свой шаблон
    "USE_EXTENDED_ERRORS" => "Y", // Использовать расширенный вывод сообщений об ошибках
    "SEF_MODE" => "N", // Включить поддержку ЧПУ
    "SEF_FOLDER" => "/ajax_pages/", // Каталог ЧПУ (относительно корня сайта)
    "SEF_URL_TEMPLATES" => Array(
        "view" => "/ajax_pages/comment.php#RESULT_ID#/"
    ),
    "CACHE_TYPE" => "A", // Тип кеширования
    "CACHE_TIME" => "3600", // Время кеширования (сек.)
    "LIST_URL" => "", // Страница со списком результатов
    "EDIT_URL" => "", // Страница редактирования результата
    "SUCCESS_URL" => "", // Страница с сообщением об успешной отправке
    "CHAIN_ITEM_TEXT" => "", // Название дополнительного пункта в навигационной цепочке
    "CHAIN_ITEM_LINK" => "", // Ссылка на дополнительном пункте в навигационной цепочке
    "VARIABLE_ALIASES" => array(
        "WEB_FORM_ID" => "WEB_FORM_ID",
        "RESULT_ID" => "RESULT_ID",
    )
        ), false
);
?>