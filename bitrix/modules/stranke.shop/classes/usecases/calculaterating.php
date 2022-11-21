<?php

namespace Stranke\Shop\Usecases;

use Bitrix\Main\Localization\Loc;

class CalculateRating
{
    private $reviewId;
    private $is_deleting;
    private $review = null;
    private $section = null;
    private $count = null;

    public function __construct($reviewId, $is_deleting = false)
    {
        $this->reviewId = $reviewId;
        $this->is_deleting = $is_deleting;
    }

    public function execute()
    {
        $this->review = $this->fetchReview();
        if (empty($this->review['IBLOCK_SECTION_ID'])) {
            return;
        }

        $this->section = $this->fetchSection($this->review['IBLOCK_SECTION_ID']);
        $this->updateSectionRating();

        if (!$this->isCommonReviews()) {
            $this->updateProductRating();
        }
    }

    private function fetchReview()
    {
        return \CIBlockElement::GetByID($this->reviewId)->Fetch();
    }

    private function fetchSection($id)
    {
        return \CIBlockSection::GetByID($id)->Fetch();
    }

    private function updateSectionRating()
    {
        $deleted_id = '';
        if($this->is_deleting) {
            $deleted_id = $this->reviewId;
        }

        $arFilter = [
            'IBLOCK_SECTION_ID' => $this->section['ID'],
            'ACTIVE' => 'Y',
            '!ID'=> $deleted_id // ѕри удалении исключаем элемент из запроса,
            // так как на момент срабатывани€ событи€ он еще не удалилс€ из базы данных
        ];

        $arSelect = ['IBLOCK_ID', 'ID', 'PROPERTY_MARKER'];
        $dbResult = \CIBlockElement::GetList([], $arFilter, false, false, $arSelect);

        $arFields = [
            'UF_RATING' => 0,
            'UF_RATING_COUNT' => 0,
            'UF_RATING_SUMM' => 0,
        ];

        if ($count = $dbResult->SelectedRowsCount()) {
            while($arReview = $dbResult->Fetch()) {
                $arFields['UF_RATING_SUMM'] += $arReview['PROPERTY_MARKER_VALUE'];
            }

            $arFields['UF_RATING_COUNT'] = $count;
            $arFields['UF_RATING'] = round($arFields['UF_RATING_SUMM'] / $count, 1);
            $this->count = $count;
        }

        $this->section = array_merge($this->section, $arFields);

        $ibs = new \CIBlockSection();
        $ibs->Update($this->section['ID'], $arFields);
    }

    private function isCommonReviews()
    {
        return $this->section['NAME'] === Loc::getMessage('ST_CALC_RATING_COMMON_SECTION_NAME');
    }

    private function updateProductRating()
    {
        $arProduct = \CIBlockElement::GetByID($this->section['NAME'])->Fetch();
        if (empty($arProduct)) {
            return;
        }

        $propertyValues = [
            'rating' => (float)$this->section['UF_RATING'],
            'REVIEWS_COUNT' => (int)$this->count
        ];
        \CIBlockElement::SetPropertyValuesEx($arProduct['ID'], $arProduct['IBLOCK_ID'], $propertyValues);
    }
}
