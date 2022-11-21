<?php
namespace Stranke\Shop;

class Reviews
{
    const SECTION_CODE_COMMON = 'common';
    const SECTION_CODE_PRODUCTS = 'products';
    const PROP_CODE_USER_NAME = 'USER_NAME';
    const PROP_CODE_RATING = 'MARKER';


    private static $instance;
    private $app;

    public $iblockId;
    public $sectionIdCommon;
    public $sectionIdProducts;
    public $propIdUserName;
    public $propIdRating;

    public static function getInstance(): Reviews
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function __construct()
    {
        $this->app = App::getInstance();
        $this->iblockId = $this->app->config->iblockIdReviews;
        $this->initSections();
        $this->initProps();
    }

    private function initSections()
    {
        $arOrder = [];
        $arFilter = [
            'IBLOCK_ID' => $this->iblockId,
        ];
        $dbSections = \CIblockSection::GetList($arOrder, $arFilter);
        while ($arSection = $dbSections->Fetch()) {
            switch ($arSection['CODE']) {
                case self::SECTION_CODE_COMMON:
                    $this->sectionIdCommon = $arSection['ID'];
                    break;
                case self::SECTION_CODE_PRODUCTS:
                    $this->sectionIdProducts = $arSection['ID'];
                    break;
            }
        }
    }

    private function initProps()
    {
        $arOrder = [];
        $arFilter = ['IBLOCK_ID' => $this->iblockId];

        $dbProps = \CIBlockProperty::GetList($arOrder, $arFilter);
        while($arProp = $dbProps->Fetch()) {
            switch ($arProp['CODE']) {
                case self::PROP_CODE_USER_NAME:
                    $this->propIdUserName = $arProp['ID'];
                    break;
                case self::PROP_CODE_RATING:
                    $this->propIdRating = $arProp['ID'];
                    break;
            }
        }
    }
}
