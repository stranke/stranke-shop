function Settings($settings) {
  this.$settings = $settings;
  this.$form = $settings.find('form');
  this.colorPickers = [];
  this.$pickrPreset = $settings.find('.pickr_preset');
  this.$tabs = $settings.find('.settings__tab');

  this.hexDigits = [
    "0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f"
  ];

  this.init();
}

Settings.prototype = {
  init: function () {
    this.$body = $('body');

    this.initPickr();
    this.initSwichery();
    this.bindEvents();
  },

  initPickr: function () {
    var options = {
      el: '.color-picker',
      default: '#000000',

      components: {

        // Main components
        preview: false,
        opacity: false,
        hue: true,

        // Input / output Options
        interaction: {
          hex: false,
          rgba: false,
          hsla: false,
          hsva: false,
          cmyk: false,
          input: true,
          clear: false,
          save: true
        }
      },
      strings: {
        save: BX.message('ST_SETTINGS_SELECT'),
      }
    };

    $('.color-picker').each(function(index, element) {
      options.el = element;

      if (!!element.dataset.default) {
        options.default = element.dataset.default;
      }

      var pickr = Pickr.create(options);
      this.colorPickers.push(pickr);
    }.bind(this));

  },

  initSwichery: function() {
    var elems = document.querySelectorAll('.js-switch');
    for (var i = 0; i < elems.length; i++) {
      new Switchery(elems[i]);
    }
  },

  bindEvents() {
    // this.$form.on('submit', this.saveSettings.bind(this));
    this.$pickrPreset.on('click', '.pcr-button', this.changeColorMain.bind(this));
    this.$tabs.on('click', this.onChangeTab.bind(this));
    this.$body.on('click', '.js-addFieldControl', this.addFieldControl.bind(this));

    for (var i = 0; i < this.colorPickers.length; i++) {
      var colorPicker = this.colorPickers[i];
      colorPicker.on('change', this.onChangePickr.bind(this));
    }
  },

  onChangePickr: function (color, instance) {
    var hex = color.toHEX().toString();
    var root = instance.getRoot().root;
    var $fieldControl = $(root).closest('.settings__field-control');
    var $input = $fieldControl.find('> input');
    this.changeColor($input, hex);
  },

  changeColorMain: function (e) {
    var $button = $(e.currentTarget);
    var computedStyle = getComputedStyle(e.currentTarget);
    var hex = this.rgb2hex(computedStyle.color);
    var $fieldControl = $(e.currentTarget).closest('.settings__field-control');
    var $input = $fieldControl.find('> input');
    this.changeColor($input, hex);
    $button.addClass('pcr-button_active').siblings().removeClass('pcr-button_active');
  },

  changeColor: function($input, hex) {
    var colorname = '';

    switch ($input.attr('name')) {
      case 'PROP[COLOR_MAIN]':
        colorname = '--color-main';
        break;
      case 'PROP[COLOR_TOP_MENU]':
        colorname = '--color-top-menu';
        break;
      case 'PROP[ALERT_BANNER_BG_COLOR]':
        colorname = '--color-banner-bg';
        break;
        case 'PROP[ALERT_BANNER_TEXT_COLOR]':
            colorname = '--color-banner-text';
            break;
    }

    document.querySelector('html').style.setProperty(colorname, hex);
    $input.val(hex);
  },

  rgb2hex: function (rgb) {
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    return "#" + this.hex(rgb[1]) + this.hex(rgb[2]) + this.hex(rgb[3]);
  },

  hex: function (x) {
    return isNaN(x) ? "00" : this.hexDigits[(x - x % 16) / 16] + this.hexDigits[x % 16];
  },

  saveSettings: function (e) {
    e.preventDefault();
    var data = this.$form.serialize();

    $.ajax({
      url: location.path,
      type: 'POST',
      data: data,
      dataType: 'json',
      success: this.saveSettingsSuccess.bind(this),
    })
  },

  saveSettingsSuccess: function (response) {
    if (response.success) {
      // location.reload();
    } else {
      console.error(response.errors);
    }
  },

  onChangeTab: function(e) {
    var $tab = $(e.currentTarget);
    var tabName = $tab.data('tab');
    var $tabContent = this.$settings.find('.settings__tab-content[data-tab="'+tabName+'"]');

    $tab.addClass('settings__tab_active')
      .siblings()
      .removeClass('settings__tab_active');

    $tabContent.addClass('settings__tab-content_active')
      .siblings()
      .removeClass('settings__tab-content_active');
  },

  addFieldControl: function(e) {
    var $fieldControl = $(e.currentTarget).parent();
    var $prevFieldControl = $fieldControl.prev();
    var $newFieldControl = $prevFieldControl.clone();
    $newFieldControl.find('input').val('');
    $fieldControl.before($newFieldControl);
  },
};

$(function () {
  new Settings($('.settings'));
});
