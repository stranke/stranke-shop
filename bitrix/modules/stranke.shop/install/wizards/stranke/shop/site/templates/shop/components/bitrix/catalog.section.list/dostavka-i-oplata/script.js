function balancer() {

  var $arContainers = $('.dostavka-i-oplata__text-list');
  var maxheight = 0;

  if($(window).width() > 1587) {
    $arContainers.each(function (index, value) {
      $(value).css("minHeight", "");
    });

    $arContainers.each(function (index, value) {

      if (maxheight < $(value).height()) {
        maxheight = $(value).height();
      }
    });

    $arContainers.each(function (index, value) {
      $(value).css("minHeight", maxheight + "px");
    });

  } else {
    $arContainers.each(function (index, value) {
      $(value).css("minHeight", "");
    });

  }
}


(function (window) {
  var $ = jQuery;

  $(document).ready(function () {

    var $body = $('body');
//----------//---------- Banner Height ----------//----------//

    balancer();
    $(window).resize(balancer);

  });
})(window);