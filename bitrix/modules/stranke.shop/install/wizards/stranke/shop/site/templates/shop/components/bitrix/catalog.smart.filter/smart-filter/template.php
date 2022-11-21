<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
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
$this->SetViewTarget("right_area");
CJSCore::Init(array("fx"));

if (file_exists($_SERVER["DOCUMENT_ROOT"] . $this->GetFolder() . '/themes/' . $arParams["TEMPLATE_THEME"] . '/colors.css'))
    $APPLICATION->SetAdditionalCSS($this->GetFolder() . '/themes/' . $arParams["TEMPLATE_THEME"] . '/colors.css');
?>

<div class="bx_filter_vertical">
    <div class="bx_filter_section m4">

        <form name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" action="<? echo $arResult["FORM_ACTION"] ?>" method="get" class="smartfilter">

            <div class="products-settings__item-list">

                <? foreach ($arResult["HIDDEN"] as $arItem) { ?>
                    <input
                            type="hidden"
                            name="<? echo $arItem["CONTROL_NAME"] ?>"
                            id="<? echo $arItem["CONTROL_ID"] ?>"
                            value="<? echo $arItem["HTML_VALUE"] ?>"
                    />
                <? } ?>

                <?
                foreach ($arResult["ITEMS"] as $key => $arItem):
                    $key = md5($key);
                    ?>
                    <? /* if (isset($arItem["PRICE"])): ?>
                    <?
                    if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
                        continue;
                    ?>
                <div class="bx_filter_container price">

                    <p class="title">Стоимость, <span>руб.</span></p>
                    <div class="bx_filter_param_area">
                        <div class="bx_filter_param_area_block"><div class="bx_input_container">
                                <span class="price_count">от</span>
                                <input
                                    class="min-price"
                                    type="text"
                                    name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                    id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                    <? if (!empty($arItem["VALUES"]["MIN"]["HTML_VALUE"])): ?>
                                        value="<? echo (int) $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                    <? else: ?>
                                        placeholder="<? echo (int) $arItem["VALUES"]["MIN"]["VALUE"] ?>"
                                    <? endif; ?>
                                    size="5"
                                    onkeyup="smartFilter.keyup(this)"
                                    />
                            </div></div>
                        <div class="bx_filter_param_area_block"><div class="bx_input_container">
                                <span class="price_count">до</span>
                                <input
                                    class="max-price"
                                    type="text"
                                    name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                    id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                    <? if (!empty($arItem["VALUES"]["MAX"]["HTML_VALUE"])): ?>
                                        value="<? echo (int) $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                    <? else: ?>
                                        placeholder="<? echo (int) $arItem["VALUES"]["MAX"]["VALUE"] ?>"
                                    <? endif; ?>
                                    size="5"
                                    onkeyup="smartFilter.keyup(this)"
                                    />
                            </div></div>
                        <div style="clear: both;"></div>
                    </div>
                    <div class="bx_ui_slider_track" id="drag_track_<?= $key ?>">
                        <div class="bx_ui_slider_range" style="left: 0; right: 0%;"  id="drag_tracker_<?= $key ?>"></div>
                        <a class="bx_ui_slider_handle left"  href="javascript:void(0)" style="left:0;" id="left_slider_<?= $key ?>"></a>
                        <a class="bx_ui_slider_handle right" href="javascript:void(0)" style="right:0%;" id="right_slider_<?= $key ?>"></a>
                    </div>
                    <div class="bx_filter_param_area">
                        <div class="bx_filter_param_area_block" id="curMinPrice_<?= $key ?>"><? //=$arItem["VALUES"]["MIN"]["VALUE"]      ?></div>
                        <div class="bx_filter_param_area_block" id="curMaxPrice_<?= $key ?>"><? //=$arItem["VALUES"]["MAX"]["VALUE"]      ?></div>
                        <div style="clear: both;"></div>
                    </div>
                </div>

                <script type="text/javascript">
                    var DoubleTrackBar<?= $key ?> = new cDoubleTrackBar('drag_track_<?= $key ?>', 'drag_tracker_<?= $key ?>', 'left_slider_<?= $key ?>', 'right_slider_<?= $key ?>', {
                        OnUpdate: function () {
                            BX("<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>").value = this.MinPos;
                            BX("<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>").value = this.MaxPos;
                        },
                        Min: parseFloat(<?= $arItem["VALUES"]["MIN"]["VALUE"] ?>),
                        Max: parseFloat(<?= $arItem["VALUES"]["MAX"]["VALUE"] ?>),
                        MinInputId: BX('<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>'),
                        MaxInputId: BX('<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>'),
                        FingerOffset: 10,
                        MinSpace: 1,
                        RoundTo: 0,
                        Precision: 2
                    });</script>
            <? endif */
                    ?>
                <? endforeach ?>

                <? //TODO: add filter by store ?>
                <? foreach ($arResult["ITEMS"] as $key => $arItem): ?>
                    <? if ($arItem["PROPERTY_TYPE"] == "N" || $arItem["PRICE"] == 1): ?>
                        <?
                        if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
                            continue;
                        ?>
                        <?
                        $arItem["VALUES"]["MIN"]["VALUE"] = round($arItem["VALUES"]["MIN"]["VALUE"]);
                        $arItem["VALUES"]["MAX"]["VALUE"] = round($arItem["VALUES"]["MAX"]["VALUE"]);
                        ?>
                        <div class="products-settings__item">

                            <div class="products-settings__item-title">
                                <?= $arItem["NAME"] = $arItem["PRICE"] == 1 ? GetMessage('CT_BCSF_FILTER_PRICE') : $arItem["NAME"]; ?>
                            </div>

                            <div class="products-settings__item-price">
                                <div class="item-price">

                                    <div class="bx-filter-parameters-box-container">
                                        <div class="bx-filter-parameters-box-container-block bx-left">
                                            <div class="bx_input_container bx-filter-input-container">
                                                <input
                                                        class="min-price"
                                                        type="text"
                                                        name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                                        id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                                        value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                                        size="7"
                                                        placeholder="<?= $arItem["VALUES"]["MIN"]["VALUE"] ?>"
                                                        onkeyup="smartFilter.keyup(this)"
                                                />
                                                <div class="bx-filter-input-container__text">
                                                    <?= GetMessage('CT_BCSF_FILTER_FROM') ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bx-filter-parameters-box-container-block bx-right">
                                            <div class="bx_input_container bx-filter-input-container">
                                                <input
                                                        class="max-price"
                                                        type="text"
                                                        name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                                        id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                                        value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                                        size="7"
                                                        placeholder="<?= $arItem["VALUES"]["MAX"]["VALUE"] ?>"
                                                        onkeyup="smartFilter.keyup(this)"
                                                />
                                                <div class="bx-filter-input-container__text">
                                                    <?= GetMessage('CT_BCSF_FILTER_TO') ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="clear: both;"></div>
                                    </div>

                                    <div class="bx-ui-slider-track-container">
                                        <div class="bx_ui_slider_track bx-ui-slider-track" id="drag_track_<?= $key ?>">
                                            <div class="bx_ui_slider_range bx-ui-slider-range" style="left: 0; right: 0%;" id="drag_tracker_<?= $key ?>"></div>
                                            <a class="bx_ui_slider_handle bx-ui-slider-handle left" href="javascript:void(0)" style="left:0;" id="left_slider_<?= $key ?>"></a>
                                            <a class="bx_ui_slider_handle bx-ui-slider-handle right" href="javascript:void(0)" style="right:0%;" id="right_slider_<?= $key ?>"></a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <script type="text/javascript">
                            $(window).on('load', function (e) {
                                var DoubleTrackBar<?= $key ?> = new cDoubleTrackBar('drag_track_<?= $key ?>', 'drag_tracker_<?= $key ?>', 'left_slider_<?= $key ?>', 'right_slider_<?= $key ?>', {
                                    OnUpdate: function () {
                                        BX("<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>").value = this.MinPos;
                                        BX("<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>").value = this.MaxPos;
                                    },
                                    Min: parseFloat(<?= $arItem["VALUES"]["MIN"]["VALUE"] ?>),
                                    Max: parseFloat(<?= $arItem["VALUES"]["MAX"]["VALUE"] ?>),
                                    MinInputId: BX('<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>'),
                                    MaxInputId: BX('<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>'),
                                    FingerOffset: 10,
                                    MinSpace: 1,
                                    RoundTo: 1
                                });
                            })</script>
                    <? elseif (!empty($arItem["VALUES"]) && !isset($arItem["PRICE"])): ?>
                        <div class="products-settings__item <?= $arItem["DISPLAY_EXPANDED"] == 'Y' ? ' open_dowm' : '' ?>" field="<?= $arItem["CODE"] ?>">
                            <div class="products-settings__item-title">
                                <svg width="10" height="7" viewBox="0 0 10 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.83267 0L5 3.83267L1.16591 0L0 1.16591L5 6.16591L10 1.16591L8.83267 0Z" fill="#383838"/>
                                </svg>
                                <? $arItem["NAME"] = str_replace(":", '', $arItem["NAME"]) ?>
                                <?= $arItem["NAME"] ?>
                            </div>

                            <div class="products-settings__item-checkbox-list ">
                                <div class="item-checkbox-list ">
                                    <? if ($arItem["CODE"] == 'BRAND'): ?>
                                        <div class="bx-filter-input-container" role="search">
                                            <input type="text" value="" placeholder="Быстрый поиск">
                                        </div>
                                    <? endif; ?>
                                    <? foreach ($arItem["VALUES"] as $val => $ar): ?>
                                        <? $checked = $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                        <? $labelClass = $checked ? 'item-checkbox-list__item-checkbox_checked' : '' ?>
                                        <label for="<? echo $ar["CONTROL_ID"] ?>" class="item-checkbox-list__item-checkbox <?= $labelClass ?> <? echo $ar["DISABLED"] ? 'disabled' : '' ?>">

                                            <input
                                                    type="checkbox"
                                                    class="vsevset_field_item_checkbox"
                                                    value="<? echo $ar["HTML_VALUE"] ?>"
                                                    name="<? echo $ar["CONTROL_NAME"] ?>"
                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                <? echo $checked ?>
                                                    onclick="smartFilter.click(this)"
                                                    <? if ($ar["DISABLED"]): ?>disabled<? endif ?>
                                            />

                                            <div class="item-checkbox-list__item-checkbox-icon">
                                                <svg width="11" height="8" viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 4.2L3.73913 7L10 1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </div>

                                            <span class="item-checkbox-list__item-checkbox-text"><? echo $ar["VALUE"]; ?></span>

                                        </label>

                                    <? endforeach; ?>
                                </div>
                            </div>


                        </div>
                    <? endif; ?>
                <? endforeach; ?>
                <div style="clear: both;"></div>

            </div>

            <div class="products-settings__bottom">

                <input class="products-settings__apply-btn" type="submit" id="set_filter" name="set_filter" value="<?= GetMessage("CT_BCSF_SET_FILTER") ?>"/>

                <input class="products-settings__reset-btn" type="submit" id="del_filter" name="del_filter" value="<?= GetMessage("CT_BCSF_DEL_FILTER") ?>"/>

                <div style="display:none;">
                    <div class="bx_filter_popup_result left" id="modef" <? if (!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"'; ?> style="display: inline-block;">
                        <? echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">' . intval($arResult["ELEMENT_COUNT"]) . '</span>')); ?>
                        <span class="arrow"></span>
                        <span data-href="<? echo $arResult["FILTER_URL"] ?>" rel="nofollow"><? echo GetMessage("CT_BCSF_FILTER_SHOW") ?></span>
                    </div>
                </div>

            </div>

        </form>

        <div style="clear: both;"></div>

    </div>
</div>
<script>
    var smartFilter = new JCSmartFilter('<? echo CUtil::JSEscape($arResult["FORM_ACTION"]) ?>');
</script>
<script type="text/javascript">
    custom_scrollbar($('.custom_scrollbar'));

    function custom_scrollbar(elem) {
        var first = false;
        if (!$(elem).find('.custom_scrollbar_content').length) {
            $(elem).html('<div class="custom_scrollbar_content_over"><div class="custom_scrollbar_content">' + $(elem).html() + '</div></div><div class="custom_scrollbar_v"></div>');
            $(elem).before('<iframe name="auto_resize_frame" width=100% height=100% style="position:absolute;z-index:-1;left: 0;top:0; opacity: 0;"></iframe>');
            $(elem).find('.products-settings').append('<iframe name="auto_resize_frame_content" width=100% height=100% style="position:absolute;z-index:-1;left: 0;top:0; opacity: 0;"></iframe>');
            $(elem).find('.custom_scrollbar_content_over').attr({'scrollTop': $(elem).scrollTop()});
            $(elem).find('.custom_scrollbar_content_over').scrollTop($(elem).scrollTop());
            first = true;
        }
        if (first) {
            $(elem).bind('DOMSubtreeModified', function (e) {
                var element = e.target;
                if ($(element).parent().hasClass('custom_scrollbar_content') || $(element).hasClass('custom_scrollbar_content')) {
                    custom_scrollbar_resize(e);
                }
            });
            var content_over = $(elem).find('.custom_scrollbar_content_over');
            $(content_over).on('scroll', function (e) {
                var content_over = $(e.currentTarget).closest('.custom_scrollbar_content_over');
                var scrollbar_v = $(elem).find('.custom_scrollbar_v');
                var content = $(elem).find('.custom_scrollbar_content');
                var scrollTop = content_over.scrollTop();
                var percent = scrollTop / (($(content).height()) - $(content_over).height());
                var scrollTop_new = percent * ($(content_over).height() - $(scrollbar_v).height() - 10) + 5;
                scrollbar_v.stop().animate({'top': scrollTop_new + 'px'}, 0);
            });
            custom_scrollbar_resize();
        }
    }

    function custom_scrollbar_resize(e) {
        var elems = $('.custom_scrollbar');
        $(elems).each(async function (indx, elem) {
            var scrollbar_v = $(elem).find('.custom_scrollbar_v');
            var content_over = $(elem).find('.custom_scrollbar_content_over');
            var content = $(elem).find('.custom_scrollbar_content');
            var scrollTop = content_over.scrollTop();
            if (parseInt($(content_over).attr('scrollTop'))) {
                scrollTop = parseInt($(content_over).attr('scrollTop'));
                $(content_over).removeAttr('scrollTop');
            }
            // $(content_over).css({'height': '100%'});
            $(elem).css({'height': '100%'});
            $(content_over).css({'height': '100%'});
            /*await new Promise(res => setTimeout(res, 10000))
            console.info($(elem).height())
            $(content_over).height($(elem).height())*/
            content_over.scrollTop(scrollTop);
            var h = ($(content_over).height() / $(content).height()) * 100;
            if (h > 100)
                h = 100;

            if ($(content_over).height() == $(content).height() || h == 100) {
                $(content_over).removeAttr('scrolling')
            } else {
                $(content_over).attr({'scrolling': 'Y'})
            }
            scrollbar_v.height(h + '%').attr({'h': h});
            var percent = scrollTop / (($(content).height()) - $(content_over).height());
            var scrollTop_new = percent * ($(content_over).height() - $(scrollbar_v).height() - 10) + 5;
            scrollbar_v.stop().animate({'top': scrollTop_new + 'px'}, 0);
        })
    }


    $(function () {
        $(auto_resize_frame).on('resize', function (e) {
            scroll_filter();
            custom_scrollbar_resize(e)
        });
        $(auto_resize_frame_content).on('resize', function (e) {
            scroll_filter();
            custom_scrollbar_resize(e)
        });
    });
</script>
<? $this->EndViewTarget("right_area"); ?>
