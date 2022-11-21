var $choise_city = $('[role="choise_city"]')
var $choisecityForm = $('.js-choisecityForm')
var $choisecityForm_loading = 0

function showChoiseCityBox() {
    $choisecityForm = $('.js-choisecityForm')
    if (!$choisecityForm.length) {
        if (!$choisecityForm_loading) {
            $choisecityForm_loading = 1;
            $.ajax({
                "type": "post",
                "url": '/ajax/choise_city.php',
                success: function (data) {

                    $('body').append(data);
                    showChoiseCityBox()
                }
            });
        }
        return;
    }
    $choisecityForm.addClass('request-call-form_visible')
}


function removeChoiseCityBox() {
    $choisecityForm.remove()
    $choisecityForm_loading = 0;
}


function sendChoiseForm() {
    $.ajax({
        "type": "post",
        "url": '/ajax/choise_city_set.php',
        "data": $choisecityForm.find('.ChangeCityForm').serializeArray(),
        "dataType": "json",
        success: function (data) {
            $choisecityForm.removeClass('request-call-form_visible');
            setChoiseCityBox(data);
        }
    });
}

function sendChoiseCity(elem) {
    $.ajax({
        "type": "post",
        "url": '/ajax/choise_city_set.php',
        "data": {location_name: $(elem).text()},
        "dataType": "json",
        success: function (data) {
            $choisecityForm.removeClass('request-call-form_visible');
            setChoiseCityBox(data);
            removeChoiseCityBox();
        }
    });
}

function setChoiseCityBox(answer = false) {
    if (answer) {
        /*var loc = $('[name="ORDER_PROP_26"]');
        if (loc.val() && BX.Sale && BX.Sale.OrderAjaxComponent) {
            $('input[name="ORDER_PROP_26"]').val(answer.ID);
            BX.Sale.OrderAjaxComponent.sendRequest();
        }
        if (window.productDetail) {
            window.productDetail.load_delivery()
        }

        // $('input[name="ORDER_PROP_6"]').val(answer.ID).trigger('input')
        $('input[name="ORDER_PROP_6"]').val(answer.CODE);
        $('input[name="ORDER_PROP_6"]').attr('value' , answer.CODE)
        $('.bx-ui-sls-fake').attr('value' , answer.CODE)
        $('input[name="RECENT_DELIVERY_VALUE"]').attr('value' , answer.CODE)
        /*$('.bx-ui-sls-fake').attr('titlr' , answer)*/
        document.dispatchEvent(new CustomEvent("change_city", answer))
    }
    $.ajax({
        "type": "post",
        "url": '/ajax/choise_city_get.php',
        "dataType": "json",
        success: function (data) {
            if (!data.NAME) {
                setChoiseCityBox()
                return;
            }
            document.dispatchEvent(new CustomEvent("change_city", {'detail': data}))
            /*$('input[name="ORDER_PROP_6"]').val(data.CODE);
            $('input[name="ORDER_PROP_6"]').attr('value', data.CODE)
            $('.bx-ui-sls-fake').attr('value', data.CODE)
            $('input[name="RECENT_DELIVERY_VALUE"]').attr('value', data.CODE)
            window.currentCity = data;*/
            $choise_city = $('[role="choise_city"]')
            $choise_city.removeClass('loading').find('span').text(data.NAME)
        }
    });
}

$(document).on("click", '.js-choisecityFormCloseBtn', function () {
    $choisecityForm.removeClass('request-call-form_visible')
});
$(document).on("click", '.js-choisecityFormSendBtn', function () {
    sendChoiseForm();
});
$(document).on("click", '.js-choisecity', function (ev) {
    sendChoiseCity($(ev.target));
});

$(document).on('ready', function () {
    setChoiseCityBox();
});
/*$.ajax({
    "type": "post",
    "url": '/ajax/choise_city_load.php',
    success: function (data) {
        $('body').append(data);
        setTimeout(function () {
            $(document).on("click", '[role="choise_city"]', function () {
                showChoiseCityBox(data)
            });
        }, 1500)
    }
});*/
