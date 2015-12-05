(function (dojo) {
    dojo.declare("NextendElementFacebookToken", NextendElement, {
        constructor: function (args) {
            dojo.mixin(this, args);
            this.hidden = dojo.byId(this.hidden);
            this.link = dojo.byId(this.link);
            this.callback = dojo.byId(this.callback);

            this.api_key = dojo.byId('settingsapikey');
            this.api_secret = dojo.byId('settingsapisecret');

            this.form = this.hidden.form.nextendform;
            this.url = this.form.url + (this.form.url.match(/\?/) ? '&' : '?') + 'nextendajax=1&mode=auth&folder=' + this.folder;

            this.callback.innerHTML = 'Calback url: ' + location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '');

            dojo.connect(this.link, 'click', this, 'startAuth');
        },

        startAuth: function () {
            window.setToken = dojo.hitch(this, 'setToken');
            this.window = window.open(this.url + '&api_key=' + this.api_key.value + '&api_secret=' + this.api_secret.value +
                '&redirect_uri=' + encodeURIComponent(this.url),
                'facebookApi',
                'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1060,height=950');
        },

        setToken: function (value) {
            this.hidden.value = value;
            if (this.window) this.window.close();
        }
    });
})(ndojo);