<? if (!empty($settings->phones)): ?>
    <? // foreach ($settings->phones as $phone): ?>
    <? $phone = $settings->phones; ?>
    <? $link = str_replace([' ', '(', ')', '-'], "", $phone); ?>
    <div class="header__phone">
                      <span>
                        <a class="gtm-phone"
                           onclick="BX.onCustomEvent('target', [{type: 'click', element: this}]);"
                           href="tel:<?= $link ?>"><?= $phone ?></a>
                      </span>
    </div>
    <? // endforeach ?>
<? endif ?>
