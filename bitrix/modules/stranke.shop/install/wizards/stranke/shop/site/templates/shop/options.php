<?


if (CModule::IncludeModule("iblock")) {

    $res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $settings->iblockId));

    if ($oSettings = $res->GetNextElement()) {

        $arSettings["FIELDS"] = $oSettings->GetFields();
        $arSettings["PROPERTIES"] = $oSettings->GetProperties();

        $arLogo = CFile::GetFileArray($arSettings["PROPERTIES"]["LOGO"]["VALUE"]);

        $GLOBALS["OPTIONS"]["LOGO"] = $arLogo;

        $GLOBALS["OPTIONS"]["PHONES"] = $arSettings["PROPERTIES"]["PHONES"]["VALUE"];

        $GLOBALS["OPTIONS"]["CITY_LIST"] = $arSettings["PROPERTIES"]["CITY_LIST"];

        $GLOBALS["OPTIONS"]["MODERATOR_NAME"] = $arSettings['PROPERTIES']['MODERATOR_NAME']['VALUE'];

        $GLOBALS["OPTIONS"]["ADDRESS"] = $arSettings['PROPERTIES']['ADDRESS'];

        $GLOBALS["OPTIONS"]["MAPBOARD_BG"] = CFile::GetFileArray($arSettings['PROPERTIES']['COTNTACTS_MAPBOARD_BG']['VALUE']);

        $GLOBALS["OPTIONS"]["NO_PHOTO_PRODUCT_PREVIEW"] = $arSettings['PROPERTIES']['NO_PHOTO_PRODUCT_PREVIEW']['VALUE'];
        $GLOBALS["OPTIONS"]["NO_PHOTO_STOCK"] = $arSettings['PROPERTIES']['NO_PHOTO_STOCK']['VALUE'];

        $GLOBALS["OPTIONS"]["STANDART_MAP"] = $arSettings['PROPERTIES']['STANDART_MAP'];

        $GLOBALS["OPTIONS"]["SOCIAL_WEBS_VK"] = $arSettings['PROPERTIES']['SOCIAL_WEBS_VK']['VALUE'];
        $GLOBALS["OPTIONS"]["SOCIAL_WEBS_FB"] = $arSettings['PROPERTIES']['SOCIAL_WEBS_FB']['VALUE'];
        $GLOBALS["OPTIONS"]["SOCIAL_WEBS_INSTA"] = $arSettings['PROPERTIES']['SOCIAL_WEBS_INSTA']['VALUE'];


        $GLOBALS['OPTIONS']['ALERT_BANNER']['ACTIVITY'] = $arSettings['PROPERTIES']['ALERT_BANNER_ACTIVITY']['VALUE'];
        $GLOBALS['OPTIONS']['ALERT_BANNER']['TEXT'] = $arSettings['PROPERTIES']['ALERT_BANNER_TEXT']['VALUE'];
        $GLOBALS['OPTIONS']['ALERT_BANNER']['TEXT_COLOR'] = $arSettings['PROPERTIES']['ALERT_BANNER_TEXT_COLOR']['VALUE'];
        $GLOBALS['OPTIONS']['ALERT_BANNER']['BG_COLOR'] = $arSettings['PROPERTIES']['ALERT_BANNER_BG_COLOR']['VALUE'];


        $GLOBALS["OPTIONS"]["DELIVERY_TIME"] = $arSettings['PROPERTIES']['DELIVERY_TIME']['VALUE'];

        $GLOBALS["OPTIONS"]["COLOR_MAIN"] = $arSettings['PROPERTIES']['COLOR_MAIN']['VALUE'];
        if (empty($GLOBALS["OPTIONS"]["COLOR_MAIN"])) {
            $GLOBALS["OPTIONS"]["COLOR_MAIN"] = "#e5353d";
        }

        $GLOBALS["OPTIONS"]["COLOR_TOP_MENU"] = $arSettings['PROPERTIES']['COLOR_TOP_MENU']['VALUE'];
        if (empty($GLOBALS["OPTIONS"]["COLOR_TOP_MENU"])) {
            $GLOBALS["OPTIONS"]["COLOR_TOP_MENU"] = "#333333";
        }


//    JSON + LD

        $GLOBALS['JSON+LD']['ORG_NAME'] = $arSettings['PROPERTIES']['organizationName'];
        $GLOBALS['JSON+LD']['ORG_ADDRESS']['addressCountry'] = $arSettings['PROPERTIES']['addressCountry'];
        $GLOBALS['JSON+LD']['ORG_ADDRESS']['addressLocality'] = $arSettings['PROPERTIES']['addressLocality'];
        $GLOBALS['JSON+LD']['ORG_ADDRESS']['addressRegion'] = $arSettings['PROPERTIES']['addressRegion'];
        $GLOBALS['JSON+LD']['ORG_ADDRESS']['postalCode'] = $arSettings['PROPERTIES']['postalCode'];
        $GLOBALS['JSON+LD']['ORG_ADDRESS']['streetAddress'] = $arSettings['PROPERTIES']['streetAddress'];

//    Icons
        $GLOBALS['ICONS'] = array();

        if ($arSettings['PROPERTIES']['FAVICON']['VALUE']) {
            $iconID = $arSettings['PROPERTIES']['FAVICON']['VALUE'];
            $GLOBALS['ICONS'][] = array(
                'id'=>$iconID,
                'src'=>CFile::GetPath($iconID),
                'type'=>'favicon',
                'size'=>'120x120'
            );
        };
        if ($arSettings['PROPERTIES']['FAVICON_16']['VALUE']) {
            $iconID = $arSettings['PROPERTIES']['FAVICON_16']['VALUE'];
            $GLOBALS['ICONS'][] = array(
                'id'=>$iconID,
                'src'=>CFile::GetPath($iconID),
                'type'=>'favicon',
                'size'=>'16x16'
            );
        };
        if ($arSettings['PROPERTIES']['FAVICON_32']['VALUE']) {
            $iconID = $arSettings['PROPERTIES']['FAVICON_32']['VALUE'];
            $GLOBALS['ICONS'][] = array(
                'id'=>$iconID,
                'src'=>CFile::GetPath($iconID),
                'type'=>'favicon',
                'size'=>'32x32'
            );
        };
        if ($arSettings['PROPERTIES']['FAVICON_64']['VALUE']) {
            $iconID = $arSettings['PROPERTIES']['FAVICON_64']['VALUE'];
            $GLOBALS['ICONS'][] = array(
                'id'=>$iconID,
                'src'=>CFile::GetPath($iconID),
                'type'=>'favicon',
                'size'=>'64x64'
            );
        };

        if ($arSettings['PROPERTIES']['APPLE_TOUCH_ICON_57']['VALUE']) {
            $iconID = $arSettings['PROPERTIES']['APPLE_TOUCH_ICON_57']['VALUE'];
            $GLOBALS['ICONS'][] = array(
                'id'=>$iconID,
                'src'=>CFile::GetPath($iconID),
                'type'=>'apple',
                'size'=>'57x57'
            );
        };
        if ($arSettings['PROPERTIES']['APPLE_TOUCH_ICON_114']['VALUE']) {
            $iconID = $arSettings['PROPERTIES']['APPLE_TOUCH_ICON_114']['VALUE'];
            $GLOBALS['ICONS'][] = array(
                'id'=>$iconID,
                'src'=>CFile::GetPath($iconID),
                'type'=>'apple',
                'size'=>'114x114'
            );
        };
        if ($arSettings['PROPERTIES']['APPLE_TOUCH_ICON_60']['VALUE']) {
            $iconID = $arSettings['PROPERTIES']['APPLE_TOUCH_ICON_60']['VALUE'];
            $GLOBALS['ICONS'][] = array(
                'id'=>$iconID,
                'src'=>CFile::GetPath($iconID),
                'type'=>'apple',
                'size'=>'60x60'
            );
        };
        if ($arSettings['PROPERTIES']['APPLE_TOUCH_ICON_120']['VALUE']) {
            $iconID = $arSettings['PROPERTIES']['APPLE_TOUCH_ICON_120']['VALUE'];
            $GLOBALS['ICONS'][] = array(
                'id'=>$iconID,
                'src'=>CFile::GetPath($iconID),
                'type'=>'apple',
                'size'=>'120x120'
            );
        };
        if ($arSettings['PROPERTIES']['APPLE_TOUCH_ICON_72']['VALUE']) {
            $iconID = $arSettings['PROPERTIES']['APPLE_TOUCH_ICON_72']['VALUE'];
            $GLOBALS['ICONS'][] = array(
                'id'=>$iconID,
                'src'=>CFile::GetPath($iconID),
                'type'=>'apple',
                'size'=>'72x72'
            );
        };
        if ($arSettings['PROPERTIES']['APPLE_TOUCH_ICON_144']['VALUE']) {
            $iconID = $arSettings['PROPERTIES']['APPLE_TOUCH_ICON_144']['VALUE'];
            $GLOBALS['ICONS'][] = array(
                'id'=>$iconID,
                'src'=>CFile::GetPath($iconID),
                'type'=>'apple',
                'size'=>'144x144'
            );
        };
        if ($arSettings['PROPERTIES']['APPLE_TOUCH_ICON_76']['VALUE']) {
            $iconID = $arSettings['PROPERTIES']['APPLE_TOUCH_ICON_76']['VALUE'];
            $GLOBALS['ICONS'][] = array(
                'id'=>$iconID,
                'src'=>CFile::GetPath($iconID),
                'type'=>'apple',
                'size'=>'76x76'
            );
        };
        if ($arSettings['PROPERTIES']['APPLE_TOUCH_ICON_152']['VALUE']) {
            $iconID = $arSettings['PROPERTIES']['APPLE_TOUCH_ICON_152']['VALUE'];
            $GLOBALS['ICONS'][] = array(
                'id'=>$iconID,
                'src'=>CFile::GetPath($iconID),
                'type'=>'apple',
                'size'=>'152x152'
            );
        };
        if ($arSettings['PROPERTIES']['APPLE_TOUCH_ICON_180']['VALUE']) {
            $iconID = $arSettings['PROPERTIES']['APPLE_TOUCH_ICON_180']['VALUE'];
            $GLOBALS['ICONS'][] = array(
                'id'=>$iconID,
                'src'=>CFile::GetPath($iconID),
                'type'=>'apple',
                'size'=>'180x180'
            );
        };

        // המהוכאעü הכÿ 8.1+ סמחהאםטו פאיכא browserconfig.xml
        if ($arSettings['PROPERTIES']['WIN_8_COLORE']['VALUE'] && $arSettings['PROPERTIES']['WIN_8_PICTURE']['VALUE']) {
            $iconID = $arSettings['PROPERTIES']['WIN_8_PICTURE']['VALUE'];
            $GLOBALS['ICONS'][] = array(
                'id'=>$iconID,
                'src'=>CFile::GetPath($iconID),
                'type'=>'win8',
                'size'=>'144x144',
                'color'=>$arSettings['PROPERTIES']['WIN_8_COLORE']['VALUE']
            );
        }
//    IconsEnd

    }

    if (!function_exists('leadToWhole')) {
        function leadToWhole($number)
        {
            $arPieces = explode('.', $number);
            $resultNumber = $arPieces[0];

            return $resultNumber;
        }
    }

    if (!function_exists('weightFormat')) {
        function weightFormat($number)
        {
            $weight = leadToWhole($number) . ' דנ.';
            return $weight;
        }
    }

    if (!function_exists('priceFormat')) {
        function priceFormat($number)
        {
            $price = leadToWhole($number) . ' נ.';
            return $price;
        }
    }

    if (!function_exists('quantityFormat')) {
        function quantityFormat($number)
        {
            $quantity = leadToWhole($number) . ' רע.';
            return $quantity;
        }
    }

    if (!function_exists('timeCustomFormat')) {
        function timeCustomFormat($number)
        {
            $quantity = leadToWhole($number) . ' רע.';
            return $quantity;
        }
    }

    if (!function_exists('showIcons')) {
        function showIcons()
        {
            if (empty($GLOBALS['ICONS'])) return;

            foreach ($GLOBALS['ICONS'] as $icon) {
                switch ($icon['type']){
                    case 'apple':
                        echo '<link rel="apple-touch-icon" sizes="'.$icon['size'].'" href="'.$icon['src'].'">';
                        break;
                    case 'favicon':
                        echo '<link rel="icon" type="image/png" sizes="'.$icon['size'].'" href="'.$icon['src'].'">';
                        break;
                    case 'win8':
                        echo '<meta name="msapplication-TileColor" content="'.$icon['color'].'">';
                        echo '<meta name="msapplication-TileImage" content="'.$icon['src'].'">';
                        break;
                }
            }
        }
    }
}
