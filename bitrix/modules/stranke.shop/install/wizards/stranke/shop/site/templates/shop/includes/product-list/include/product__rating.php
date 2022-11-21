<?
function formatVoteCount($value)
{
    $count = $value % 100;

    if ($count >= 5 && $count <= 20) {
        $str = GetMessage('ST_PRODUCT_DETAIL_MARK_VOTE_COUNT_5');
    } else {
        $count = $count % 10;
        if ($count === 1) {
            $str = GetMessage('ST_PRODUCT_DETAIL_MARK_VOTE_COUNT_1');
        } else if ($count >= 2 && $count <= 4) {
            $str = GetMessage('ST_PRODUCT_DETAIL_MARK_VOTE_COUNT_2');
        } else {
            $str = GetMessage('ST_PRODUCT_DETAIL_MARK_VOTE_COUNT_5');
        }
    }

    return $str;
}

$arResult['PROPERTIES']['rating']['VALUE'] = $arResult['PROPERTIES']['rating']['VALUE'] ? $arResult['PROPERTIES']['rating']['VALUE'] : 0;
$value = number_format($arResult['PROPERTIES']['rating']['VALUE'], 1);
$count = (int)$arResult['PROPERTIES']['REVIEWS_COUNT']['VALUE'];
$countTxt = formatVoteCount($count);
?>
<div class="product__rating">
    <div style="display: none" itemprop="aggregateRating" itemscope
         itemtype="http://schema.org/AggregateRating">
        <meta itemprop="ratingValue" content="<?= $value ?>"/>
        <meta itemprop="reviewCount"
              content="<?= $count ?>"/>
        <meta itemprop="bestRating" content="5"/>
        <meta itemprop="worstRating" content="1"/>
        <meta itemprop="itemReviewed" content="<?= $arResult['NAME'] ?>">
    </div>
    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 5.88272L5.81372 5.5005L8.00319 0L10.1927 5.5005L16 5.88272L11.5458 9.66478L13.0074 15.4019L8.00319 12.2388L2.99891 15.4019L4.46053 9.66478L0 5.88272Z" fill="#FFC700"/>
    </svg>
    <span class="product__rating-value"><?= $value ?></span> /
    <span class="product__rating-text"><?= $count ?> <?= $countTxt ?></span>
</div>
