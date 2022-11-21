<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/install/wizard_sol/wizard.php");

define('WIZARD_STRANKE_PATH', '/bitrix/wizards/stranke/shop');

class SelectSiteStep extends CSelectSiteWizardStep
{
    function InitStep()
    {
        parent::InitStep();

        $wizard =& $this->GetWizard();
        $wizard->solutionName = "shop";
    }
}


class SelectTemplateStep extends CSelectTemplateWizardStep
{
    function InitStep()
    {
        $this->SetStepID("select_template");
        $this->SetTitle(GetMessage("SELECT_TEMPLATE_TITLE"));
        $this->SetSubTitle(GetMessage("SELECT_TEMPLATE_SUBTITLE"));
        //$this->SetPrevStep("welcome_step");
        $this->SetNextStep("site_settings");
        $this->SetNextCaption(GetMessage("NEXT_BUTTON"));
    }

    function OnPostForm()
    {
        $wizard =& $this->GetWizard();

        $proactive = COption::GetOptionString("statistic", "DEFENCE_ON", "N");
        if ($proactive == "Y") {
            COption::SetOptionString("statistic", "DEFENCE_ON", "N");
            $wizard->SetVar("proactive", "Y");
        } else {
            $wizard->SetVar("proactive", "N");
        }

        if ($wizard->IsNextButtonClick()) {
            $arTemplates = array("shop");

            $templateID = $wizard->GetVar("wizTemplateID");

            if (!in_array($templateID, $arTemplates))
                $this->SetError(GetMessage("wiz_template"));

            if (in_array($templateID, array("shop")))
                $wizard->SetVar("templateID", "shop");
        }
    }

    function ShowStep()
    {
        $wizard =& $this->GetWizard();

        $templatesPath = WizardServices::GetTemplatesPath($wizard->GetPath() . "/site");
        $arTemplates = WizardServices::GetTemplates($templatesPath);

        $arTemplateOrder = array();

        if (in_array("shop", array_keys($arTemplates))) {
            $arTemplateOrder[] = "shop";
        }

        $defaultTemplateID = COption::GetOptionString("main", "wizard_template_id", "shop", $wizard->GetVar("siteID"));
        if (!in_array($defaultTemplateID, array("shop"))) $defaultTemplateID = "shop";
        $wizard->SetDefaultVar("wizTemplateID", $defaultTemplateID);

        $arTemplateInfo = array(
            "shop" => array(
                "NAME" => GetMessage("STRANKE_WIZ_TEMPLATE"),
                "DESCRIPTION" => "",
                "PREVIEW" => $wizard->GetPath() . "/site/templates/shop/img/preview.png",
                "SCREENSHOT" => $wizard->GetPath() . "/site/templates/shop/img/screen.gif",
            ),
        );

        global $SHOWIMAGEFIRST;
        $SHOWIMAGEFIRST = true;

        $this->content .= '<div class="inst-template-list-block">';
        foreach ($arTemplateOrder as $templateID) {
            $arTemplate = $arTemplateInfo[$templateID];

            if (!$arTemplate)
                continue;

            $this->content .= '<div class="inst-template-description">';
            $this->content .= $this->ShowRadioField("wizTemplateID", $templateID, Array("id" => $templateID, "class" => "inst-template-list-inp"));

            global $SHOWIMAGEFIRST;
            $SHOWIMAGEFIRST = true;

            if ($arTemplate["SCREENSHOT"] && $arTemplate["PREVIEW"])
                $this->content .= CFile::Show2Images($arTemplate["PREVIEW"], $arTemplate["SCREENSHOT"], 150, 150, ' class="inst-template-list-img"');
            else
                $this->content .= CFile::ShowImage($arTemplate["SCREENSHOT"], 150, 150, ' class="inst-template-list-img"', "", true);

            $this->content .= '<label for="' . $templateID . '" class="inst-template-list-label">' . $arTemplate["NAME"] . "</label>";
            $this->content .= "</div>";
        }

        $this->content .= "</div>";
    }
}

class SiteSettingsStep extends CSiteSettingsWizardStep
{
    function InitStep()
    {
        $wizard =& $this->GetWizard();
        $wizard->solutionName = "shop";
        parent::InitStep();

        $this->SetNextCaption(GetMessage("NEXT_BUTTON"));
        $this->SetTitle(GetMessage("WIZ_STEP_SITE_SET"));

        $siteID = $wizard->GetVar("siteID");
        $isWizardInstalled = COption::GetOptionString("shop", "wizard_installed", "N", $siteID) == "Y";

        if (COption::GetOptionString("shop", "wizard_installed", "N", $siteID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
            $this->SetNextStep("data_install");
        else {
            $this->SetNextStep("catalog_settings");
        }

        $templateID = $wizard->GetVar("templateID");


        $siteLogo = WIZARD_STRANKE_PATH . '/images/logo.png';
        if ($isWizardInstalled) {
            // ������� �������� �� ��������� ��������
        }

        $wizard->SetDefaultVars([
            "siteLogo" => $siteLogo,
            "siteName" => $this->GetFileContent(WIZARD_SITE_PATH . "include/company_name.php", GetMessage("WIZ_COMPANY_NAME_DEF")),
            "siteSchedule" => $this->GetFileContent(WIZARD_SITE_PATH . "include/schedule.php", GetMessage("WIZ_COMPANY_SCHEDULE_DEF")),
            "siteTelephone" => $this->GetFileContent(WIZARD_SITE_PATH . "include/telephone.php", GetMessage("WIZ_COMPANY_TELEPHONE_DEF")),
            "siteCopy" => $this->GetFileContent(WIZARD_SITE_PATH . "include/copyright.php", GetMessage("STRANKE_WIZ_COPYRIGHT_DEF")),
            "shopEmail" => COption::GetOptionString("shop", "shopEmail", "sale@" . $_SERVER["SERVER_NAME"], $siteID),
            "siteMetaDescription" => GetMessage("wiz_site_desc"),
            "siteMetaKeywords" => GetMessage("wiz_keywords"),
            "installEshopApp" => COption::GetOptionString("shop", "installEshopApp", "N", $siteID),
        ]);
    }

    function ShowStep()
    {
        $wizard =& $this->GetWizard();

        $this->content .= '<div class="wizard-input-form">';

        $this->content .= '
		<div class="wizard-input-form-block">
			<label for="siteName" class="wizard-input-title">' . GetMessage("WIZ_COMPANY_NAME") . '</label>
			' . $this->ShowInputField('text', 'siteName', array("id" => "siteName", "class" => "wizard-field")) . '
		</div>';
//logo --
        $siteLogo = $wizard->GetVar("siteLogo", true);
        //$this->content .= "<div style='margin: 5px 0 5px 0;'>".CFile::ShowImage($siteLogo, 0, 0, "border=0 id=\"site-logo-image\"".($wizard->GetVar("useSiteLogo", true) != "Y" ? " class=\"disabled\"" : ""), "", true)."</div>";
        $this->content .= '
		<div class="wizard-input-form-block" style="background-color: #f4f5f6;   width: 571px; padding: 10px">
			<label for="siteLogo">' . GetMessage("WIZ_COMPANY_LOGO") . '</label><br/>';
        $this->content .= CFile::ShowImage($siteLogo, 215, 50, "border=0 vspace=15");
        $this->content .= "<br/>" . $this->ShowFileField("siteLogo", Array("show_file_info" => "N", "id" => "siteLogo")) .
            '</div>';

        // phone
        $this->content .= '
		<div class="wizard-input-form-block">
			<label for="siteTelephone" class="wizard-input-title">' . GetMessage("WIZ_COMPANY_TELEPHONE") . '</label>
			' . $this->ShowInputField('text', 'siteTelephone', array("id" => "siteTelephone", "class" => "wizard-field")) . '
		</div>';

        if (LANGUAGE_ID != "ru") {
            $this->content .= '<div class="wizard-input-form-block">
				<label for="shopEmail" class="wizard-input-title">' . GetMessage("WIZ_SHOP_EMAIL") . '</label>
				' . $this->ShowInputField('text', 'shopEmail', array("id" => "shopEmail", "class" => "wizard-field")) . '
			</div>';
        }
        $this->content .= '
		<div class="wizard-input-form-block">
			<label for="siteSchedule" class="wizard-input-title">' . GetMessage("WIZ_COMPANY_SCHEDULE") . '</label>
			' . $this->ShowInputField('textarea', 'siteSchedule', array("rows" => "3", "id" => "siteSchedule", "class" => "wizard-field")) . '
		</div>';

        $firstStep = COption::GetOptionString("main", "wizard_first" . substr($wizard->GetID(), 7) . "_" . $wizard->GetVar("siteID"), false, $wizard->GetVar("siteID"));
        $styleMeta = 'style="display:block"';
        if ($firstStep == "Y") $styleMeta = 'style="display:none"';

        $this->content .= '
		<div  id="bx_metadata" ' . $styleMeta . '>
			<div class="wizard-input-form-block">
				<div class="wizard-metadata-title">' . GetMessage("wiz_meta_data") . '</div>
				<label for="siteMetaDescription" class="wizard-input-title">' . GetMessage("wiz_meta_description") . '</label>
				' . $this->ShowInputField("textarea", "siteMetaDescription", Array("id" => "siteMetaDescription", "rows" => "3", "class" => "wizard-field")) . '
			</div>';
        $this->content .= '
			<div class="wizard-input-form-block">
				<label for="siteMetaKeywords" class="wizard-input-title">' . GetMessage("wiz_meta_keywords") . '</label><br>
				' . $this->ShowInputField('text', 'siteMetaKeywords', array("id" => "siteMetaKeywords", "class" => "wizard-field")) . '
			</div>
		</div>';

//install Demo data
        if ($firstStep == "Y") {
            $this->content .= '
			<div class="wizard-input-form-block"' . (LANGUAGE_ID != "ru" ? ' style="display:none"' : '') . '>
				' . $this->ShowCheckboxField(
                    "installDemoData",
                    "Y",
                    (array("id" => "installDemoData", "onClick" => "if(this.checked == true){document.getElementById('bx_metadata').style.display='block';}else{document.getElementById('bx_metadata').style.display='none';}"))
                ) . '
				<label for="installDemoData">' . GetMessage("wiz_structure_data") . '</label>
			</div>';
        } else {
            $this->content .= $this->ShowHiddenField("installDemoData", "Y");
        }

        if (CModule::IncludeModule("catalog")) {
            $db_res = CCatalogGroup::GetGroupsList(array("CATALOG_GROUP_ID" => '1', "BUY" => "Y", "GROUP_ID" => 2));
            if (!$db_res->Fetch()) {
                $this->content .= '
				<div class="wizard-input-form-block">
					<label for="shopAdr">' . GetMessage("WIZ_SHOP_PRICE_BASE_TITLE") . '</label>
					<div class="wizard-input-form-block-content">
						' . GetMessage("WIZ_SHOP_PRICE_BASE_TEXT1") . '<br><br>
						' . $this->ShowCheckboxField("installPriceBASE", "Y",
                        (array("id" => "install-demo-data")))
                    . ' <label for="install-demo-data">' . GetMessage("WIZ_SHOP_PRICE_BASE_TEXT2") . '</label><br />

					</div>
				</div>';
            }
        }

        $this->content .= '</div>';
    }

    function OnPostForm()
    {
        $wizard =& $this->GetWizard();
        $res = $this->SaveFile("siteLogo");
    }
}

class CatalogSettings extends CWizardStep
{
    function InitStep()
    {
        $this->SetStepID("catalog_settings");
        $this->SetTitle(GetMessage("WIZ_STEP_CT"));
        if (LANGUAGE_ID != "ru")
            $this->SetNextStep("pay_system");
        else
            $this->SetNextStep("shop_settings");
        $this->SetPrevStep("site_settings");
        $this->SetNextCaption(GetMessage("NEXT_BUTTON"));
        $this->SetPrevCaption(GetMessage("PREVIOUS_BUTTON"));

        $wizard =& $this->GetWizard();
        $siteID = $wizard->GetVar("siteID");

        $subscribe = COption::GetOptionString("sale", "subscribe_prod", "");
        $arSubscribe = unserialize($subscribe);

        $wizard->SetDefaultVars(
            Array(
                "catalogSubscribe" => (isset($arSubscribe[$siteID])) ? ($arSubscribe[$siteID]['use'] == "Y" ? "Y" : false) : "Y",//COption::GetOptionString("shop", "catalogSubscribe", "Y", $siteID),
                "catalogView" => COption::GetOptionString("shop", "catalogView", "list", $siteID),
                "useStoreControl" => COption::GetOptionString("catalog", "default_use_store_control", "N"),
                "productReserveCondition" => COption::GetOptionString("sale", "product_reserve_condition", "P")
            )
        );
    }

    function ShowStep()
    {
        $wizard =& $this->GetWizard();

        $this->content .= '
			<div class="wizard-input-form-block">
				<div class="wizard-catalog-title">' . GetMessage("WIZ_CATALOG_USE_STORE_CONTROL") . '</div>
				<div>
					<div class="wizard-catalog-form-item">
						' . $this->ShowCheckboxField("useStoreControl", "Y", array("id" => "use-store-control"))
            . '<label for="use-store-control">' . GetMessage("WIZ_STORE_CONTROL") . '</label>
					</div>';

        $arConditions = array(
            "O" => GetMessage("SALE_PRODUCT_RESERVE_1_ORDER"),
            "P" => GetMessage("SALE_PRODUCT_RESERVE_2_PAYMENT"),
            "D" => GetMessage("SALE_PRODUCT_RESERVE_3_DELIVERY"),
            "S" => GetMessage("SALE_PRODUCT_RESERVE_4_DEDUCTION")
        );

        $this->content .= '
			<div class="wizard-catalog-form-item">'
            . $this->ShowSelectField("productReserveCondition", $arConditions) .
            '<label>' . GetMessage("SALE_PRODUCT_RESERVE_CONDITION") . '</label>
			</div>';
        $this->content .= '</div>
			</div>';
    }

    function OnPostForm()
    {
        $wizard =& $this->GetWizard();

    }
}

class ShopSettings extends CWizardStep
{
    function InitStep()
    {
        $this->SetStepID("shop_settings");
        $this->SetTitle(GetMessage("WIZ_STEP_SS"));
        $this->SetNextStep("pay_system");
        $this->SetPrevStep("catalog_settings");
        $this->SetNextCaption(GetMessage("NEXT_BUTTON"));
        $this->SetPrevCaption(GetMessage("PREVIOUS_BUTTON"));

        $wizard =& $this->GetWizard();

        $siteStamp = $wizard->GetPath() . "/site/templates/minimal/images/pechat.gif";
        $siteID = $wizard->GetVar("siteID");

        $wizard->SetDefaultVars(
            Array(
                "shopLocalization" => COption::GetOptionString("shop", "shopLocalization", "ru", $siteID),
                "shopEmail" => COption::GetOptionString("shop", "shopEmail", "sale@" . $_SERVER["SERVER_NAME"], $siteID),
                "shopOfName" => COption::GetOptionString("shop", "shopOfName", GetMessage("WIZ_SHOP_OF_NAME_DEF"), $siteID),
                "shopLocation" => COption::GetOptionString("shop", "shopLocation", GetMessage("WIZ_SHOP_LOCATION_DEF"), $siteID),
                //"shopZip" => 101000,
                "shopAdr" => COption::GetOptionString("shop", "shopAdr", GetMessage("WIZ_SHOP_ADR_DEF"), $siteID),
                "shopINN" => COption::GetOptionString("shop", "shopINN", "1234567890", $siteID),
                "shopKPP" => COption::GetOptionString("shop", "shopKPP", "123456789", $siteID),
                "shopNS" => COption::GetOptionString("shop", "shopNS", "0000 0000 0000 0000 0000", $siteID),
                "shopBANK" => COption::GetOptionString("shop", "shopBANK", GetMessage("WIZ_SHOP_BANK_DEF"), $siteID),
                "shopBANKREKV" => COption::GetOptionString("shop", "shopBANKREKV", GetMessage("WIZ_SHOP_BANKREKV_DEF"), $siteID),
                "shopKS" => COption::GetOptionString("shop", "shopKS", "30101 810 4 0000 0000225", $siteID),
                "siteStamp" => COption::GetOptionString("shop", "siteStamp", $siteStamp, $siteID),

                //"shopCompany_ua" => COption::GetOptionString("shop", "shopCompany_ua", "", $siteID),
                "shopOfName_ua" => COption::GetOptionString("shop", "shopOfName_ua", GetMessage("WIZ_SHOP_OF_NAME_DEF_UA"), $siteID),
                "shopLocation_ua" => COption::GetOptionString("shop", "shopLocation_ua", GetMessage("WIZ_SHOP_LOCATION_DEF_UA"), $siteID),
                "shopAdr_ua" => COption::GetOptionString("shop", "shopAdr_ua", GetMessage("WIZ_SHOP_ADR_DEF_UA"), $siteID),
                "shopEGRPU_ua" => COption::GetOptionString("shop", "shopEGRPU_ua", "", $siteID),
                "shopINN_ua" => COption::GetOptionString("shop", "shopINN_ua", "", $siteID),
                "shopNDS_ua" => COption::GetOptionString("shop", "shopNDS_ua", "", $siteID),
                "shopNS_ua" => COption::GetOptionString("shop", "shopNS_ua", "", $siteID),
                "shopBank_ua" => COption::GetOptionString("shop", "shopBank_ua", "", $siteID),
                "shopMFO_ua" => COption::GetOptionString("shop", "shopMFO_ua", "", $siteID),
                "shopPlace_ua" => COption::GetOptionString("shop", "shopPlace_ua", "", $siteID),
                "shopFIO_ua" => COption::GetOptionString("shop", "shopFIO_ua", "", $siteID),
                "shopTax_ua" => COption::GetOptionString("shop", "shopTax_ua", "", $siteID),

                "installPriceBASE" => COption::GetOptionString("shop", "installPriceBASE", "Y", $siteID),
                "personType" => [
                    "fiz" => COption::GetOptionString("shop", "personTypeFiz", "Y", $siteID),
                ]
            )
        );
    }

    function ShowStep()
    {
        $wizard =& $this->GetWizard();
        $siteStamp = $wizard->GetVar("siteStamp", true);
        $firstStep = COption::GetOptionString("main", "wizard_first" . substr($wizard->GetID(), 7) . "_" . $wizard->GetVar("siteID"), false, $wizard->GetVar("siteID"));

        if (!CModule::IncludeModule("catalog")) {
            $this->content .= "<p style='color:red'>" . GetMessage("WIZ_NO_MODULE_CATALOG") . "</p>";
            $this->SetNextStep("shop_settings");
        } else {
            $this->content .=
                '<div class="wizard-catalog-title">' . GetMessage("WIZ_SHOP_LOCALIZATION") . '</div>
				<div class="wizard-input-form-block" >' .
                $this->ShowSelectField("shopLocalization", array(
                    "ru" => GetMessage("WIZ_SHOP_LOCALIZATION_RUSSIA"),
                    "ua" => GetMessage("WIZ_SHOP_LOCALIZATION_UKRAINE"),
                    "kz" => GetMessage("WIZ_SHOP_LOCALIZATION_KAZAKHSTAN"),
                    "bl" => GetMessage("WIZ_SHOP_LOCALIZATION_BELORUSSIA")
                ), array("onchange" => "langReload()", "id" => "localization_select", "class" => "wizard-field", "style" => "padding:0 0 0 15px")) . '
				</div>';

            $currentLocalization = $wizard->GetVar("shopLocalization");
            if (empty($currentLocalization))
                $currentLocalization = $wizard->GetDefaultVar("shopLocalization");

            $this->content .= '<div class="wizard-catalog-title">' . GetMessage("WIZ_STEP_SS") . '</div>
				<div class="wizard-input-form">';

            $this->content .= '
				<div class="wizard-input-form-block">
					<label class="wizard-input-title" for="shopEmail">' . GetMessage("WIZ_SHOP_EMAIL") . '</label>
					' . $this->ShowInputField('text', 'shopEmail', array("id" => "shopEmail", "class" => "wizard-field")) . '
				</div>';

            //ru
            $this->content .= '<div id="ru_bank_details" class="wizard-input-form-block" style="display:' . (($currentLocalization == "ru" || $currentLocalization == "kz" || $currentLocalization == "bl") ? 'block' : 'none') . '">
				<div class="wizard-input-form-block">
					<label class="wizard-input-title" for="shopOfName">' . GetMessage("WIZ_SHOP_OF_NAME") . '</label>'
                . $this->ShowInputField('text', 'shopOfName', array("id" => "shopOfName", "class" => "wizard-field")) . '
				</div>';

            $this->content .= '
				<div class="wizard-input-form-block">
					<label class="wizard-input-title" for="shopLocation">' . GetMessage("WIZ_SHOP_LOCATION") . '</label>'
                . $this->ShowInputField('text', 'shopLocation', array("id" => "shopLocation", "class" => "wizard-field")) . '
				</div>';

            $this->content .= '
				<div class="wizard-input-form-block">
					<label class="wizard-input-title" for="shopAdr">' . GetMessage("WIZ_SHOP_ADR") . '</label>'
                . $this->ShowInputField('textarea', 'shopAdr', array("rows" => "3", "id" => "shopAdr", "class" => "wizard-field")) . '
				</div>';

            if ($firstStep != "Y") {
                $this->content .= '
					<div class="wizard-catalog-title">' . GetMessage("WIZ_SHOP_BANK_TITLE") . '</div>
					<table class="wizard-input-table">
						<tr>
							<td class="wizard-input-table-left">' . GetMessage("WIZ_SHOP_INN") . ':</td>
							<td class="wizard-input-table-right">' . $this->ShowInputField('text', 'shopINN', array("class" => "wizard-field")) . '</td>
						</tr>
						<tr>
							<td class="wizard-input-table-left">' . GetMessage("WIZ_SHOP_KPP") . ':</td>
							<td class="wizard-input-table-right">' . $this->ShowInputField('text', 'shopKPP', array("class" => "wizard-field")) . '</td>
						</tr>
						<tr>
							<td class="wizard-input-table-left">' . GetMessage("WIZ_SHOP_NS") . ':</td>
							<td class="wizard-input-table-right">' . $this->ShowInputField('text', 'shopNS', array("class" => "wizard-field")) . '</td>
						</tr>
						<tr>
							<td class="wizard-input-table-left">' . GetMessage("WIZ_SHOP_BANK") . ':</td>
							<td class="wizard-input-table-right">' . $this->ShowInputField('text', 'shopBANK', array("class" => "wizard-field")) . '</td>
						</tr>
						<tr>
							<td class="wizard-input-table-left">' . GetMessage("WIZ_SHOP_BANKREKV") . ':</td>
							<td class="wizard-input-table-right">' . $this->ShowInputField('text', 'shopBANKREKV', array("class" => "wizard-field")) . '</td>
						</tr>
						<tr>
							<td class="wizard-input-table-left">' . GetMessage("WIZ_SHOP_KS") . ':</td>
							<td class="wizard-input-table-right">' . $this->ShowInputField('text', 'shopKS', array("class" => "wizard-field")) . '</td>
						</tr>
						<tr>
							<td class="wizard-input-table-left">' . GetMessage("WIZ_SHOP_STAMP") . ':</td>
							<td class="wizard-input-table-right">' . $this->ShowFileField("siteStamp", Array("show_file_info" => "N", "id" => "siteStamp")) . '<br />' . CFile::ShowImage($siteStamp, 75, 75, "border=0 vspace=5", false, false) . '</td>
						</tr>
					</table>
				</div><!--ru-->
				';
            }
            $this->content .= '<div id="ua_bank_details" class="wizard-input-form-block" style="display:' . (($currentLocalization == "ua") ? 'block' : 'none') . '">
				<div class="wizard-input-form-block">
					<label class="wizard-input-title" for="shopOfName_ua">' . GetMessage("WIZ_SHOP_OF_NAME") . '</label>'
                . $this->ShowInputField('text', 'shopOfName_ua', array("id" => "shopOfName_ua", "class" => "wizard-field")) . '
					<p style="color:grey; margin: 3px 0 7px;">' . GetMessage("WIZ_SHOP_OF_NAME_DESCR_UA") . '</p>
				</div>';

            $this->content .= '<div class="wizard-input-form-block">
					<label class="wizard-input-title" for="shopLocation_ua">' . GetMessage("WIZ_SHOP_LOCATION") . '</label>'
                . $this->ShowInputField('text', 'shopLocation_ua', array("id" => "shopLocation_ua", "class" => "wizard-field")) . '
					<p style="color:grey; margin: 3px 0 7px;">' . GetMessage("WIZ_SHOP_LOCATION_DESCR_UA") . '</p>
				</div>';


            $this->content .= '
				<div class="wizard-input-form-block">
					<label class="wizard-input-title" for="shopAdr_ua">' . GetMessage("WIZ_SHOP_ADR") . '</label>' .
                $this->ShowInputField('textarea', 'shopAdr_ua', array("rows" => "3", "id" => "shopAdr_ua", "class" => "wizard-field")) . '
					<p style="color:grey; margin: 3px 0 7px;">' . GetMessage("WIZ_SHOP_ADR_DESCR_UA") . '</p>
				</div>';

            if ($firstStep != "Y") {
                $this->content .= '
					<div class="wizard-catalog-title">' . GetMessage("WIZ_SHOP_RECV_UA") . '</div>
					<p>' . GetMessage("WIZ_SHOP_RECV_UA_DESC") . '</p>
					<table class="wizard-input-table">
						<tr>
							<td class="wizard-input-table-left">' . GetMessage("WIZ_SHOP_EGRPU_UA") . ':</td>
							<td class="wizard-input-table-right">' . $this->ShowInputField('text', 'shopEGRPU_ua', array("class" => "wizard-field")) . '</td>
						</tr>
						<tr>
							<td class="wizard-input-table-left">' . GetMessage("WIZ_SHOP_INN_UA") . ':</td>
							<td class="wizard-input-table-right">' . $this->ShowInputField('text', 'shopINN_ua', array("class" => "wizard-field")) . '</td>
						</tr>
						<tr>
							<td class="wizard-input-table-left">' . GetMessage("WIZ_SHOP_NDS_UA") . ':</td>
							<td class="wizard-input-table-right">' . $this->ShowInputField('text', 'shopNDS_ua', array("class" => "wizard-field")) . '</td>
						</tr>
						<tr>
							<td class="wizard-input-table-left">' . GetMessage("WIZ_SHOP_NS_UA") . ':</td>
							<td class="wizard-input-table-right">' . $this->ShowInputField('text', 'shopNS_ua', array("class" => "wizard-field")) . '</td>
						</tr>
						<tr>
							<td class="wizard-input-table-left">' . GetMessage("WIZ_SHOP_BANK_UA") . ':</td>
							<td class="wizard-input-table-right">' . $this->ShowInputField('text', 'shopBank_ua', array("class" => "wizard-field")) . '</td>
						</tr>
						<tr>
							<td class="wizard-input-table-left">' . GetMessage("WIZ_SHOP_MFO_UA") . ':</td>
							<td class="wizard-input-table-right">' . $this->ShowInputField('text', 'shopMFO_ua', array("class" => "wizard-field")) . '</td>
						</tr>
						<tr>
							<td class="wizard-input-table-left">' . GetMessage("WIZ_SHOP_PLACE_UA") . ':</td>
							<td class="wizard-input-table-right">' . $this->ShowInputField('text', 'shopPlace_ua', array("class" => "wizard-field")) . '</td>
						</tr>
						<tr>
							<td class="wizard-input-table-left">' . GetMessage("WIZ_SHOP_FIO_UA") . ':</td>
							<td class="wizard-input-table-right">' . $this->ShowInputField('text', 'shopFIO_ua', array("class" => "wizard-field")) . '</td>
						</tr>
						<tr>
							<td class="wizard-input-table-left">' . GetMessage("WIZ_SHOP_TAX_UA") . ':</td>
							<td class="wizard-input-table-right">' . $this->ShowInputField('text', 'shopTax_ua', array("class" => "wizard-field")) . '</td>
						</tr>
					</table>
				</div>
				';
            }

            if (CModule::IncludeModule("catalog")) {
                $db_res = CCatalogGroup::GetGroupsList(array("CATALOG_GROUP_ID" => '1', "BUY" => "Y", "GROUP_ID" => 2));
                if (!$db_res->Fetch()) {
                    $this->content .= '
					<div class="wizard-input-form-block">
						<div class="wizard-catalog-title">' . GetMessage("WIZ_SHOP_PRICE_BASE_TITLE") . '</div>
						<div class="wizard-input-form-block-content">
							' . GetMessage("WIZ_SHOP_PRICE_BASE_TEXT1") . '<br><br>
							' . $this->ShowCheckboxField("installPriceBASE", "Y",
                            (array("id" => "install-demo-data")))
                        . ' <label for="install-demo-data">' . GetMessage("WIZ_SHOP_PRICE_BASE_TEXT2") . '</label><br />

						</div>
					</div>';
                }
            }

            $this->content .= '</div>';

            $this->content .= '
				<script>
					function langReload()
					{
						var objSel = document.getElementById("localization_select");
						var locSelected = objSel.options[objSel.selectedIndex].value;
						document.getElementById("ru_bank_details").style.display = (locSelected == "ru" || locSelected == "kz" || locSelected == "bl") ? "block" : "none";
						document.getElementById("ua_bank_details").style.display = (locSelected == "ua") ? "block" : "none";
						/*document.getElementById("kz_bank_details").style.display = (locSelected == "kz") ? "block" : "none";*/
					}
				</script>
			';
        }
    }

    function OnPostForm()
    {
        $wizard =& $this->GetWizard();
        $res = $this->SaveFile("siteStamp", Array("extensions" => "gif,jpg,jpeg,png", "max_height" => 70, "max_width" => 190, "make_preview" => "Y"));
    }

}

class PersonType extends CWizardStep
{
    function InitStep()
    {
        $this->SetStepID("person_type");
        $this->SetTitle(GetMessage("WIZ_STEP_PT"));
        $this->SetNextStep("pay_system");
        $this->SetPrevStep("shop_settings");
        $this->SetNextCaption(GetMessage("NEXT_BUTTON"));
        $this->SetPrevCaption(GetMessage("PREVIOUS_BUTTON"));

        $wizard =& $this->GetWizard();
        $shopLocalization = $wizard->GetVar("shopLocalization", true);
        $siteID = $wizard->GetVar("siteID");

        if ($shopLocalization == "ua") {
            $wizard->SetDefaultVars([
                "personType" => [
                    "fiz" => "Y",
                    "fiz_ua" => "Y",
                    "ur" => "Y",
                ]
            ]);
        } else {
            $wizard->SetDefaultVars([
                "personType" => [
                    "fiz" => COption::GetOptionString("shop", "personTypeFiz", "Y", $siteID),
                ]
            ]);
        }
    }

    function ShowStep()
    {

        $wizard =& $this->GetWizard();
        $shopLocalization = $wizard->GetVar("shopLocalization", true);

        $this->content .= '<div class="wizard-input-form">';
        $this->content .= '
		<div class="wizard-input-form-block">
			<!--<div class="wizard-catalog-title">' . GetMessage("WIZ_PERSON_TYPE_TITLE") . '</div>-->
			<div style="padding-top:15px">
				<div class="wizard-input-form-field wizard-input-form-field-checkbox">
					<div class="wizard-catalog-form-item">
						' . $this->ShowCheckboxField('personType[fiz]', 'Y', (array("id" => "personTypeF"))) .
            ' <label for="personTypeF">' . GetMessage("WIZ_PERSON_TYPE_FIZ") . '</label><br />
					</div>';
        if ($shopLocalization == "ua")
            $this->content .=
                '<div class="wizard-catalog-form-item">'
                . $this->ShowCheckboxField('personType[fiz_ua]', 'Y', (array("id" => "personTypeFua"))) .
                ' <label for="personTypeFua">' . GetMessage("WIZ_PERSON_TYPE_FIZ_UA") . '</label>
					</div>';
        $this->content .= '
				</div>
			</div>
			<div class="wizard-catalog-form-item">' . GetMessage("WIZ_PERSON_TYPE") . '<div>
		</div>';
        $this->content .= '</div>';
    }

    function OnPostForm()
    {
        $wizard = &$this->GetWizard();
        $personType = $wizard->GetVar("personType");

        if (empty($personType["fiz"]) && empty($personType["ur"]))
            $this->SetError(GetMessage('WIZ_NO_PT'));
    }

}

class PaySystem extends CWizardStep
{
    function InitStep()
    {
        $this->SetStepID("pay_system");
        $this->SetTitle(GetMessage("WIZ_STEP_PS"));
        $this->SetNextStep("data_install");
        $this->SetPrevStep("catalog_settings");
        $this->SetNextCaption(GetMessage("NEXT_BUTTON"));
        $this->SetPrevCaption(GetMessage("PREVIOUS_BUTTON"));

        $wizard =& $this->GetWizard();

        if (LANGUAGE_ID == "ru") {
            $shopLocalization = $wizard->GetVar("shopLocalization", true);

            if ($shopLocalization == "ua")
                $wizard->SetDefaultVars(
                    Array(
                        "paysystem" => Array(
                            "cash" => "Y",
                            "oshad" => "Y",
                            "bill" => "Y",
                        ),
                        "delivery" => Array(
                            "courier" => "Y",
                            "self" => "Y",
                        )
                    )
                );
            else
                $wizard->SetDefaultVars(
                    Array(
                        "paysystem" => Array(
                            "cash" => "Y",
                            "sber" => "Y",
                            "bill" => "Y",
                            "collect" => "Y"  //cash on delivery
                        ),
                        "delivery" => Array(
                            "courier" => "Y",
                            "self" => "Y",
                            "rus_post" => "N",
                            "ua_post" => "N",
                            "kaz_post" => "N"
                        )
                    )
                );
        } else {
            $wizard->SetDefaultVars(
                Array(
                    "paysystem" => Array(
                        "cash" => "Y",
                        "paypal" => "Y",
                    ),
                    "delivery" => Array(
                        "courier" => "Y",
                        "self" => "Y",
                        "dhl" => "Y",
                        "ups" => "Y",
                    )
                )
            );
        }
    }

    function OnPostForm()
    {
        $wizard = &$this->GetWizard();
        $paysystem = $wizard->GetVar("paysystem");

        if (
            empty($paysystem["cash"])
            && empty($paysystem["sber"])
            && empty($paysystem["bill"])
            && empty($paysystem["paypal"])
            && empty($paysystem["oshad"])
            && empty($paysystem["collect"])
        )
            $this->SetError(GetMessage('WIZ_NO_PS'));
        /*payer type
                if(LANGUAGE_ID == "ru")
                {
                    $personType = $wizard->GetVar("personType");

                    if (empty($personType["fiz"]) && empty($personType["ur"]))
                        $this->SetError(GetMessage('WIZ_NO_PT'));
                }
        ===*/
    }

    function ShowStep()
    {

        $wizard =& $this->GetWizard();
        $shopLocalization = $wizard->GetVar("shopLocalization", true);

        $personType = $wizard->GetVar("personType");

        $arAutoDeliveries = array();
        if (CModule::IncludeModule("sale")) {
            $dbRes = \Bitrix\Sale\Delivery\Services\Table::getList(array(
                'filter' => array(
                    '=CLASS_NAME' => array(
                        '\Sale\Handlers\Delivery\SpsrHandler',
                        '\Bitrix\Sale\Delivery\Services\Automatic',
                        '\Sale\Handlers\Delivery\AdditionalHandler'
                    )
                ),
                'select' => array('ID', 'CODE', 'ACTIVE', 'CLASS_NAME')
            ));

            while ($dlv = $dbRes->fetch()) {
                if ($dlv['CLASS_NAME'] == '\Sale\Handlers\Delivery\SpsrHandler') {
                    $arAutoDeliveries['spsr'] = $dlv['ACTIVE'];
                } elseif ($dlv['CLASS_NAME'] == '\Sale\Handlers\Delivery\AdditionalHandler' && $dlv['CONFIG']['MAIN']['SERVICE_TYPE'] == 'RUSPOST') {
                    $arAutoDeliveries['ruspost'] = $dlv['ACTIVE'];
                } elseif (!empty($dlv['CODE'])) {
                    $arAutoDeliveries[$dlv['CODE']] = $dlv['ACTIVE'];
                }
            }
        }

        $siteID = WizardServices::GetCurrentSiteID($wizard->GetVar("siteID"));
        $this->content .= '<div class="wizard-input-form">';
        $this->content .= '
		<div class="wizard-input-form-block">
			<div class="wizard-catalog-title">' . GetMessage("WIZ_PAY_SYSTEM_TITLE") . '</div>
			<div>
				<div class="wizard-input-form-field wizard-input-form-field-checkbox">
					<div class="wizard-catalog-form-item">
						' . $this->ShowCheckboxField('paysystem[cash]', 'Y', (array("id" => "paysystemC"))) .
            ' <label for="paysystemC">' . GetMessage("WIZ_PAY_SYSTEM_C") . '</label>
					</div>';

        $this->content .= '</div>
			</div>
		</div>';

        if (
            LANGUAGE_ID != "ru" ||
            LANGUAGE_ID == "ru" &&
            (
                COption::GetOptionString("shop", "wizard_installed", "N", $siteID) != "Y"
                || $shopLocalization == "ru" && ($arAutoDeliveries["rus_post"] != "Y")
                || $shopLocalization == "ua" && ($arAutoDeliveries["ua_post"] != "Y")
                || $shopLocalization == "kz" && ($arAutoDeliveries["kaz_post"] != "Y")
            )
        ) {
            $deliveryNotes = array();
            $deliveryContent = '<div class="wizard-input-form-field wizard-input-form-field-checkbox">';

            if (COption::GetOptionString("shop", "wizard_installed", "N", $siteID) != "Y") {
                $deliveryContent .= '<div class="wizard-catalog-form-item">
					' . $this->ShowCheckboxField('delivery[courier]', 'Y', (array("id" => "deliveryC"))) .
                    ' <label for="deliveryC">' . GetMessage("WIZ_DELIVERY_C") . '</label>
				</div>
				<div class="wizard-catalog-form-item">
					' . $this->ShowCheckboxField('delivery[self]', 'Y', (array("id" => "deliveryS"))) .
                    ' <label for="deliveryS">' . GetMessage("WIZ_DELIVERY_S") . '</label>
				</div>';
            }

            $this->content .=
                '<div class="wizard-input-form-block">
					<div class="wizard-catalog-title">' . GetMessage("WIZ_DELIVERY_TITLE") . '</div>
					<div>' .
                $deliveryContent .
                '</div>
				</div>';
        }

        $this->content .= '</div>';
    }
}

class DataInstallStep extends CDataInstallWizardStep
{
    function CorrectServices(&$arServices)
    {
        if ($_SESSION["BX_ESHOP_LOCATION"] == "Y")
            $this->repeatCurrentService = true;
        else
            $this->repeatCurrentService = false;

        $wizard =& $this->GetWizard();
        if ($wizard->GetVar("installDemoData") != "Y") {
        }
    }
}

class FinishStep extends CFinishWizardStep
{
    function InitStep()
    {
        $this->SetStepID("finish");
        $this->SetNextStep("finish");
        $this->SetTitle(GetMessage("FINISH_STEP_TITLE"));
        $this->SetNextCaption(GetMessage("wiz_go"));
    }

    function ShowStep()
    {
        $name = str_replace(':', '.', $this->wizard->package->name);
        $wizard =& $this->GetWizard();
        // Set deafault update version
        $version_file = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $name . '/install/version.php';
        $version_file_tmp = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $name . '/install/tmp_version.php';
        $default_version = '"VERSION" => "1.0.0",';

        if (file_exists($version_file)) {
            // copy operation
            $sh = fopen($version_file, 'r');
            $th = fopen($version_file_tmp, 'w');
            while (!feof($sh)) {
                $line = fgets($sh);
                if (strpos($line, '"VERSION"') !== false) {
                    $line = $default_version . PHP_EOL;
                }
                fwrite($th, $line);
            }

            fclose($sh);
            fclose($th);
            // delete old source file
            unlink($version_file);
            // rename target file to source file
            rename($version_file_tmp, $version_file);
        }
        if ($wizard->GetVar("proactive") == "Y")
            COption::SetOptionString("statistic", "DEFENCE_ON", "Y");

        $siteID = WizardServices::GetCurrentSiteID($wizard->GetVar("siteID"));
        $rsSites = CSite::GetByID($siteID);
        $siteDir = "/";
        if ($arSite = $rsSites->Fetch())
            $siteDir = $arSite["DIR"];

        $wizard->SetFormActionScript(str_replace("//", "/", $siteDir . "/?finish"));

        $this->CreateNewIndex();

        COption::SetOptionString("main", "wizard_solution", $wizard->solutionName, false, $siteID);

        $this->content .=
            '<table class="wizard-completion-table">
				<tr>
					<td class="wizard-completion-cell">'
            . GetMessage("FINISH_STEP_CONTENT") .
            '</td>
				</tr>
			</table>';
        //	$this->content .= "<br clear=\"all\"><a href=\"/bitrix/admin/wizard_install.php?lang=".LANGUAGE_ID."&site_id=".$siteID."&wizardName=bitrix:eshop.mobile&".bitrix_sessid_get()."\" class=\"button-next\"><span id=\"next-button-caption\">".GetMessage("wizard_store_mobile")."</span></a><br>";

        if ($wizard->GetVar("installDemoData") == "Y")
            $this->content .= GetMessage("FINISH_STEP_REINDEX");
    }
}
