function SearchTitle(form){
  this.$searchForm = form;

  this.init();
}

SearchTitle.prototype = {
  constructor: SearchTitle,

  init: function(){
    this.$input = this.$searchForm.find('.search_field');
    this.$placeHolder = this.$searchForm.find('.placeholder');
    var _this = this;
      this.$searchForm.find('.search-btn__icon').on('click',function(){
          _this.$searchForm.submit();
      })
    this.bindEvents();
  },

  bindEvents: function () {
    // this.$searchForm.on('mouseover',this.hidePlaceholder.bind(this));
    // this.$searchForm.on('mouseleave',this.showPlaceholder.bind(this));
      this.$input.on('change', this.inputOnChange.bind(this));
  },

  inputOnChange: function(){
    var val = this.$input.val().trim();

    if(val.length > 0){
        this.$placeHolder.hide();
    }else{
        this.$placeHolder.show();
    }

  },

  hidePlaceholder: function(){
    this.$placeHolder.hide();
  },

  showPlaceholder: function(){

    this.$placeHolder.show();
  }

};
