<? if ($APPLICATION->GetCurPage(false) === "/"): ?>
    <div class="header__logo">
        <img src="<?= $app->config->logo ?>" alt="logo">
    </div>
<? else: ?>
    <a href="<?= SITE_DIR ?>" class="header__logo">
        <img src="<?= $app->config->logo ?>" alt="logo">
    </a>
<? endif ?>
