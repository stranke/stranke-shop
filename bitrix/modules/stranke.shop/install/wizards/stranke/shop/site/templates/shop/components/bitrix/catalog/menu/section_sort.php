<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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


$file = __FILE__;
$file = str_replace('section_sort.php', 'section.php', $file);
$templateFolder_ = str_replace('/section.php', '', $file);;
IncludeTemplateLangFile($templateFolder_ . '/lang/ru/section.php');

$this->addExternalCss($templateFolder_ . '/css/catalog-section.css');
?>
<?
$countParam = $arParams["PAGE_ELEMENT_COUNT"];
/** start COUNT */
if (!empty($_COOKIE['count'])) {
    $countParam = (int)$_COOKIE['count'];
}

if (!empty($_REQUEST['count'])) {
    $countParam = (int)$_REQUEST['count'];
}

if ($countParam > 0) {
    $arParams["PAGE_ELEMENT_COUNT"] = $countParam;
}
/** end COUNT */

/** start SORT */
if (!empty($_COOKIE['sort'])) {
    $sortParam = $_COOKIE['sort'];
}

if (!empty($_REQUEST["sort"])) {
    $sortParam = $_REQUEST["sort"];
}

//$sortParam = $sortParam ? $sortParam : 'popular>';
$sortParam = $sortParam ? $sortParam : 'price<';

if (!empty($sortParam)) {
    $sort = $sortParam;
    $name = substr($sort, 0, strlen($sort) - 1);
    $method = substr($sort, -1);

    switch ($name) {
        case "price":
//                $arParams["ELEMENT_SORT_FIELD"] = "property_SORTING_PRICE";
            $arParams["ELEMENT_SORT_FIELD"] = "CATALOG_PRICE_1";
            break;
        case "name":
            $arParams["ELEMENT_SORT_FIELD"] = "name";
            break;
        case "popular":
            $arParams["ELEMENT_SORT_FIELD"] = "shows";
            break;
    }

    switch ($method) {
        case "<":
            $arParams["ELEMENT_SORT_ORDER"] = "asc";
            break;
        case ">":
            $arParams["ELEMENT_SORT_ORDER"] = "desc";
            break;
    }
}
/** end SORT */

?>
<div class="subsection-page__products-sort-panel">
    <? $arProductSort = array(
        'price<' => GetMessage("CATALOG_SORT_VARIANT_2"),
        'price>' => GetMessage("CATALOG_SORT_VARIANT_3"),
        "popular>" => GetMessage("CATALOG_SORT_VARIANT_1"),
        'name<' => GetMessage("CATALOG_SORT_VARIANT_4"),
    ); ?>
    <div class="subsection-page__products-sort">
        <? foreach ($arProductSort as $key => $value) { ?>
            <a name="product-sort" data-view="<?= $key ?>" <?= $key == $sortParam ? 'selected' : '' ?>><?= $value ?></option>
            </a>
        <? } ?>
    </div>
    <div class="subsection-page__view-mode-panel show_desktop">
        <? $arProductCount = array(
            "24" => '24',
            '48' => '48',
            '96' => '96',
            '9999' => GetMessage("CATALOG_PAGE_COUNT_VARIANT_ALL"),
        ) ?>
        <label class="subsection-page__product-number-on-page custom_select with_kwazi_select">
                            <span>
                                <?= GetMessage("CATALOG_PAGE_COUNT") ?>
                            </span>
            <select name="product-number-on-page" id="product-number-on-page">
                <? foreach ($arProductCount as $key => $value) { ?>
                    <option value="<?= $key ?>" <?= intval($key) === intval($countParam) ? 'selected' : '' ?>><?= $value ?></option>
                <? } ?>
            </select>
            <kwazi_select name="product-number-on-page" no_select="Y">
                <items_title>
                    <val>
                        <? foreach ($arProductCount as $key => $value) { ?>
                            <? if (intval($key) === intval($countParam)): ?>
                                <input type="radio" name="product-number-on-page" value="<? echo $key ?>">
                                <label>
                                    <? echo $value ?>
                                </label>
                            <? endif; ?>
                        <? } ?>
                    </val>
                </items_title>
                <items>
                    <? foreach ($arProductCount as $key => $value): ?>
                        <kwazi_option value="<? echo $key ?>"<? echo intval($key) === intval($countParam) ? ' selected' : '' ?>>
                            <input type="radio" name="product-number-on-page" value="<? echo $key ?>" id="product-number-on-page_<? echo intval($key) ?>">
                            <label for="product-number-on-page_<? echo intval($key) ?>">
                                <? echo $value ?>
                            </label>
                        </kwazi_option>
                    <? endforeach ?>
                </items>
            </kwazi_select>
            <svg width="10" height="7" viewBox="0 0 10 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.83267 -1.54435e-06L5 3.83267L1.16591 -2.03855e-07L2.03855e-07 1.16591L5 6.16591L10 1.16591L8.83267 -1.54435e-06Z" fill="#5E5E5E"/>
            </svg>
        </label>

        <?
        /*$arViewMode = array("simple", "tile", "table");
        $classViewModeBtnActive = "";
        ?>

        <div class="subsection-page__view-mode">
            <? foreach ($arViewMode as $mode) { ?>
                <?
                if ($mode == $VIEW_THEME) {
                    $classViewModeBtnActive = "active";
                } else {
                    $classViewModeBtnActive = "";
                }
                ?>
                <div class="view-mode-btn <?= $mode ?> js-view-mode-btn <?= $classViewModeBtnActive ?>" data-view="<?= $mode ?>"></div>
            <? } ?>
        </div>
        <? */ ?>

    </div>
</div>
