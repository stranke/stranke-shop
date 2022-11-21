function ProductCard(elem) {
    this.$elem = $(elem);
    this.init();
}

ProductCard.prototype = {
    constructor: ProductCard,

    init: function () {
        this.$select = this.$elem.find('select');
        this.$inputType = this.$elem.find('input[name="input_type"]');
        this.addToBasket = this.$elem.find('div[class*="__add-to-basket-btn"]');
        this.$price = this.$elem.find('.price');
        this.$itemId = this.$elem.attr('item_id');
        this.haveSKU = !!this.$select.length;
        this.itemData = window.arPopupData[this.$itemId];

        this.urlManager = new window.URLManager();
        this.viewMode = this.urlManager.getValue("view");

        if(this.viewMode === false){
            this.viewMode = 'simple';
        }

        if( this.$select.hasClass("product-view-mobile__select-variant") ){
            this.viewMode = 'mobile';
        }

        if (this.haveSKU) {

            this.$storeBlock = this.$elem.find('.store__block');

        }

        this.bindEvents();
    },

    bindEvents: function () {

        if (this.haveSKU) {
            this.$select.on('change', this.onChangeSelect.bind(this));
        }

    },

    onChangeSelect: function(e){
        var _this = this;
        var select = e.target;
        var selectIndex = select.options.selectedIndex;
        this.selectedSKUId = select.options[selectIndex].value;
        _this.quantityData = '';
        for (var i in _this.itemData[this.selectedSKUId].CATALOG_QUANTITY_DATA) {
            var val = _this.itemData[this.selectedSKUId].CATALOG_QUANTITY_DATA[i];

            if(_this.viewMode !== 'simple') {

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
            }
            if( val['avaliable'] === false){ val['QUANTITY'] = 'Нет'; }
            _this.quantityData +=
                '<div class="product-view-' + _this.viewMode + '__shop">'+
                    '<span>' + val['ADRES'] + ': </span>'+
                    '<span class="' + (val['avaliable'] ? 'available' : 'unavailable') + '">'
                        + (val['avaliable'] ? (val['QUANTITY'] + ' шт') : val['QUANTITY']) +
                    '</span>'+
                '</div>';
        }

        _this.$storeBlock.html(_this.quantityData);
        console.info(_this.$storeBlock)
        _this.$inputType.val(_this.selectedSKUId);
        _this.$price.html(_this.itemData[_this.selectedSKUId]['PRINT_PRICE']);

        if(_this.itemData[_this.selectedSKUId]["IN_BASKET"] == "Y"){
            _this.addToBasket.addClass('added').attr({'onclick': "window.location.href='" + BASKET_URL + "'"}).find('.val').html('В корзине <i class="fas fa-check"></i>');
        }else{
            _this.addToBasket.removeClass('added').attr('onclick','catalogBuyItem(this)');
            _this.addToBasket.find('.val').html('В корзину');
        }



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
        $productCards.each(function(){
            _this.productCards.push(new ProductCard(this));
        });

        this.urlManager = new window.URLManager();
        this.urlManagerLastPage = new window.URLManager(window.lastpage);

        this.numberLastPage = this.urlManagerLastPage.getValue("PAGEN_1");

        var pagen = this.urlManager.getValue('PAGEN_1');
        if( pagen && pagen > 1){
            this.pagen = Number(pagen);
        }else{
            this.pagen = 1;
        }
        this.$showMoreBtn = $('.js-ProductListShowMoreBtn');

        this.bindEvents();

    },

    bindEvents: function(){
        this.$showMoreBtn.on('click', this.showMore.bind(this));
    },

    showMore: function(){
        this.incrementPagen();

        this.urlManager.setUrlVar("PAGEN_1", this.pagen );
        this.urlManager.setUrlVar("show_more", "Y" );
        this.urlManager.getUrl();

        this.ajax(this.urlManager.url);
    },

    incrementPagen: function(){
        this.pagen += 1;
    },

    ajax: function(url){
        $.ajax({
            url: url,
            type: "GET",
            dataType: "json"
        }).done(this.processAjax.bind(this));
    },

    processAjax: function(json){
        var _this = this;

        if(Number(this.numberLastPage) === this.pagen){
            this.$showMoreBtn.remove();
        }

        var $html = $(json.html);
        $('.subsection-page__product-list').eq(1).append($html);

        var mergedArPopupData = this.objMerge(window.arPopupData, json.arPopupData);

        window.arPopupData = mergedArPopupData;

        var $productCards = $('.subsection-page__product-list > div');

        $productCards.each(function(idx){
            if(idx > (_this.pagen-1) * 24-1){
                _this.productCards.push(new ProductCard(this));
            }
        });
    },

    objMerge: function(obj, src){
        for (var key in src){
            if(src.hasOwnProperty(key)){
                obj[key] = src[key];
            }
        }
        return obj;
    }

};

$(function () {

    window.productManager = new ProductManager();

});
