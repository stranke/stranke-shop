<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

use \Bitrix\Catalog\RoundingTable;

if(!CModule::IncludeModule("iblock") || !CModule::IncludeModule("catalog"))
	return;

if(COption::GetOptionString("shop", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
	return;


$iblockType = "catalog";
$iblockXmlId = "catalog_products_".WIZARD_SITE_ID;
$iblockXmlFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/catalog/catalog.xml";

$rsIBlock = CIBlock::GetList([], ["TYPE" => $iblockType, "XML_ID" => $iblockXmlId]);
$IBLOCK_CATALOG_ID = false;
if ($arIBlock = $rsIBlock->Fetch()) {
	$IBLOCK_CATALOG_ID = $arIBlock["ID"];
}

if (WIZARD_INSTALL_DEMO_DATA && $IBLOCK_CATALOG_ID)
{
	$boolFlag = true;
	$arSKU = CCatalogSKU::GetInfoByProductIBlock($IBLOCK_CATALOG_ID);
	if (!empty($arSKU))
	{
		$boolFlag = CCatalog::UnLinkSKUIBlock($IBLOCK_CATALOG_ID);
		if (!$boolFlag)
		{
			$strError = "";
			if ($ex = $APPLICATION->GetException())
			{
				$strError = $ex->GetString();
			}
			else
			{
				$strError = "Couldn't unlink iblocks";
			}
			//die($strError);
		}
		$boolFlag = CIBlock::Delete($arSKU['IBLOCK_ID']);
		if (!$boolFlag)
		{
			$strError = "";
			if ($ex = $APPLICATION->GetException())
			{
				$strError = $ex->GetString();
			}
			else
			{
				$strError = "Couldn't delete offers iblock";
			}
			//die($strError);
		}
	}
	if ($boolFlag)
	{
		$boolFlag = CIBlock::Delete($IBLOCK_CATALOG_ID);
		if (!$boolFlag)
		{
			$strError = "";
			if ($ex = $APPLICATION->GetException())
			{
				$strError = $ex->GetString();
			}
			else
			{
				$strError = "Couldn't delete catalog iblock";
			}
			//die($strError);
		}
	}
	if ($boolFlag)
	{
		$IBLOCK_CATALOG_ID = false;
	}
}


$dbResultList = CCatalogGroup::GetList(array(), array("BASE" => "Y"));
if(!($dbResultList->Fetch()))
{
	$arFields = array();
	$rsLanguage = CLanguage::GetList($by, $order, array());
	while($arLanguage = $rsLanguage->Fetch())
	{
		WizardServices::IncludeServiceLang("catalog.php", $arLanguage["ID"]);
		$arFields["USER_LANG"][$arLanguage["ID"]] = GetMessage("WIZ_PRICE_NAME");
	}
	$arFields["BASE"] = "Y";
	$arFields["SORT"] = 100;
	$arFields["NAME"] = "BASE";
	$arFields["USER_GROUP"] = array(1);
	$arFields["USER_GROUP_BUY"] = array(1);
	$catalogGroupId = CCatalogGroup::Add($arFields);

    $fields = [
        'CATALOG_GROUP_ID' => $catalogGroupId,
        'PRICE' => 0,
        'ROUND_TYPE' => RoundingTable::ROUND_UP,
        'ROUND_PRECISION' => 1,
    ];
    $result = RoundingTable::add($fields);
}

if($IBLOCK_CATALOG_ID == false)
{
	$permissions = Array(
			"1" => "X",
			"2" => "R"
		);
	$dbGroup = CGroup::GetList($by = "", $order = "", Array("STRING_ID" => "sale_administrator"));
	if($arGroup = $dbGroup -> Fetch())
	{
		$permissions[$arGroup["ID"]] = 'W';
	}
	$dbGroup = CGroup::GetList($by = "", $order = "", Array("STRING_ID" => "content_editor"));
	if($arGroup = $dbGroup -> Fetch())
	{
		$permissions[$arGroup["ID"]] = 'W';
	}

	\Bitrix\Catalog\Product\Sku::disableUpdateAvailable();
    @copy($_SERVER["DOCUMENT_ROOT"].$iblockXMLFile, $_SERVER["DOCUMENT_ROOT"].$iblockXMLFile.".back");
    CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"].$iblockXMLFile, Array("SITE_ID" => WIZARD_SITE_ID));
	$IBLOCK_CATALOG_ID = WizardServices::ImportIBlockFromXML(
        $iblockXmlFile,
        $iblockXmlId,
        $iblockType,
		WIZARD_SITE_ID,
		$permissions
	);
    if(file_exists($_SERVER["DOCUMENT_ROOT"].$iblockXMLFile.".back")){
        @copy($_SERVER["DOCUMENT_ROOT"].$iblockXMLFile.".back", $_SERVER["DOCUMENT_ROOT"].$iblockXMLFile);
    }

	\Bitrix\Catalog\Product\Sku::enableUpdateAvailable();
	if ($IBLOCK_CATALOG_ID < 1)
		return;

	$_SESSION["WIZARD_CATALOG_IBLOCK_ID"] = $IBLOCK_CATALOG_ID;
}
else
{
	$arSites = array();
	$db_res = CIBlock::GetSite($IBLOCK_CATALOG_ID);
	while ($res = $db_res->Fetch())
		$arSites[] = $res["LID"];
	if (!in_array(WIZARD_SITE_ID, $arSites))
	{
		$arSites[] = WIZARD_SITE_ID;
		$iblock = new CIBlock;
		$iblock->Update($IBLOCK_CATALOG_ID, array("LID" => $arSites));
	}
}
