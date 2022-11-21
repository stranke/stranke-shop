<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
global $DB;
/** @global CUser $USER */
global $USER;
/** @global CMain $APPLICATION */
global $APPLICATION;
/** @global CCacheManager $CACHE_MANAGER */
global $CACHE_MANAGER;


use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\Location;

Loc::loadMessages(__FILE__);
?>
<script type="text/javascript" src='/bitrix/components/bitrix/sale.location.selector.search/templates/.default/script.js'></script>
<link rel="stylesheet" href='/bitrix/components/bitrix/sale.location.selector.search/templates/.default/style.css'/>
<div class="request-call-form js-choisecityForm">

    <div class="request-call-form__bg"></div>

    <div class="request-call-form__container">

        <div class="request-call-form__content">

            <div class="request-call-form__close-btn_ js-choisecityFormCloseBtn">
            </div>

            <div class="request-call-form__title">
                Выберите город
            </div>

            <form name="ChangeCityForm" class="ChangeCityForm" method="POST">
                <?
                /* if (CModule::IncludeModule("iblock")) {
                  $arSelect = array('ID', 'NAME');
                  $arFilter = array('IBLOCK_ID' => 6, 'ACTIVE' => 'Y');
                  $res = CIBlockSection::GetList(array(), $arFilter, false, $arSelect);
                  while ($ar_region = $res->GetNext()) {
                  ?>
                  <label>
                  <input type="radio"<? echo $_SESSION['region_id'] == $ar_region['ID'] ? ' checked' : '' ?> class="inputtext" name="region_city" value="<? echo $ar_region['NAME'] ?>" size="0">	<span><? echo $ar_region['NAME'] ?></span>
                  </label><br>
                  <?
                  };
                  } */
                ?>
                <?php
                $APPLICATION->IncludeComponent("bitrix:sale.location.selector.search", "", Array(
                    "COMPONENT_TEMPLATE" => ".default",
                    "ID" => $_SESSION['city_location_id'], // ID местоположения
                    "CODE" => "", // Символьный код местоположения
                    "INPUT_NAME" => "locationId", // Имя поля ввода
                    "PROVIDE_LINK_BY" => "id", // Сохранять связь через
                    "JSCONTROL_GLOBAL_ID" => "", // Идентификатор javascript-контрола
                    "JS_CALLBACK" => "", // Javascript-функция обратного вызова
                    "SEARCH_BY_PRIMARY" => "Y", // Искать по идентификатору и коду
                    "EXCLUDE_SUBTREE" => "Y", // Исключить поддерево элемента
                    "FILTER_BY_SITE" => "N", // Фильтровать по сайту
                    "SHOW_DEFAULT_LOCATIONS" => "N", // Отображать местоположения по умолчанию
                    "FILTER_SITE_ID" => "s1", // Cайт
                    "CACHE_TYPE" => "A", // Тип кеширования
                    "CACHE_TIME" => "3600", // Время кеширования (сек.)
                ), false
                );
                ?>
                <?
                global $DB;
                $arCities = array();
                $strSql_select = 'SELECT NAME';
                $strSql_where = 'WHERE (ID>0)';
                $strSql = $strSql_select . '
            FROM location_city_counter 
            ' . $strSql_where . ' ORDER BY COUNTER DESC LIMIT 0,20;';

                $sql_result = $DB->Query($strSql, false, $err_mess . __LINE__);
                /*print_r($sql_result);*/
                while ($one_result = $sql_result->Fetch()) {
                    $arCities[] = $one_result['NAME'];
                }
                ?>
                <div class="set_city_from_list">
                    <? foreach ($arCities as $arCity): ?>
                        <a class="js-choisecity btn bg_main"><?= $arCity ?></a>
                    <? endforeach; ?>
                </div>
                <div class="request-call-form__send-request btn bg_main js-choisecityFormSendBtn">
                    Сохранить
                </div>
            </form>

        </div>

    </div>

</div>
