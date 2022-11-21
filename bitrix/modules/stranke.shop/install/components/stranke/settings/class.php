<?php
require_once 'classes/Field.php';
use \Bitrix\Main\Loader;
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class Settings extends CBitrixComponent
{
    private $iblockId;
    public $fields = [];

    public function executeComponent()
    {
        if (empty($this->arParams['TITLE'])) {
            $this->arParams['TITLE'] = Loc::getMessage('ST_SETTINGS_TITLE');
        }

        if($this->startResultCache())
        {
            Loader::includeModule('iblock');

            $this->findIblock();
            $this->setFields();

            $this->includeComponentTemplate();
        }

        return $this->arResult;
    }

    private function findIblock()
    {
        $arFilter = [
            'TYPE' => 'services',
            'XML_ID' => 'services_settings_'.SITE_ID,
        ];
        $arIblock = CIBlock::GetList([], $arFilter)->Fetch();

        $this->iblockId = $arIblock['ID'];
    }

    private function setFields()
    {
        $arFilter = ['IBLOCK_ID' => $this->iblockId];
        $oElement =  CIBlockElement::GetList([], $arFilter)->GetNextElement();
        $arFields = $oElement->GetProperties();
        $this->fields = $this->setEnum($arFields);
    }

    private function setEnum($arFields)
    {
        $arOrder = ["SORT"=>"ASC", "VALUE"=>"ASC"];
        $arFilter = ['IBLOCK_ID' => $this->iblockId];

        $dbPropEnum = CIBlockPropertyEnum::GetList($arOrder, $arFilter);
        while($arEnum = $dbPropEnum->GetNext()) {
            $propId = !empty($arEnum['PROPERTY_CODE']) ?
                $arEnum['PROPERTY_CODE'] : $arEnum['PROPERTY_ID'];

            $arFields[$propId]['ENUM'][] = $arEnum;
        }

        return $arFields;
    }

    public function render($fieldName)
    {
        if (!in_array($fieldName, array_keys($this->fields))) {
            return false;
        }

        (new Field($this->fields[$fieldName]))->render();
    }
}
