(function (dojo) {
    dojo.declare("NextendElementFacebookAlbumsbyPage", NextendElement, {
        constructor: function (args) {
            dojo.mixin(this, args);
            this.hidden = dojo.byId(this.hidden);

            this.listhidden = dojo.byId(this.listhidden);

            this.form = this.hidden.form.nextendform;
            dojo.connect(this.hidden, 'change', this, 'loadAlbums');

        },

        loadAlbums: function () {
            var v = this.hidden.value.split('|*|');
            if (v[0] != this.val) {

                var d = {};

                dojo.mixin(d, {
                    nextendajax: 1,
                    mode: 'pluginmethod',
                    group: this.group,
                    method: this.method,
                    fbpage: v[0]
                });
                var xhrArgs = {
                    url: this.form.url,
                    handleAs: 'json',
                    content: d,
                    load: dojo.hitch(this, 'load'),
                    error: dojo.hitch(this, 'error')
                };
                var deferred = dojo.xhrPost(xhrArgs);
                this.val = v[0];
            }
        },
        load: function (r) {
            var select = this.listhidden.select;
            select.selectedIndex = 0;

            for (var i = select.options.length - 1; i > 0; i--) {
                select.options[i].parentNode.removeChild(select.options[i]);
            }
            for (var k in r) {
                dojo.create('option', {innerHTML: r[k], value: k}, select);
            }
        },
        error: function () {

        }
    });
})(ndojo);