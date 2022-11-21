<? if (count($arResult["PROPS"])): ?>
    <h2 class="tab-title"><?= GetMessage('ST_PRODUCT_DETAIL_NAV_PROPS') ?></h2>
    <div class="props">
        <? foreach ($arResult["PROPS"] as $arProp): ?>
            <div class="prop">
                <div class="prop-name"><?= $arProp['~NAME'] ?></div>
                <div class="prop-flex"></div>
                <div class="prop-value"><?= $arProp['DISPLAY_VALUE'] ?></div>
            </div>
        <? endforeach; ?>
    </div>
<? endif; ?>
<? if ($arParams['TYPE'] != 'properties') { ?>
    <br/>
    <div class="btn-autosize">
        <a href="<?= $arResult["DETAIL_PAGE_URL"] ?>properties/" class="btn btn-border">
            <?= GetMessage('CT_BCE_CATALOG_BTN_SHOW_ALL') ?>
            <svg width="11" height="15" viewBox="0 0 11 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.5 1.5L8.5 7.5L1.5 13.5" stroke="#3246FD" stroke-width="2.04511"/>
            </svg>
        </a>
    </div>
<? } ?>
