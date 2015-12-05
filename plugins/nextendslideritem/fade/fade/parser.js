(function($, scope, undefined) {
    scope.ssItemParserfade = scope.ssItemParser.extend({
        parse: function(name, data){
            var o = this._super(name, data);
            if(name === 'link'){
                var _d = data.split('|*|');
                o.url = _d[0];
                o.target = _d[1];
                delete o.size;
            }else if(name === 'imagefront' || name === 'imageback'){
                o[name] = nextendFixRelative(o[name]);
            }
            return o;
        },
        render: function(node, data){
            if(data['url'] == '#'){
                node.html(node.children('a').html());
            }
            return node;
        }
    });
})(njQuery, window);
