function init_product_offers(product_id, offers = false) {
    var $product_div = $('[product_id="' + product_id + '"]');
    const $offersInputRadio = $product_div.find('[role="product__offer-radio"]');
    const $buyBtn = $product_div.find('[role="buy_btn"]');
    var offer_id = parseInt($offersInputRadio.val())
    var canBuy = true;

    function basketResult(arResult) {
        var popupContent, popupButtons, productPict;

        canBuy = true;

        if (arResult.STATUS === 'OK') {
            // this.setAnalyticsDataLayer('addToCart');
        }


        if (arResult.STATUS === 'OK') {
            // if (basketMode === 'BUY') {
            // this.basketRedirect();
            // } else {
            $('[role="header_cart"]').html(arResult.CART);
            $product_div.find('[role="buy_btn"]').html('<svg width="21" height="15" viewBox="0 0 21 15" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
                '<path d="M19 2L7.3125 13L2 8" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>\n' +
                '</svg> ' + BX.message('CT_BCE_CATALOG_ADDED')).addClass('product__buy-btn_added');

            // }
        } else {
            // this.initPopupWindow();

            popupContent = '<div style="width: 100%; margin: 0; text-align: center;"><p>'
                + (arResult.MESSAGE ? arResult.MESSAGE : BX.message('BASKET_UNKNOWN_ERROR'))
                + '</p></div>';
            popupButtons = [
                new BasketButton({
                    text: BX.message('BTN_MESSAGE_CLOSE'),
                    events: {
                        click: BX.delegate(this.obPopupWin.close, this.obPopupWin)
                    }
                })
            ];
        }

    }

    function buy_item() {
        var basketParams = {
            ajax_basket: 'Y',
            add_item: product_id,
        };
        if (offer_id) {
            basketParams.add_item = offer_id;
        }
        if (!canBuy)
            return;

        canBuy = false;
        BX.ajax({
            method: 'POST',
            dataType: 'json',
            url: $product_div.attr('url') || (window.location.pathname + window.location.search),
            data: basketParams,
            onsuccess: basketResult
        });
    }

    function change_product_offers() {
        offer_id = parseInt($offersInputRadio.val())
        var offer = offers.find(item => item.ID == offer_id)
        $product_div.find('[role="price_old"]').remove();
        $product_div.find('[role="price_value"]').html(offer.MIN_PRICE.PRINT_DISCOUNT_VALUE)
        if (offer.MIN_PRICE.DISCOUNT_DIFF) {
            $product_div.find('[role="price"]').prepend('<span role="price_old" class="product__price-old">' + offer.MIN_PRICE.PRINT_VALUE + '</span>')
        }
        if (offer.CATALOG_QUANTITY <= 0 && offer.PRODUCT.CAN_BUY_ZERO != 'Y') {
            $product_div.find('[role="buy_btn"]').removeClass('product__buy-btn_added').html(BX.message('CT_BCE_CATALOG_NO_AVAILABLE')).addClass('product__buy-btn_not-available')
        } else {
            $product_div.find('[role="buy_btn"]').removeClass('product__buy-btn_added').html('<svg width="21" height="26" viewBox="0 0 21 26" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
                '<path d="M18.9282 25H1.53333C1.24615 25 1 24.7538 1 24.4666V7.68714C1 7.39996 1.24615 7.15381 1.53333 7.15381H18.9282C19.2154 7.15381 19.4615 7.39996 19.4615 7.68714V24.4666C19.4615 24.7538 19.2154 25 18.9282 25Z" stroke="white" stroke-width="1.23" stroke-miterlimit="10"/>\n' +
                '<path d="M4.89746 7.15385C4.89746 1 10.2308 1 10.2308 1C10.2308 1 15.5641 1 15.5641 7.15385" stroke="white" stroke-width="1.23" stroke-miterlimit="10"/>\n' +
                '<line x1="10.5" y1="13" x2="10.5" y2="20" stroke="white"/>\n' +
                '<line x1="7" y1="16.5" x2="14" y2="16.5" stroke="white"/>\n' +
                '</svg>\n ' + BX.message('CT_BCE_CATALOG_ADD')).removeClass('product__buy-btn_not-available')
        }
        if (offer.CATALOG_QUANTITY <= 0) {
            $product_div.find('[role="quantity_info"]').html('<span class="unavailable">' + BX.message('CT_BCE_CATALOG_NO_AVAILABLE') + '</span>')
        } else {
            $product_div.find('[role="quantity_info"]').html(BX.message('CT_BCE_CATALOG_COUNT_AVAILABLE') + ' <span class="available">' + offer.CATALOG_QUANTITY + ' ' + BX.message('CT_BCE_CATALOG_COUNT_IZM') + '</span>')
        }
    }

    $offersInputRadio.on('change', change_product_offers);
    $buyBtn.on('click', buy_item);
}


function show_filter(elem) {
    var filter = $('.right-col');
    if (filter.attr('open')) {
        filter.removeAttr('open');
        $('body,html').removeClass('filter_show');
    } else {
        filter.attr({'open': 'Y'})
        $('body,html').addClass('filter_show');
    }
}
