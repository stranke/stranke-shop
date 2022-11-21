<?$alertBanner = $GLOBALS['OPTIONS']['ALERT_BANNER'];?>
<? if ($alertBanner['ACTIVITY'] == 'Y' && !empty($alertBanner['TEXT'])) { ?>
    <? if (empty($_COOKIE['ALERT_BANNER_IS_CLOSED'])) {?>
        <div class="alert-banner" id="alertBanner">
            <div class="alert-banner__content">
                <div class="alert-banner__text"
                    <?if (!empty($alertBanner['TEXT_COLOR'])):?>
                        style="color: <?=$alertBanner['TEXT_COLOR']?>"
                    <?endif?>
                >
                    <?=$alertBanner['TEXT']['TEXT']?>
                </div>

                <div class="alert-banner__close-btn" onclick="closeAlertBanner()">
                    <div class="alert-banner__close-btn__1"
                        <? if (!empty($alertBanner['TEXT_COLOR'])) {?>
                            style="background-color: <?=$GLOBALS['OPTIONS']['ALERT_BANNER']['TEXT_COLOR']?>"
                        <?} ?>
                    ></div>

                    <div class="alert-banner__close-btn__2"
                        <? if (!empty($alertBanner['TEXT_COLOR'])) {?>
                            style="background-color: <?=$alertBanner['TEXT_COLOR']?>"
                        <?} ?>
                    ></div>
                </div>
            </div>
        </div>

        <script>
            function closeAlertBanner() {
              console.log('closeAlertBanner');
              BX('alertBanner').classList.add('alert-banner_closed');
              BX.setCookie('ALERT_BANNER_IS_CLOSED', true, {
                path: '/',
                expires: 86400,
              });
            }
        </script>
    <? } ?>
<? } ?>