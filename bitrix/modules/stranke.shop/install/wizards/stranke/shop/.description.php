<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(!defined("WIZARD_DEFAULT_SITE_ID") && !empty($_REQUEST["wizardSiteID"]))
	define("WIZARD_DEFAULT_SITE_ID", $_REQUEST["wizardSiteID"]);

$arWizardDescription = [
	"NAME" => GetMessage("STRANKE_SHOP_WIZARD_NAME"),
	"DESCRIPTION" => GetMessage("STRANKE_SHOP_WIZARD_DESC"),
	"VERSION" => "1.0.0",
	"START_TYPE" => "WINDOW",
	"WIZARD_TYPE" => "INSTALL",
	"IMAGE" => "/images/".LANGUAGE_ID."/solution.jpg",
	"PARENT" => "wizard_sol",
	"TEMPLATES" => [["SCRIPT" => "wizard_sol"]],
	"STEPS" => [],
];

if (!defined("WIZARD_DEFAULT_SITE_ID")) {
    $arWizardDescription["STEPS"][] = "SelectSiteStep";
}
$arWizardDescription["STEPS"][] = "SelectTemplateStep";
$arWizardDescription["STEPS"][] = "SiteSettingsStep";
$arWizardDescription["STEPS"][] = "CatalogSettings";
if (LANGUAGE_ID == "ru") {
    $arWizardDescription["STEPS"][] = "ShopSettings";
    $arWizardDescription["STEPS"][] = "PersonType";
}
$arWizardDescription["STEPS"][] = "PaySystem";
$arWizardDescription["STEPS"][] = "DataInstallStep";
$arWizardDescription["STEPS"][] = "FinishStep";
