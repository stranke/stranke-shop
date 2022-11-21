<div class="product__bottom-block">

  <div class="product__description">

    <? if ($arProp['INGREDIENTS']['VALUE'] !== '') { ?>
      <div class="product__description-consist">
        <h2 class="product__subtitle h2"><?=$arProp['INGREDIENTS']['NAME']?></h2>
        <span><?=$arProp['INGREDIENTS']['VALUE']?></span>
      </div>
    <? } ?>
  </div>

</div>
