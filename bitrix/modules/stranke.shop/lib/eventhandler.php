<?php

namespace Stranke\Shop;

use \phpQuery;
use \Bitrix\Main\Localization\Loc;
use Stranke\Shop\Usecases\CalculateRating;

class eventhandler
{
    public function OnBeforeProlog()
    {
        self::getSettings();
        self::updateSettings();
        self::showPanel();
    }


    public static function getSettings()
    {
        global $app, $settings;
        $app = App::getInstance();
        $settings = \Stranke\Shop\Settings::getInstance();
    }

    public static function updateSettings()
    {
        \Bitrix\Main\Loader::includeModule('iblock');
        // It's crazy, but work! Get by ID and by NAME!
        if (!empty($_POST) && $_POST['saveSettings'] === 'Y') {
            $props = [];
            $json_props = ['sms_auth'];

            foreach ($_POST['PROP'] as $code => $value) {
                if (empty($value)) continue;
                $props[$code] = $value;
                if (in_array($code, $json_props) && is_array($value))
                    $props[$code] = json_encode($value);
            }


            $arFilter = [
                'TYPE' => 'services',
                'XML_ID' => 'services_settings_' . SITE_ID,
            ];
            $arIblock = \CIBlock::GetList([], $arFilter)->Fetch();
            $arFilter = ['IBLOCK_ID' => $arIblock['ID']];
            $arElement = \CIBlockElement::GetList([], $arFilter)->Fetch();

            if (!empty($_FILES)) {
                foreach ($_FILES as $propId => $file) {
                    $props[$propId] = $file;
                }
            }

            \CIBlockElement::SetPropertyValues($arElement['ID'], $arIblock['ID'], $props);
        }
    }

    public static function showPanel()
    {
        if ($GLOBALS["USER"]->IsAdmin() && \COption::GetOptionString("main", "wizard_solution", "", SITE_ID) == "shop") {
            $GLOBALS["APPLICATION"]->SetAdditionalCSS("/bitrix/wizards/stranke/shop/css/panel.css");

            $arMenu = Array(
                Array(
                    "ACTION" => "jsUtils.Redirect([], '" . \CUtil::JSEscape("/bitrix/admin/wizard_install.php?lang=" . LANGUAGE_ID . "&wizardSiteID=" . SITE_ID . "&wizardName=stranke:shop&" . bitrix_sessid_get()) . "')",
                    "ICON" => "bx-popup-item-wizard-icon",
                    "TITLE" => GetMessage("STOM_BUTTON_TITLE_W1"),
                    "TEXT" => GetMessage("STOM_BUTTON_NAME_W1"),
                )
            );

            $GLOBALS["APPLICATION"]->AddPanelButton(array(
                "HREF" => "/bitrix/admin/wizard_install.php?lang=" . LANGUAGE_ID . "&wizardName=stranke:shop&wizardSiteID=" . SITE_ID . "&" . bitrix_sessid_get(),
                "ID" => "shop_wizard",
                "ICON" => "bx-panel-site-wizard-icon",
                "MAIN_SORT" => 2500,
                "TYPE" => "BIG",
                "SORT" => 10,
                "ALT" => GetMessage("SCOM_BUTTON_DESCRIPTION"),
                "TEXT" => GetMessage("SCOM_BUTTON_NAME"),
                "MENU" => $arMenu,
            ));
        }
    }

    function OnEndBufferContentHandler(&$content)
    {
        if (!empty($_GET["ID"])) {
            $config = Config::getInstance();

            $ID = $_GET["ID"];
            $arID = $config->getCatalogIblocks();

            if (in_array($ID, $arID) && $_SERVER["SCRIPT_URL"] == '/bitrix/admin/iblock_edit.php') {

                $str_IPROPERTY_TEMPLATES = $_POST["IPROPERTY_TEMPLATES"];

                $doc = phpQuery::newDocumentHTML($content);
                $elem = $doc->find('#IPROPERTY_TEMPLATES_ELEMENT_PAGE_TITLE');

                $ipropTemlates = new \Bitrix\Iblock\InheritedProperty\IblockTemplates($ID);
                $str_IPROPERTY_TEMPLATES = $ipropTemlates->findTemplates();

                $arELEMENT_META = array(
//                    array(
//                        "CODE" => "ELEMENT_META_TITLE_photo",
//                        "NAME" => Loc::getMessage('ST_ELEMENT_META_TITLE_PHOTO'),
//                    ),
//                    array(
//                        "CODE" => "ELEMENT_META_DESCRIPTION_photo",
//                        "NAME" => Loc::getMessage('ST_ELEMENT_META_DESCRIPTION_PHOTO'),
//                    ),
                    array(
                        "CODE" => "ELEMENT_META_TITLE_properties",
                        "NAME" => Loc::getMessage('ST_ELEMENT_META_TITLE_PROPERTIES'),
                    ),
                    array(
                        "CODE" => "ELEMENT_META_DESCRIPTION_properties",
                        "NAME" => Loc::getMessage('ST_ELEMENT_META_DESCRIPTION_PROPERTIES'),
                    ),
                    array(
                        "CODE" => "ELEMENT_META_TITLE_reviews",
                        "NAME" => Loc::getMessage('ST_ELEMENT_META_TITLE_REVIEWS'),
                    ),
                    array(
                        "CODE" => "ELEMENT_META_DESCRIPTION_reviews",
                        "NAME" => Loc::getMessage('ST_ELEMENT_META_DESCRIPTION_REVIEWS'),
                    ),
                    array(
                        "CODE" => "ELEMENT_META_TITLE_related-products",
                        "NAME" => Loc::getMessage('ST_ELEMENT_META_TITLE_RELATED'),
                    ),
                    array(
                        "CODE" => "ELEMENT_META_DESCRIPTION_related-products",
                        "NAME" => Loc::getMessage('ST_ELEMENT_META_DESCRIPTION_RELATED'),
                    )

                );

                $str = "";
                foreach ($arELEMENT_META as $meta) {
                    $str .= '<tr class="adm-detail-valign-top">';
                    $str .= '<td width="40%">' . $meta["NAME"] . '</td>';
                    $str .= '<td width="60%">' . IBlockInheritedPropertyInput($ID, $meta["CODE"], $str_IPROPERTY_TEMPLATES, "E") . '</td>';
                    $str .= '</tr>';

                }

                $elem->parent()->append($str);
                $content = $doc->html();

            }
        }

        if ($_SERVER["SCRIPT_URL"] == '/bitrix/admin/seo_sitemap.php') {
            $content = str_replace("/bitrix/admin/seo_sitemap_run.php", "/ajax/seo_sitemap_run.php", $content);
        }
    }

    function OnBeforeIBlockUpdateHandler(&$arFields)
    {
        $config = Config::getInstance();
        $arID = $config->getCatalogIblocks();;

        if (in_array($arFields["ID"], $arID) && !empty($arFields["IPROPERTY_TEMPLATES"])) {
            $ar = array(
                "ELEMENT_META_TITLE_photo" => $_POST["IPROPERTY_TEMPLATES"]["ELEMENT_META_TITLE_photo"]["TEMPLATE"],
                "ELEMENT_META_DESCRIPTION_photo" => $_POST["IPROPERTY_TEMPLATES"]["ELEMENT_META_DESCRIPTION_photo"]["TEMPLATE"],
                "ELEMENT_META_TITLE_reviews" => $_POST["IPROPERTY_TEMPLATES"]["ELEMENT_META_TITLE_reviews"]["TEMPLATE"],
                "ELEMENT_META_DESCRIPTION_reviews" => $_POST["IPROPERTY_TEMPLATES"]["ELEMENT_META_DESCRIPTION_reviews"]["TEMPLATE"],
                "ELEMENT_META_TITLE_related-products" => $_POST["IPROPERTY_TEMPLATES"]["ELEMENT_META_TITLE_related-products"]["TEMPLATE"],
                "ELEMENT_META_DESCRIPTION_related-products" => $_POST["IPROPERTY_TEMPLATES"]["ELEMENT_META_DESCRIPTION_related-products"]["TEMPLATE"],
                "ELEMENT_META_TITLE_properties" => $_POST["IPROPERTY_TEMPLATES"]["ELEMENT_META_TITLE_properties"]["TEMPLATE"],
                "ELEMENT_META_DESCRIPTION_properties" => $_POST["IPROPERTY_TEMPLATES"]["ELEMENT_META_DESCRIPTION_properties"]["TEMPLATE"],

            );

            $arFields["IPROPERTY_TEMPLATES"] = array_merge($arFields["IPROPERTY_TEMPLATES"], $ar);
        }
    }

    public function OnAfterIBlockElementAdd(&$arFields)
    {
        self::recalcRating($arFields);
    }

    public function OnAfterIBlockElementUpdate(&$arFields)
    {
        self::recalcRating($arFields);
    }

    public function OnBeforeIBlockElementDelete($ID)
    {
        \Bitrix\Main\Loader::includeModule('iblock');
        $res = \CIBlockElement::GetByID($ID);
        if ($arFields = $res->GetNext()) {

            $arIblockReviews = [];
            $dbResult = \CIBlock::GetList([], ['CODE' => 'content_reviews_%']);
            while ($arIblock = $dbResult->Fetch()) {
                $arIblockReviews[] = $arIblock['ID'];
            }

            if (in_array($arFields['IBLOCK_ID'], $arIblockReviews)) {
                $usecase = new CalculateRating($ID, true);
                $usecase->execute();
            }
        }
    }

    public static function OnOrderNewSendEmail($orderID, &$eventName, &$arFields)
    {
        \Bitrix\Main\Loader::includeModule('sale');
        $arOrder = \CSaleOrder::GetByID($orderID);
        $arOrderProps = [];

        $PHONE = '';
        $STREET = '';
        $HOME = '';
        $APARTMENT = '';
        $ENTRANCE = '';
        $FLOOR = '';
        $FIO = '';

        $dbOrderProps = \CSaleOrderPropsValue::GetOrderProps($orderID);
        while ($arProps = $dbOrderProps->Fetch()) {

            $arOrderProps[$arProps["CODE"]] = $arProps;
            // Телефон
            if ($arProps["CODE"] === 'PHONE') {
                $PHONE = $arProps['VALUE'];
            }
            // Улица
            if ($arProps["CODE"] === 'STREET') {
                $STREET = $arProps['VALUE'];
            }
            // Дом
            if ($arProps["CODE"] === 'HOME') {
                $HOME = $arProps['VALUE'];
            }
            // Квартира
            if ($arProps["CODE"] === 'APARTMENT') {
                $APARTMENT = $arProps['VALUE'];
            }
            // Подьезд
            if ($arProps["CODE"] === 'ENTRANCE') {
                $ENTRANCE = $arProps['VALUE'];
            }
            // Этаж
            if ($arProps["CODE"] === 'FLOOR') {
                $FLOOR = $arProps['VALUE'];
            }
            // Ф.И.О.
            if ($arProps["CODE"] === 'FIO') {
                $FLOOR = $arProps['VALUE'];
            }
        }

        $DELIVERY = '';
        $PAY_SYSTEM = '';

        if ($delivery = \CSaleDelivery::GetByID($arOrder["DELIVERY_ID"])) {
            $DELIVERY = $delivery['NAME'];
        }

        if ($arPaySys = \CSalePaySystem::GetByID($arOrder["PAY_SYSTEM_ID"])) {
            $PAY_SYSTEM = $arPaySys["PSA_NAME"];
        }

        $arFields["ORDER_COMMENT"] = $arOrder["USER_DESCRIPTION"];
        $arFields["PHONE"] = $PHONE;
        $arFields["STREET"] = $STREET;
        $arFields["HOME"] = $HOME;
        $arFields["APARTMENT"] = $APARTMENT;
        $arFields["ENTRANCE"] = $ENTRANCE;
        $arFields["FLOOR"] = $FLOOR;
        $arFields["FIO"] = $FIO;
        $arFields["DELIVERY"] = $DELIVERY;
        $arFields["PAY_SYSTEM"] = $PAY_SYSTEM;
        $arFields["PRICE_DELIVERY"] = $arOrder["PRICE_DELIVERY"];
    }

    private function recalcRating($arFields)
    {
        $arIblockReviews = [];
        $dbResult = \CIBlock::GetList([], ['CODE' => 'content_reviews_%']);
        while ($arIblock = $dbResult->Fetch()) {
            $arIblockReviews[] = $arIblock['ID'];
        }

        if (in_array($arFields['IBLOCK_ID'], $arIblockReviews)) {
            $usecase = new CalculateRating($arFields['ID']);
            $usecase->execute();
        }
    }
}
