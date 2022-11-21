(function ($) {
    $(document).ready(function () {

        var $body = $('body');
        $body.on('click', '.footer_item_header', function () {
            var $link = $(this);
            var $target = $link.closest('.footer_content_item');
            $target.toggleClass('open');
        });

        var ex = $('kwazi_select');
        $(ex).each(function (indx, elem) {
            if ($(elem).attr('no_select')) {
                return;
            }
            if ($(elem).find('items kwazi_option[selected]').length) {
                var items_title = document.createElement('div');
                items_title.innerHTML = $(elem).find('items kwazi_option[selected]').html();
                $(items_title).find('input').removeAttr('onchange').removeAttr('id').removeAttr('name');
                $(items_title).find('label').removeAttr('for');
                $(elem).find('items_title val').html($(items_title).html());
            }
            if (!$(elem).find('items[sizeable]').length) {
                var html = '<div id="sizeable">' + $(elem).find('items').html() + '</div>';
                $(html).find('[id]').each(function (ind, el) {
                    $(el).removeAttr('id')
                })
                $(elem).append('<items sizeable>' + $(html).find('#sizeable').html() + '</items>');
            }
        })

        $(document).on('click', 'kwazi_option', function (ev) {
            var elem = $(this);
            var kwazi_select = $(elem).parents('kwazi_select');
            //kwazi_select.find('val').text($(elem).text());
            kwazi_select.removeAttr('open').find('kwazi_option').removeAttr('selected');
            var html = document.createElement('div');
            html.innerHTML = $(elem).html();
            $(html).find('input').removeAttr('onchange').removeAttr('id').removeAttr('name');
            $(html).find('label').removeAttr('for');
            kwazi_select.find('items_title val').html($(html).html());
            $(elem).attr({'selected': 'Y'});
            const name = kwazi_select.attr('name');
            const val = kwazi_select.find('items_title val input').val();
            $('select[name="' + name + '"]').val(val).trigger('change');
        })
        $(document).on('click', 'items_title', function (ev) {
            var elem = $(ev.target);
            var kwazi_select = $(elem).parents('kwazi_select');
            if (kwazi_select.attr('open')) {
                kwazi_select.removeAttr('open');
            } else {
                kwazi_select.attr({'open': 'Y'});
            }
        })
        $(document).on('click', function (ev) {
            var elem = $(ev.target);

            if (!$(elem).parents('kwazi_select').length && !$(elem).parents('label').find('kwazi_select').length) {
                $('kwazi_select').removeAttr('open');
            }
        })

    })
})(jQuery);
