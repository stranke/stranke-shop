$(function(){
    var $body = $('body');
    var $productListSections = $('.filters-block__filter-list');

    if (!($productListSections.length > 0)) {
        return;
    }

    var height = $productListSections[0].clientHeight;
    var scrollHeight = $productListSections[0].scrollHeight;
    var $showMore = $productListSections.find('.filters-block__show-btn');

    if(scrollHeight > height){
        $showMore.toggleClass('hidden');
    }

});