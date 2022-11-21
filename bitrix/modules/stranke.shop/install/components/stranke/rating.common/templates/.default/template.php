<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogProductsViewedComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

$title = $arParams['TITLE'] ? $arParams['TITLE'] : GetMessage('ST_RC_TITLE');
$className = 'rating-common';
if (empty($arResult['VALUE'])) {
    $className .= ' rating-common_empty';
}
?>
<div class="<?=$className?>" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
    <div class="rating-common__title"><?=$title?></div>

    <?if (empty($arResult['COUNT'])):?>
        <div class="rating-common__value rating-common__value_empty" itemprop="ratingValue">
            <?=GetMessage('ST_RC_VALUE_EMPTY')?>
        </div>
    <?else:?>
        <div class="rating-common__value" itemprop="ratingValue">
            <?=$arResult['VALUE']?>
        </div>
    <?endif?>

    <div class="rating-common__count-reviews">
        <?if (empty($arResult['COUNT'])):?>
            <?=GetMessage('ST_RC_COUNT_EMPTY')?>
        <?else:?>
            <span itemprop="reviewCount"><?=$arResult['COUNT']?></span> <?=$arResult['COUNT_TEXT']?>
        <?endif?>
    </div>

    <?if (!empty($arResult['LINK'])):?>
        <a class="rating-common__link" href="<?=$arResult['LINK']?>"><?=GetMessage('ST_RC_SEE_ALL')?></a>
    <?endif?>
</div>