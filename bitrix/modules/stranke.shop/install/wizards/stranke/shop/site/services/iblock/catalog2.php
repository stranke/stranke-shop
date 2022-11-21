<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("catalog"))
	return;

if(COption::GetOptionString("shop", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
	return;

$xmlSku = WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/catalog/offers.xml";
$iblockType = "catalog";
$iblockXmlId = "catalog_offers_".WIZARD_SITE_ID;

$rsIBlock = CIBlock::GetList([], ["TYPE" => $iblockType, "XML_ID" => $iblockXmlId]);
$IBLOCK_OFFERS_ID = false;
if ($arIBlock = $rsIBlock->Fetch())
{
	$IBLOCK_OFFERS_ID = $arIBlock["ID"];
	if (WIZARD_INSTALL_DEMO_DATA)
	{
		CIBlock::Delete($arIBlock["ID"]);
		$IBLOCK_OFFERS_ID = false;
	}
}
//--offers

if($IBLOCK_OFFERS_ID == false)
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
	$IBLOCK_OFFERS_ID = WizardServices::ImportIBlockFromXML(
		$xmlSku,
        $iblockXmlId,
        $iblockType,
		WIZARD_SITE_ID,
		$permissions
	);
    if(file_exists($_SERVER["DOCUMENT_ROOT"].$iblockXMLFile.".back")){
        @copy($_SERVER["DOCUMENT_ROOT"].$iblockXMLFile.".back", $_SERVER["DOCUMENT_ROOT"].$iblockXMLFile);
    }
	\Bitrix\Catalog\Product\Sku::enableUpdateAvailable();

	if ($IBLOCK_OFFERS_ID < 1)
		return;

	$_SESSION["WIZARD_OFFERS_IBLOCK_ID"] = $IBLOCK_OFFERS_ID;
}
else
{
	$arSites = array();
	$db_res = CIBlock::GetSite($IBLOCK_OFFERS_ID);
	while ($res = $db_res->Fetch())
		$arSites[] = $res["LID"];
	if (!in_array(WIZARD_SITE_ID, $arSites))
	{
		$arSites[] = WIZARD_SITE_ID;
		$iblock = new CIBlock;
		$iblock->Update($IBLOCK_OFFERS_ID, array("LID" => $arSites));
	}
}
