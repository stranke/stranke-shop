function ProductCard(elem) {
    this.$elem = $(elem);
    this.init();
}

ProductCard.prototype = {
    constructor: ProductCard,

    init: function () {
        this.$body = $('body');
        this.$select = this.$elem.find('.js-product-variant-select-item');
        this.$dropDownBlockList = this.$elem.find('.vsevset_dropdown_block_list');
        this.$inputType = this.$elem.find('input[name="input_type"]');
        this.addToBasket = this.$elem.find('div[class*="__add-to-basket-btn"]');
        this.$price = this.$elem.find('.js-basePriceTitle');
        this.$itemId = this.$elem.attr('item_id');
        this.haveSKU = !!this.$select.length;
        this.itemData = window.arPopupData[this.$itemId];
        this.tovarName = this.$elem.find('[role="tovar_name"]');
        this.delivery_text = this.$elem.find('[role="delivery_text"]');

        this.urlManager = new window.URLManager();
        this.viewMode = this.urlManager.getValue("view");

        if (this.viewMode === false) {
            this.viewMode = 'simple';
        }

        if (this.$select.hasClass("product-view-mobile__select-variant")) {
            this.viewMode = 'mobile';
        }

        if (window.isMobile === true) {
            this.viewMode = 'mobile';
        }

        if (this.haveSKU) {

            this.$storeBlock = this.$elem.find('.store__block');

        }
        this.$quantityBlock = this.$elem.find('[role="quantity_info"]');

        this.bindEvents();
    },

    bindEvents: function () {

        if (this.haveSKU) {

            this.$body.on('click', this.anyClick.bind(this));
            this.$select.on('click', this.onChangeSelect.bind(this));
        }

    },

    anyClick: function (e) {
        var target = e.target;
        var $target = $(target);
        var $select = $target.closest('.product-variant__select');
        if ($select.length <= 0) {
            this.$dropDownBlockList.removeClass('open');
        }
    },

    onChangeSelect: function (e) {
        var _this = this;
        var select = e.target;
        var $select = $(select);
        this.selectedSKUId = $select.attr('value_data');
        this.selectedSKUFakeBuyBtn = $select.attr('buyBtn_data');
        this.selectedSKUDemoBtn = $select.attr('demoBtn_data');
        this.selectedSKUName = $select.text();
        this.tovarName.text(this.selectedSKUName);
        _this.quantityData = '';
        _this.delivery_text.text(_this.itemData[this.selectedSKUId].CATALOG_DELIVERY_TEXT);
        for (var i in _this.itemData[this.selectedSKUId].CATALOG_QUANTITY_DATA) {
            var val = _this.itemData[this.selectedSKUId].CATALOG_QUANTITY_DATA[i];
            if (this.viewMode !== 'simple' || this.viewMode !== 'table') {
                switch (val["ID"]) {
                    case 1:
                    case "1":
                        val["ADRES"] = "1К";
                        break;
                    case 2:
                    case "2":
                        val["ADRES"] = "78ДБ";
                        break;
                    case 5:
                    case "5":
                        val["ADRES"] = "УС";
                        break;
                    case 4:
                    case "4":
                        val["ADRES"] = "УС";
                        break;
                    case 8:
                    case "8":
                        val["ADRES"] = "17КП";
                        break;

                }
                switch (val["ID"]) {
                    case 1:
                    case "1":
                        val["ADRES"] = "ул. Крылова д.1";
                        break;
                    case 2:
                    case "2":
                        val["ADRES"] = "ул. 78 Добровольческой бригады, д. 4";
                        break;
                    case 5:
                    case "5":
                        val["ADRES"] = "Удаленный склад";
                        break;
                    case 4:
                    case "4":
                        val["ADRES"] = "Удаленный склад";
                        break;
                    case 8:
                    case "8":
                        val["ADRES"] = "ул. Копылова 17";
                        break;

                }
            }

            var shtuk = "";

            if (val['avaliable'] === false) {
                val['QUANTITY'] = 'Нет';
            }
            _this.quantityData +=
                '<div class="product-view-' + _this.viewMode + '__shop">' +
                '<span>' + val['ADRES'] + ': </span>' +
                '<span class="' + (val['avaliable'] ? 'available' : 'unavailable') + '">'
                + (val['avaliable'] ? (val['QUANTITY'] + ' шт') : val['QUANTITY']) +
                '</span>' +
                '</div>';
        }
        if (!(_this.itemData[this.selectedSKUId].isPresentationOrder)) {
            if (this.selectedSKUFakeBuyBtn.length > 0) {
                this.$elem.find('.js-pricePrice').css({'display': 'block'});
                this.$elem.find('.js-openModalCheaper').css({'display': 'block'});
                this.$elem.find('.js-partnerPriceTitle').css({'display': 'block'});
                this.$elem.find(".product-view-" + _this.viewMode + "__add-to-basket-btn").remove();
                $('<div class="product-view-' + _this.viewMode + '__add-to-basket-btn" title="Купить ' + this.itemData[this.selectedSKUId].NAME + '" data-href="'+this.selectedSKUFakeBuyBtn+'" data-target="blank">\n' +
                    '                        <div class="product-view-' + _this.viewMode + '__add-to-basket-icon">\n' +
                    '                          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="17" height="17" viewBox="0 0 17 17"><defs><path id="tb1la" d="M1263.7 478c.67 0 1.26.4 1.53.97l.34.72h12.54a.85.85 0 0 1 .74 1.26l-3.03 5.5a1.7 1.7 0 0 1-1.48.88h-6.32l-.76 1.38-.03.1c0 .12.1.21.22.21h9.81v1.7h-10.17a1.7 1.7 0 0 1-1.5-2.51l1.16-2.08-3.05-6.44h-1.7V478h1.7m11.87 13.57a1.7 1.7 0 1 1 0 3.39 1.7 1.7 0 0 1 0-3.4m-8.48 0a1.7 1.7 0 1 1 0 3.4 1.7 1.7 0 0 1 0-3.4"/></defs><g><g transform="translate(-1262 -478)"><use fill="#fff" xlink:href="#tb1la"/></g></g></svg>\n' +
                    '                        </div>\n' +
                    '                        <span class="val">Купить</span>\n' +
                    '                      </div>').insertAfter(this.$elem.find('.product-view-simple__price'));
            } else {
                if (parseInt(_this.itemData[this.selectedSKUId].CATALOG_QUANTITY)) {
                    this.$elem.find('.js-pricePrice').css({'display': 'block'});
                    this.$elem.find('.js-openModalCheaper').css({'display': 'block'});
                    this.$elem.find('.js-partnerPriceTitle').css({'display': 'block'});
                    this.$elem.find(".product-view-" + _this.viewMode + "__add-to-basket-btn").remove();
                    $('<div class="product-view-' + _this.viewMode + '__add-to-basket-btn" title="Купить ' + this.itemData[this.selectedSKUId].NAME + '" onclick="catalogBuyItem(this)">\n' +
                        '                        <div class="product-view-' + _this.viewMode + '__add-to-basket-icon">\n' +
                        '                          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="17" height="17" viewBox="0 0 17 17"><defs><path id="tb1la" d="M1263.7 478c.67 0 1.26.4 1.53.97l.34.72h12.54a.85.85 0 0 1 .74 1.26l-3.03 5.5a1.7 1.7 0 0 1-1.48.88h-6.32l-.76 1.38-.03.1c0 .12.1.21.22.21h9.81v1.7h-10.17a1.7 1.7 0 0 1-1.5-2.51l1.16-2.08-3.05-6.44h-1.7V478h1.7m11.87 13.57a1.7 1.7 0 1 1 0 3.39 1.7 1.7 0 0 1 0-3.4m-8.48 0a1.7 1.7 0 1 1 0 3.4 1.7 1.7 0 0 1 0-3.4"/></defs><g><g transform="translate(-1262 -478)"><use fill="#fff" xlink:href="#tb1la"/></g></g></svg>\n' +
                        '                        </div>\n' +
                        '                        <span class="val">В корзину</span>\n' +
                        '                      </div>').insertAfter(this.$elem.find('.product-view-simple__price'));
                } else {
                    this.$elem.find(".product-view-" + _this.viewMode + "__add-to-basket-btn").remove();
                    $('<div class="product-view-' + _this.viewMode + '__add-to-basket-btn add-to-order" title="Заказать ' + this.itemData[this.selectedSKUId].NAME + '" href="#call_order" id="call_order_link">\n' +
                        '                      <i class="fa fa-shopping-cart"></i>\n' +
                        '                      Заказать\n' +
                        '                    </div>'
                    ).insertAfter(this.$elem.find('.product-view-simple__price'));
                    _this.quantityData = '';
                }
            }


            if (_this.itemData[_this.selectedSKUId]['PRICE'] >= 20000) {
                _this.$elem.find('[role="form__tinkoff"]').css({
                    'display': 'block'
                })
            } else {
                _this.$elem.find('[role="form__tinkoff"]').css({
                    'display': 'none'
                })
            }
            _this.$storeBlock.html(_this.quantityData);
            _this.$inputType.val(_this.selectedSKUId);
            _this.$price.html(_this.itemData[_this.selectedSKUId]['PRINT_PRICE']);
            _this.$elem.find('[role="credit_pay"]').html('Кредит от ' + Math.round(_this.itemData[_this.selectedSKUId]['PRICE'] / 19) + ' руб. в мес.');
            _this.$elem.find('[role="installment_pay"]').html(' Рассрочка от ' + Math.round(_this.itemData[_this.selectedSKUId]['PRICE'] / 19) + ' руб. в мес.');
            _this.$elem.find('[role="credit_sum"]').val(_this.itemData[_this.selectedSKUId]['PRICE']);
            _this.$elem.find('[role="credit_variant_name"]').val(_this.itemData[_this.selectedSKUId]['NAME']);
            if (_this.itemData[_this.selectedSKUId]['CATALOG_QUANTITY']>0) {
                _this.$quantityBlock.html('Доступно: <span class="available">' + _this.itemData[_this.selectedSKUId]['CATALOG_QUANTITY'] + ' шт.</span>');
            } else {
                _this.$quantityBlock.html('<span class="unavailable">Нет в наличии</span>');
            }

            this.updatePartnerPriceTitle();
            this.updateBasePriceTitle();

            if (_this.itemData[_this.selectedSKUId]["IN_BASKET"] == "Y") {
                _this.addToBasket.addClass('added').attr({'onclick': "window.location.href='" + BASKET_URL + "'"}).find('.val').html('В корзине <i class="fas fa-check"></i>');
            } else {
                _this.addToBasket.removeClass('added').attr('onclick', 'catalogBuyItem(this)');
                _this.addToBasket.find('.val').html('В корзину');
            }
        } else {
            this.$elem.find('.js-pricePrice').css({'display': 'none'});
            this.$elem.find('.js-openModalCheaper').css({'display': 'none'});
            this.$elem.find('.js-partnerPriceTitle').css({'display': 'none'});
            this.$elem.find(".product-view-" + _this.viewMode + "__add-to-basket-btn").remove();
            $(
                '<div class="product-view-' + _this.viewMode + '__add-to-basket-btn product-view-' + _this.viewMode + '__add-to-basket-btn_presentation js-presentationOrder">\n' +
                '  <span class="val">Заказать презентацию</span>\n' +
                '</div>'
            ).insertAfter(this.$elem.find('.product-view-simple__price'));
        }

    },

    updatePartnerPriceTitle: function () {
        let $partnerPriceTitle = this.$elem.find('.js-partnerPriceTitle');

        if (this.isPartnerPrice()) {
            //let text = this.itemData[this.selectedSKUId]['partnerPriceTitle'];
            let text = this.itemData[this.selectedSKUId]['partnerPrice'];
            if ($partnerPriceTitle.length) {
                $partnerPriceTitle.html(text);
            } else {
                this.$price.before('<div class="price-block__title js-partnerPriceTitle">' + text + '</div>');
            }
        } else {
            $partnerPriceTitle.length && $partnerPriceTitle.remove();
        }
    },

    updateBasePriceTitle: function () {
        let $basePriceTitle = this.$elem.find('.js-basePriceTitle'),
            $priceContainer = this.$elem.find('.price-container'),
            $isDiscount = this.itemData[this.selectedSKUId]['DEFAULT_PRICE'] > this.itemData[this.selectedSKUId]['PRICE'];
        if ($isDiscount)
        {
           if ($priceContainer.hasClass('new-price-container')) {
               let text = this.itemData[this.selectedSKUId]['basePrice'],
                   $defaultPriceTitle = this.$elem.find('.js-defaultPriceTitle'),
                   $percentContainer = this.$elem.find('.price-shild');
               $basePriceTitle.html(text);
               $defaultPriceTitle.html(this.itemData[this.selectedSKUId]['PRINT_DEFAULT_PRICE']);
               $percentContainer.html('-'+this.itemData[this.selectedSKUId]['PERCENT']+'%');
           } else {
               let text = this.itemData[this.selectedSKUId]['PRINT_PRICE'],
                   $defaultPricePrint = this.itemData[this.selectedSKUId]['PRINT_DEFAULT_PRICE'],
                   $percentContainer = this.$elem.find('.price-shild');
               let $div = '';
               $div += '<span class="price price_new js-basePriceTitle">' + text + '</span>\n' +
                   '<span class="price-shild">-' + this.itemData[this.selectedSKUId]['PERCENT'] + '%</span>\n' +
                   '</div>\n';

               $priceContainer.addClass('new-price-container');
               $priceContainer.html($div);
               $priceContainer.after('<span class="price price_old js-defaultPriceTitle">' + $defaultPricePrint + '</span>');
           }
        } else {
            if ($priceContainer.hasClass('new-price-container')) {
                let text = this.itemData[this.selectedSKUId]['PRINT_PRICE'];
                let $div = '';
                $div = '<span class="price js-basePriceTitle">'+text+'</span>\n';
                $priceContainer.removeClass('new-price-container');
                $priceContainer.html($div);
                this.$elem.find('.price_old').remove();
            } else {
                let text = this.itemData[this.selectedSKUId]['basePrice'];
                if ($basePriceTitle.length) {
                    $basePriceTitle.html(text);
                } else {
                    this.$price.after('<div class="price-block__title js-basePriceTitle">' + text + '</div>');
                }
            }
        }

    },

    isPartnerPrice: function () {
        return this.itemData[this.selectedSKUId]['isPartnerPrice'];
    }

};

function ProductManager() {
    this.productCards = [];

    this.init();
}

ProductManager.prototype = {
    constructor: ProductManager,

    init: function () {
        var _this = this;
        var $productCards = $('.subsection-page__product-list > div');
        $productCards.each(function () {
            _this.productCards.push(new ProductCard(this));
        });

        this.urlManager = new window.URLManager();
        this.urlManagerLastPage = new window.URLManager(window.lastpage);

        this.numberLastPage = this.urlManagerLastPage.getValue("PAGEN_1");

        var pagen = this.urlManager.getValue('PAGEN_1');
        if (pagen && pagen > 1) {
            this.pagen = Number(pagen);
        } else {
            this.pagen = 1;
        }
        this.$showMoreBtn = $('.js-ProductListShowMoreBtn');

        this.bindEvents();

    },

    bindEvents: function () {
        this.$showMoreBtn.on('click', this.showMore.bind(this));
    },

    showMore: function () {
        this.incrementPagen();

        this.urlManager.setUrlVar("PAGEN_1", this.pagen);
        this.urlManager.setUrlVar("show_more", "Y");
        this.urlManager.getUrl(true);

        this.ajax(this.urlManager.url);
    },

    incrementPagen: function () {
        this.pagen += 1;
    },

    ajax: function (url) {
        $.ajax({
            url: url,
            type: "GET",
            dataType: "json"
        }).done(this.processAjax.bind(this));
    },

    processAjax: function (json) {
        var _this = this;

        if (Number(this.numberLastPage) === this.pagen) {
            this.$showMoreBtn.remove();
        }

        var $html = $(json.html);


        var length = $('.subsection-page__product-list').length;

        if (length > 0) {

            $('.subsection-page__product-list').eq(length - 1).append($html);

            var mergedArPopupData = this.objMerge(window.arPopupData, json.arPopupData);

            window.arPopupData = mergedArPopupData;

            var $productCards = $('.subsection-page__product-list > div');

            $productCards.each(function (idx) {
                if (idx > (_this.pagen - 1) * 24 - 1) {
                    _this.productCards.push(new ProductCard(this));
                }
            });

        }

        BX.onCustomEvent('ajaxSuccessLoadedProducts');
        let $btnActive = $('.shop-page-nav-new__btn:contains("' + this.pagen + '")');
        $btnActive.addClass('shop-page-nav-new__btn_active').siblings().removeClass('shop-page-nav-new__btn_active');
    },

    objMerge: function (obj, src) {
        for (var key in src) {
            if (src.hasOwnProperty(key)) {
                obj[key] = src[key];
            }
        }
        return obj;
    }

};

$(function () {

    window.productManager = new ProductManager();

});
