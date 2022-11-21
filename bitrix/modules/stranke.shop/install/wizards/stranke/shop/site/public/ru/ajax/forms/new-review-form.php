<?php
require $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php';
global $USER;
?>


<form class="reviews-form">
    <input type="hidden" class="reviews-form__field-control" name="section-id" id="section-id" value="428">

    <div class="reviews-form__title"><?=GetMessage('ST_NEW_REVIEW_FORM_TITLE')?></div>

    <div class="reviews-form__content">
        <div class="reviews-form__fields reviews-form__fields_left">
            <div class="reviews-form__rating">
                <input type="hidden" class="reviews-form__field-control" name="rating" id="rating" value="0">

                <div class="reviews-form__text-title"><?=GetMessage('ST_NEW_REVIEW_FORM_RATE')?>*</div>
                <div class="reviews-form__rating-value">
                    <i class="star" data-rate="1"></i>
                    <i class="star" data-rate="2"></i>
                    <i class="star" data-rate="3"></i>
                    <i class="star" data-rate="4"></i>
                    <i class="star" data-rate="5"></i>
                </div>
            </div>

            <?if (!$USER->IsAuthorized()):?>
                <div class="reviews-form__input-container">
                    <div class="reviews-form__text-title"><?=GetMessage('ST_NEW_REVIEW_FORM_NAME')?>*</div>
                    <input type="text" id="name" name="name" class="reviews-form__field-control" required placeholder="<?=GetMessage('ST_NEW_REVIEW_FORM_NAME')?>">
                </div>

                <div class="reviews-form__input-container">
                    <div class="reviews-form__text-title"><?=GetMessage('ST_NEW_REVIEW_FORM_PHONE')?></div>
                    <input type="text" id="phone" name="phone" class="reviews-form__field-control phone-mask" required placeholder="+7 (___) ___-__-__">
                </div>
            <?endif?>
        </div>

        <div class="reviews-form__fields reviews-form__fields_right">
            <div class="reviews-form__text">
                <div class="reviews-form__text-title"><?=GetMessage('ST_NEW_REVIEW_FORM_REVIEW')?>*</div>
                <textarea name="msg" id="msgReview" class="reviews-form__field-control" placeholder="<?=GetMessage('ST_NEW_REVIEW_FORM_REVIEW_PLACEHOLDER')?>"></textarea>
            </div>

            <?if (!$USER->IsAuthorized()):?>
                <div class="reviews-form__input-container reviews-form__input-container_privacy-policy">
                    <label class="reviews-form__privacy-policy">
                        <input id="checkbox" type="checkbox" style="display: none">
                        <span class="form__checkbox-icon">
                                <i class="fas fa-check"></i>
                            </span>
                        <?=GetMessage('ST_NEW_REVIEW_FORM_ACCEPT')?><a href="<?=SITE_DIR?>privacy_policy/"><?=GetMessage('ST_NEW_REVIEW_FORM_POLICY')?></a>
                    </label>
                </div>
            <?endif?>

            <div class="reviews-form__control-btns js-reviewControlBtns">
                <button type="submit" class="reviews-form__send-btn js-sendReview"><?=GetMessage('ST_NEW_REVIEW_FORM_SEND')?></button>
            </div>
        </div>


    </div>
</form>

<script>

    BX.message({WRONG_EMAIL:'<?=GetMessage("ST_NEW_REVIEW_FORM_WRONG_EMAIL")?>'});

    $(function () {
    var $stars = $(".reviews-form__rating-value .star");
    var $sendReview = $('.js-sendReview');
    var inputs = $('input[required]');
    var $checkbox = $('#checkbox');
    var checkboxLabel = $checkbox;

    window.$stars = $stars;

    function sendReview(e) {
      e.preventDefault();

      var $form = $sendReview.closest("form");

      var testValid = isValidForm();

      if (testValid) {

        var data = $form.serialize(),
            success = function success(json) {
              if (json.status === true) {
                OpenModalMessage();
                clearFields();

                BX.onCustomEvent('target', [{
                  type: 'submit',
                  result: 'success',
                  element: 'form-review'
                }]);
              } else {
                //  вывод окна об ошибке отправке отзыва
              }
            };

        $.ajax({
          url: "<?=SITE_DIR?>ajax/forms/new-review.php",
          type: "post",
          data: data,
          dataType: "json",
          success: success
        });
      }
    }

    var starHover = function() {
      var index = $stars.index(this) + 1;

      $stars.slice(0, index).addClass("star_active");
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
          .removeClass("star_active");
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
              $input.attr('placeholder', BX.message('WRONG_EMAIL'));
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
      $('.reviews-form__rating').removeClass('field-error');
      $('textarea.reviews-form__field-control').val('');
      $('#rating').val(0);
      $('.reviews-form__rating-value i').removeClass('star_active');
      $stars.removeClass('star_active');
      $checkbox.attr("checked", false);
    }

    /** add handlers **/

    $stars.hover(starHover).on("click", starClick);
    $stars.mouseleave(starsMouseLeave);

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
  });

  $(function () {
    $stars.hover(starHover).on("click", starClick);
    $stars.mouseleave(starsMouseLeave);
  })

</script>
