<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */


if (!isset($arParams["CACHE_TIME"]))
    $arParams["CACHE_TIME"] = 36000000;

$arParams["ID"] = intval($arParams["ID"]);
$arParams["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);

$arParams["DEPTH_LEVEL"] = intval($arParams["DEPTH_LEVEL"]);
if ($arParams["DEPTH_LEVEL"] <= 0)
    $arParams["DEPTH_LEVEL"] = 1;

$arResult["SECTIONS"] = array();
$arResult["ELEMENT_LINKS"] = array();

if ($this->StartResultCache() || $_REQUEST['tpl']==2021) {
    if (!CModule::IncludeModule("iblock")) {
        $this->AbortResultCache();
    } else {
        $arFilter = array(
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "GLOBAL_ACTIVE" => "Y",
            "IBLOCK_ACTIVE" => "Y",
            "<=" . "DEPTH_LEVEL" => $arParams["DEPTH_LEVEL"],
            "!ID" => 709,
            'UF_SEO_SECTION' => false,
        );
        $arOrder = array(
            "left_margin" => "asc",
        );

        $rsSections = CIBlockSection::GetList($arOrder, $arFilter, false, array(
            "ID",
            "DEPTH_LEVEL",
            "DETAIL_PICTURE",
            "NAME",
            "SECTION_PAGE_URL",
            "UF_BANNERS_RIGHT",
            "UF_BANNERS_DOWN",
            "UF_BRENDS_DOWN"
        ));
        if ($arParams["IS_SEF"] !== "Y")
            $rsSections->SetUrlTemplates("", $arParams["SECTION_URL"]);
        else
            $rsSections->SetUrlTemplates("", $arParams["SEF_BASE_URL"] . $arParams["SECTION_PAGE_URL"]);

        $arAllUFBannersRight = array();
        $arAllUFBannersDown = array();
        $arAllUFBrendsDown = array();
        $i = 0;
        $arTmp = array();
        while ($arSection = $rsSections->GetNext()) {
            $arAllUFBannersRight = array_merge($arAllUFBannersRight, $arSection['UF_BANNERS_RIGHT']);
            $arAllUFBannersDown = array_merge($arAllUFBannersDown, $arSection['UF_BANNERS_DOWN']);
            $arAllUFBrendsDown = array_merge($arAllUFBrendsDown, $arSection['UF_BRENDS_DOWN']);

            $pic = CFile::ResizeImageGet(
                $arSection["DETAIL_PICTURE"],
                array("width" => 63, "height" => 63),
                2
            );
            $arResult["SECTIONS"][$i] = array(
                "ID" => $arSection["ID"],
                "DETAIL_PICTURE" => $pic['src'],
                "DEPTH_LEVEL" => $arSection["DEPTH_LEVEL"],
                "~NAME" => $arSection["~NAME"],
                "~SECTION_PAGE_URL" => $arSection["~SECTION_PAGE_URL"],
            );
            $arResult["ELEMENT_LINKS"][$arSection["ID"]] = array();

            foreach ($arSection['UF_BANNERS_RIGHT'] as $bannerID) {
                $arTmp["RIGHT_BANNERS"][$bannerID][] = $i;
            }
            foreach ($arSection['UF_BANNERS_DOWN'] as $bannerID) {
                $arTmp["DOWN_BANNERS"][$bannerID][] = $i;
            }
            foreach ($arSection['UF_BRENDS_DOWN'] as $bannerID) {
                $arTmp["DOWN_BRENDS"][$bannerID][] = $i;
            }

            $i++;
        }
        /** RIGHT_BANNERS */
        $arSort = array();
        $arFilter = array("IBLOCK_ID" => '89', "ID" => $arAllUFBannersRight, "ACTIVE" => "Y");
        $arSelect = array('ID', "NAME", "PREVIEW_TEXT", "DETAIL_PICTURE", "PROPERTY_URL");
        $dbBannersRight = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
        while ($arBannersRight = $dbBannersRight->GetNext()) {
            $pic = CFile::ResizeImageGet(
                $arBannersRight["DETAIL_PICTURE"],
                array("width" => 532, "height" => 204),
                2
            );
            $arBannersRight["DETAIL_PICTURE"] = $pic['src'];
            foreach ($arTmp["RIGHT_BANNERS"][$arBannersRight["ID"]] as $sectionKey) {
                $arResult["SECTIONS"][$sectionKey]["RIGHT_BANNERS"][] = $arBannersRight;
            }
        }
        /** end RIGHT_BANNERS */

        /** DOWN_BANNERS */
        $arSort = array();
        $arFilter = array("IBLOCK_ID" => '98', "ID" => $arAllUFBannersDown, "ACTIVE" => "Y");
        $arSelect = array('ID', "NAME", "PREVIEW_TEXT", "DETAIL_PICTURE", "PROPERTY_URL");
        $dbBannersDown = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
        while ($arBannersDown = $dbBannersDown->GetNext()) {
            $pic = CFile::ResizeImageGet(
                $arBannersDown["DETAIL_PICTURE"],
                array("width" => 263, "height" => 59),
                2
            );
            $arBannersDown["DETAIL_PICTURE"] = $pic['src'];
            foreach ($arTmp["DOWN_BANNERS"][$arBannersDown["ID"]] as $sectionKey) {
                $arResult["SECTIONS"][$sectionKey]["DOWN_BANNERS"][] = $arBannersDown;
            }
        }
        /** end DOWN_BANNERS */

        /** DOWN_BRENDS */
        $arSort = array();
        $arFilter = array("IBLOCK_ID" => '99', "ID" => $arAllUFBrendsDown, "ACTIVE" => "Y");
        $arSelect = array('ID', "NAME", "PREVIEW_TEXT", "DETAIL_PICTURE", "PROPERTY_URL");
        $dbBrendsDown = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
        while ($arBrendsDown = $dbBrendsDown->GetNext()) {
            $pic = CFile::ResizeImageGet(
                $arBrendsDown["DETAIL_PICTURE"],
                array("width" => 60, "height" => 60),
                1
            );
            $arBrendsDown["DETAIL_PICTURE"] = $pic['src'];
            foreach ($arTmp["DOWN_BRENDS"][$arBrendsDown["ID"]] as $sectionKey) {
                $arResult["SECTIONS"][$sectionKey]["DOWN_BRENDS"][] = $arBrendsDown;
            }
        }
        /** end DOWN_BRENDS */

        $this->EndResultCache();
    }
}


//In "SEF" mode we'll try to parse URL and get ELEMENT_ID from it
if ($arParams["IS_SEF"] === "Y") {
    $engine = new CComponentEngine($this);
    if (CModule::IncludeModule('iblock')) {
        $engine->addGreedyPart("#SECTION_CODE_PATH#");
        $engine->setResolveCallback(array("CIBlockFindTools", "resolveComponentEngine"));
    }
    $componentPage = $engine->guessComponentPath(
        $arParams["SEF_BASE_URL"],
        array(
            "section" => $arParams["SECTION_PAGE_URL"],
            "detail" => $arParams["DETAIL_PAGE_URL"],
        ),
        $arVariables
    );
    if ($componentPage === "detail") {
        CComponentEngine::InitComponentVariables(
            $componentPage,
            array("SECTION_ID", "ELEMENT_ID"),
            array(
                "section" => array("SECTION_ID" => "SECTION_ID"),
                "detail" => array("SECTION_ID" => "SECTION_ID", "ELEMENT_ID" => "ELEMENT_ID"),
            ),
            $arVariables
        );
        $arParams["ID"] = intval($arVariables["ELEMENT_ID"]);
    }
}

if (($arParams["ID"] > 0) && (intval($arVariables["SECTION_ID"]) <= 0) && CModule::IncludeModule("iblock")) {
    $arSelect = array("ID", "IBLOCK_ID", "DETAIL_PAGE_URL", "IBLOCK_SECTION_ID");
    $arFilter = array(
        "ID" => $arParams["ID"],
        "ACTIVE" => "Y",
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    );
    $rsElements = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
    if (($arParams["IS_SEF"] === "Y") && (strlen($arParams["DETAIL_PAGE_URL"]) > 0))
        $rsElements->SetUrlTemplates($arParams["SEF_BASE_URL"] . $arParams["DETAIL_PAGE_URL"]);
    while ($arElement = $rsElements->GetNext()) {
        $arResult["ELEMENT_LINKS"][$arElement["IBLOCK_SECTION_ID"]][] = $arElement["~DETAIL_PAGE_URL"];
    }
}

$aMenuLinksNew = array();
$menuIndex = 0;
$previousDepthLevel = 1;
foreach ($arResult["SECTIONS"] as $arSection) {
    if ($menuIndex > 0)
        $aMenuLinksNew[$menuIndex - 1][3]["IS_PARENT"] = $arSection["DEPTH_LEVEL"] > $previousDepthLevel;
    $previousDepthLevel = $arSection["DEPTH_LEVEL"];

    $arResult["ELEMENT_LINKS"][$arSection["ID"]][] = urldecode($arSection["~SECTION_PAGE_URL"]);
    $aMenuLinksNew[$menuIndex++] = array(
        htmlspecialcharsbx($arSection["~NAME"]),
        $arSection["~SECTION_PAGE_URL"],
        $arResult["ELEMENT_LINKS"][$arSection["ID"]],
        array(
            "FROM_IBLOCK" => true,
            "DETAIL_PICTURE" => $arSection["DETAIL_PICTURE"],
            "IS_PARENT" => false,
            "DEPTH_LEVEL" => $arSection["DEPTH_LEVEL"],
            "BANNERS" => array(
                "RIGHT_BANNERS" => $arSection["RIGHT_BANNERS"],
                "DOWN_BANNERS" => $arSection["DOWN_BANNERS"],
                "DOWN_BRENDS" => $arSection["DOWN_BRENDS"]
            )
        ),
    );
}

return $aMenuLinksNew;
?>
