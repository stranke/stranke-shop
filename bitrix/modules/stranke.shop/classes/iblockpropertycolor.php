<?php
namespace Stranke\Shop;

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class IblockPropertyColor
{
    public static function GetUserTypeDescription()
    {
        return array(
            'PROPERTY_TYPE' => 'S',
            'USER_TYPE' => 'STRANKE_COLOR',
            'DESCRIPTION' => Loc::getMessage('STRANKE_PROPERTY_COLOR_NAME'),
            "GetPropertyFieldHtml" =>array("\Stranke\Shop\IblockPropertyColor", "GetPropertyFieldHtml"),
        );
    }

    public static function GetPropertyFieldHtml($arProperty, $value, $arHTMLControlName)
    {
        return '<input type="text" name="'.$arHTMLControlName["VALUE"].'" value="'.$value["VALUE"].'">';
    }
}
