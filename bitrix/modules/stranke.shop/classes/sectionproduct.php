<?php

namespace Stranke\Shop;

use CFile;
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class SectionProduct
{
    private $arItem;

    public function __construct($arItem)
    {
        $this->arItem = $arItem;
    }

    public function prepare()
    {
        $this->catalog();
        $this->img();
        $this->offers();
        $this->rating();
        $this->price();


        return $this->arItem;
    }

    private function img()
    {
        $imgId = $this->getImgId();

        $img = \CFile::ResizeImageGet(
            $imgId,
            array('width' => 400, 'height' => 245),
            2,
            true
        );

        $arSeo = $this->arItem['IPROPERTY_VALUES'];
        $img['ALT'] = $arSeo['ELEMENT_PREVIEW_PICTURE_FILE_ALT'];
        $img['TITLE'] = $arSeo['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'];

        $this->arItem['IMG'] = $img;
    }

    private function getImgId()
    {
        $imgId = $GLOBALS["OPTIONS"]["NO_PHOTO_PRODUCT_PREVIEW"];

        if (!empty($this->arItem['PREVIEW_PICTURE']['ID'])) {
            $imgId = $this->arItem['PREVIEW_PICTURE']['ID'];
        } elseif (!empty($this->arItem['DETAIL_PICTURE']['ID'])) {
            $imgId = $this->arItem['DETAIL_PICTURE']['ID'];
        }

        return $imgId;
    }

    private function offers()
    {
        if (empty($this->arItem['OFFERS'])) {
            return;
        }

        foreach ($this->arItem['OFFERS'] as $index => $arOffer) {
            $arOffer['DISPLAY_NAME'] = $this->getOfferDisplayName($arOffer);
            $this->getOfferDisplayPrice($arOffer);


            $this->arItem['OFFERS'][$index] = $arOffer;
        }
    }

    private function getOfferDisplayName(&$arOffer)
    {
        $displayName = '';

        foreach ($arOffer['DISPLAY_PROPERTIES'] as $prop) {
            $displayName .= ' ' . $prop['VALUE'];
        }

        if (!empty($arOffer['CATALOG_WEIGHT'])) {
            if (!empty(trim($displayName))) {
                $displayName .= ' / ';
            }

            $displayName .= $arOffer['CATALOG_WEIGHT'] . Loc::getMessage('ST_SECTION_PRODUCT_WEIGHT');
        }

        return trim($displayName);
    }

    private function getOfferDisplayPrice(&$arOffer)
    {
        $price = $arOffer['MIN_PRICE']['VALUE']?$arOffer['MIN_PRICE']['VALUE']:$arOffer['MIN_PRICE']['PRICE'];
        $arOffer['DISPLAY_PRICE'] = $arOffer['MIN_PRICE']['PRINT_VALUE'];
        $arOffer['DISPLAY_OLD_PRICE'] = '';

        if ($arOffer['MIN_PRICE']['DISCOUNT_VALUE'] < $price) {
            $arOffer['DISPLAY_OLD_PRICE'] = $arOffer['DISPLAY_PRICE'];
            $arOffer['DISPLAY_PRICE'] = $arOffer['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
            $this->arItem['IS_DISCOUNT'] = true;
        }
        if ($arOffer['MIN_PRICE']['DISCOUNT']) {
            $arOffer['DISPLAY_OLD_PRICE'] = $arOffer['MIN_PRICE']['PRINT_BASE_PRICE'];
            $arOffer['DISPLAY_PRICE'] = $arOffer['MIN_PRICE']['PRINT_PRICE'];
            $this->arItem['IS_DISCOUNT'] = true;
        }
    }

    private function rating()
    {
        if (empty($this->arItem['PROPERTIES']['rating']['VALUE'])) {
            $this->arItem['PROPERTIES']['rating']['VALUE'] = 0;
        }

        if (empty($this->arItem['PROPERTIES']['vote_count']['VALUE'])) {
            $this->arItem['PROPERTIES']['vote_count']['VALUE'] = 0;
        }

        $rating = (int)$this->arItem['PROPERTIES']['rating']['VALUE'];

        for ($i = 0; $i < 5; $i++) {
            $this->arItem['stars'][] = $i < $rating;
        }
    }

    private function catalog()
    {
        foreach ($this->arItem['PRODUCT'] as $index => $value) {
            $this->arItem['CATALOG_' . $index] = $value;
        }
        if ($this->arItem['OFFERS']) {
            foreach ($this->arItem['OFFERS'] as $key => $arOffer) {
                foreach ($arOffer['PRODUCT'] as $index => $value) {
                    $arOffer['CATALOG_' . $index] = $value;
                }
                $this->arItem['OFFERS'][$key] = $arOffer;
            }
        }
    }

    private function price()
    {
        $price = $this->arItem['MIN_PRICE']['VALUE'] ? $this->arItem['MIN_PRICE']['VALUE'] : $this->arItem['MIN_PRICE']['PRICE'];

        $this->arItem['DISPLAY_PRICE'] = $this->arItem['MIN_PRICE']['PRINT_VALUE'] ? $this->arItem['MIN_PRICE']['PRINT_VALUE'] : $this->arItem['MIN_PRICE']['PRINT_PRICE'];
        $this->arItem['DISPLAY_OLD_PRICE'] = '';

        if ($this->arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $price) {
            $this->arItem['DISPLAY_OLD_PRICE'] = $this->arItem['DISPLAY_PRICE'];
            $this->arItem['DISPLAY_PRICE'] = $this->arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
            $this->arItem['IS_DISCOUNT'] = true;
        }
        if ($this->arItem['MIN_PRICE']['DISCOUNT']) {
            $this->arItem['DISPLAY_OLD_PRICE'] = $this->arItem['MIN_PRICE']['PRINT_BASE_PRICE'];
            $this->arItem['DISPLAY_PRICE'] = $this->arItem['MIN_PRICE']['PRINT_PRICE'];
            $this->arItem['IS_DISCOUNT'] = true;
        }
    }
}
