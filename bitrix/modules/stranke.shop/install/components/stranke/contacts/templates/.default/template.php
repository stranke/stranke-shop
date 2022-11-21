<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="page-container page-container_wide">
    <h1><?=GetMessage('STRANKE_CONTACTS_TITLE')?></h1>

    <div class="contacts">
        <div class="contacts__map-block">
            <div class="map-block">
                <div class="map-block__board" style="background-image: url(<?=$GLOBALS["OPTIONS"]["MAPBOARD_BG"]['SRC']?>)">
                    <div class="map-block__board-info">
                        <div class="board-info">
                            <div class="board-info__element-list">
                                <div class="board-info__element">
                                    <div class="board-info__element-icon" style="background-image: url(<?=SITE_TEMPLATE_PATH?>/img/placeholder.png)"></div><!--
                                    --><div class="board-info__element-info">
                                        <div class="board-info__element-info-title">
                                            <?=$arResult['CITY']?>
                                        </div>

                                        <?if (!empty($arResult['ADDRESS'])):?>
                                            <?foreach($arResult['ADDRESS'] as $address):?>
                                                <span class="board-info__element-info-row"><?=$address?></span>
                                            <?endforeach?>
                                        <?endif?>
                                    </div>
                                </div>

                                <div class="board-info__element">
                                    <div class="board-info__element-icon" style="background-image: url(<?=SITE_TEMPLATE_PATH?>/img/phone-call.png)"></div><!--
                                    --><div class="board-info__element-info">
                                        <div class="board-info__element-info-title">
                                            <?=GetMessage('STRANKE_CONTACTS_PHONES_TITLE')?>
                                        </div>
                                        <?//foreach ($arResult['PHONES'] as $item):?>
                                        <?$item = $arResult['PHONES']?>
                                            <?
                                            $arSearch = array(' ', '(', ')', '-');
                                            $phoneLink = str_replace($arSearch, "", $item);
                                            ?>
                                            <a class="gtm-phone board-info__element-info-row"
                                               href="tel:<?=$phoneLink?>"
                                               onclick="BX.onCustomEvent('target', [{type: 'click', element: this}]);"
                                               ><?=$item?></a>
                                        <?//endforeach?>
                                    </div>
                                </div>
                            </div>

                            <?if (!empty($arResult['SOCIAL_LINKS'])):?>
                                <div class="board-info__social-links">
                                    <?foreach ($arResult['SOCIAL_LINKS'] as $name => $value):?>
                                        <a class="board-info__social-link board-info__social-link_<?=$name?>"
                                           href="<?=$value?>"
                                           target="_blank"
                                        ></a>
                                    <?endforeach?>
                                </div>
                            <?endif?>

                            <div class="board-info__delivery"><?=$arResult['INFORMATION']?></div>
                        </div>
                    </div>
                </div><!--
                --><div class="map-block__map">
                    <?
                    $APPLICATION->IncludeComponent(
                        "bitrix:map.yandex.view",
                        ".default",
                        array(
                            "INIT_MAP_TYPE" => "MAP",
                            "MAP_WIDTH" => "100%",
                            "MAP_HEIGHT" => "auto",
                            "CONTROLS" => array(
                                0 => "ZOOM",
                                1 => "MINIMAP",
                                2 => "TYPECONTROL",
                                3 => "SCALELINE",
                            ),
                            "OPTIONS" => array(
                                0 => "ENABLE_SCROLL_ZOOM",
                                1 => "ENABLE_DBLCLICK_ZOOM",
                                2 => "ENABLE_DRAGGING",
                            ),
                            "COMPONENT_TEMPLATE" => ".default",
                            "MAP_DATA" => $arResult['MAP_DATA'],
                            "MAP_ID" => "",
                            "COMPOSITE_FRAME_MODE" => "A",
                            "COMPOSITE_FRAME_TYPE" => "AUTO"
                        ),
                        false
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
