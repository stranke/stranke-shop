(function(window){

  $(document).ready(function(){

    var $body = $('body');


    function openPhotoSwipe(e) {
      var $imgCurrent = $(e.currentTarget).find('img');
      var $imgList = $('.js-photo-swipe-btn img');
      var index = $imgList.index($imgCurrent);

      var pswpElement = document.querySelectorAll('.pswp')[0];

      var items = [];

      $imgList.each(function () {
        var $img = $(this);
        items.push({
          src: $img.data('originalsrc'),
          w: $img.data('originalwidth'),
          h: $img.data('originalheight'),
          i:index
        });
      });

      var options = {
        index: index,
        bgOpacity: 0.6,
        closeOnScroll: false,
        closeOnVerticalDrag: false,
        pinchToClose: false,
        shareEl: false,
        fullscreenEl: false,
        getDoubleTapZoom: function getDoubleTapZoom(isMouseClick, item) {
          return 1.75;
        }

      };

      var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
      gallery.init();
    }

    $body.on("click", ".js-photo-swipe-btn", openPhotoSwipe);


  });

})(window);
