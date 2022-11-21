//toggle form
function ToggleForm(){
  this.init();
}

ToggleForm.prototype = {
  constructor: ToggleForm,

  init: function(){
    this.hiddenClass = "lk-profile__hidden";
    this.$body = $('body');
    this.$lkProfile = this.$body.find('.lk-profile');
    this.$mainForm = this.$lkProfile.find('.lk-profile__main-form');
    this.$inputUserType = this.$mainForm.find('[name="UF_USER_TYPE"]');
    this.$arForm = this.$mainForm.find('form');
    this.$userTypeBlock = this.$lkProfile.find('.lk-profile__user-type-block');
    this.$arRadio = this.$userTypeBlock.find('.lk-profile__field-radio input');

    this.sessid = this.$mainForm.find('#sessid').val();
    this.subscribeEmail = this.$mainForm.find('[name="SENDER_SUBSCRIBE_EMAIL"]').val();

    this.$arSubscribes = this.$mainForm.find('.lk-profile__subscription-field input');

    this.showForm();
    this.bindEvents();
  },

  bindEvents: function(){

    this.$arRadio.on('change', this.toggleForm.bind(this));
    this.$arSubscribes.on('change', this.toggleSubscribe.bind(this));

  },

  toggleSubscribe: function(e){

    var val = e.target.value;
    var chk = e.target.checked;
    var $checkBoxes = this.$mainForm.find('input[value="'+val+'"]');
    $checkBoxes.each(function(index, value){
      $checkBoxes[index].checked = chk;
    });
    var _this = this;
    var data = {
      "id": val,
      "checked": chk
    };

    $.ajax({
      url: window.SITE_DIR + "ajax/lk/subscribe.php",
      method: "POST",
      dataType: "json",
      data: data
    }).done(function(json){
      console.log(json)
    });
  },

  toggleForm: function(e){
    var _this = this;

    var formName = e.target.value;
    var $form = _this.$mainForm.find('form[name="'+formName+'"]');

    _this.$inputUserType.val(formName);
    _this.$arForm.addClass(_this.hiddenClass);

    $form.removeClass(_this.hiddenClass);

  },
  
  showForm: function(){
    var _this = this;

    _this.$arRadio.each(function (index, value) {

      var checked = _this.$arRadio[index].checked;
      var formName = _this.$arRadio[index].value;
      var $form = _this.$mainForm.find('form[name="'+formName+'"]');

      if(checked){
        $form.removeClass(_this.hiddenClass);
      }else{
        $form.addClass(_this.hiddenClass);
      }

    });
  }
  
};

/** popup **/
function PopupManager(){

  this.init();
}

PopupManager.prototype = {

  constructor: PopupManager,

  init: function(){
    this.$body = $('body');
    this.visibleClassName = "popup-message_visible";
    this.showpopup = window.showpopup;

    this.modalFormOk = $('' +
      '<div class="popup-message popup-message_visible">' +
      '<div class="popup-message__bg "></div>' +
      '<div class="popup-message__container">' +
      '<div class="popup-message__content">' +
      '<div class="popup-message__close-btn" role="popup-message-close">' +
      '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 20 20" > <defs> <path id="8qi9a" d="M1167.13 171.26l-1.37 1.36-3.5-3.5-3.52 3.5-1.36-1.36 3.5-3.51-3.5-3.51 1.36-1.37 3.51 3.51 3.51-3.5 1.37 1.36-3.51 3.5zm-4.88-13.26a9.78 9.78 0 0 0-9.75 9.75 9.78 9.78 0 0 0 9.75 9.75 9.78 9.78 0 0 0 9.75-9.75 9.78 9.78 0 0 0-9.75-9.75z"/> </defs> <g> <g transform="translate(-1152 -158)"> <use fill="#95989a" xlink:href="#8qi9a"/> </g> </g> </svg> ' +
      '</div> ' +
      '<div class="popup-message__title"></div> ' +
      '<div class="popup-message__text"></div> ' +
      '<div class="popup-message__img">' +
      '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100" viewBox="0 0 100 100" > <defs> <path id="pdbva" d="M909 358a50 50 0 1 1 100 0 50 50 0 0 1-100 0z"/> <path id="pdbvc" d="M977.25 346.41L955 368.38l-10.2-10.28-1.8 1.84 9 9 3 3 3-3 21-21z"/> <clipPath id="pdbvb"><use fill="#fff" xlink:href="#pdbva"/></clipPath> </defs> <g> <g transform="translate(-909 -308)"> <use fill="#fff" fill-opacity="0" stroke="#80c18b" stroke-miterlimit="50" stroke-width="2" clip-path="url(&quot;#pdbvb&quot;)" xlink:href="#pdbva"/> </g> <g transform="translate(-909 -308)"><use fill="#80c18b" xlink:href="#pdbvc"/></g> </g> </svg> ' +
      '</div> ' +
      '</div> ' +
      '</div> ' +
      '</div>');

    if( this.showpopup === "changed"){
      this.showPopupChanged();
    }

  },

  showPopupChanged: function(){
    this.$body.append(this.modalFormOk);
    this.modalFormOk.find('.popup-message__title').text(BX.message('ST_PROFILE_MANAGE_DATA_CHANGED'));
    this.modalFormOk.find('.popup-message__text').html("");
    var $popupClose = this.modalFormOk.find('[role="popup-message-close"]');
    $popupClose.on('click', this.closePopup.bind(this));
  },

  setErrorDescription: function($block, description){
    var $desc = $block.find('.form-block__error-text');
    if($desc.length <= 0){
      $desc = $('<div class="form-block__error-text"></div>');
      $block.append($desc);
    }
    $desc.html(description);
  },

  clearError: function(e){
    var $input = $(e.target);
    var $formField = $input.closest('.form-block__field');
    $formField.removeClass(this.errorClassName);
    $input.off('click');
  },

  showError: function(error){
    var $input = $('[name="' + error.name + '"]');
    var $block = $input.closest('.form-block__field');
    $block.addClass(this.errorClassName);
    this.setErrorDescription($block, error.description);
    $input.on("click", this.clearError.bind(this));
  },

  closePopup: function(){
    this.modalFormOk.removeClass(this.visibleClassName);
  },

  errorRender: function(){
    return function(json){

      if(!json.status){
        var count = json.errors.length;
        for(var i=0;i<count; i++){
          var error = json.errors[i];
          this.showError(error);
        }
      } else {

        this.$body.append(this.modalFormOk);
        var $popupClose = this.modalFormOk.find('[role="popup-message-close"]');
        $popupClose.on('click', this.closePopup.bind(this));
        setTimeout(function(){document.location.reload();}, 3000);

        yaCounter20728162.reachGoal('FORMA_VOSTAN');

      }
    }.bind(this);
  },

  formCheck: function(e){
    e.preventDefault();

    this.$form.find('[name="AUTH_FORM"]').remove();
    this.$form.find('[name="TYPE"]').remove();
    var data = this.$form.serialize();

    $.ajax({
      url: window.SITE_DIR + 'ajax/lk/reg.php',
      type: 'POST',
      data: data,
      dataType: 'json'
    }).done(this.errorRender());

  }


};


$(document).ready(function () {

  function triggerClick(e) {
    $('form#add-photo-form').trigger('click');
  }

  function delPhoto(){
    var data = {
      "DEL": "Y"
    };

    $.ajax({
      url: window.SITE_DIR + "ajax/lk/del_photo.php",
      data: data,
      dataType: "json",
      type: "POST"
    }).done(function(){
      window.myDropzone.removeAllFiles();
      $('.dz-foto-stub').remove();
      $('.lk-profile__del-photo-btn').remove();
    });
  }

  var $body = $('body');
  $body.on('click', '.lk-profile__add-photo-btn', triggerClick);
  $body.on('click', '.lk-profile__photo-block .dz-preview', triggerClick);
  $body.on('click', '.lk-profile__del-photo-btn', delPhoto);

  //подключаем dropzone
  window.myDropzone = new Dropzone("form#add-photo-form", { url: window.SITE_DIR + "ajax/lk/set_photo.php" });
  window.myDropzone.on("addedfile", function(file) {
    var $photoBlock = $('.lk-profile__photo-block');
    var isDelBtn = ($('.lk-profile__del-photo-btn').length > 0)? $('.lk-profile__del-photo-btn'): false;

    if( isDelBtn === false){
      var $delBtn = $(
        '<div class="lk-profile__del-photo-btn">' + BX.message('ST_PROFILE_PHOTO_DEL') + '</div>'
      );
      $photoBlock.append($delBtn);
    }

  });

  //подключаем datetimepicker
  flatpickr("input[name='PERSONAL_BIRTHDAY']", {
    "locale":  "ru",
    dateFormat: "d.m.Y"
  });

  //popup
  var popupManager = new PopupManager();

});