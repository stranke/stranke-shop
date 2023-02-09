<? global $USER; ?>
<? global $app ?>
<? $color_action_background = ''; ?>
<? $color_action_text = ''; ?>

<? if ($app->config->color_action_background) {
    $color_action_background = 'style="background:' . $app->config->color_action_background . '"';
} ?>
<? if ($app->config->color_action_text) {
    $color_action_text = 'style="color:' . $app->config->color_action_text . '"';
} ?>
<? if ($app->config->action_text_on == 'Y') { ?>
    <div class="product-card__price-reduction" onclick="cropper_open_action()">
        <a class="price-reduction js-openModalCheaper" <?= $color_action_background ?>>
            <div class="price-reduction__text" <?= $color_action_text ?>>
                <? if (!$app->config->action_text) { ?>
                    <?= GetMessage('ST_PRICE_REDUCTION') ?>
                <? } else { ?>
                    <?= $app->config->action_text ?>
                <? } ?>
            </div>
        </a>
    </div>
    <div class="lightbox" id="modal_action">
        <div class="lightbox_window_over">
            <div class="lightbox_window">
                <div class="lightbox_window_body">
                    <span class="lightbox_window_close " onclick="cropper_close_action(true)"></span>
                    <div class="lightbox_window_footer">
                        <div class="action_block">
                            <div class="action_title"><? if (!$app->config->action_text) { ?>
                                    <?= GetMessage('ST_PRICE_REDUCTION') ?>
                                <? } else { ?>
                                    <?= $app->config->action_text ?>
                                <? } ?></div>
                            <div class="action_comment">
                                <?= GetMessage('ZFSKS') ?>
                            </div>
                            <form class="request-call-form__content" onchange="<?= $app->config->YMONCHANGEFORMPRIZ ?>">


                            <div class="form_fields">
                                    <div class="request-call-form__input-elements-block">
                                        <div class="action_up_block">
                                            <!--
                        -->
                                            <div class="request-call-form__input-title">
                                                <?= GetMessage('NUMBER') ?>

                                                <input id="request-call-form-input-phone" name="PHONE" type="text"
                                                       placeholder="+7 (   ) -   -  ">

                                            </div>
                                            <div class="request-call-form__input-title">
                                                <?= GetMessage('NAME') ?>
                                                <input id="request-call-form-input-name" type="text" name="NAME">

                                            </div>
                                        </div>
                                        <div class="request-call-form__input-message">

                                            <div class="request-call-form__message">
                                                <?= GetMessage('COMMENT') ?>
                                                <textarea name="COMMENT" id="request-call-form-textarea" cols="30"
                                                          rows="7"></textarea>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="request-call-form__agreement">
                                        <? $APPLICATION->IncludeComponent(
                                            "bitrix:main.userconsent.request",
                                            "sogl_auth",
                                            array(
                                                "AUTO_SAVE" => "Y",
                                                "ID" => "1",
                                                "IS_CHECKED" => "Y",
                                                "IS_LOADED" => "N"
                                            )
                                        ); ?>


                                    </div>

                                    <div class="request-call-form__send-request_action" onclick="SendCallbackFormpr()">
                                        <?= GetMessage('SEND') ?>
                                    </div>

                                    <input type="hidden" name="FORM" value="action_tov_form">
                                    <input type="hidden" name="ITEM_NAME" value="<?= $arResult['NAME'] ?>">
                                    <input type="hidden" name="ITEM_ID" value="<?= $arResult['ID'] ?>">
                                </div>
                            </form>
                        </div>
                        <div class="action_block" style="display: none">
                            <div class="action_title"><?= GetMessage('ST_PRICE_REDUCTION') ?></div>
                            <div class="action_comment"><?= GetMessage('SZZF') ?>
                            </div>
                            <div class="request-call-form__send-request_action" style="margin: 0 auto"
                                 onclick="cropper_close_action(true)"><?= GetMessage('OK') ?>
                            </div>
                        </div>
                        <div style="clear: both; margin-bottom: 20px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<? } ?>
<div class="product__price" role="price">
    <? if (!empty($arOffer['MIN_PRICE']) && ($arOffer['MIN_PRICE']['DISCOUNT_DIFF'])): ?>
        <div role="price_old" class="product__price-old"><?= $arOffer['MIN_PRICE']['PRINT_VALUE'] ?></div>
    <? endif ?>
    <? if (!empty($arOffer['MIN_PRICE'])): ?>
        <div role="price_value" class="product__price-value"><?= $arOffer['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?></div>
    <? endif ?>
</div>





