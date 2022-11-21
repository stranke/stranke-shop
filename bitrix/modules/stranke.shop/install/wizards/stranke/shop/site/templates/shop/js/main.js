(function(window) {

  $(document).ready(function(){

    var $body = $('body');

    $body.on('click', '[data-href]', function () {

      var $link = $(this);
      var target = $link.data('target');
      var url = $link.data('href');

      if( typeof target === 'string' && target === '_blank' ){
        window.open(url)
      } else {
        location.href = url;
      }
    });

//----------------------- HeaderMenuHeightHandle -----------------------//
// For
// bitrix/templates/shop/components/bitrix/menu/catalog-menu/template.php
// ---------------------------------------------------------------------//

    hideMenuItems()

    $(window).resize(function() {
      hideMenuItems()
    });

    function hideMenuItems() {

      var menu = window.document.getElementById('catalog-nav-bar__item-list-id')
      var blockHeight = 0

      if(menu && menu.offsetHeight > 46) {
        blockHeight = menu.offsetHeight
        var children = menu.getElementsByTagName('a');
        let countHiddenItem = 0;
        for (var i = 0; i < children.length; ++i) {

          if(children[i].offsetTop > 1) {
            console.log('children[i].offsetTop', children[i].offsetTop)

            children[i].style.display = 'none'
            countHiddenItem++
          }
        }

        console.log('menu children', countHiddenItem)
        if(countHiddenItem > 0) {
          longMenu = window.document.getElementById('desktop-long-menu-container')
          longMenu.style.display = 'block'
        }
      }
    }

    $('#desktop-long-menu-container').on("click", function() {
      menu = window.document.getElementById('catalog-nav-bar__item-list-id')
      long_menu = window.document.getElementById('long_menu')

      if(long_menu) {
        long_menu.remove()
      } else {

        var children = menu.getElementsByTagName('a');
        long_menu = document.createElement('div');
        long_menu.setAttribute('id', 'long_menu')

        for (var i = 0; i < children.length; ++i) {
          if(children[i].style.display === 'none') {
            new_children = children[i].cloneNode(true)
            new_children.style.display = 'block'
            long_menu.appendChild(new_children)
          }
        }

        menu.appendChild(long_menu)
      }
    });


//----------------------- NiceScroll -----------------------//

    $(".get-nicer").niceScroll({
      cursorwidth: "5px",
      cursorcolor: "transparent",
      cursorborder: 'none',
    }).hide();

    $(".get-nicer1").niceScroll({
      cursorwidth: "5px",
      // cursorcolor: "#892420",
      cursorborder: 'none',
      cursoropacitymin: 1,
    });

    $(".get-nicer2").niceScroll({
      cursorwidth: "5px",
      cursorcolor: "transparent",
      cursorborder: 'none',
    }).hide();

//----------------------- PhoneMask -----------------------//


    var inputPhone = document.querySelector('#phone-input');

    if (inputPhone !== null) {
      vanillaTextMask.maskInput({
        inputElement: inputPhone,
        mask: ['+', '7', ' ', '(', /[1-9]/, /\d/, /\d/, ')', ' ', /\d/, /\d/, /\d/, '-', /\d/, /\d/, '-', /\d/, /\d/],
      });
    }

//----------------------- Products -----------------------//

    var $productOffer = $('.products__item-offer');
    var $productBtn = $('.js-productBtn');
    var $productConsistBtn = $('.js-productConsistBtn');
    var $productTimeBtn = $('.js-productTimeBtn');

    function productOfferClick () {
      var $this = $(this);

      $this.siblings('.products__item-offer').removeClass('products__item-offer_selected');
      $this.addClass('products__item-offer_selected');

      var $product = $this.closest('.products__item');
      var $btn = $product.find('.products__item-btn');
      productBtnSetActivity($btn, false);
    }
    function productBtnIsActive($btn) {
      return $btn.hasClass('products__item-btn_pressed');
    }
    function productBtnSetActivity($btn, isActive) {
      if (typeof isActive === 'undefined') {
        isActive = false;
      }

      var className = 'products__item-btn_pressed';

      if (isActive) {
        $btn.addClass(className);
      } else {
        $btn.removeClass(className);
      }
    }
    function productBtnPressed () {
      var $this = $(this);
      var $btn = $this.closest('.products__item-btn');

      if (productBtnIsActive($btn)) {
        productBtnSetActivity($btn, false);
      } else {
        productBtnSetActivity($btn, true);
      }
    }
    function productConsistToggle () {
      $this = $(this);
      var $productConsist = $this.siblings('.products__item-consist');

      if (!$productConsist.hasClass('products__item-consist_active')) {
        $productConsist.addClass('products__item-consist_active');
        $this.find('.products__item-consist-btn-icon').addClass('open');
      } else {
        $this.find('.products__item-consist-btn-icon').removeClass('open');
        $productConsist.removeClass('products__item-consist_active');
      }
    }
    function productTimeToggle () {
      $this = $(this);
      var $productConsist = $this.siblings('.products__item-time');

      if (!$productConsist.hasClass('products__item-time_active')) {
        $productConsist.addClass('products__item-time_active');
        // $this.find('i').addClass('open');
      } else {
        // $this.find('i').removeClass('open');
        $productConsist.removeClass('products__item-time_active');
      }
    }

    // $productOffer.on('click', productOfferClick);
    $productBtn.on('click', productBtnPressed);
    $productConsistBtn.on('click', productConsistToggle);
    $productTimeBtn.on('click', productTimeToggle);

//----------------------- Orders -----------------------//

    var $orderBtn = $('.js-orderBtn');

    function orderBtnClick () {
      var $this = $(this);
      var $currentOrder = $this.closest('.lk-orders__order');
      var $currentItemList = $currentOrder.find('.lk-order__basket-list');

      if (!$this.hasClass('lk-orders__order-btn_pressed')) {
        $this.addClass('lk-orders__order-btn_pressed');
        $this.text('������');
        $currentItemList.slideDown(400);
      } else {
        $currentItemList.slideUp(400);
        $this.text('��������');
        $this.removeClass('lk-orders__order-btn_pressed');
      }
    }

    $orderBtn.on('click', orderBtnClick);

//----------------------- ShowMoreText -----------------------//

    function ShowMoreText () {
      var $this = $(this);
      var $btnContainer = $this.closest('.text-page');
      var $textContainer = $btnContainer.find('.text-page__text');

      if ($this.hasClass('text-page__show-more-btn_pressed')) {

        $this.removeClass('text-page__show-more-btn_pressed');
        $textContainer.removeClass('text-page__text_open');

      } else {

        $this.addClass('text-page__show-more-btn_pressed');
        $textContainer.addClass('text-page__text_open');
      }

    }

    $('.text-page__show-more-btn').on('click', ShowMoreText);

//----------------------- DostavkaHeight -----------------------//

    function SetMaxHeight1() {

      var mainDivs = document.getElementsByClassName('dostavka-i-oplata__text-list');
      var maxHeight = 0;
      var $windWidfth = $(window).width();

      if ($windWidfth >= 1200) {
        for (var i = 0; i < mainDivs.length; ++i) {

          if (maxHeight < mainDivs[i].clientHeight) {
            maxHeight = mainDivs[i].clientHeight;
          }
        }

        for (var i = 0; i < mainDivs.length; ++i) {
          mainDivs[i].style.height = maxHeight + "px";
        }
      }
    }

    SetMaxHeight1();

//----------------------- BasketManager -----------------------//
    class BasketManager {
      constructor(){
        this.$body = $('body');


        this.bindEvents();
      }

      bindEvents(){
        this.$body.on('click', '[role="add_to_basket"]', this.clickAddToBasket.bind(this));
      }

      clickAddToBasket(e){
        this.$btn = $(e.target);
        var target = e.target;
        var action = 'ADD_TO_BASKET';
        var pQuantity = 1;
        var priceId = 1;
        this.productId = target.getAttribute("data-productid");
        var data = {
          "ACTION": action, // init.php
          "quantity": pQuantity,
          "productId": this.productId,
          "priceId": priceId,
        };

        $.ajax({
          url: location.href,
          type: "post",
          data: data,
          dataType: "json",
        }).done(function(json){

          if( json.status === true ){
            document.body.dispatchEvent(new Event('product_added'));

            window.CARTITEMS = json.CARTITEMS;
            if( typeof yaCounter !== 'undefined' ){
              /* TODO: reachGoal */
              // yaCounter.reachGoal('addToBasket');

            }

            if( typeof json.price !== 'undefined' && json.price !== ''){
              /* TODO: basketTotalPrice */
              // $basketTotalPrice.text(json.total.TOTAL_PRICE_FORMATTED);
            }

            if( typeof json.total.NUM_PRODUCTS !== 'undefined' && json.total.NUM_PRODUCTS !==''){
              /* TODO: basketNumProducts */
              // if( $basketNumProducts.length > 0 ){
              // $basketNumProducts.removeClass('empty');
              // $basketNumProducts.text(json.total.NUM_PRODUCTS);
              // }
            }

            this.setBtn();
          }
        }.bind(this));


      }

      setBtn(){
        var arSearch = `[data-productid="${this.productId}"][role="add_to_basket"]`;
        var $btn = $(arSearch);
        $btn.addClass('in-basket').html('������� � �������').attr('role','go_to_basket');
        this.$btn.addClass('in-basket').html('������� � �������').attr('role','go_to_basket');
      }

    }

    window.basketManager = new BasketManager();

//----------------------- SwitchHeaders -----------------------//

    function MobileBasketAjax () {
      $body = $('body');
      $("#ajax-mobile-basket").load(window.SITE_DIR + "ajax/mobile-basket/mobile-basket.php");

    }
    MobileBasketAjax();

    window.OpenModalMessage = OpenModalMessage;
    function OpenModalMessage() {
      $('.modal-block-custom').addClass('modal-block-custom_active');
      $('.success-review').addClass('modal-message_active');
    }

    window.OpenModalMessage1 = OpenModalMessage1;
    function OpenModalMessage1(title, text) {
      $('.modal-message__title').text(title);
      $('.modal-message__text').text(text);
      $('.modal-block-custom').addClass('modal-block-custom_active');
      $('.success-review').addClass('modal-message_active');
    }

    window.CloseModalMessage = CloseModalMessage;
    function CloseModalMessage() {
      $('.success-review').removeClass('modal-message_active');
      $('.modal-block-custom').removeClass('modal-block-custom_active');
    }

    $('.modal-message__close-btn').on('click', CloseModalMessage);




  });

})(window);

function getReviewForm($container) {
  $.get(window.SITE_DIR + 'ajax/forms/new-review-form.php',  function(data) {
    $container.append(data)
  });
}

function getProductReviewForm($container, sectionId) {
  $.get(window.SITE_DIR + 'ajax/forms/new-product-review-form.php?sectionId='+sectionId,  function(data) {
    $container.append(data).trigger('loaded');
  });
}

$(function(){
  var $body = $('body');

  function addToBasket(e) {
    var $btn = $(e.currentTarget);
    var $product = $btn.closest('.products__item');
    var offerId = getSelectedOffer($product);

    if (!offerId) {
      offerId = $('[name="product__offer-radio"]:checked').val();
    }

    ajaxAddToBasket(offerId, processAjax($btn));
  }

  function getSelectedOffer($product) {
    var $offer = $product.find('.products__item-offer_selected');
    return $offer.data('productid')
  }

  function ajaxAddToBasket(productId, callback) {
    if (!productId) return;

    var url = location.origin + location.pathname + '?action=ADD2BASKET&id=' + productId;
    $.ajax({
      url: url,
      type: 'POST',
      data: {
        ajax_basket: 'Y',
      },
      dataType: 'json',
    }).done(callback);
  }

  function processAjax($btn) {
    return function(json) {
      if (json.STATUS === 'OK') {
        window.dispatchEvent(new Event('addToBasket'));
        BX.onCustomEvent('OnBasketChange');
        animateBtnAdded($btn);
      } else {
        console.error(json);
      }
    }
  }

  function animateBtnAdded($btn) {
    const htmlOriginal = $btn.html();
    const classNameAdded = $btn.hasClass('product__buy-btn') ? 'product__buy-btn_added' : 'products__item-btn_added';
    const html = '<div class="products__item-btn-text">' + BX.message('ST_ADDED') + '<i class="fas fa-check"></i></div>';

    $btn.addClass(classNameAdded).html(html);

    setTimeout(function() {
      $btn.removeClass(classNameAdded).html(htmlOriginal);
      $btn = null;
    }, 2000);
  }

  $body.on('click', '.js-productBtn', addToBasket);
});

// TODO: remove from old
function getYaCounter() {
  for(var i in window){
    if(new RegExp(/yaCounter/).test(i)){
      return window[i];
    }
  }

  return false;
}
