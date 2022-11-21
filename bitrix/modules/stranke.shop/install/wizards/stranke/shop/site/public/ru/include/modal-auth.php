<div class="banner-on-main">
    <div class="banner-on-main__container">
        <div class="banner-on-main__row">

            <div class="banner-on-main__col">
                <? /*<form class="banner-on-main__form" method="POST">
                    <?=bitrix_sessid_post()?>
                    <input type="hidden" name="ACTION" value="ORDER_CONSULTATION">
                    <div class="banner-on-main__form-title">Заказать консультацию</div>

                    <div class="banner-on-main__form-field">
                        <label for="name" class="banner-on-main__form-field-label">Имя</label>
                        <input class="banner-on-main__form-field-input" type="text" name="name" id="name" required>
                    </div>

                    <div class="banner-on-main__form-field">
                        <label for="name" class="banner-on-main__form-field-label">Телефон</label>
                        <input class="banner-on-main__form-field-input" type="text" name="phone" id="phone" placeholder="+7 (___) ___-__-__" required>
                    </div>

                    <button class="banner-on-main__form-button">Отправить заявку</button>

                    <div class="banner-on-main__form-privacy">
                        <input type="checkbox" name="privacy" id="privacy" checked>
                        <label class="banner-on-main__form-privacy-checkbox" for="privacy"></label>
                        <label for="privacy">
                            Согласен (-на) на обработку персональных данных
                        </label>
                    </div>
                </form>*/ ?>
                <? if (!$arParams['IS_AUTH']): ?>
                    <div class="banner-on-main__form" method="POST">
                        <input type="hidden" name="ACTION" value="ORDER_CONSULTATION">
                        <div class="banner-on-main__form-title">Для продолжения введите номер телефона</div>
                        <form id="modal_auth-form_phone_static" method="POST" onsubmit="get_code_static(this); return false;">
                            <div class="banner-on-main__form-field">
                                <label for="name" class="banner-on-main__form-field-label">Введите номер телефона</label>
                                <input class="banner-on-main__form-field-input" type="text" name="phone" placeholder="+7 (___) ___-__-__" required>
                                <input value="get_code" type="hidden" name="method">
                            </div>
                            <div class="error"></div>
                            <div class="wrap-btn">
                                <button class="btn bg_main" role="get_code" onclick="get_code_static(this)">
                                    Получить код
                                </button>
                            </div>

                        </form>

                        <form id="modal_auth-form_code_static" method="POST" onsubmit="check_code_static(this);return false;" style="display: none">
                            <div class="nomer_izmen" onclick="nomer_izm()"><svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.8576 4.57106H3.88655L6.52655 1.93106C6.63242 1.82892 6.71637 1.70629 6.77327 1.57064C6.83018 1.43499 6.85886 1.28916 6.85755 1.14206C6.85391 0.840144 6.73229 0.55163 6.51869 0.338218C6.3051 0.124807 6.01648 0.0034373 5.71455 6.36757e-05C5.56741 -0.00153562 5.4215 0.0270069 5.28581 0.0839327C5.15011 0.140858 5.02751 0.224962 4.92555 0.331064L0.378552 4.87906C0.259215 4.98288 0.163672 5.11122 0.0984396 5.25532C0.0332068 5.39942 -0.000181394 5.55589 0.000552051 5.71406C-0.00456822 5.87085 0.0259846 6.02676 0.0899056 6.17002C0.153827 6.31328 0.249447 6.44015 0.369552 6.54106L4.92655 11.1001C5.02851 11.2062 5.15111 11.2903 5.28681 11.3472C5.4225 11.4041 5.56841 11.4327 5.71555 11.4311C6.01765 11.4277 6.30641 11.3062 6.52004 11.0926C6.73367 10.8789 6.85517 10.5902 6.85855 10.2881C6.85986 10.141 6.83118 9.99514 6.77427 9.85949C6.71736 9.72384 6.63342 9.6012 6.52755 9.49906L3.88755 6.85906H14.8576C15.1607 6.85906 15.4514 6.73864 15.6658 6.52429C15.8801 6.30993 16.0006 6.01921 16.0006 5.71606C16.0006 5.41292 15.8801 5.12219 15.6658 4.90784C15.4514 4.69349 15.1607 4.57306 14.8576 4.57306V4.57106Z" fill="#E31E24"/>
                                </svg>
                                Изменить номер</div>
                            <div class="banner-on-main__form-field">
                                <label for="name" class="banner-on-main__form-field-label">Сейчас на номер <span></span> поступит входящий звонок. Введите последние 4 цифры номера, с которого поступил звонок. Снимать трубку не нужно.</label>
                                <div class="input_code_auth">Введите код</div>
                                <input class="banner-on-main__form-field-input" type="text" name="code" placeholder="____" required>
                                <input value="check_code" type="hidden" name="method">
                            </div>
                            <div class="error"></div>
                            <div class="new-review__checkbox-block">

                                <label class="new-review__checkbox-label custom_field_wrap">

                                    <input required type="checkbox" name="check_select_part" checked="" id="new-review-checkbox">

                                    <span class="new-review__check-box">
                                <i class="fas fa-checks"></i>
                            </span>
                                    Я даю <a href="<?= SITE_DIR?>privacy_policy/">Согласие на обработку </a>персональных данных
                                    <span class="custom_error_message"></span>
                                </label>

                            </div>
                            <div class="wrap-btn">
                                <button class="btn bg_main" role="get_code" onclick="check_code_static(this)">
                                    Войти
                                </button>
                            </div>
                        </form>
                    </div>
                <? endif; ?>
            </div>
        </div>
    </div>
    <div class="banner-on-main__popup banner-on-main__popup_success">
        <div class="banner-on-main__popup-close mfp-close"></div>
        <div class="banner-on-main__popup-header">Спасибо!</div>
        <div class="banner-on-main__popup-body">
            Ваша заявка успешно отправлена
        </div>
    </div>
</div>
