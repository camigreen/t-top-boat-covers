(function($, scope, undefined) {
    scope.ssItemParseriframe = scope.ssItemParser.extend({
        parse: function(name, data){
            var o = this._super(name, data);
            if(name === 'size'){
                var _d = data.split('|*|');
                o.width = _d[0];
                o.height = _d[1];
                delete o.size;
            }
            return o;
        }
    });
})(njQuery, window);
