function GUIManager(){
    this.$body = $('body');

    this.init();
}

GUIManager.prototype = {
    constructor: GUIManager,

    init: function(){

        this.urlManager = new window.URLManager();
        this.bindEvents();
    },

    bindEvents: function(){
        this.$body.on('click', '.js-view-mode-btn', this.setView.bind(this) );
        this.$body.on('click', '[name="product-sort"]', this.setSort_a.bind(this) );
        this.$body.on('change', '#products-sort', this.setSort.bind(this) );
        this.$body.on('change', '#product-number-on-page', this.setCount.bind(this) );
    },

    setView: function(e){

        var view = e.target.dataset.view;

        this.urlManager.setUrlVar('view', view);
        this.urlManager.delValue('show_more');
        this.urlManager.getUrl();
        this.urlManager.go();
    },

    setSort_a: function(e){

        var view = e.target.dataset.view;

        this.urlManager.setUrlVar('sort', view);
        this.urlManager.delValue('show_more');
        this.urlManager.getUrl();
        this.urlManager.go();
    },

    setSort: function(e){
        var selectSort = e.target;
        var selectSortIndex = selectSort.options.selectedIndex;
        var selectSortValue = selectSort.options[selectSortIndex].value;

        this.urlManager.setUrlVar('sort', selectSortValue);
        this.urlManager.delValue('show_more');
        this.urlManager.getUrl();
        this.urlManager.go();
    },

    setCount: function(e){
        var selectCount = e.target;
        var selectCountIndex = selectCount.options.selectedIndex;
        var selectCountValue = selectCount.options[selectCountIndex].value;

        this.urlManager.setUrlVar('count', selectCountValue);
        this.urlManager.delValue('show_more');
        this.urlManager.getUrl();
        this.urlManager.go();
    }

};

$(function(){
    window.GUIManager = new GUIManager();
});
