var load_get_code_static = false

function get_code_static() {

    if (load_get_code_static)
        return false;
    load_get_code_static = true

    var $form = $('#modal_auth-form_phone_static')
    var $form1 = $('#modal_auth-form_code_static')
    var phone = $form.find('input[name="phone"]').val()
    var method = $form.find('input[name="method"]').val()


    var data = {phone: phone};
    var data1 = {method: method};

    $.ajax({
        type: "post",
        url: SITE_DIR + 'ajax/auth/index.php',
        data: {
            'phone': phone,
            'method': method,
        },
        /*JSON.stringify(data,data1),*/
        dataType: "json",
        success: function (answer) {

            load_get_code_static = false


            if (answer.errors) {
                $form.find('.error').html(answer.errors[0]).css({
                    'display': 'block'
                })
            } else {
                $('.banner-on-main__form-title').html('Авторизация в сервисе')
                $form1.find('.banner-on-main__form-field-label span').html(answer.phone)
                $form.css({
                    'display': 'none'
                })
                $('#modal_auth-form_code_static').css({
                    'display': 'block'
                })
            }
        }
    })
    return false
}

function nomer_izm() {
    $('#modal_auth-form_code_static').css({
        'display': 'none'
    })
    $('#modal_auth-form_phone_static').css({
        'display': 'block'
    })
}

function check_code_static() {
    if (load_get_code_static)
        return false;
    load_get_code_static = true
    var $form_prev = $('#modal_auth-form_phone_static')
    var $form = $('#modal_auth-form_code_static')
    var phone = $form_prev.find('input[name="phone"]').val()
    var code = $form.find('input[name="code"]').val()
    var method = $form.find('input[name="method"]').val()
    var data = {phone: phone, code: code, method: method};
    $.ajax({
        type: "post",
        url: SITE_DIR + 'ajax/auth/index.php',
        data: {
            'phone': phone,
            'method': method,
            'code': code
        },
        /*JSON.stringify(data),*/
        dataType: "json",
        success: function (answer) {
            load_get_code_static = false
            if (answer.errors) {
                $form.find('.error').html(answer.errors[0]).css({
                    'display': 'block'
                })
            } else {
                window.location.reload()
            }
        }
    })
    return false
}

$(function () {
    var $form = $('.banner-on-main__form');

    var inputPhone = document.querySelector('.banner-on-main__form-field-input[name="phone"]');
    /*if (inputPhone) {
        Inputmask({
            mask: "+7 (999) 999-99-99",
            showMaskOnHover: !1
        }).mask(inputPhone);
    }*/

    /*$form.parsley({
        errorsWrapper: '',
        errorClass: 'banner-on-main__form-field_error',
        classHandler: function (field) {
            const $parent = field.$element.closest('.banner-on-main__form-field');
            if ($parent.length) return $parent;

            return field.$element;
        }
    });*/

    $form.on('submit', submitForm);

    function submitForm(e) {
        e.preventDefault();
        var $form = $(e.target);
        var data = $form.serialize();
        $.ajax({
            url: location.href,
            data: data,
            type: 'POST',
            dataType: 'json',
            success: ajaxSuccess
        });
    }

    function ajaxSuccess(response) {
        if (!response.success) {
            return console.error(response);
        }

        // ym(36068250, 'reachGoal', 'banner-on-main-form-success');

        $('input[name="name"], input[name="phone"]').val('');
        $.magnificPopup.open({
            items: {
                src: $('.banner-on-main__popup'),
                type: 'inline',
            }
        });
    }
});
