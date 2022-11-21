<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $mobileColumns
 * @var array $arParams
 * @var string $templateFolder
 */

$usePriceInAdditionalColumn = in_array('PRICE', $arParams['COLUMNS_LIST']) && $arParams['PRICE_DISPLAY_MODE'] === 'Y';
$useSumColumn = in_array('SUM', $arParams['COLUMNS_LIST']);
$useActionColumn = in_array('DELETE', $arParams['COLUMNS_LIST']);

$restoreColSpan = 2 + $usePriceInAdditionalColumn + $useSumColumn + $useActionColumn;

$positionClassMap = array(
    'left' => 'basket-item-label-left',
    'center' => 'basket-item-label-center',
    'right' => 'basket-item-label-right',
    'bottom' => 'basket-item-label-bottom',
    'middle' => 'basket-item-label-middle',
    'top' => 'basket-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION'])) {
    foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos) {
        $discountPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
    }
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION'])) {
    foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos) {
        $labelPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
    }
}
?>
<script id="basket-item-template" type="text/html">
    <div class="basket-items-list-item-container{{#SHOW_RESTORE}} basket-items-list-item-container-expend{{/SHOW_RESTORE}}"
         id="basket-item-{{ID}}" data-entity="basket-item" data-id="{{ID}}">
        {{#SHOW_RESTORE}}
        <div class="basket-items-list-item-notification" colspan="<?= $restoreColSpan ?>">
            <div class="basket-items-list-item-notification-inner basket-items-list-item-notification-removed" id="basket-item-height-aligner-{{ID}}">
                {{#SHOW_LOADING}}
                <div class="basket-items-list-item-overlay"></div>
                {{/SHOW_LOADING}}
                <div class="basket-items-list-item-removed-container">
                    <div>
                        <?= Loc::getMessage('SBB_GOOD_CAP') ?>
                        <strong>{{NAME}}</strong> <?= Loc::getMessage('SBB_BASKET_ITEM_DELETED') ?>.
                    </div>
                    <div class="basket-items-list-item-removed-block">
                        <a href="javascript:void(0)" data-entity="basket-item-restore-button">
                            <?= Loc::getMessage('SBB_BASKET_ITEM_RESTORE') ?>
                        </a>
                        <span class="basket-items-list-item-clear-btn" data-entity="basket-item-close-restore-button"></span>
                    </div>
                </div>
            </div>
        </div>
        {{/SHOW_RESTORE}}
        {{^SHOW_RESTORE}}
        <div class="basket-items-list-item-descriptions">
            <div class="basket-items-list-item-descriptions-inner" id="basket-item-height-aligner-{{ID}}">
                <?
                if (in_array('PREVIEW_PICTURE', $arParams['COLUMNS_LIST']))
                {
                ?>
                <div class="basket-item-block-image<?= (!isset($mobileColumns['PREVIEW_PICTURE']) ? ' hidden-xs' : '') ?>">
                    {{#DETAIL_PAGE_URL}}
                    <a href="{{DETAIL_PAGE_URL}}" class="basket-item-image-link">
                        {{/DETAIL_PAGE_URL}}
                        <?
                        //                        print_r($arParams['COLUMNS_LIST']);
                        ?>
                        <canvas width="76" height="63"></canvas>
                        <img class="basket-item-image" alt="{{NAME}}"
                             src="{{{IMAGE_URL}}}{{^IMAGE_URL}}<?= $templateFolder ?>/images/no_photo.png{{/IMAGE_URL}}">
                        {{#SHOW_LABEL}}
                        <div class="basket-item-label-text basket-item-label-big <?= $labelPositionClass ?>">
                            {{#LABEL_VALUES}}
                            <div
                                    {{#HIDE_MOBILE}} class="hidden-xs" {{
                            /HIDE_MOBILE}}>
                            <span title="{{NAME}}">{{NAME}}</span>
                        </div>
                        {{/LABEL_VALUES}}
                </div>
                {{/SHOW_LABEL}}

                <?
                if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y') {
                    ?>
                    {{#DISCOUNT_PRICE_PERCENT}}
                    <div class="basket-item-label-ring basket-item-label-small <?= $discountPositionClass ?>">
                        -{{DISCOUNT_PRICE_PERCENT_FORMATED}}
                    </div>
                    {{/DISCOUNT_PRICE_PERCENT}}
                    <?
                }
                ?>

                {{#DETAIL_PAGE_URL}}
                </a>
                {{/DETAIL_PAGE_URL}}
            </div>
            <?
            }
            ?>
            <div class="basket-item-block-info">
                <div class="basket-item-info-data">
                    <h2 class="basket-item-info-name">
                        {{#DETAIL_PAGE_URL}}
                        <a href="{{DETAIL_PAGE_URL}}" class="basket-item-info-name-link">
                            {{/DETAIL_PAGE_URL}}

                            <span data-entity="basket-item-name">{{NAME}}</span>

                            {{#DETAIL_PAGE_URL}}
                        </a>
                        {{/DETAIL_PAGE_URL}}
                    </h2>
                    {{#NOT_AVAILABLE}}
                    <div class="basket-items-list-item-warning-container">
                        <div class="alert alert-warning text-center">
                            <?= Loc::getMessage('SBB_BASKET_ITEM_NOT_AVAILABLE') ?>.
                        </div>
                    </div>
                    {{/NOT_AVAILABLE}}
                    {{#DELAYED}}
                    <div class="basket-items-list-item-warning-container">
                        <div class="alert alert-warning text-center">
                            <?= Loc::getMessage('SBB_BASKET_ITEM_DELAYED') ?>.
                            <a href="javascript:void(0)" data-entity="basket-item-remove-delayed">
                                <?= Loc::getMessage('SBB_BASKET_ITEM_REMOVE_DELAYED') ?>
                            </a>
                        </div>
                    </div>
                    {{/DELAYED}}
                    {{#WARNINGS.length}}
                    <div class="basket-items-list-item-warning-container">
                        <div class="alert alert-warning alert-dismissable" data-entity="basket-item-warning-node">
                            <span class="close" data-entity="basket-item-warning-close">&times;</span>
                            {{#WARNINGS}}
                            <div data-entity="basket-item-warning-text">{{{.}}}</div>
                            {{/WARNINGS}}
                        </div>
                    </div>
                    {{/WARNINGS.length}}

                    <? if (!empty($arParams['PRODUCT_BLOCKS_ORDER'])) { ?>
                        <div class="basket-item-block-properties">


                            <? foreach ($arParams['PRODUCT_BLOCKS_ORDER'] as $blockName) {
                                switch (trim((string)$blockName)) {
                                    case 'props':
                                        if (in_array('PROPS', $arParams['COLUMNS_LIST'])) {
                                            ?>
                                            {{#PROPS}}
                                            <div class="basket-item-property<?= (!isset($mobileColumns['PROPS']) ? ' hidden-xs' : '') ?>">
                                                <div class="basket-item-property-name">
                                                    {{{NAME}}}
                                                </div>
                                                <div class="basket-item-property-value"
                                                     data-entity="basket-item-property-value" data-property-code="{{CODE}}">
                                                    {{{VALUE}}}
                                                </div>
                                            </div>
                                            {{/PROPS}}
                                            <?
                                        }

                                        break;
                                    case 'sku':
                                        ?>
                                        {{#SKU_BLOCK_LIST}}
                                        {{#IS_IMAGE}}
                                        <div class="basket-item-property basket-item-property-scu-image"
                                             data-entity="basket-item-sku-block">
                                            <div class="basket-item-property-name">{{NAME}}</div>
                                            <div class="basket-item-property-value">
                                                <ul class="basket-item-scu-list">
                                                    {{#SKU_VALUES_LIST}}
                                                    <li class="basket-item-scu-item{{#SELECTED}} selected{{/SELECTED}}
																		{{#NOT_AVAILABLE_OFFER}} not-available{{/NOT_AVAILABLE_OFFER}}"
                                                        title="{{NAME}}"
                                                        data-entity="basket-item-sku-field"
                                                        data-initial="{{#SELECTED}}true{{/SELECTED}}{{^SELECTED}}false{{/SELECTED}}"
                                                        data-value-id="{{VALUE_ID}}"
                                                        data-sku-name="{{NAME}}"
                                                        data-property="{{PROP_CODE}}">
																				<span class="basket-item-scu-item-inner"
                                                                                      style="background-image: url({{PICT}});"></span>
                                                    </li>
                                                    {{/SKU_VALUES_LIST}}
                                                </ul>
                                            </div>
                                        </div>
                                        {{/IS_IMAGE}}

                                        {{^IS_IMAGE}}
                                        <div class="basket-item-property basket-item-property-scu-text"
                                             data-entity="basket-item-sku-block">
                                            <div class="basket-item-property-name">{{NAME}}</div>
                                            <div class="basket-item-property-value">
                                                <ul class="basket-item-scu-list">
                                                    {{#SKU_VALUES_LIST}}
                                                    <li class="basket-item-scu-item{{#SELECTED}} selected{{/SELECTED}}
																		{{#NOT_AVAILABLE_OFFER}} not-available{{/NOT_AVAILABLE_OFFER}}"
                                                        title="{{NAME}}"
                                                        data-entity="basket-item-sku-field"
                                                        data-initial="{{#SELECTED}}true{{/SELECTED}}{{^SELECTED}}false{{/SELECTED}}"
                                                        data-value-id="{{VALUE_ID}}"
                                                        data-sku-name="{{NAME}}"
                                                        data-property="{{PROP_CODE}}">
                                                        <span class="basket-item-scu-item-inner">{{NAME}}</span>
                                                    </li>
                                                    {{/SKU_VALUES_LIST}}
                                                </ul>
                                            </div>
                                        </div>
                                        {{/IS_IMAGE}}
                                        {{/SKU_BLOCK_LIST}}

                                        {{#HAS_SIMILAR_ITEMS}}
                                        <div class="basket-items-list-item-double" data-entity="basket-item-sku-notification">
                                            <div class="alert alert-info alert-dismissable text-center">
                                                {{#USE_FILTER}}
                                                <a href="javascript:void(0)"
                                                   class="basket-items-list-item-double-anchor"
                                                   data-entity="basket-item-show-similar-link">
                                                    {{/USE_FILTER}}
                                                    <?= Loc::getMessage('SBB_BASKET_ITEM_SIMILAR_P1') ?>{{#USE_FILTER}}</a>{{/USE_FILTER}}
                                                <?= Loc::getMessage('SBB_BASKET_ITEM_SIMILAR_P2') ?>
                                                {{SIMILAR_ITEMS_QUANTITY}} {{MEASURE_TEXT}}
                                                <br>
                                                <a href="javascript:void(0)" class="basket-items-list-item-double-anchor"
                                                   data-entity="basket-item-merge-sku-link">
                                                    <?= Loc::getMessage('SBB_BASKET_ITEM_SIMILAR_P3') ?>
                                                    {{TOTAL_SIMILAR_ITEMS_QUANTITY}} {{MEASURE_TEXT}}?
                                                </a>
                                            </div>
                                        </div>
                                        {{/HAS_SIMILAR_ITEMS}}
                                        <?
                                        break;
                                    case 'columns':
                                        ?>
                                        {{#COLUMN_LIST}}
                                        {{#IS_IMAGE}}
                                        <div class="basket-item-property-custom basket-item-property-custom-photo
														{{#HIDE_MOBILE}}hidden-xs{{/HIDE_MOBILE}}"
                                             data-entity="basket-item-property">
                                            <div class="basket-item-property-custom-name">{{NAME}}</div>
                                            <div class="basket-item-property-custom-value">
                                                {{#VALUE}}
                                                <span>
																	<img class="basket-item-custom-block-photo-item"
                                                                         src="{{{IMAGE_SRC}}}" data-image-index="{{INDEX}}"
                                                                         data-column-property-code="{{CODE}}">
																</span>
                                                {{/VALUE}}
                                            </div>
                                        </div>
                                        {{/IS_IMAGE}}

                                        {{#IS_TEXT}}
                                        <div class="basket-item-property-custom basket-item-property-custom-text
														{{#HIDE_MOBILE}}hidden-xs{{/HIDE_MOBILE}}"
                                             data-entity="basket-item-property">
                                            <div class="basket-item-property-custom-name">{{NAME}}</div>
                                            <div class="basket-item-property-custom-value"
                                                 data-column-property-code="{{CODE}}"
                                                 data-entity="basket-item-property-column-value">
                                                {{VALUE}}
                                            </div>
                                        </div>
                                        {{/IS_TEXT}}

                                        {{#IS_HTML}}
                                        <div class="basket-item-property-custom basket-item-property-custom-text
														{{#HIDE_MOBILE}}hidden-xs{{/HIDE_MOBILE}}"
                                             data-entity="basket-item-property">
                                            <div class="basket-item-property-custom-name">{{NAME}}</div>
                                            <div class="basket-item-property-custom-value"
                                                 data-column-property-code="{{CODE}}"
                                                 data-entity="basket-item-property-column-value">
                                                {{{VALUE}}}
                                            </div>
                                        </div>
                                        {{/IS_HTML}}

                                        {{#IS_LINK}}
                                        <div class="basket-item-property-custom basket-item-property-custom-text
														{{#HIDE_MOBILE}}hidden-xs{{/HIDE_MOBILE}}"
                                             data-entity="basket-item-property">
                                            <div class="basket-item-property-custom-name">{{NAME}}</div>
                                            <div class="basket-item-property-custom-value"
                                                 data-column-property-code="{{CODE}}"
                                                 data-entity="basket-item-property-column-value">
                                                {{#VALUE}}
                                                {{{LINK}}}{{^IS_LAST}}<br>{{/IS_LAST}}
                                                {{/VALUE}}
                                            </div>
                                        </div>
                                        {{/IS_LINK}}
                                        {{/COLUMN_LIST}}
                                        <?
                                        break;
                                }
                            } ?>
                        </div>
                    <? } ?>
                </div>
                <div class="basket-item-info-amount-price">
                    <div class="basket-item-block-amount{{#NOT_AVAILABLE}} disabled{{/NOT_AVAILABLE}}"
                         data-entity="basket-item-quantity-block">
                        <span class="basket-item-amount-btn-minus" data-entity="basket-item-quantity-minus"></span>
                        <div class="basket-item-amount-filed-block">
                            <input type="text" class="basket-item-amount-filed" value="{{QUANTITY}}"
                                   {{#NOT_AVAILABLE}} disabled="disabled" {{/NOT_AVAILABLE}}
                            data-value="{{QUANTITY}}" data-entity="basket-item-quantity-field"
                            id="basket-item-quantity-{{ID}}">
                        </div>
                        <span class="basket-item-amount-btn-plus" data-entity="basket-item-quantity-plus"></span>
                        <div class="basket-item-amount-field-description">
                            <?
                            if ($arParams['PRICE_DISPLAY_MODE'] === 'Y') {
                                ?>
                                {{MEASURE_TEXT}}
                                <?
                            } else {
                                ?>
                                {{#SHOW_PRICE_FOR}}
                                {{MEASURE_RATIO}} {{MEASURE_TEXT}} =
                                <span id="basket-item-price-{{ID}}">{{{PRICE_FORMATED}}}</span>
                                {{/SHOW_PRICE_FOR}}
                                {{^SHOW_PRICE_FOR}}
                                {{MEASURE_TEXT}}
                                {{/SHOW_PRICE_FOR}}
                                <?
                            }
                            ?>
                        </div>
                        {{#SHOW_LOADING}}
                        <div class="basket-items-list-item-overlay"></div>
                        {{/SHOW_LOADING}}
                    </div>

                    <? if ($usePriceInAdditionalColumn): ?>
                        <div class="basket-item-block-price<?= (!isset($mobileColumns['PRICE']) ? ' hidden-xs' : '') ?>">
                            {{#SHOW_DISCOUNT_PRICE}}
                            <div class="basket-item-price-old">
                                                <span class="basket-item-price-old-text">
                                                    {{{FULL_PRICE_FORMATED}}}
                                                </span>
                            </div>
                            {{/SHOW_DISCOUNT_PRICE}}

                            <div class="basket-item-price-current">
                                            <span class="basket-item-price-current-text" id="basket-item-price-{{ID}}">
                                                {{{PRICE_FORMATED}}}
                                            </span>
                            </div>

                            <div class="basket-item-price-title">
                                <?= Loc::getMessage('SBB_BASKET_ITEM_PRICE_FOR') ?> {{MEASURE_RATIO}} {{MEASURE_TEXT}}
                            </div>
                            {{#SHOW_LOADING}}
                            <div class="basket-items-list-item-overlay"></div>
                            {{/SHOW_LOADING}}
                        </div>
                    <? endif ?>

                    <? if ($useSumColumn): ?>
                        <div class="basket-item-block-price<?= (!isset($mobileColumns['SUM']) ? ' hidden-xs' : '') ?>">
                            {{#SHOW_DISCOUNT_PRICE}}
                            <div class="basket-item-price-old">
                                            <span class="basket-item-price-old-text" id="basket-item-sum-price-old-{{ID}}">
                                                {{{SUM_FULL_PRICE_FORMATED}}}
                                            </span>
                            </div>
                            {{/SHOW_DISCOUNT_PRICE}}

                            <div class="basket-item-price-current">
                                        <span class="basket-item-price-current-text" id="basket-item-sum-price-{{ID}}">
                                            {{{SUM_PRICE_FORMATED}}}
                                        </span>
                            </div>

                            {{#SHOW_DISCOUNT_PRICE}}
                            <div class="basket-item-price-difference">
                                <?= Loc::getMessage('SBB_BASKET_ITEM_ECONOMY') ?>
                                <span id="basket-item-sum-price-difference-{{ID}}" style="white-space: nowrap;">
                                                {{{SUM_DISCOUNT_PRICE_FORMATED}}}
                                            </span>
                            </div>
                            {{/SHOW_DISCOUNT_PRICE}}
                            {{#SHOW_LOADING}}
                            <div class="basket-items-list-item-overlay"></div>
                            {{/SHOW_LOADING}}
                        </div>
                    <? endif ?>
                </div>
            </div>

            {{#SHOW_LOADING}}
            <div class="basket-items-list-item-overlay"></div>
            {{/SHOW_LOADING}}

            <? if ($useActionColumn): ?>
                <td class="basket-items-list-item-remove hidden-xs">
                    <div class="basket-item-block-actions">
                        <span class="basket-item-actions-remove" data-entity="basket-item-delete">
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.4252 20H3.19691C2.65675 19.9987 2.13908 19.7835 1.75713 19.4016C1.37517 19.0196 1.16001 18.5019 1.15869 17.9618V3.58757C1.15869 3.38932 1.23745 3.19919 1.37763 3.059C1.51782 2.91881 1.70795 2.84006 1.90621 2.84006H13.7169C13.9152 2.84006 14.1053 2.91881 14.2455 3.059C14.3857 3.19919 14.4644 3.38932 14.4644 3.58757V17.9618C14.4631 18.5021 14.2478 19.0199 13.8657 19.4019C13.4835 19.7839 12.9656 19.9989 12.4252 20ZM2.65372 4.33509V17.9618C2.65385 18.1058 2.71112 18.2439 2.81296 18.3457C2.9148 18.4476 3.05289 18.5048 3.19691 18.505H12.4252C12.5693 18.505 12.7076 18.4478 12.8095 18.3459C12.9114 18.244 12.9688 18.1059 12.9689 17.9618V4.33509H2.65372Z" fill="#757575"/>
                                <path d="M10.9505 4.33509H4.67134C4.47309 4.33509 4.28296 4.25633 4.14277 4.11614C4.00258 3.97596 3.92383 3.78582 3.92383 3.58757V2.22909C3.92462 1.63805 4.15979 1.07146 4.57776 0.653583C4.99573 0.235705 5.56238 0.000659255 6.15341 0H9.46839C10.0594 0.000659255 10.6261 0.235705 11.044 0.653583C11.462 1.07146 11.6972 1.63805 11.698 2.22909V3.58757C11.698 3.78582 11.6192 3.97596 11.479 4.11614C11.3389 4.25633 11.1487 4.33509 10.9505 4.33509ZM5.41886 2.84006H10.203V2.22909C10.2027 2.0344 10.1252 1.84777 9.98748 1.71015C9.84977 1.57253 9.66308 1.49516 9.46839 1.49503H6.15341C5.95881 1.49529 5.77225 1.57272 5.63465 1.71032C5.49704 1.84793 5.41962 2.03448 5.41936 2.22909L5.41886 2.84006Z" fill="#757575"/>
                                <path d="M7.81099 17.1385C7.61274 17.1385 7.4226 17.0598 7.28242 16.9196C7.14223 16.7794 7.06348 16.5893 7.06348 16.391V6.44956C7.06348 6.2513 7.14223 6.06117 7.28242 5.92098C7.4226 5.7808 7.61274 5.70204 7.81099 5.70204C8.00924 5.70204 8.19938 5.7808 8.33956 5.92098C8.47975 6.06117 8.55851 6.2513 8.55851 6.44956V16.391C8.55851 16.5893 8.47975 16.7794 8.33956 16.9196C8.19938 17.0598 8.00924 17.1385 7.81099 17.1385Z" fill="#757575"/>
                                <path d="M5.11177 17.1385C4.91352 17.1385 4.72339 17.0598 4.5832 16.9196C4.44301 16.7794 4.36426 16.5893 4.36426 16.391V6.44956C4.36426 6.2513 4.44301 6.06117 4.5832 5.92098C4.72339 5.7808 4.91352 5.70204 5.11177 5.70204C5.31003 5.70204 5.50016 5.7808 5.64035 5.92098C5.78053 6.06117 5.85929 6.2513 5.85929 6.44956V16.391C5.85929 16.5893 5.78053 16.7794 5.64035 16.9196C5.50016 17.0598 5.31003 17.1385 5.11177 17.1385Z" fill="#757575"/>
                                <path d="M10.5107 17.1385C10.3124 17.1385 10.1223 17.0598 9.98213 16.9196C9.84194 16.7794 9.76318 16.5893 9.76318 16.391V6.44956C9.76318 6.2513 9.84194 6.06117 9.98213 5.92098C10.1223 5.7808 10.3124 5.70204 10.5107 5.70204C10.709 5.70204 10.8991 5.7808 11.0393 5.92098C11.1795 6.06117 11.2582 6.2513 11.2582 6.44956V16.391C11.2582 16.5893 11.1795 16.7794 11.0393 16.9196C10.8991 17.0598 10.709 17.1385 10.5107 17.1385Z" fill="#757575"/>
                                <path d="M14.875 4.33509H0.747514C0.549261 4.33509 0.359128 4.25633 0.218942 4.11614C0.078756 3.97596 0 3.78583 0 3.58757C0 3.38932 0.078756 3.19919 0.218942 3.059C0.359128 2.91881 0.549261 2.84006 0.747514 2.84006H14.875C15.0733 2.84006 15.2634 2.91881 15.4036 3.059C15.5438 3.19919 15.6226 3.38932 15.6226 3.58757C15.6226 3.78583 15.5438 3.97596 15.4036 4.11614C15.2634 4.25633 15.0733 4.33509 14.875 4.33509Z" fill="#757575"/>
                            </svg>
                        </span>
                        {{#SHOW_LOADING}}
                        <div class="basket-items-list-item-overlay"></div>
                        {{/SHOW_LOADING}}
                    </div>
                </td>
            <? endif ?>
        </div>
    </div>
    {{/SHOW_RESTORE}}
    </div>
</script>
