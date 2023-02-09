<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
use Bitrix\Main\Web\Json;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);


$name = $arResult['NAME'];
$description = $arResult['NAME'];

$arOffers = $arResult['OFFERS'];
//
//function cmp($a, $b)
//{
//    return strcmp($a["SORT"], $b["SORT"]);
//}
//
//usort($arOffers, "cmp");

$arProp = $arResult['PROPERTIES'];

$GLOBALS['PRODUCT_PROP'] = $arProp;
$GLOBALS['PRODUCT_PROP']['INGREDIENTS'] = $arResult['PREVIEW_TEXT'];
$GLOBALS['PRODUCT_PROP']['DESCRIPTION'] = $arResult['DETAIL_TEXT'];

$arPhotoElementsID = $arProp['dop_photo']['VALUE'];

$imgAlt = '';
if (!empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])) {
    $imgAlt = $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'];
}

$imgTitle = '';
if (!empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])) {
    $imgTitle = $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'];
}

$backLink = $arResult['SECTION']['SECTION_PAGE_URL'];
$youTubeCode = $arResult['PROPERTIES']['YOUTUBE_CODE']['VALUE'];
?>
<?
$this->AddEditAction($arResult['ID'], $arResult['EDIT_LINK'], CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "ELEMENT_EDIT"));
$this->AddDeleteAction($arResult['ID'], $arResult['DELETE_LINK'], CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
?>

<div class="wrapper catalog-element">
    <div class="products__product" itemscope itemtype="http://schema.org/Product">

        <div class="product" id="<?= $this->GetEditAreaId($arResult['ID']) ?>">
            <meta itemprop="description" content="<?= $arResult['IPROPERTY_VALUES']['ELEMENT_META_DESCRIPTION'] ?>">

            <div class="product__top">
                <div class="product__photos">
                    <? require 'product_photo.php' ?>
                    <? if (strlen($youTubeCode)) { ?>
                        <!--                <a class="video_button" href="--><? //=$arResult["DETAIL_PAGE_URL"]?><!--#video_r" target="_blank" rel="nofollow"><img src="--><? //= $templateFolder?><!--/images/youtube.svg"><span>  --><? //=GetMessage('ST_PRODUCT_DETAIL_SHOW_VIDEO')?><!--</span></a>-->
                        <a class="video_button" href="<?= $arResult["DETAIL_PAGE_URL"] ?>#video_r" rel="nofollow"><img src="<?= $templateFolder ?>/images/youtube.svg"><span>  <?= GetMessage('ST_PRODUCT_DETAIL_SHOW_VIDEO') ?></span></a>
                    <? } ?>

                    <script>
                        window.images = <?=\Bitrix\Main\Web\Json::encode($images)?>;
                    </script>
                </div>
                <? include 'include/product__info.php' ?>
            </div>
            <div class="product__nav-bar-wrapper">
                <div class="product__nav-bar">
                    <a href="<?= $arResult["DETAIL_PAGE_URL"] ?>"
                       class="product__nav-bar-element <? if ($arParams['TYPE'] == 'description') { ?> product__nav-bar-element_active<? } ?>"
                       onclick="return open_tovar_tabs(this);"
                    >
                        <?= GetMessage('ST_PRODUCT_DETAIL_NAV_DESCRIPTION') ?>
                    </a>
                    <? if (count($arResult["PROPS"])) { ?>
                        <a href="<?= $arResult["DETAIL_PAGE_URL"] ?>properties/"
                           class="video_link product__nav-bar-element <? if ($arParams['TYPE'] == 'properties') { ?> product__nav-bar-element_active<? } ?>"
                           onclick="return open_tovar_tabs(this);">
                            <?= GetMessage('ST_PRODUCT_DETAIL_NAV_PROPS') ?>
                        </a>
                    <? } ?>
                    <? if (strlen($youTubeCode)) { ?>
                        <a href="<?= $arResult["DETAIL_PAGE_URL"] ?>video/#video_r"
                           class="video_link product__nav-bar-element <? if ($arParams['TYPE'] == 'video') { ?> product__nav-bar-element_active<? } ?>"
                           onclick="return open_tovar_tabs(this);">
                            <?= GetMessage('ST_PRODUCT_DETAIL_NAV_VIDEO') ?>
                        </a>
                    <? } ?>
                    <? /* if (is_array($arPhotoElementsID)) { ?>
                        <a href="<?= $arResult["DETAIL_PAGE_URL"] ?>photo/"
                           class="product__nav-bar-element <? if ($arParams['TYPE'] == 'photo') { ?> product__nav-bar-element_active<? } ?>"
                           onclick="return open_tovar_tabs(this);">
                            <?= GetMessage('ST_PRODUCT_DETAIL_NAV_PHOTOS') ?>
                        </a>
                    <? }*/ ?>
                    <? if (0) { ?>
                        <a href="<?= $arResult["DETAIL_PAGE_URL"] ?>reviews/"
                           class="product__nav-bar-element <? if ($arParams['TYPE'] == 'reviews') { ?> product__nav-bar-element_active<? } ?>"
                           onclick="return open_tovar_tabs(this);">
                            <?= GetMessage('ST_PRODUCT_DETAIL_NAV_REVIEWS') ?>
                        </a>
                    <? } ?>

                    <? /*if (!empty($arResult['related_elements'])) { ?>
                        <a href="<?= $arResult["DETAIL_PAGE_URL"] ?>related-products/"
                           class="product__nav-bar-element <? if ($arParams['TYPE'] == 'related-products') { ?> product__nav-bar-element_active<? } ?>"
                           onclick="return open_tovar_tabs(this);">
                            <?= GetMessage('ST_PRODUCT_DETAIL_NAV_RELATED') ?>
                        </a>
                    <? } */ ?>
                </div>

            </div>

            <script>
                $('.video_button').on('click', function (event) {
                    // event.preventDefault();
                    // $('.video_link').click()
                    // let iframe = window.document.getElementById('frame');
                    // iframe.src += '&autoplay=1'
                    // if (!window.document.fullscreenElement) {
                    //     iframe.requestFullscreen().catch(err => {
                    //         alert('���-�� ����� �� ���');
                    //     });
                    // } else {
                    //     document.exitFullscreen();
                    // }
                });
            </script>
            <script>
                    BX.message({
                    ST_ADD_TO_BASKET: '<?=GetMessage('ST_ADD_TO_BASKET')?>',
                    CT_BCE_CATALOG_SELECT_OFFER: '<?=GetMessage('CT_BCE_CATALOG_SELECT_OFFER')?>',
                    CT_BCE_CATALOG_NO_AVAILABLE: '<?=GetMessage('CT_BCE_CATALOG_NO_AVAILABLE')?>',
                    CT_BCE_CATALOG_NOT_AVAILABLE: '<?=GetMessage('CT_BCE_CATALOG_NOT_AVAILABLE')?>',
                    CT_BCE_CATALOG_COUNT_AVAILABLE: '<?=GetMessage('CT_BCE_CATALOG_COUNT_AVAILABLE')?>',
                    CT_BCE_CATALOG_COUNT_IZM: '<?=GetMessage('CT_BCE_CATALOG_COUNT_IZM')?>',
                    CT_BCE_CATALOG_ADD: '<?=GetMessage('CT_BCE_CATALOG_ADD')?>',
                    CT_BCE_CATALOG_ADDED: '<?=GetMessage('CT_BCE_CATALOG_ADDED')?>',


                });
            </script>
            <?
            $arOffers_json = array();
            $no_key = array('DISPLAY_PROPERTIES');
            foreach ($arOffers as $i => $arOffer) {
                foreach ($arOffer as $key => $val) {
                    if (in_array($key, $no_key) || (strpos($key, 'ITEM_') === 0 && is_array($val))) {
                        continue;
                    }
//        if (!empty($val) && $val !== false)
                    $arOffers_json[$i][$key] = $val;
                }
            } ?>

            <script>
                init_product_offers(<?= $arResult['ID'] ?>, JSON.parse('<?= json_encode($arOffers_json)?>'))
                var productDetail = new ProductDetail('.product',<?= $arResult['OFFER_ID'] ? $arResult['OFFER_ID'] : $arResult['ID'] ?>);
            </script>
        </div>


        <? /*<!-- Root element of PhotoSwipe. Must have class pswp. -->
        <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

            <!-- Background of PhotoSwipe.
                 It's a separate element as animating opacity is faster than rgba(). -->
            <div class="pswp__bg"></div>

            <!-- Slides wrapper with overflow:hidden. -->
            <div class="pswp__scroll-wrap">

                <!-- Container that holds slides.
                    PhotoSwipe keeps only 3 of them in the DOM to save memory.
                    Don't modify these 3 pswp__item elements, data is added later on. -->
                <div class="pswp__container">
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                </div>

                <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                <div class="pswp__ui pswp__ui--hidden">

                    <div class="pswp__top-bar">

                        <!--  Controls are self-explanatory. Order can be changed. -->

                        <div class="pswp__counter"></div>

                        <button class="pswp__button pswp__button--share" title="Share"></button>

                        <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                        <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                        <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                        <!-- element will get class pswp__preloader--active when preloader is running -->
                        <div class="pswp__preloader">
                            <div class="pswp__preloader__icn">
                                <div class="pswp__preloader__cut">
                                    <div class="pswp__preloader__donut">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                        <div class="pswp__share-tooltip"></div>
                    </div>

                    <button class="pswp__button pswp__button--close" title="Close (Esc)">
                    </button>

                    <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                    </button>

                    <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                    </button>

                    <div class="pswp__caption">
                        <div class="pswp__caption__center"></div>
                    </div>

                </div>

            </div>

        </div>*/ ?>
        <? require 'tabs/init.php' ?>
    </div>
</div>
