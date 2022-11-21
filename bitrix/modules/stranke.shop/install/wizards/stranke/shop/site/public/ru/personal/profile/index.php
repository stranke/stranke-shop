<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Настройки пользователя");
?>

<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "pages_crumbs_vsevset", Array(
"START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
"PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
"SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
),
false
);?>

<div class="text_pages">
    <div class="left_side">
        <h2>Личный кабинет</h2>
        <ul>
            <li><a href="/personal/" class="active">Личный кабинет</a></li>
            <?php if ($USER->IsAuthorized()): ?>
                <li><a href="/personal/order/">Список заказов</a></li>
            <?php endif; ?>
            <li><a href="/personal/cart/">Корзина</a></li>
            <li><a href="/personal/subscribe/">Управление подпиской</a></li>
        </ul>


        <?
        /*
        $APPLICATION->IncludeComponent("bitrix:news.detail", "banner_left_page", Array(
        "IBLOCK_TYPE" => "site_banners",	// Тип информационного блока (используется только для проверки)
        "IBLOCK_ID" => "15",	// Код информационного блока
        "ELEMENT_ID" => "5576",	// ID новости
        "ELEMENT_CODE" => "",	// Код новости
        "CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
        "FIELD_CODE" => array(	// Поля
        0 => "",
        1 => "",
        ),
        "PROPERTY_CODE" => array(	// Свойства
        0 => "",
        1 => "",
        ),
        "IBLOCK_URL" => "",	// URL страницы просмотра списка элементов (по умолчанию - из настроек инфоблока)
        "AJAX_MODE" => "N",	// Включить режим AJAX
        "AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
        "AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
        "AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
        "CACHE_TYPE" => "A",	// Тип кеширования
        "CACHE_TIME" => "3600",	// Время кеширования (сек.)
        "CACHE_GROUPS" => "Y",	// Учитывать права доступа
        "META_KEYWORDS" => "-",	// Установить ключевые слова страницы из свойства
        "META_DESCRIPTION" => "-",	// Установить описание страницы из свойства
        "BROWSER_TITLE" => "-",	// Установить заголовок окна браузера из свойства
        "SET_STATUS_404" => "N",	// Устанавливать статус 404, если не найдены элемент или раздел
        "SET_TITLE" => "N",	// Устанавливать заголовок страницы
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
        "ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
        "ADD_ELEMENT_CHAIN" => "N",	// Включать название элемента в цепочку навигации
        "ACTIVE_DATE_FORMAT" => "",	// Формат показа даты
        "USE_PERMISSIONS" => "N",	// Использовать дополнительное ограничение доступа
        "PAGER_TEMPLATE" => "",	// Шаблон постраничной навигации
        "DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
        "DISPLAY_BOTTOM_PAGER" => "N",	// Выводить под списком
        "PAGER_TITLE" => "Страница",	// Название категорий
        "PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
        "DISPLAY_DATE" => "N",	// Выводить дату элемента
        "DISPLAY_NAME" => "N",	// Выводить название элемента
        "DISPLAY_PICTURE" => "Y",	// Выводить детальное изображение
        "DISPLAY_PREVIEW_TEXT" => "N",	// Выводить текст анонса
        "USE_SHARE" => "N",	// Отображать панель соц. закладок
        "AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
        ),
        false
        );
        */
        ?>
    </div>
    <div class="right_side">
        <h1>Изменение регистрационных данных</h1>
        <?$APPLICATION->IncludeComponent("bitrix:main.profile", "profile_settings_vsevset", Array(
        "AJAX_MODE" => "N",	// Включить режим AJAX
        "AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
        "AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
        "AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
        "SET_TITLE" => "Y",	// Устанавливать заголовок страницы
        "USER_PROPERTY" => "",	// Показывать доп. свойства
        "SEND_INFO" => "N",	// Генерировать почтовое событие
        "CHECK_RIGHTS" => "Y",	// Проверять права доступа
        "AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
        ),
        false
        );?>
    </div>
    <div class="clear"></div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>