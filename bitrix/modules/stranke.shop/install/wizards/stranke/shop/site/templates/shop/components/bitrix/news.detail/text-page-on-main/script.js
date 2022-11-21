
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
