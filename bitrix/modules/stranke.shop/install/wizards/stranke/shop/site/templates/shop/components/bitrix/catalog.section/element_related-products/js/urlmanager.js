//----------//---------- select section view mode ----------//----------//
function URLManager(inputUrl){
    this.objUrlParams = {};
    this.url = '';

    if (typeof inputUrl === 'string' && inputUrl.length) {

        this.inputUrl = inputUrl;
    } else {
        this.inputUrl = window.location.search;
    }


    this.init();
}

URLManager.prototype = {
    constructor: URLManager,

    init: function(){
        this.getUrlVar();
    },

    getValue: function(name){
        var value = false;
        for( var key in this.objUrlParams ){

            if(this.objUrlParams.hasOwnProperty(key)){

                if( key === name){
                    value = this.objUrlParams[key];
                }

            }
        }
        return value;
    },

    delValue: function(name){
        var deleted = false;
        for( var key in this.objUrlParams ){

            if(this.objUrlParams.hasOwnProperty(key)){

                if( key === name){
                    deleted = delete this.objUrlParams[key];
                }

            }
        }
        return deleted;
    },

    go: function(){
        document.location.href = this.url;
    },

    getUrlVar: function(){
        var urlVar = this.inputUrl;
        var arrayVar = urlVar.substr(1).split('&');
        var valueAndKey = [];
        var resultObject = {};

        if(!arrayVar[0].length) return;

        for(var i = 0; i < arrayVar.length; i++){
            valueAndKey = arrayVar[i].split('=');
            resultObject[valueAndKey[0]] = valueAndKey[1];
        }

        this.objUrlParams = resultObject;
    },

    setUrlVar: function(name, new_value){
        var isSet = false;
        for( var key in this.objUrlParams ){

            if(this.objUrlParams.hasOwnProperty(key)){

                if( key === name){
                    this.objUrlParams[key] = new_value;
                    isSet = true;
                }

            }
        }

        if(!isSet){
            this.objUrlParams[name] = new_value;
        }

    },

    getUrl: function(isAjax){
        isAjax = isAjax || false;
        var url = '';

        url += window.location.protocol+'//';
        url += window.location.host;

        if (isAjax) {
            url += '/ajax';
        }

        url += window.location.pathname;
        url += '?';

        var objKeys = Object.keys(this.objUrlParams);
        var i = 0;
        var objKeyLength = objKeys.length;

        for( var key in this.objUrlParams ){

            if( this.objUrlParams.hasOwnProperty(key) ){
                url += key + '=' + this.objUrlParams[key];
                if(i + 1 < objKeyLength){
                    url += '&';
                }
                i++;
            }
        }

        this.url = url;
    }

};

$(function(){
    window.URLManager = URLManager;
});