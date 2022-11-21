<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

//echo "WIZARD_SITE_ID=".WIZARD_SITE_ID." | ";
//echo "WIZARD_SITE_PATH=".WIZARD_SITE_PATH." | ";
//echo "WIZARD_RELATIVE_PATH=".WIZARD_RELATIVE_PATH." | ";
//echo "WIZARD_ABSOLUTE_PATH=".WIZARD_ABSOLUTE_PATH." | ";
//echo "WIZARD_TEMPLATE_ID=".WIZARD_TEMPLATE_ID." | ";
//echo "WIZARD_TEMPLATE_RELATIVE_PATH=".WIZARD_TEMPLATE_RELATIVE_PATH." | ";
//echo "WIZARD_TEMPLATE_ABSOLUTE_PATH=".WIZARD_TEMPLATE_ABSOLUTE_PATH." | ";
//echo "WIZARD_THEME_ID=".WIZARD_THEME_ID." | ";
//echo "WIZARD_THEME_RELATIVE_PATH=".WIZARD_THEME_RELATIVE_PATH." | ";
//echo "WIZARD_THEME_ABSOLUTE_PATH=".WIZARD_THEME_ABSOLUTE_PATH." | ";
//echo "WIZARD_SERVICE_RELATIVE_PATH=".WIZARD_SERVICE_RELATIVE_PATH." | ";
//echo "WIZARD_SERVICE_ABSOLUTE_PATH=".WIZARD_SERVICE_ABSOLUTE_PATH." | ";
//echo "WIZARD_IS_RERUN=".WIZARD_IS_RERUN." | ";
//die();

if (!defined("WIZARD_TEMPLATE_ID"))
	return;

$bitrixTemplateDir = $_SERVER["DOCUMENT_ROOT"].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID;

CopyDirFiles(
	$_SERVER["DOCUMENT_ROOT"].WizardServices::GetTemplatesPath(WIZARD_RELATIVE_PATH."/site")."/".WIZARD_TEMPLATE_ID,
	$bitrixTemplateDir,
	$rewrite = true,
	$recursive = true,
	$delete_after_copy = false,
	$exclude = "themes"
);

//Attach template to default site
$obSite = CSite::GetList($by = "def", $order = "desc", Array("LID" => WIZARD_SITE_ID));
if ($arSite = $obSite->Fetch())
{
	$arTemplates = Array();
	$found = false;
	$foundEmpty = false;
	$obTemplate = CSite::GetTemplateList($arSite["LID"]);
	while($arTemplate = $obTemplate->Fetch())
	{
		if(!$found && strlen(trim($arTemplate["CONDITION"]))<=0)
		{
			$arTemplate["TEMPLATE"] = WIZARD_TEMPLATE_ID;
			$found = true;
		}
		if($arTemplate["TEMPLATE"] == "empty")
		{
			$foundEmpty = true;
			continue;
		}
		$arTemplates[]= $arTemplate;
	}

	if (!$found)
		$arTemplates[]= Array("CONDITION" => "", "SORT" => 150, "TEMPLATE" => WIZARD_TEMPLATE_ID);

	$arFields = Array(
		"TEMPLATE" => $arTemplates,
		"NAME" => $arSite["NAME"],
	);

	$obSite = new CSite();
	$obSite->Update($arSite["LID"], $arFields);
}

$wizrdTemplateId = $wizard->GetVar("wizTemplateID");
if (!in_array($wizrdTemplateId, array("shop")))
	$wizrdTemplateId = "shop";

COption::SetOptionString("main", "wizard_template_id", $wizrdTemplateId, false, WIZARD_SITE_ID);

function ___writeToAreasFile($fn, $text)
{
	$fd = @fopen($fn, "wb");
	if(!$fd)
		return false;

	if(false === fwrite($fd, $text))
	{
		fclose($fd);
		return false;
	}

	fclose($fd);

	if(defined("BX_FILE_PERMISSIONS"))
		@chmod($fn, BX_FILE_PERMISSIONS);
}

//logo
$templateID = $wizard->GetVar("templateID");
$themeID = $wizard->GetVar($templateID."_themeID");

$fLogo = CFile::GetByID($wizard->GetVar("siteLogo"));
$logo = $fLogo->Fetch();
if($logo)
{
	if ($logo)
	{
		$strOldFile = str_replace("//", "/", WIZARD_SITE_ROOT_PATH."/".(COption::GetOptionString("main", "upload_dir", "upload"))."/".$logo["SUBDIR"]."/".$logo["FILE_NAME"]);
		@copy($strOldFile, WIZARD_SITE_PATH."include/logo.png");
		CFile::Delete($fLogo);
	}

	$content = '<img src="'.WIZARD_SITE_DIR.'include/logo.png"/>';
	___writeToAreasFile(WIZARD_SITE_PATH."include/company_logo.php", $content);
}
elseif(WIZARD_INSTALL_DEMO_DATA || !file_exists(WIZARD_SITE_PATH."/include/company_logo.php") && !file_exists(WIZARD_SITE_PATH."/include/logo.png"))
{
	copy(WIZARD_ABSOLUTE_PATH."/site/templates/shop/themes/".$themeID."/images/logo.png", WIZARD_SITE_PATH."include/logo.png");
	copy(WIZARD_ABSOLUTE_PATH."/site/templates/shop/themes/".$themeID."/images/logo_retina.png", WIZARD_SITE_PATH."include/logo_retina.png");
	___writeToAreasFile(WIZARD_SITE_PATH."include/company_logo.php", '<img src="'.WIZARD_SITE_DIR.'include/logo.png"  srcset="'.WIZARD_SITE_DIR.'include/logo_retina.png" />');
}

elseif(WIZARD_INSTALL_DEMO_DATA || !file_exists(WIZARD_SITE_PATH."/include/company_logo_mobile.php") && !file_exists(WIZARD_SITE_PATH."/include/logo_mobile.png") /*|| __isDefaultLogoOrText(WIZARD_SITE_PATH."/include/company_name.php")*/)
{
	copy(WIZARD_ABSOLUTE_PATH."/site/templates/shop/themes/".$themeID."/images/logo_mobile.png", WIZARD_SITE_PATH."include/logo_mobile.png");
	copy(WIZARD_ABSOLUTE_PATH."/site/templates/shop/themes/".$themeID."/images/logo_mobile_retina.png", WIZARD_SITE_PATH."include/logo_mobile_retina.png");
	___writeToAreasFile(WIZARD_SITE_PATH."include/company_logo_mobile.php", '<img src="'.WIZARD_SITE_DIR.'include/logo_mobile.png"  srcset="'.WIZARD_SITE_DIR.'include/logo_mobile_retina.png" />');
}
