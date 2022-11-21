<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("iblock") || !CModule::IncludeModule("catalog"))
	return;

if(COption::GetOptionString("shop", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
	return;

$shopLocalization = $wizard->GetVar("shopLocalization");

$IBLOCK_CATALOG_ID = (isset($_SESSION["WIZARD_CATALOG_IBLOCK_ID"]) ? (int)$_SESSION["WIZARD_CATALOG_IBLOCK_ID"] : 0);
$IBLOCK_OFFERS_ID = (isset($_SESSION["WIZARD_OFFERS_IBLOCK_ID"]) ? (int)$_SESSION["WIZARD_OFFERS_IBLOCK_ID"] : 0);


if ($IBLOCK_OFFERS_ID)
{
    $iblockCode = 'catalog_offers';
    $iblockXmlId = $iblockCode.'_'.WIZARD_SITE_ID;

	//IBlock fields
	$iblock = new CIBlock;
	$arFields = Array(
		"ACTIVE" => "Y",
        "CODE" => $iblockXmlId,
        "XML_ID" => $iblockXmlId,
		"FIELDS" => array (
			'IBLOCK_SECTION' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
			'ACTIVE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'Y', ), 'ACTIVE_FROM' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
			'ACTIVE_TO' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'SORT' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
			'NAME' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => '', ),
			'PREVIEW_PICTURE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'FROM_DETAIL' => 'N', 'SCALE' => 'N', 'WIDTH' => '', 'HEIGHT' => '', 'IGNORE_ERRORS' => 'N', 'METHOD' => 'resample', 'COMPRESSION' => 95, 'DELETE_WITH_DETAIL' => 'N', 'UPDATE_WITH_DETAIL' => 'N', ), ),
			'PREVIEW_TEXT_TYPE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'text', ), 'PREVIEW_TEXT' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
			'DETAIL_PICTURE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'SCALE' => 'N', 'WIDTH' => '', 'HEIGHT' => '', 'IGNORE_ERRORS' => 'N', 'METHOD' => 'resample', 'COMPRESSION' => 95, ), ),
			'DETAIL_TEXT_TYPE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'text', ),
			'DETAIL_TEXT' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
			'XML_ID' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
			'CODE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'UNIQUE' => 'Y', 'TRANSLITERATION' => 'Y', 'TRANS_LEN' => 100, 'TRANS_CASE' => 'L', 'TRANS_SPACE' => '_', 'TRANS_OTHER' => '_', 'TRANS_EAT' => 'Y', 'USE_GOOGLE' => 'Y', ), ),
			'TAGS' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'SECTION_NAME' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
			'SECTION_PICTURE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'FROM_DETAIL' => 'N', 'SCALE' => 'N', 'WIDTH' => '', 'HEIGHT' => '', 'IGNORE_ERRORS' => 'N', 'METHOD' => 'resample', 'COMPRESSION' => 95, 'DELETE_WITH_DETAIL' => 'N', 'UPDATE_WITH_DETAIL' => 'N', ), ),
			'SECTION_DESCRIPTION_TYPE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => 'text', ),
			'SECTION_DESCRIPTION' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 'SECTION_DETAIL_PICTURE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'SCALE' => 'N', 'WIDTH' => '', 'HEIGHT' => '', 'IGNORE_ERRORS' => 'N', 'METHOD' => 'resample', 'COMPRESSION' => 95, ), ),
			'SECTION_XML_ID' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
			'SECTION_CODE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'UNIQUE' => 'Y', 'TRANSLITERATION' => 'Y', 'TRANS_LEN' => 100, 'TRANS_CASE' => 'L', 'TRANS_SPACE' => '_', 'TRANS_OTHER' => '_', 'TRANS_EAT' => 'Y', 'USE_GOOGLE' => 'Y', ), ),
        ),
	);
	$iblock->Update($IBLOCK_OFFERS_ID, $arFields);
}

if ($IBLOCK_CATALOG_ID)
{
    $iblockCode = 'catalog_products';
    $iblockXmlId = $iblockCode.'_'.WIZARD_SITE_ID;

	//IBlock fields
	$iblock = new CIBlock;
	$arFields = Array(
		"ACTIVE" => "Y",
        "CODE" => $iblockXmlId,
        "XML_ID" => $iblockXmlId,
		"FIELDS" => array (
		    'IBLOCK_SECTION' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => '', ),
            'ACTIVE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'Y', ),
            'ACTIVE_FROM' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
            'ACTIVE_TO' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
            'SORT' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
            'NAME' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => '', ),
            'PREVIEW_PICTURE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'FROM_DETAIL' => 'N', 'SCALE' => 'N', 'WIDTH' => '', 'HEIGHT' => '', 'IGNORE_ERRORS' => 'N', 'METHOD' => 'resample', 'COMPRESSION' => 95, 'DELETE_WITH_DETAIL' => 'N', 'UPDATE_WITH_DETAIL' => 'N', ), ),
            'PREVIEW_TEXT_TYPE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'text', ),
            'PREVIEW_TEXT' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
            'DETAIL_PICTURE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'SCALE' => 'N', 'WIDTH' => '', 'HEIGHT' => '', 'IGNORE_ERRORS' => 'N', 'METHOD' => 'resample', 'COMPRESSION' => 95, ), ),
            'DETAIL_TEXT_TYPE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'text', ),
            'DETAIL_TEXT' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
            'XML_ID' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
            'CODE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => array ( 'UNIQUE' => 'Y', 'TRANSLITERATION' => 'Y', 'TRANS_LEN' => 100, 'TRANS_CASE' => 'L', 'TRANS_SPACE' => '_', 'TRANS_OTHER' => '_', 'TRANS_EAT' => 'Y', 'USE_GOOGLE' => 'Y', ), ),
            'TAGS' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
            'SECTION_NAME' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => '', ),
            'SECTION_PICTURE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'FROM_DETAIL' => 'N', 'SCALE' => 'N', 'WIDTH' => '', 'HEIGHT' => '', 'IGNORE_ERRORS' => 'N', 'METHOD' => 'resample', 'COMPRESSION' => 95, 'DELETE_WITH_DETAIL' => 'N', 'UPDATE_WITH_DETAIL' => 'N', ), ),
            'SECTION_DESCRIPTION_TYPE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'text', ),
            'SECTION_DESCRIPTION' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
            'SECTION_DETAIL_PICTURE' => array ( 'IS_REQUIRED' => 'N','DEFAULT_VALUE' => array ( 'SCALE' => 'N', 'WIDTH' => '', 'HEIGHT' => '', 'IGNORE_ERRORS' => 'N', 'METHOD' => 'resample', 'COMPRESSION' => 95, ), ),
            'SECTION_XML_ID' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
            'SECTION_CODE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => array ( 'UNIQUE' => 'Y', 'TRANSLITERATION' => 'Y', 'TRANS_LEN' => 100, 'TRANS_CASE' => 'L', 'TRANS_SPACE' => '_', 'TRANS_OTHER' => '_', 'TRANS_EAT' => 'Y', 'USE_GOOGLE' => 'Y', ), ),
        ),
	);
	$iblock->Update($IBLOCK_CATALOG_ID, $arFields);

	if ($IBLOCK_OFFERS_ID)
	{
		$ID_SKU = CCatalog::LinkSKUIBlock($IBLOCK_CATALOG_ID, $IBLOCK_OFFERS_ID);

		$rsCatalogs = CCatalog::GetList(
			array(),
			array('IBLOCK_ID' => $IBLOCK_OFFERS_ID),
			false,
			false,
			array('IBLOCK_ID')
		);
		if ($arCatalog = $rsCatalogs->Fetch())
		{
			CCatalog::Update($IBLOCK_OFFERS_ID,array('PRODUCT_IBLOCK_ID' => $IBLOCK_CATALOG_ID,'SKU_PROPERTY_ID' => $ID_SKU));
		}
		else
		{
			CCatalog::Add(array('IBLOCK_ID' => $IBLOCK_OFFERS_ID, 'PRODUCT_IBLOCK_ID' => $IBLOCK_CATALOG_ID, 'SKU_PROPERTY_ID' => $ID_SKU));
		}
	}

	//user fields for sections
	$arLanguages = Array();
	$rsLanguage = CLanguage::GetList($by, $order, array());
	while($arLanguage = $rsLanguage->Fetch())
		$arLanguages[] = $arLanguage["LID"];

	$arUserFields = array("UF_BROWSER_TITLE", "UF_KEYWORDS", "UF_META_DESCRIPTION");
	foreach ($arUserFields as $userField)
	{
		$arLabelNames = Array();
		foreach($arLanguages as $languageID)
		{
			WizardServices::IncludeServiceLang("property_names.php", $languageID);
			$arLabelNames[$languageID] = GetMessage($userField);
		}

		$arProperty["EDIT_FORM_LABEL"] = $arLabelNames;
		$arProperty["LIST_COLUMN_LABEL"] = $arLabelNames;
		$arProperty["LIST_FILTER_LABEL"] = $arLabelNames;

		$dbRes = CUserTypeEntity::GetList(Array(), Array("ENTITY_ID" => 'IBLOCK_'.$IBLOCK_CATALOG_ID.'_SECTION', "FIELD_NAME" => $userField));
		if ($arRes = $dbRes->Fetch())
		{
			$userType = new CUserTypeEntity();
			$userType->Update($arRes["ID"], $arProperty);
		}
	}

	// add discounts
	$iterator = \Bitrix\Catalog\DiscountTable::getList([
		'select' => ['ID'],
		'filter' => ['=SITE_ID' => WIZARD_SITE_ID],
		'limit' => 1
	]);
	$row = $iterator->fetch();
	unset($iterator);
	if (empty($row))
	{
		if (CModule::IncludeModule("iblock"))
		{
			$dbSect = CIBlockSection::GetList(Array(), Array("IBLOCK_TYPE" => "catalog", "IBLOCK_ID"=>$IBLOCK_CATALOG_ID, "CODE" => "shashlyk", "IBLOCK_SITE_ID" => WIZARD_SITE_ID));
			if ($arSect = $dbSect->Fetch())
				$sofasSectId = $arSect["ID"];
		}

		switch ($shopLocalization)
		{
			case "ua":
				$defCurrency = "UAH";
				break;
			case "by":
				$defCurrency = "BYR";
				break;
			default:
				$defCurrency = "RUB";
		}
		$arF = Array (
			"SITE_ID" => WIZARD_SITE_ID,
			"ACTIVE" => "Y",
			"RENEWAL" => "N",
			"NAME" => GetMessage("WIZ_DISCOUNT"),
			"SORT" => 100,
			"MAX_DISCOUNT" => 0,
			"VALUE_TYPE" => "P",
			"VALUE" => 10,
			"CURRENCY" => $defCurrency,
			"CONDITIONS" => Array (
				"CLASS_ID" => "CondGroup",
				"DATA" => Array("All" => "OR", "True" => "True"),
				"CHILDREN" => Array(Array("CLASS_ID" => "CondIBSection", "DATA" => Array("logic" => "Equal", "value" => $sofasSectId)))
			)
		);
//        CSaleDiscount::Add($arF);
	}
	unset($row);

	if(\Bitrix\Main\Loader::includeModule('sale'))
	{
		$strapIds = array();
		$specificConditions = array();
		$dbItem = CIBlockElement::GetList(Array(), Array(
			"CODE" => array(
				"shashlyk-iz-shei",
				"strap-rainbow",
				"strap-weaving",
				"strap-classics",
			),
			"IBLOCK_ID"=>$IBLOCK_CATALOG_ID,
			"IBLOCK_SITE_ID" => WIZARD_SITE_ID,
		), false, Array("nTopCount" => 100), Array(
			"ID",
			"IBLOCK_ID",
		));
		while($arItem = $dbItem->Fetch())
		{
			$strapIds[] = $arItem['ID'];
			$specificConditions[] = array(
				'CLASS_ID' => 'CondIBElement',
				'DATA' => array(
					'logic' => 'Equal',
					'value' => $arItem['ID'],
				),
			);
		}

		$name = GetMessage('WIZ_DISCOUNT_BASKET_GIFTS');
		$siteId = WIZARD_SITE_ID;
		$userGroupIds = array();

		$groupIterator = \Bitrix\Main\GroupTable::getList(array(
			'select' => array('ID'),
		));
		while($group = $groupIterator->fetch())
		{
			$userGroupIds[] = $group['ID'];
		}

		$arFields = array(
			'LID' => $siteId,
			'NAME' => $name,
			'ACTIVE_FROM' => '',
			'ACTIVE_TO' => '',
			'ACTIVE' => 'Y',
			'SORT' => '100',
			'PRIORITY' => '1',
			'LAST_DISCOUNT' => 'Y',
			'XML_ID' => '',
			'CONDITIONS' => array(
				'CLASS_ID' => 'CondGroup',
				'DATA' => array(
					'All' => 'OR',
					'True' => 'False',
				),
				'CHILDREN' => array(
					array(
						'CLASS_ID' => 'CondGroup',
						'DATA' => array(
							'All' => 'AND',
							'True' => 'True',
						),
						'CHILDREN' => array(
							array(
								'CLASS_ID' => 'CondBsktRowGroup',
								'DATA' => array(
									'logic' => 'Equal',
									'Value' => 1,
									'All' => 'OR',
								),
								'CHILDREN' => $specificConditions,
							),
							array(
								'CLASS_ID' => 'CondBsktRowGroup',
								'DATA' => array(
									'logic' => 'Equal',
									'Value' => 1,
									'All' => 'AND',
								),
								'CHILDREN' => array(),
							),
						),
					),
				),
			),
			'ACTIONS' => array(
				'CLASS_ID' => 'CondGroup',
				'DATA' => array(
					'All' => 'AND',
				),
				'CHILDREN' => array(
					array(
						'CLASS_ID' => 'GiftCondGroup',
						'DATA' => array(
							'All' => 'AND',
						),
						'CHILDREN' => array(
							array(
								'CLASS_ID' => 'GifterCondIBElement',
								'DATA' => array(
									'Type' => 'one',
									'Value' => $strapIds,
								),
							),
						),
					),
				),
			),
			'USER_GROUPS' => $userGroupIds,
		);

//		if($strapIds)
//		{
//			CSaleDiscount::Add($arFields);
//		}

		//----------------------------------------------------------------------

        $strapIds = array();
        $specificConditions = array();
        $dbItem = CIBlockElement::GetList(Array(), Array(
            "CODE" => array("shashlyk-iz-shei",),
            "IBLOCK_ID"=>$IBLOCK_CATALOG_ID,
            "IBLOCK_SITE_ID" => WIZARD_SITE_ID,
        ), false, Array("nTopCount" => 100), Array(
            "ID",
            "IBLOCK_ID",
        ));
        while($arItem = $dbItem->Fetch())
        {
            $strapIds[] = $arItem['ID'];
            $specificConditions[] = array(
                'CLASS_ID' => 'CondIBElement',
                'DATA' => array(
                    'logic' => 'Equal',
                    'value' => $arItem['ID'],
                ),
            );
        }

        $name = GetMessage('ST_WIZ_DISCOUNT_BARBECUE');
        $siteId = WIZARD_SITE_ID;
        $userGroupIds = array();

        $groupIterator = \Bitrix\Main\GroupTable::getList(array(
            'select' => array('ID'),
        ));
        while($group = $groupIterator->fetch())
        {
            $userGroupIds[] = $group['ID'];
        }

        $arFields = array(
            'LID' => $siteId,
            'NAME' => $name,
            'ACTIVE_FROM' => '',
            'ACTIVE_TO' => '',
            'ACTIVE' => 'Y',
            'SORT' => '100',
            'PRIORITY' => '1',
            'LAST_DISCOUNT' => 'Y',
            'XML_ID' => '',
            'CONDITIONS' => array (
                'CLASS_ID' => 'CondGroup',
                'DATA' =>
                    array (
                        'All' => 'AND',
                        'True' => 'True',
                    ),
                'CHILDREN' =>
                    array (
                    ),
            ),
            'ACTIONS' => array (
                'CLASS_ID' => 'CondGroup',
                'DATA' =>
                    array (
                        'All' => 'AND',
                    ),
                'CHILDREN' =>
                    array (
                        0 =>
                            array (
                                'CLASS_ID' => 'ActSaleBsktGrp',
                                'DATA' =>
                                    array (
                                        'Type' => 'Discount',
                                        'Value' => 15.0,
                                        'Unit' => 'Perc',
                                        'Max' => 0,
                                        'All' => 'AND',
                                        'True' => 'True',
                                    ),
                                'CHILDREN' => $specificConditions,
                            ),
                    ),
            ),
            'USER_GROUPS' => $userGroupIds,
        );

        if($strapIds)
        {
            CSaleDiscount::Add($arFields);
        }

        //----------------------------------------------------------------------
	}
	// end add dicount

//precet
	$dbSite = CSite::GetByID(WIZARD_SITE_ID);
	if($arSite = $dbSite -> Fetch())
		$lang = $arSite["LANGUAGE_ID"];

	$dbProperty = CIBlockProperty::GetList(Array(), Array("IBLOCK_ID"=>$IBLOCK_CATALOG_ID, "CODE"=>"SALELEADER"));
	$arFields = array();
	while($arProperty = $dbProperty->GetNext())
	{
		$arFields["find_el_property_".$arProperty["ID"]] = "";
	}
	$dbProperty = CIBlockProperty::GetList(Array(), Array("IBLOCK_ID"=>$IBLOCK_CATALOG_ID, "CODE"=>"NEWPRODUCT"));
	while($arProperty = $dbProperty->GetNext())
	{
		$arFields["find_el_property_".$arProperty["ID"]] = "";
	}
	$dbProperty = CIBlockProperty::GetList(Array(), Array("IBLOCK_ID"=>$IBLOCK_CATALOG_ID, "CODE"=>"SPECIALOFFER"));
	while($arProperty = $dbProperty->GetNext())
	{
		$arFields["find_el_property_".$arProperty["ID"]] = "";
	}
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/interface/admin_lib.php");
	CAdminFilter::AddPresetToBase( array(
			"NAME" => GetMessage("WIZ_PRECET"),
			"FILTER_ID" => "tbl_product_admin_".md5($iblockType.".".$IBLOCK_CATALOG_ID)."_filter",
			"LANGUAGE_ID" => $lang,
			"FIELDS" => $arFields
		)
	);
	CUserOptions::SetOption("filter", "tbl_product_admin_".md5($iblockType.".".$IBLOCK_CATALOG_ID)."_filter", array("rows" => "find_el_name, find_el_active, find_el_timestamp_from, find_el_timestamp_to"), true);

	CAdminFilter::SetDefaultRowsOption("tbl_product_admin_".md5($iblockType.".".$IBLOCK_CATALOG_ID)."_filter", array("miss-0","IBEL_A_F_PARENT"));

//delete 1c props
	$arPropsToDelete = array("CML2_TAXES", "CML2_BASE_UNIT", "CML2_TRAITS", "CML2_ATTRIBUTES", "CML2_ARTICLE", "CML2_BAR_CODE", "CML2_FILES", "CML2_MANUFACTURER", "CML2_PICTURES");
	foreach ($arPropsToDelete as $code)
	{
		$dbProperty = CIBlockProperty::GetList(Array(), Array("IBLOCK_ID"=>$IBLOCK_CATALOG_ID, "XML_ID"=>$code));
		if($arProperty = $dbProperty->GetNext())
		{
			CIBlockProperty::Delete($arProperty["ID"]);
		}
		if ($IBLOCK_OFFERS_ID)
		{
			$dbProperty = CIBlockProperty::GetList(Array(), Array("IBLOCK_ID"=>$IBLOCK_OFFERS_ID, "XML_ID"=>$code));
			if($arProperty = $dbProperty->GetNext())
			{
				CIBlockProperty::Delete($arProperty["ID"]);
			}
		}
	}

	//filter for index page
	$dbProperty = CIBlockProperty::GetList(Array(), Array("IBLOCK_ID"=>$IBLOCK_CATALOG_ID, "CODE"=>"TREND"));
	if($arProperty = $dbProperty->GetNext())
	{
		$dbProps = CIBlockProperty::GetPropertyEnum($arProperty["ID"], Array("SORT"=>"asc"));
		while ($prop = $dbProps->Fetch())
		{
			if ($prop["XML_ID"] == "Y")
			{
				CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/_index.php", array("TREND_PROPERTY_VALUE_ID" => $prop["ID"]));
			}
		}
	}

    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/_index.php", ["CATALOG_IBLOCK_ID" => $IBLOCK_CATALOG_ID]);
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/catalog/index.php", ["CATALOG_IBLOCK_ID" => $IBLOCK_CATALOG_ID]);
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/.catalog.menu_ext.php", ["CATALOG_IBLOCK_ID" => $IBLOCK_CATALOG_ID]);

	// Добавим привязку UF_SEO_SECTIONS к инфоблоку
    $oUserTypeEntity = new CUserTypeEntity();
    $arUserField = $oUserTypeEntity->GetList([], [
        'ENTITY_ID' => 'IBLOCK_'.$IBLOCK_CATALOG_ID.'_SECTION',
        'XML_ID' => 'UF_SEO_SECTIONS',
    ])->Fetch();
    $result = $oUserTypeEntity->Update($arUserField['ID'], [
        'SETTINGS' => [
            'IBLOCK_TYPE_ID' => 'catalog',
            'IBLOCK_ID' => $IBLOCK_CATALOG_ID,
            'LIST_HEIGHT' => 10,
        ]
    ]);
}
