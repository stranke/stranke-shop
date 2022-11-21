"use strict";

$(function () {
  var $stars = $(".reviews-form__rating-value .fa-star");
  var $sendReview = $('.js-sendReview');
  var inputs = $('input[required]');
  var $checkbox = $('#checkbox');
  var checkboxLabel = $checkbox;

  window.$stars = $stars;

  function sendReview(e) {
    e.preventDefault();

    var $form = $sendReview.closest("form");

    var testValid = isValidForm();

    // Double with form new-review-form.php?!!!
    if (testValid) {

      var data = $form.serialize(),
          success = function success(json) {
            if (json.status === true) {
              OpenModalMessage();
              clearFields();
            } else {
              //  вывод окна об ошибке отправке отзыва
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

  function isValidForm () {
    var testText = $('#msgReview').val();
    var testRate = $('#rating').val();
    var $errorCount = 0;

    if (testRate == 0) {
      $errorCount++;
      $('.reviews-form__rating').addClass('field-error');
    }


    if (inputs.length > 0){
      inputs.each(function () {
        var $input = $(this);

        if (($input.val().length < 1) || ($input.hasClass('phone-mask') && $input.val().length < 18) ) {
          $errorCount++;
          $input.closest('.reviews-form__input-container').addClass('field-error');
        }

        if ( $input.attr('name') == 'email') {
          var isValidEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test($input.val());

          if(!isValidEmail) {
            $input.closest('.reviews-form__input-container').addClass('field-error');
            $input.val('');
            $input.attr('placeholder', 'Некорректный email');
            $errorCounter++;
          }

        }

      });
    }


    if (testText.length < 1) {
      $errorCount++;

      $('#msgReview').closest('.reviews-form__text').addClass('field-error');
    }



    if (checkboxLabel.length > 0 && !$checkbox.prop('checked')) {
      $errorCount++;
      $checkbox.closest('label').addClass('field-error');
    }

    return $errorCount === 0;
  }

  function removeError () {
    $(this).closest('.field-error').removeClass('field-error');
  }

  function clearFields () {
    $('.reviews-form__field-control').val('');
    $('#rating').val(0);
    $stars.removeClass('good');
    $stars.addClass('bad');
    $checkbox.attr("checked", false);

  }

  /** add handlers **/

  $sendReview.on("click", sendReview);
  $('.reviews-form__field-control').on('click', removeError);
  $stars.on('click', removeError);
  $('label').on('click', function () {
    $(this).removeClass('field-error');
  })
});


var $inputPhone = $('.phone-mask');

$inputPhone.each(function (index, element) {

  vanillaTextMask.maskInput({
    inputElement: $inputPhone[index],
    mask: ['+', '7', ' ', '(', /[1-9]/, /\d/, /\d/, ')', ' ', /\d/, /\d/, /\d/, '-', /\d/, /\d/, '-', /\d/, /\d/],
  });

  $(function () {
    $stars.hover(starHover).on("click", starClick);
    $stars.mouseleave(starsMouseLeave);
  })
});

