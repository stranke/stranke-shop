<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>
<?

use Stranke\CRM\CRMMain;
use Stranke\CRM\CRMJob;
use Stranke\CRM\CRMUser;
use Stranke\CRM\CRMClient;


?>
<? if ($USER->IsAdmin()) { ?>
    <?

    /*if (1) {
        require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/wizard.php");
        require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/install/wizard_sol/utils.php");

        if(!CModule::IncludeModule("iblock"))
            return;

        global $DB;
        $DB->StartTransaction();

        include 'arIblocks.php';

        set_time_limit(0);


        $ib = new CIBlock;

        $iblockType = SITE_ID . '_info';
        $iblockCode = SITE_ID . '_widget_1';
        $iblockXmlId = $iblockCode . "_" . SITE_ID;
        $iblockXMLFile = '/bitrix/modules/stranke.crm/install/wizards/stranke/crm/site/services/iblock' . "/xml/" . LANGUAGE_ID . "/widget.xml";


        $rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
        $iblockID = false;
        if ($arIBlock = $rsIBlock->Fetch()) {
            $iblockID = $arIBlock["ID"];

            if (INSTALL_DEMO_DATA) {
                CIBlock::Delete($arIBlock["ID"]);
                $iblockID = false;
            }
        }

        if ($iblockID == false) {
            $permissions = Array("2" => "R");

            @copy($_SERVER["DOCUMENT_ROOT"] . $iblockXMLFile, $_SERVER["DOCUMENT_ROOT"] . $iblockXMLFile . ".back");
            CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"] . $iblockXMLFile, Array("SITE_ID" => SITE_ID));
            $iblockID = WizardServices::ImportIBlockFromXML(
                $iblockXMLFile,
                $iblockXmlId,
                $iblockType,
                SITE_ID,
                $permissions
            );
            if (file_exists($_SERVER["DOCUMENT_ROOT"] . $iblockXMLFile . ".back")) {
                @copy($_SERVER["DOCUMENT_ROOT"] . $iblockXMLFile . ".back", $_SERVER["DOCUMENT_ROOT"] . $iblockXMLFile);
            }

            echo $iblockID;

            if ($iblockID < 1)
                $err = true;
        }
        if ($err) {
            die($code . '<br>' . '
    ' . $err . '
    ');
            $DB->Rollback();
        } else {
            $DB->Commit();
        }
        echo 'ok';
        die();
    }*/
//    $client = new \Stranke\CRM\CRMClient();
//
//    $phone = '79125245487';
//    $arClient = $client->search_by_phone($phone);
//    die();

//    $eventManager = \Bitrix\Main\EventManager::getInstance();
//
//    $eventManager->registerEventHandler('iblock', 'OnAfterIBlockElementUpdate', "stranke.crm", '\Stranke\CRM\CRMMain', 'on_ElementUpdate');
//
//    die();
    if (0) { /* Перепривязка клиентов у сделок */

//        $_SESSION['UPDATE_STORE'] = 1;
        $arFilter = array(
            'ACTIVE' => 'Y',
//            'ID' => 36579,
            'IBLOCK_CODE' => SITE_ID . '_lid'
        );
        $one_iteration = 30;
        $res = CIBlockElement::GetList(array('ID' => 'DESC'), $arFilter, false, array('nPageSize' => $one_iteration, 'iNumPage' => $_SESSION['UPDATE_STORE']));
        if ($res->PAGEN == $res->NavPageNomer) {
            ?>
            UPDATE_STORE: Step <? echo $res->NavPageNomer ?> of <? echo $res->NavPageCount ?><br>
            <?
        } else {
            unset($_SESSION['UPDATE_STORE']);
            echo 'UPDATE_STORE: Complite';
            die();
        }
        $CLIENT_PROPS = array(
            'CLIENT',
            'CLIENT_CONTACT',
            'PROJECT',
        );
        if ($_SESSION['UPDATE_STORE']) {
            $el = new CIBlockElement;
            while ($obElem = $res->GetNextElement()) {
                $arResult = $obElem->GetFields();
                $arResult['PROPERTIES'] = $obElem->GetProperties();


                $real_CLIENT = false;
                $CLIENT_PROPS_name = array();
                $real_CLIENT_ID = false;
                $real_CLIENT_PROPERTY = false;
                $newProps = array();
                foreach ($CLIENT_PROPS as $code) {
                    if ($arResult['PROPERTIES'][$code]['VALUE']) {
                        $real_CLIENT_ID = $arResult['PROPERTIES'][$code]['VALUE'];
                        $real_CLIENT_PROPERTY = $code;
                    }
                    $CLIENT_PROPS_name[] = $arResult['PROPERTIES'][$code]['NAME'];
                    $newProps[$code] = '';
                }
                if ($real_CLIENT_ID) {
                    $ar_filtar = array('ID' => $real_CLIENT_ID);
                    $resElem_ = CIBlockElement::GetList(array(
                        'SORT' => 'ASC',
                        'NAME' => 'ASC',
                        'ID' => 'ASC',
                    ), $ar_filtar, false, array('nTopCount' => 1), array(
                        'ID',
                        'IBLOCK_CODE',
                        'PROPERTY_PHONE',
                        'DETAIL_PAGE_URL',
                        'PROPERTY_FCLIENT',
                        'NAME',
                        'PREVIEW_PICTURE',
                    ));
                    while ($arElem = $resElem_->GetNext()) {
                        if ($arElem["NAME"] == 'elem_' . $arElem["ID"]) {
                            continue;
                        }
                        $arElem['code'] = strtoupper(substr($arElem['IBLOCK_CODE'], strlen(SITE_ID) + 1));
                        $real_CLIENT = $arElem;
                    }
                }
                if ($real_CLIENT['ID'] && $arResult['PROPERTIES'][$real_CLIENT['code']]['VALUE'] != $real_CLIENT['ID']) {


                    $newProps[$real_CLIENT['code']] = $real_CLIENT['ID'];
//                    echo '<pre>';
//                    print_r($newProps);
//                    die();
                    CIBlockElement::SetPropertyValuesEx($arResult['ID'], $arResult['IBLOCK_ID'], $newProps);
                }
            }

            if ($_SESSION['UPDATE_STORE'] >= 0) {
                $_SESSION['UPDATE_STORE']++;
                ?>
                <script>
                    console.info('UPDATE_STORE: Step <? echo $_SESSION['UPDATE_STORE'] - 1 ?>');
                    $(window).on('load', function () {
                        window.location.reload();
                    })
                </script>
                <?
            }
        }
        die();
    } elseif (0) {

//        $_SESSION['UPDATE_STORE'] = 1;
        $arFilter = array(
            'ACTIVE' => 'Y',
//            'ID' => 19952,
            'IBLOCK_CODE' => SITE_ID . '_lid'
        );
        $one_iteration = 30;
        $res = CIBlockElement::GetList(array('ID' => 'DESC'), $arFilter, false, array('nPageSize' => $one_iteration, 'iNumPage' => $_SESSION['UPDATE_STORE']));
        if ($res->PAGEN == $res->NavPageNomer) {
            ?>
            UPDATE_STORE: Step <? echo $res->NavPageNomer ?> of <? echo $res->NavPageCount ?><br>
            <?
        } else {
            unset($_SESSION['UPDATE_STORE']);
            echo 'UPDATE_STORE: Complite';
            die();
        }
        if ($_SESSION['UPDATE_STORE']) {
            $el = new CIBlockElement;
            while ($obElem = $res->GetNextElement()) {
                $arElem = $obElem->GetFields();
                $arElem['PROPERTIES'] = $obElem->GetProperties();

//                echo '<pre>';
//                print_r($arElem);
//                die();

                CIBlockElement::SetPropertyValuesEx($arElem['ID'], $arElem['IBLOCK_ID'], array('STATUS_VALUE' => $arElem['PROPERTIES']['STATUS']['VALUE']));

            }

            if ($_SESSION['UPDATE_STORE'] >= 0) {
                $_SESSION['UPDATE_STORE']++;
                ?>
                <script>
                    console.info('UPDATE_STORE: Step <? echo $_SESSION['UPDATE_STORE'] - 1 ?>');
                    $(window).on('load', function () {
                        window.location.reload();
                    })
                </script>
                <?
            }
        }
        die();
    } elseif (0) {
        ?>
        <? $webrtcKey = '3aa78abcfb0491e52e2d2e6bf0b73cc517d92636fc7ed7e82451f9d964f906f2104145d3af846339c144d3e6f0d4ad38a9a7535ef89e3d791b4bc670460f5000'; ?>
        <? $login = '110268-245' ?>
        <script src="https://my.zadarma.com/webphoneWebRTCWidget/v8/js/loader-phone-lib.js?v=23"></script>
        <script src="https://my.zadarma.com/webphoneWebRTCWidget/v8/js/loader-phone-fn.js?v=23"></script>
        <script>
            if (window.addEventListener) {
                window.addEventListener('load', function () {
                    zadarmaWidgetFn('<?= $webrtcKey?>', '<?= $login?>', 'square' /*square|rounded*/, 'en' /*ru, en, es, fr, de, pl, ua*/, true, "{right:'10px',bottom:'5px'}");
                }, false);
            } else if (window.attachEvent) {
                window.attachEvent('onload', function () {
                    zadarmaWidgetFn('<?= $webrtcKey?>', '<?= $login?>', 'square' /*square|rounded*/, 'en' /*ru, en, es, fr, de, pl, ua*/, true, "{right:'10px',bottom:'5px'}");
                });
            }
        </script>
        <?
        die();
    } elseif (0) {
        echo COption::GetOptionString("security", "ipcheck_disable_file");
        die();
    } elseif (0) {
        $CLIENT_ID = 47903;
        $ar_filtar = array('ID' => $CLIENT_ID);
        $resElem = CIBlockElement::GetList(array(), $ar_filtar, false, false, array(
            'PROPERTY_PHONE',
        ));
        $arJob = $resElem->GetNext();
        echo '<pre>';
        print_r($arJob);
        echo '</pre>';
        die();
    } elseif (0) {
        $_SESSION['UPDATE_STORE'] = 1;
        $arFilter = array(
            'ACTIVE' => 'Y',
            'NAME' => 'elem_%'
//            'ID' => 37724
        );
        $one_iteration = 30;
        $res = CIBlockElement::GetList(array('ID' => 'DESC'), $arFilter, false, array('nPageSize' => $one_iteration, 'iNumPage' => $_SESSION['UPDATE_STORE']));
        if ($res->PAGEN == $res->NavPageNomer) {
            ?>
            UPDATE_STORE: Step <? echo $res->NavPageNomer ?> of <? echo $res->NavPageCount ?><br>
            <?
            $_SESSION['UPDATE_STORE']++;
        } else {
            unset($_SESSION['UPDATE_STORE']);
            echo 'UPDATE_STORE: Complite';
            die();
        }
        if ($_SESSION['UPDATE_STORE']) {
            $el = new CIBlockElement;
            while ($obElem = $res->GetNextElement()) {
                $arElem = $obElem->GetFields();
                echo '<pre>';
                print_r($arElem);
                echo '</pre>';
                if ($arElem['NAME'] == 'elem_' . $arElem['ID']) {
//                    $el->Delete($arElem['ID']);
                    continue;
                }
                /*$arElem['PROPERTIES'] = $obElem->GetProperties();
                if ($arElem['PROPERTIES']['PRICE']['VALUE'] > 0) {
                    CIBlockElement::SetPropertyValuesEx($arElem['ID'], $arElem['IBLOCK_ID'], array('RECIPIENT' => 20374));
                } else {
                    if ($arElem['PROPERTIES']['RECIPIENT']['VALUE'] == 20374) {
                        CIBlockElement::SetPropertyValuesEx($arElem['ID'], $arElem['IBLOCK_ID'], array('RECIPIENT' => ''));
                    } else {
                        if ($arElem['PROPERTIES']['CLIENT']['VALUE'] != 20374) {
                            CIBlockElement::SetPropertyValuesEx($arElem['ID'], $arElem['IBLOCK_ID'], array('RECIPIENT' => $arElem['PROPERTIES']['CLIENT']['VALUE'], 'CLIENT' => 20374));
                        } else {
                            CIBlockElement::SetPropertyValuesEx($arElem['ID'], $arElem['IBLOCK_ID'], array('CLIENT' => 20374));
                        }
                    }
                }*/
            }

            if ($_SESSION['UPDATE_STORE'] >= 0) {
                ?>
                <script>
                    console.info('UPDATE_STORE: Step <? echo $_SESSION['UPDATE_STORE'] - 1 ?>');
                    $(window).on('load', function () {
                        // window.location.reload();
                    })
                </script>
                <?
            }
        }
        die();
    }
    /*$rsSites = CSite::GetList($by = "sort", $order = "asc");
    $site_id = false;
    while ($arSite = $rsSites->Fetch()) {
        $rsTemplates = CSite::GetTemplateList($arSite['ID']);
        while ($arTemplate = $rsTemplates->Fetch()) {
            if ($arTemplate['TEMPLATE'] == 'vsevset_template') {
                $site_id = $arSite['ID'];
                break;
            }
        }
        if ($site_id) {
            break;
        }
    }

    $iblockType = $site_id . '_info';
    $iblockCode = $site_id . '_widget';

    $ar_filtar = array('ACTIVE' => 'Y', "TYPE" => $iblockType, 'CODE' => $iblockCode);

    $resElem = CIBlock::GetList(array('ID' => 'DESC'), $ar_filtar, false, false, array('ID'));
    while ($arElem = $resElem->GetNext()) {

        echo "<pre>";
        print_r($arElem);
        echo "</pre>";
    }
    die();*/
    /* for debug only */

//удаление свойства TIME  время приготовления
    $res = CIBlockProperty::GetByID("TIME", false, "catalog_products_" . SITE_ID);
    if ($ar_res = $res->GetNext()) {
        $deletetime = CIBlockProperty::Delete($ar_res['ID']);
    }
//
    //добавление свойства длоп фото для ТП
    $res = CIBlock::GetList(
        array(),
        array(
            'SITE_ID' => SITE_ID,
            'ACTIVE' => 'Y',
            "CODE" => "catalog_offers_" . SITE_ID
        ), false
    );
    while ($ar_res = $res->Fetch()) {
        $tpid = $ar_res['ID'];
    }

    $res = CIBlockProperty::GetByID("TP_DOP_PHOTO", false, "catalog_offers_" . SITE_ID);
    if (!$ar_res = $res->GetNext()) {
        $arFields = array(
            "NAME" => "Дополнительные фото",
            "ACTIVE" => "Y",
            "SORT" => "500",
            "DEFAULT_VALUE" => "",
            "CODE" => "TP_DOP_PHOTO",
            "MULTIPLE" => "Y",
            "PROPERTY_TYPE" => "F",
            "IBLOCK_ID" => $tpid
        );
        $ibp = new CIBlockProperty;
        $SrcPropID = $ibp->Add($arFields);
    }
    //

    //добавление свойства аксесуаров для ТП


    $res = CIBlockProperty::GetByID("TP_ACCESSORIES", false, "catalog_offers_" . SITE_ID);
    if (!$ar_res = $res->GetNext()) {
        $arFields = array(
            "NAME" => "Аксесуары",
            "ACTIVE" => "Y",
            "SORT" => "500",
            "DEFAULT_VALUE" => "",
            "CODE" => "TP_ACCESSORIES",
            "MULTIPLE" => "Y",
            "PROPERTY_TYPE" => "E",
            "IBLOCK_ID" => $tpid
        );
        $ibp = new CIBlockProperty;
        $SrcPropID = $ibp->Add($arFields);
    }
    //


    //добавление свойства телеграмм
    $res = CIBlock::GetList(
        array(),
        array(
            'SITE_ID' => SITE_ID,
            'ACTIVE' => 'Y',
            "CODE" => "services_settings_" . SITE_ID
        ), false
    );
    while ($ar_res = $res->Fetch()) {
        $tpid = $ar_res['ID'];
    }

    $res = CIBlockProperty::GetByID("SOCIAL_TELEGRAM", false, "services_settings_" . SITE_ID);
    if (!$ar_res = $res->GetNext()) {
        $arFields = array(
            "NAME" => "Telegram",
            "ACTIVE" => "Y",
            "SORT" => "500",
            "DEFAULT_VALUE" => "",
            "CODE" => "SOCIAL_TELEGRAM",
            "MULTIPLE" => "N",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => $tpid
        );
        $ibp = new CIBlockProperty;
        $SrcPropID = $ibp->Add($arFields);
    }
    //
    //переименование соц сетей
    $socialnames = array('Facebook' => 'SOCIAL_WEBS_FB',
        'Instagram' => 'SOCIAL_WEBS_INSTA',
        'Vkontakte' => 'SOCIAL_WEBS_VK',
        'AppStore' => 'APP_STORE_LINK',
        'Google Play' => 'GOOGLE_PLAY_LINK',
        'AppGallery' => 'APP_GALLERY_LINK');
    foreach ($socialnames as $keys => $socialnamesitem) {
        $res = CIBlockProperty::GetByID("$socialnamesitem", false, "services_settings_" . SITE_ID);
        $ar_res = $res->GetNext();
        if ($ar_res['NAME'] != $keys) {
            $fields = CIBlock::getFields($tpid);
            $arFields = array(
                "NAME" => $keys,
            );
            $ibp = new CIBlockProperty;
            if (!$ibp->Update($ar_res['ID'], $arFields))
                echo $ibp->LAST_ERROR;
        }
    }

    //

    //блок призыва создание свойства


    $res = CIBlockProperty::GetByID("BLOCK_PRIZ_TOVAR_ON", false, "services_settings_" . SITE_ID);
    if (!$ar_res = $res->GetNext()) {
        $arFields = array(
            "NAME" => "Блок призыва на странице товара",
            "ACTIVE" => "Y",
            "SORT" => "500",
            "DEFAULT_VALUE" => "",
            "CODE" => "BLOCK_PRIZ_TOVAR_ON",
            "MULTIPLE" => "N",
            "PROPERTY_TYPE" => "L",
            'ROW_COUNT' => 1,
            'COL_COUNT' => 30,
            'LIST_TYPE' => 'C',
            'MULTIPLE_CNT' => 5,
            "IBLOCK_ID" => $tpid
        );
        $arFields["VALUES"][0] = array(
            "VALUE" => "Y",
            "SORT" => "500"
        );
        $ibp = new CIBlockProperty;
        $SrcPropID = $ibp->Add($arFields);
    }
    //

    //цвет подложки свойство


    $res = CIBlockProperty::GetByID("COLOR_BACKGROUND_ACTION", false, "services_settings_" . SITE_ID);
    if (!$ar_res = $res->GetNext()) {
        $arFields = array(
            "NAME" => "Цвет подложки",
            "ACTIVE" => "Y",
            "SORT" => "500",
            "DEFAULT_VALUE" => "",
            "CODE" => "COLOR_BACKGROUND_ACTION",
            "MULTIPLE" => "N",
            'COL_COUNT' => 30,
            'LIST_TYPE' => 'L',
            "PROPERTY_TYPE" => "S",
            'USER_TYPE' => 'STRANKE_COLOR',
            "IBLOCK_ID" => $tpid
        );
        $ibp = new CIBlockProperty;
        $SrcPropID = $ibp->Add($arFields);
    }
    //

    //добавление свойства цвет текста


    $res = CIBlockProperty::GetByID("COLOR_TEXT_ACTION", false, "services_settings_" . SITE_ID);
    if (!$ar_res = $res->GetNext()) {
        $arFields = array(
            "NAME" => "Цвет текста",
            "ACTIVE" => "Y",
            "SORT" => "500",
            "DEFAULT_VALUE" => "",
            "CODE" => "COLOR_TEXT_ACTION",
            "MULTIPLE" => "N",
            'COL_COUNT' => 30,
            'LIST_TYPE' => 'L',
            "PROPERTY_TYPE" => "S",
            'USER_TYPE' => 'STRANKE_COLOR',
            "IBLOCK_ID" => $tpid
        );
        $ibp = new CIBlockProperty;
        $SrcPropID = $ibp->Add($arFields);
    }
    //

    //добавление свойства текст


    $res = CIBlockProperty::GetByID("TEXT_ACTION", false, "services_settings_" . SITE_ID);
    if (!$ar_res = $res->GetNext()) {
        $arFields = array(
            "NAME" => "Текст",
            "ACTIVE" => "Y",
            "SORT" => "500",
            "DEFAULT_VALUE" => "",
            "CODE" => "TEXT_ACTION",
            "MULTIPLE" => "N",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => $tpid
        );
        $ibp = new CIBlockProperty;
        $SrcPropID = $ibp->Add($arFields);
    }
    //

    //добавление свойства Идентификатор цели 'Успешная авторизация'


    $res = CIBlockProperty::GetByID("TARGET_AUTH", false, "services_settings_" . SITE_ID);
    if (!$ar_res = $res->GetNext()) {
        $arFields = array(
            "NAME" => "Идентификатор цели 'Успешная авторизация'",
            "ACTIVE" => "Y",
            "SORT" => "500",
            "DEFAULT_VALUE" => "",
            "CODE" => "TARGET_AUTH",
            "MULTIPLE" => "N",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => $tpid
        );
        $ibp = new CIBlockProperty;
        $SrcPropID = $ibp->Add($arFields);
    }
    //

    //добавление свойства остаток на складе


    $res = CIBlockProperty::GetByID("STOCK_BALANCE", false, "services_settings_" . SITE_ID);
    if (!$ar_res = $res->GetNext()) {
        $arFields = array(
            "NAME" => "Остаток на складе",
            "ACTIVE" => "Y",
            "SORT" => "500",
            "DEFAULT_VALUE" => "",
            "CODE" => "STOCK_BALANCE",
            "MULTIPLE" => "N",
            "PROPERTY_TYPE" => "L",
            'ROW_COUNT' => 1,
            'COL_COUNT' => 30,
            'LIST_TYPE' => 'C',
            'MULTIPLE_CNT' => 5,
            "IBLOCK_ID" => $tpid
        );
        $arFields["VALUES"][0] = array(
            "VALUE" => "Y",
            "SORT" => "500"
        );
        $ibp = new CIBlockProperty;
        $SrcPropID = $ibp->Add($arFields);
    }
    //


//добавление свойства размер текста для баннера заголовок
    $res = CIBlockProperty::GetByID("BANNER_TITLE_FONT_SIZE", false, "services_settings_" . SITE_ID);
    if (!$ar_res = $res->GetNext()) {
        $arFields = array(
            "NAME" => "Размер текста для заголовка слайдера (px)",
            "ACTIVE" => "Y",
            "SORT" => "500",
            "DEFAULT_VALUE" => "",
            "CODE" => "BANNER_TITLE_FONT_SIZE",
            "MULTIPLE" => "N",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => $tpid
        );
        $arFields["VALUES"][0] = array(
            "VALUE" => "Y",
            "SORT" => "500"
        );
        $ibp = new CIBlockProperty;
        $SrcPropID = $ibp->Add($arFields);
    }
    //

//добавление свойства размер текста для баннера подзаголовок
    $res = CIBlockProperty::GetByID("BANNER_SUBTITLE_FONT_SIZE", false, "services_settings_" . SITE_ID);
    if (!$ar_res = $res->GetNext()) {
        $arFields = array(
            "NAME" => "Размер текста для подзаголовка слайдера (px)",
            "ACTIVE" => "Y",
            "SORT" => "500",
            "DEFAULT_VALUE" => "",
            "CODE" => "BANNER_SUBTITLE_FONT_SIZE",
            "MULTIPLE" => "N",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => $tpid
        );
        $arFields["VALUES"][0] = array(
            "VALUE" => "Y",
            "SORT" => "500"
        );
        $ibp = new CIBlockProperty;
        $SrcPropID = $ibp->Add($arFields);
    }
    //


//изменение урл у текстовых страниц
    $res = CIBlock::GetList(
        array(),
        array(
            'SITE_ID' => SITE_ID,
            'ACTIVE' => 'Y',
            "CODE" => "content_pages_" . SITE_ID
        ), true
    );
    while ($ar_res = $res->Fetch()) {
        $idtextstr = $ar_res['ID'];
    }


    $ib = new CIBlock;
    $arFields = array(
        "LIST_PAGE_URL" => '',
        "DETAIL_PAGE_URL" => '#SITE_DIR#/#ELEMENT_CODE#/',
        'SECTION_PAGE_URL' => '',
    );
    $res = $ib->Update($idtextstr, $arFields);
    //


    //добавление Идентификатор цели 'Отправка форма призыва'
    $res = CIBlock::GetList(
        array(),
        array(
            'SITE_ID' => SITE_ID,
            'ACTIVE' => 'Y',
            "CODE" => "services_settings_" . SITE_ID
        ), false
    );
    while ($ar_res = $res->Fetch()) {
        $tpid = $ar_res['ID'];
    }

    $res = CIBlockProperty::GetByID("YM_ONCHANGE_FORM_PRIZ", false, "services_settings_" . SITE_ID);
    if (!$ar_res = $res->GetNext()) {
        $arFields = array(
            "NAME" => "Идентификатор цели 'Отправка форма призыва'",
            "ACTIVE" => "Y",
            "SORT" => "500",
            "DEFAULT_VALUE" => "",
            "CODE" => "YM_ONCHANGE_FORM_PRIZ",
            "MULTIPLE" => "N",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => $tpid
        );
        $ibp = new CIBlockProperty;
        $SrcPropID = $ibp->Add($arFields);
    }
    //
//создание инфоблока заявки в служебном типе
    $res = CIBlock::GetList(
        array(),
        array(
            'SITE_ID' => SITE_ID,
            'ACTIVE' => 'Y',
            "CODE" => "services_applications_" . SITE_ID
        ), false
    );
    while ($ar_res = $res->Fetch()) {
        $tpida = $ar_res['ID'];
    }
    if (!$tpida) {
        $ib = new CIBlock;
        $arFields = array(
            "ACTIVE" => 'Y',
            "NAME" => 'Заявки',
            "CODE" => "services_applications_" . SITE_ID,
            "IBLOCK_TYPE_ID" => 'services',
            "SITE_ID" => SITE_ID,
            "SORT" => "500",
            "GROUP_ID" => array("2" => "D", "3" => "R")
        );
        $ID = $ib->Add($arFields);
    }
    //
//добавление свойства телефон для заявок
    $res = CIBlockProperty::GetByID("PHONE_APLIC", false, "services_applications_" . SITE_ID);
    if (!$ar_res = $res->GetNext()) {
        $arFields = array(
            "NAME" => "Телефон",
            "ACTIVE" => "Y",
            "SORT" => "500",
            "DEFAULT_VALUE" => "",
            "CODE" => "PHONE_APLIC",
            "MULTIPLE" => "N",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => $tpida
        );
        $arFields["VALUES"][0] = array(
            "VALUE" => "Y",
            "SORT" => "500"
        );
        $ibp = new CIBlockProperty;
        $SrcPropID = $ibp->Add($arFields);
    }
    //
    //добавление свойства ссылка для заявок
    $res = CIBlockProperty::GetByID("URL_APLIC", false, "services_applications_" . SITE_ID);
    if (!$ar_res = $res->GetNext()) {
        $arFields = array(
            "NAME" => "Ссылка",
            "ACTIVE" => "Y",
            "SORT" => "500",
            "DEFAULT_VALUE" => "",
            "CODE" => "URL_APLIC",
            "MULTIPLE" => "N",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => $tpida
        );
        $arFields["VALUES"][0] = array(
            "VALUE" => "Y",
            "SORT" => "500"
        );
        $ibp = new CIBlockProperty;
        $SrcPropID = $ibp->Add($arFields);
    }
    //
//добавление раздела заявки формы призыва
    $arFilter = array('IBLOCK_ID' => $tpida, 'GLOBAL_ACTIVE' => 'Y', 'CODE' => 'call_form_application');
    $db_list = CIBlockSection::GetList(array($by => $order), $arFilter, true);
    while ($ar_result = $db_list->GetNext()) {
        $apfpid = $ar_result['ID'];
    }
    if (!$apfpid) {


        $bs = new CIBlockSection;
        $arFields = array(
            "ACTIVE" => 'Y',
            "IBLOCK_ID" => $tpida,
            "NAME" => 'Заявки формы призыва',
            "SORT" => '500',
            'CODE' => 'call_form_application',
            "DESCRIPTION_TYPE" => 'text'
        );

        $ID = $bs->Add($arFields);

    }


    //

    $name_module = 'stranke.shop';
    $name_ex = explode('.', $name_module);
    $dir = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $name_module . '/install';
    if (1) {
//        CopyDirFiles($dir . '/wizards/', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/wizards', true, true);
        CopyDirFiles($dir . '/components/', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/components', true, true);
        CopyDirFiles($dir . '/wizards/' . implode('/', $name_ex) . '/site/templates/', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/templates', true, true);
//        CopyDirFiles($dir . '/wizards/' . implode('/', $name_ex) . '/site/templates/stranke_shop/lang', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/templates/stranke_shop/lang', true, true);
        CopyDirFiles($dir . '/wizards/' . implode('/', $name_ex) . '/site/public/ru/', $_SERVER['DOCUMENT_ROOT'] . '/', true, true);
        CopyDirFiles($dir . '/wizards/', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/wizards', true, true);

        echo 'Update';
        die();
    }
    /* for debug only */

    if ($_POST['SUBMIT'] && !$_SESSION['UPDATE_STORE']) {
        $_SESSION['UPDATE_STORE'] = 1;
        header("Location: " . $APPLICATION->GetCurPage(), true, 301);
        die();
    }
    $archive_status_id = array('archive');
//    $_SESSION['UPDATE_STORE'] = 1;
    if (isset($_SESSION['UPDATE_STORE'])) {
        if (0) { // Пересчёт задач

            $job = new \Stranke\CRM\CRMJob();
            $job->RecalcJobCount();
            $arFilter = array(
                'ACTIVE' => 'Y',
                'IBLOCK_ID' => $job->iblock_id,
                '=PROPERTY_CLOSE' => false,
            );
            $one_iteration = 30;
            $arFilter = array('IBLOCK_ID' => $IBLOCK_ID, '<DATE_CREATE' => '01.01.2018');
            $arFilter['!PROPERTY_STATUS'] = array('cancel', 'archive');
            $res = CIBlockElement::GetList(array('ID' => 'DESC'), $arFilter, false, array('nPageSize' => $one_iteration, 'iNumPage' => $_SESSION['UPDATE_STORE']));
            if ($res->PAGEN == $res->NavPageNomer) {
                ?>
                UPDATE_STORE: Step <? echo $res->NavPageNomer ?> of <? echo $res->NavPageCount ?><br>
                <?
//                $_SESSION['UPDATE_STORE']++;
            } else {
                unset($_SESSION['UPDATE_STORE']);
                echo 'UPDATE_STORE: Complite';
                die();
            }
            if ($_SESSION['UPDATE_STORE']) {
                $el = new CIBlockElement;
                while ($obElem = $res->GetNextElement()) {
                    $arElem = $obElem->GetFields();
                    $job->SetJobCount($arElem['ID']);
                }

                if ($_SESSION['UPDATE_STORE'] >= 0) {
                    ?>
                    <script>
                        console.info('UPDATE_STORE: Step <? echo $_SESSION['UPDATE_STORE'] - 1 ?>');
                        $(window).on('load', function () {
                            // window.location.reload();
                        })
                    </script>
                    <?
                }
            }
        }
    } else {
        ?>
        <form method="POST">
            <input type="submit" name="SUBMIT" value="Обновить значения остатков">
        </form>
    <? } ?>
    <?
}
?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
