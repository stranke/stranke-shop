<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

class RatingCommonComponent extends CBitrixComponent
{
	public function onPrepareComponentParams($params)
	{

        $this->arResult['VALUE'] = 0;
        $this->arResult['COUNT'] = 0;

		if (!empty($params['VALUE']))
		{
            $this->arResult['VALUE'] = round($params['VALUE'], 1);
		}

        if (!empty($params['COUNT']))
        {
            $this->arResult['COUNT'] = $params['COUNT'];
            $this->arResult['COUNT_TEXT'] = $this->getCountText($params['COUNT']);
        }

        if (!empty($params['LINK']))
        {
            $this->arResult['LINK'] = $params['LINK'];
        }



		return $params;
	}

	public function executeComponent()
	{
		$this->includeComponentTemplate();
	}

	private function getCountText($value)
    {
        $n = $value % 100;
        if ($n > 10 && $n < 20) {
            return Loc::getMessage('ST_RC_COUNT_FORM_3');
        }

        $n = $value % 10;
        if ($n === 1) {
            return Loc::getMessage('ST_RC_COUNT_FORM_1');
        }

        if ($n > 1 && $n < 5) {
            return Loc::getMessage('ST_RC_COUNT_FORM_2');
        }

	    return Loc::getMessage('ST_RC_COUNT_FORM_3');
    }
}