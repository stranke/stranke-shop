<?php
use Bitrix\Main\Localization\Loc;

class SettingsHelper
{
    private $wizard;
    private $iblockID;
    private $element;

    public function __construct(&$wizard, $iblockID)
    {
        $this->wizard = $wizard;
        $this->iblockID = $iblockID;

        $this->setup();
        $this->setLogo();
        $this->setSecFilterMask();
        $this->replace();
    }

    public function setLogo()
    {
        $fileId = $this->wizard->GetVar("siteLogo");
        if ($fileId) {
            $arFile = CFile::MakeFileArray($fileId);
        } else {
            $file = $_SERVER['DOCUMENT_ROOT'].WIZARD_STRANKE_PATH.'/images/logo.png';
            $arFile = CFile::MakeFileArray($file);
        }
        $arFile["MODULE_ID"] = "iblock";

        $arProps = [
            'LOGO' => $arFile,
            'organizationName' => $this->wizard->GetVar("siteName"),
            'INFORMATION' => $this->wizard->GetVar("siteSchedule"),
            'PHONES' => [$this->wizard->GetVar("siteTelephone")],
            'addressLocality' => [$this->wizard->GetVar("shopLocation")],
            'streetAddress' => [$this->wizard->GetVar("shopAdr")],
        ];
        CIBlockElement::SetPropertyValuesEx(
            $this->element['ID'],
            $this->iblockID,
            $arProps
        );

        if ($fileId) {
            CFile::Delete($fileId);
        }
    }

    private function setup()
    {
        $arFilter = ['IBLOCK_ID' => $this->iblockID];
        $this->element = CIBlockElement::GetList([], $arFilter)->Fetch();
        if (!$this->element) {

            throw new Exception(Loc::getMessage('ST_SETTING_HEPLER_EXEPTOPN'));
        }
    }

    private function replace()
    {
        $bitrixTemplateDir = $_SERVER["DOCUMENT_ROOT"].BX_PERSONAL_ROOT."/templates";
        CWizardUtil::ReplaceMacros(
            $bitrixTemplateDir."/shop/options.php",
            ["SETTINGS_IBLOCK_ID" => $this->iblockID]
        );

    }

    private function setSecFilterMask()
    {
        global $DB;
        $mask = "*/settings/*";

        $arLikeSearch = array("?", "*", ".");
        $arLikeReplace = array("_",  "%", "\\.");
        $arPregSearch = array("\\", ".",  "?", "*",   "'");
        $arPregReplace = array("/",  "\.", ".", ".*?", "\'");
        $arMask = array(
            "SORT" => 500,
            "FILTER_MASK" => $mask,
            "LIKE_MASK" => str_replace($arLikeSearch, $arLikeReplace, $mask),
            "PREG_MASK" => str_replace($arPregSearch, $arPregReplace, $mask),
        );
        $DB->Add("b_sec_filter_mask", $arMask);
    }
}
