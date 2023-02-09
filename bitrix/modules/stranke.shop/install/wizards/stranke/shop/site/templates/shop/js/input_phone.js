(function ($) {
    $.fn.phone_mask = function () {
        set_phone_mask = function (ev) {
            const placeholder = '+_ (___) ___-__-__';
            var setter = {
                phone_placeholder() {
                    return '<span>' + phone + '</span>' + placeholder.substr(phone != false ? phone.length : 0)
                },
                phone_value() {
                    phone = phone.replace(/[^0-9]/g, "");
                    if (phone.length == 1 && phone == '8') {
                        phone = '7';
                    }
                    if (phone.length && phone[0] != '7') {
                        phone = '7' + phone;
                    }
                    return phone
                },
                phone_render() {
                    var n = 0;
                    var str = ''
                    for (var i in placeholder) {
                        if (phone.length <= n) {
                            return str;
                        }
                        if (placeholder[i] == '_') {
                            str = str + phone[n];
                            n++;
                        } else {
                            str = str + placeholder[i];
                        }
                    }
                    return str;
                },
            }
            var phone = elem.val();
            setter.phone_value();
            elem.val(setter.phone_render());
        }
        var elem = $(this);
        if (!elem.attr('phone_mask')) {
            elem.attr({'phone_mask': 'Y'})
            elem.on('input', set_phone_mask)
        }
    };
})(jQuery);

$(window).on("load", function () {
    var elems = $('[name=phone],[is_phone=Y]')
    $(document).on('focus', '[name=phone],[is_phone=Y],[name=PHONE]', function () {
        var elem = $(this);
        elem.phone_mask();
    });
    elems.phone_mask();
    elems.trigger('input');
})
