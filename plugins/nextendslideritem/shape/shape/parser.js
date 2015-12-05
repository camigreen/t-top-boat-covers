(function ($, scope, undefined) {
    scope.ssItemParsershape = scope.ssItemParser.extend({
        parse: function (name, data) {
            var o = this._super(name, data);
            if (name === 'size') {
                var _d = data.split('|*|');
                o.width = _d[0];
                o.height = _d[1];
                delete o.size;
                o.uuuid = njQuery.fn.uid();
            } else if (name === 'color') {
                var _d = data;
                o.colora = hex2rgba(_d);
                o.colorhex = _d.substr(0, 6);
                delete o.size;
            }
            return o;

            function hex2rgba(hex) {
                var r = hexdec(hex.substr(0, 2));
                var g = hexdec(hex.substr(2, 2));
                var b = hexdec(hex.substr(4, 2));
                var a = (intval(hexdec(hex.substr(6, 2)))) / 255;
                a = a.toFixed(3);
                var color = r + "," + g + "," + b + "," + a;
                return color;
            }

            function hexdec(hex_string) {
                hex_string = (hex_string + '').replace(/[^a-f0-9]/gi, '');
                return parseInt(hex_string, 16);
            }

            function intval(mixed_var, base) {
                var tmp;
                var type = typeof(mixed_var);
                if (type === 'boolean') {
                    return +mixed_var;
                } else if (type === 'string') {
                    tmp = parseInt(mixed_var, base || 10);
                    return (isNaN(tmp) || !isFinite(tmp)) ? 0 : tmp;
                } else if (type === 'number' && isFinite(mixed_var)) {
                    return mixed_var | 0;
                } else {
                    return 0;
                }
            }
        }
    });
})(njQuery, window);
