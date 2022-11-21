<?php
use \Stranke\Shop\App;

class Contacts extends CBitrixComponent
{
    private $iblockId;
    private $fields = [];

    public function executeComponent()
    {
        if($this->startResultCache())
        {
            $arResult = [];

            $app = App::getInstance();

            $arResult['PHONES'] = $app->config->phones;
            $arResult['ADDRESS'] = $app->config->address;
            $arResult['CITY'] = $app->config->addressLocality;
            $arResult['INFORMATION'] = $app->config->information;

            $this->arResult = $arResult;
            $this->includeComponentTemplate();
        }

        return $this->arResult;
    }
}
