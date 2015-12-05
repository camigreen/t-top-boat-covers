//#|empty_when_free|#
(function($, scope, undefined) {
    scope.ssItemParseryoutube = scope.ssItemParser.extend({
        parse: function(name, data){
            var o = this._super(name, data);
            if(name === 'youtubeurl'){
                var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
                var match = data.match(regExp);
                if (match&&match[7].length==11){
                    o.code = match[7];
                }else{
                    o.code = data;
                }
                delete o.size;
            }
            return o;
        }
    });
})(njQuery, window);
