<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if (empty($arResult))
    return "";

$strReturn = '<div class="wrapper">';

//we can't use $APPLICATION->SetAdditionalCSS() here because we are inside the buffered function GetNavChain()
//$css = $APPLICATION->GetCSSArray();
//if (!is_array($css) || !in_array("/bitrix/css/main/font-awesome.css", $css)) {
//    $strReturn .= '<link href="' . CUtil::GetAdditionalFileURL("/bitrix/css/main/font-awesome.css") . '" type="text/css" rel="stylesheet" />' . "\n";
//}

$strReturn .= '<div class="bx-breadcrumb" itemprop="http://schema.org/breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';

$itemSize = count($arResult);
for ($index = 0; $index < $itemSize; $index++) {
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);
    $arrow = '';
    //$arrow = ($index > 0 ? '<span>/</span>' : ' ');

    if ($arResult[$index]["LINK"] <> "" && $index != $itemSize - 1) {
        $strReturn .= '
			<a itemprop="item" href="' . $arResult[$index]["LINK"] . '" title="' . $title . '" itemprop="url" class="bx-breadcrumb-item" id="bx_breadcrumb_' . $index . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				' . $arrow . '
					<span itemprop="name">' . $title . '</span>
				<meta itemprop="position" content="' . ($index + 1) . '" />
			</a>';
    } else {
        $strReturn .= '
			<div class="bx-breadcrumb-item">
				' . $arrow . '
				<span>' . $title . '</span>
			</div>';
    }
}

$strReturn .= '<div style="clear:both"></div></div>';

$strReturn .= '</div>';

return $strReturn;
