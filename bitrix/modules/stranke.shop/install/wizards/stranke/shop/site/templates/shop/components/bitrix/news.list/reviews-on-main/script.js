"use strict";

$(function () {
  var $stars = $(".reviews-form__rating-value .fa-star");
  var $sendReview = $('.js-sendReview');
  var $cancelSendReview = $('.js-cancelSendReview');

  window.$stars = $stars;

  function sendReview(e) {
    e.preventDefault();

    var $form = $sendReview.closest("form");

    if (!$sendReview.hasClass('reviews-form__send-btn_disable')){

      var data = $form.serialize(),
          success = function success(json) {
            if (json.status === true) {
              $('.modal-block').removeClass('disable');
              $('.send-review-success').removeClass('disable');
            } else {
              $('.modal-block').removeClass('disable');
              $('.send-review-error').removeClass('disable');
            }
          };

      $.ajax({
        url: window.SITE_DIR + "ajax/forms/new-review.php",
        type: "post",
        data: data,
        dataType: "json",
        success: success
      });
    }
  }

  var starHover = function() {
    var index = $stars.index(this) + 1;

    $stars
      .addClass("bad")
      .slice(0, index)
      .removeClass("bad")
      .addClass("good");
  };

  window.starHover = starHover;

  var starClick = function () {
    var index = $stars.index(this) + 1;
    $("#rating").val(index).trigger('change');
    starsMouseLeave ();

  };

  window.starClick = starClick;

  var starsMouseLeave = function () {
    var rating = void 0;
    rating = $("#rating").val();
    $stars
        .slice(rating)
        .removeClass("good")
        .addClass("bad");
  };

  window.starsMouseLeave = starsMouseLeave;

  function checkup () {
    var testText = $('#msgReview').val();
    var testRate = $('#rating').val();
    var isValidForm = testText.length && testRate > 0;
    var isShowCancel = testText.length || testRate > 0;

    if (isShowCancel) {
      $cancelSendReview.removeClass('reviews-form__cancel-btn_disable');
    } else {
      $cancelSendReview.addClass('reviews-form__cancel-btn_disable');
    }

    if (isValidForm) {
      $sendReview.removeClass('reviews-form__send-btn_disable');
    } else {
      $sendReview.addClass('reviews-form__send-btn_disable');
    }
  }

  function onClickCancel () {
    $('#msgReview').val('').trigger('input');
    $('#rating').val(0).trigger('change');
  }



  function closeModalBlockSendReview () {
    $(this).closest('.modal-block__send-review').addClass('disable');
    $('.modal-block').addClass('disable');
  }

  /** add handlers **/

  $sendReview.on("click", sendReview);

  $('#msgReview').on('input',checkup);

  $('#rating').on('change', checkup);

  $cancelSendReview.on('click', onClickCancel);

  $('.js-notificationOkBtn').on('click', closeModalBlockSendReview);
});
