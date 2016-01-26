// the semi-colon before function invocation is a safety net against concatenated
// scripts and/or other plugins which may not be closed properly.
;
(function ($, window, document, undefined) {

    // undefined is used here as the undefined global variable in ECMAScript 3 is
    // mutable (ie. it can be changed by someone else). undefined isn't really being
    // passed in so we can ensure the value of it is truly undefined. In ES5, undefined
    // can no longer be modified.

    // window and document are passed through as local variable rather than global
    // as this (slightly) quickens the resolution process and can be more efficiently
    // minified (especially when both are regularly referenced in your plugin).


    // The actual plugin constructor
    var StoreItem = function (element, options) {
        this.$element = $(element);
        this.defaults = {
            validate: true,
            debug: true,
            events: {}
        };
        this.settings = $.extend(true, this.defaults, options);
        // Initialize the Plugin
        this.name = options.name;
        this.confirm = {
            elem: null,
            status: false,
            modal: null,
            button: null,
            cancel: null,
            id: null
        };
        this.items = {};
        this.total = 0;
        this.$atc = this.$element.find('.atc');
        this.$qty = this.$element.find('.qty');
        this.init();

        
//         Set the event handlers
        this.$atc.on('click', $.proxy(this, 'addToCart'));
        this.$qty.on('change', $.proxy(this, '_updateQuantity'));
        this.$element.on('input','.item-option:not(select)', $.proxy(this, 'trigger', 'onChanged'));
        this.$element.on('change','select.item-option', $.proxy(this, 'trigger', 'onChanged'));
        this.$element.on('refresh',$.proxy(this, '_refresh'));
        this.trigger('onComplete');

    };

    StoreItem.prototype = {
        fields: {},
        cart: {
            validated: false,
            items: {},
            id: null,
            confirmed: false
        },
        validation: {
            status: null,
            message: null,
            messageData: {
                    message : '<span>Please complete the fields in red!</span><i class="uk-icon-arrow-down uk-margin-left" />',
                    status  : 'danger',
                    timeout : 0,
                    pos     : 'top-center'
            },
            sendMessage: function () {
                if (!this.message) {
                    this.message = UIkit.notify(this.messageData);
                }
                    
            },
            closeMessage: function () {
                if(this.message) {
                    this.message.close();
                    this.message = null;
                }
            }
        },
        init: function () {
            this.loadItems();
            this.$element.find('#price').remove();
            this._createConfirmModal();
            //this._publishPrice();
            this.trigger('onInit');
            
        },
        loadItems: function() {
            var elems = this.$element.find('.storeItem'), self = this;
            $.each(elems, function(k, v) {
                var elem = $(v);
                var id = elem.prop('id');
                var items = elem.data('item');
                $.each(items, function(key, item) {
                    self.items[id] = item;
                    console.log(item.name + ' Added.');
                }); 
            });
            
            this._getFields();
            this._getOptions();
            // console.log(attributes);
            // this.items[attributes.id] = {};
            
            console.log(this.items);
        },
        setMarkup: function(args) {
            var id = args[0];
            var markup = args[1];
            this.items[id].markup = markup;
        },
        _createConfirmModal: function () {
            this.confirm.elem = this.$element.find('#confirm-modal');
            this.confirm.button = this.confirm.elem.find('button.confirm');
            this.confirm.cancel = this.confirm.elem.find('button.cancel');
            this.confirm.modal = $.UIkit.modal(this.confirm.elem);
            this.confirm.modal.options.bgclose = false;
            this.confirm.button.on('click', $.proxy(this, '_confirm'));
            this.confirm.cancel.on('click', $.proxy(this, '_clearConfirm'));
        },
        getEvents: function (id, type) {
            
            var self = this, events = [];
            if (typeof this._events[id] !== 'undefined') {
                $.each(self._events[id], function(k,v) {
                        events.push(v);
                });
            }
            if (typeof this.settings.events[id] !== 'undefined') {
                $.each(self.settings.events[id], function(k,v) {
                        events.push(v);
                });
                
            }
            if (typeof type !== 'undefined' && typeof this.settings.events[type] !== 'undefined' && typeof this.settings.events[type][id] !== 'undefined') {
                $.each(self.settings.events[type][id], function(k,v) {
                        events.push(v);
                });
                
            }
            return events;
        },
        _events: {
            onInit: [
                function () {
                    this._debug('StoreItem Plugin Initialized.', false);
                }
            ],
            beforeAddToCart: [
                function (e, args) {
                    this._debug('beforeAddToCart Callback');
                    return args[0];
                }
            ],
            afterAddToCart: [
                function (e, args) {
                    this._clearConfirm();
                    this.$qty.val(1);
                    this.validation.status = null;
                }
            ],
            onChanged: [
                function (e) {
                    this._debug('onChanged Callback', true);
                    this._refresh(e);
                    //this._debug(this.item.name + ' StoreItem Plugin Change Detected.');
                    this._debug('Field {' + $(e.target).prop("name") + '} changed to ' + $(e.target).val() + '.');
                }            
            ],
            onComplete: [
                function () {
                    this._debug('StoreItem Plugin Complete.', true);
                }
            ],
            validate: [
                function (e, args) {
                    if (!this.settings.validate) {
                        return 'break';
                    }
                    return true;
                },
                function (e, args) {
                    var self = this, validated = true, id = args[0];
                    console.log(id);
                    self.$element.find('.validation-fail').removeClass('validation-fail');
                    var fields = typeof this.fields[id] === 'undefined' ? {} : this.fields[id];
                    $.each(fields, function (k, v) {
                        if($(this).hasClass('required') && ($(this).val() === 'X' || $(this).val() === '')) {
                            $(this).addClass('validation-fail');
                            self._debug($(this).prop('name') + 'Failed Validation');
                            validated = false;
                            
                        }; 
                    });
                    return validated;
                }
                
            ],
            validation_pass: [
                function () {
                    this._debug('Validation Passed!');
                    this.validation.status = 'passed';
                    this.validation.closeMessage();
                }
            ],
            validation_fail: [
                function () {
                    this._debug('Validation Failed!');
                    this.validation.status = 'failed';
                    this.validation.sendMessage();
                }
            ],
            confirmation: [
                function (e, args) {
                    var result = false;
                    $.each(args[0], function(key, item){
                        result = item.confirm;
                    });
                    console.log(result);
                    this._debug('Starting Confirmation');
                    if (!result) {
                        return 'break';
                    }


                    if (this.cart.confirmed === false) {
                        
                            var self = this, container;
                            var items = args[0];
                            $.each(items, function(k,item) {
                                var title = typeof item.title === 'undefined' ? item.name : item.title;
                                container = $('<div id="'+item.id+'" class="uk-width-1-1"></div>').append('<div class="item-name uk-width-1-1 uk-margin-top uk-text-large">'+title+'</div>').append('<div class="item-options uk-width-1-1 uk-margin-top"><table class="uk-width-1-1"></table></div>');
                                
                                $.each(item.options, function(k, option){
                                    if (typeof option.visible === 'undefined' || option.visible) {
                                        container.find('.item-options table').append('<tr><td class="item-options-name">'+option.name+'</td><td class="item-options-text">'+option.text+'</td></tr>');
                                    }
                                });
                                
                            self.confirm.elem.find('.item').append(container);
                            
                            });
                            this.confirm.modal.show();
                            return false;
                    }
                    return true;
                }
            ],
            onPublishPrice: [
                function(e, args){
                    return args[0];
                }
            ]
        },
        trigger: function (event, e) {
            var self = this, args = Array.prototype.slice.call(arguments, 2);
            if(typeof e === 'object') {
                var id = $(e.target).closest('.storeItem').prop('id');
                console.log(id);
                var type = this.items[id].type; 
            }
                    
            var events = this.getEvents(event, type);
            console.log(events);
            var result = true;
            $.each(events, function (k, v) {
                self._debug('Starting ' + event + ' ['+k+']');
                result = v.call(self,e,args);
                if (result === 'break') {
                    self._debug('Breaking from '+event+' event.');
                    result = true;
                    return false;
                }
                if(result === false) {
                    self._debug('Trigger is returning false from '+event+' event.');
                }
                if(result === true) {
                    self._debug('Trigger is returning true from '+event+' event.');
                }
                self._debug(event + ' Complete. ['+k+']');
            });
            return result;
        },
        addToCart: function (e) {
            if(!this.cart.id) {
                this.cart.id = $(e.target).data('item');
            }
            var self = this;

            if(!this.cart.validated) {
                if (!this.trigger('validate', e, this.cart.id)) {
                    this.trigger('validation_fail', e);
                    this.clearCart();
                    return;
                }
                this.cart.validated = true;
                this.trigger('validation_pass', e);
            }
            

            // Get the item
            this.cart.items[this.cart.id] = this.items[this.cart.id];

            // trigger beforeAddToCart
            this.cart.items = this.trigger('beforeAddToCart', e, this.cart.items);
            if (!this.cart.items) {
                return;
            }

            // Trigger the confirmation.
            if(!this.cart.confirmed) {
                if (!this.trigger('confirmation', e, this.cart.items)) {
                    return;
                }
            }
            $('body').ShoppingCart('addToCart', this.cart.items);
            this.clearCart();
            this.trigger('afterAddToCart', e, this.cart);
        },
        clearCart: function() {
            this.cart.id = null;
            this.cart.items = {};
            this.cart.validated = false;
            this.cart.confirmed = false;
        },
        getItem: function(id) {
            return this.items[id];
        },
        _confirm: function() {
            var modal = this.confirm.elem;
            var accept = modal.find('[name="accept"]');
            var error = modal.find('.confirm-error');
            if (accept.val().toLowerCase() === 'yes') {
                this.confirm.status = true;
                modal.hide();
                this.cart.confirmed = true;
                this.$element.find('.atc[data-item="'+this.cart.id+'"]').trigger('click');
            } else {
                error.html('You must type "yes" or press cancel.');            
            }
        },
        _clearConfirm: function() {
            var modal = this.confirm.elem;
            var accept = modal.find('[name="accept"]');
            var error = modal.find('.confirm-error');
            
            this.confirm.status = false;
            modal.find('.item-name').html('');
            modal.find('.item-options').html('');
            accept.val('');
            error.html('');
            this.confirm.modal.hide();
            this.clearCart();
        },
        _cartItemID: function () {
            return $.md5(JSON.stringify(this.item));
        },
        _getPricing: function() {
            var pricing = {}, options = '';
            var opts = this._getOptions();
            var attributes = this._getAttributes();
            pricing.group = this.settings.pricePoints.group;
            var markup = $('input[name="markup"]').val();
            $.each(this.settings.pricePoints.options, function(k,v) {
                if($.type(opts[v]) !== 'undefined') {
                    options += '.'+opts[v].value;
                    return false;
                }
                if($.type(attributes[v]) !== 'undefined') {
                    options += '.'+attributes[v].value;
                    return false;
                }
            });
            pricing.group += options;
            pricing.markup = markup;
            return pricing;
        },
        _publishPrice: function (e) {
            if(typeof e === 'object') {
                var id = $(e.target).closest('.storeItem').prop('id');
            } else {
                var id = e;
            }
            console.log(e);
            var item = this.items[id];
            this._debug('Publishing Price');
            var self = this;
            //var pricing = this._getPricing();
            $.ajax({
                type: 'POST',
                url: "?option=com_zoo&controller=store&task=getPrice&format=json",
                data: {item: item},
                success: function(data){
                    var elem = $('#'+id+'-price span');
                    price = self.trigger('onPublishPrice', e, data.price);
                    console.log(elem);
                    elem.html(price.toFixed(2));
                },
                error: function(data, status, error) {
                    var elem = $('#'+id+'-price span');
                    elem.html('ERROR');
                    self._debug('Error');
                    self._debug(status);
                    self._debug(error);
                },
                dataType: 'json'
            });

            
        },
        _getOptionValue: function (key, name) {
            return this.items[key].options[name].value;
        },
        _getOptions: function () {
            var self = this;
            $.each(this.items, function(id, item){
                var options = typeof self.fields[id] === 'undefined' ? {} : self.fields[id];
                console.log(options);
                var itemOptions = {};
                $.each(options, function(name, elem){
                    itemOptions[elem.prop('name')] = {
                        name: elem.data('name'),
                        value: elem.val(),
                        text: (elem.find('option:selected, input').text() ? elem.find('option:selected, input').text() : elem.val())
                    };
                });
                
                self.items[id].options = $.extend({},self.items[id].options, itemOptions);
            });
        },
        _getFields: function() {
            var elems = this.$element.find('input.item-option, select.item-option'), self = this;
            var fields = {};
            $.each(elems, function(k, field) {
                var id = $(this).closest('.storeItem').prop('id');
                if(typeof fields[id] === 'undefined') {
                    fields[id] = {};
                }
                fields[id][$(this).prop('name')] = $(field);
            });
            this.fields = fields;
        },
        _getPrices: function () {
            this.prices = this.$element.data('prices');
        },
        _updateQuantity: function (e) {
            this._debug('Updating Quantity');
            var elem = $(e.target);
            var id = elem.data('item');
            console.log(id);
            this.items[id].qty = elem.val();
            this.trigger('onChanged', e);
        },
        _refresh: function (e) {
            id = $(e.target).closest('.storeItem').prop('id');
            this._getOptions();
            var self = this;
            this._publishPrice(e);
            
            if (this.validation.status === 'failed') {
                this._validate();
            }
            
        },
        _validate: function () {
            if(this.trigger('validate')) {
                this.trigger('validation_pass');
            } else {
                this.trigger('validation_fail');
            }
            return this.validation.status;
        },
        _debug: function (status, showThis) {
            if (!this.settings.debug) {
                return false;
            }
            console.log(status);
            if (showThis) {
                console.log(this);
            }
            

        }
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn.StoreItem = function (option) {
        var args = Array.prototype.slice.call(arguments, 1);
        var methodReturn;
        var plugin = 'StoreItem';
        var $set = this.each(function () {
            var $this = $(this);
            var data = $this.data(plugin);
            var options = typeof option === 'object' && option;
            if (!data)
                $this.data(plugin, (data = new StoreItem(this, options)));
                if (typeof option === 'string') {
                    methodReturn = data[ option ].apply(data, args);
                }
                
        });
        return (methodReturn === undefined) ? $set : methodReturn;
    };
})(jQuery, window, document);

/*
 * jQuery MD5 Plugin 1.2.1
 * https://github.com/blueimp/jQuery-MD5
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://creativecommons.org/licenses/MIT/
 * 
 * Based on
 * A JavaScript implementation of the RSA Data Security, Inc. MD5 Message
 * Digest Algorithm, as defined in RFC 1321.
 * Version 2.2 Copyright (C) Paul Johnston 1999 - 2009
 * Other contributors: Greg Holt, Andrew Kepert, Ydnar, Lostinet
 * Distributed under the BSD License
 * See http://pajhome.org.uk/crypt/md5 for more info.
 */

/*jslint bitwise: true */
/*global unescape, jQuery */

(function ($) {
    'use strict';

    /*
     * Add integers, wrapping at 2^32. This uses 16-bit operations internally
     * to work around bugs in some JS interpreters.
     */
    function safe_add(x, y) {
        var lsw = (x & 0xFFFF) + (y & 0xFFFF),
                msw = (x >> 16) + (y >> 16) + (lsw >> 16);
        return (msw << 16) | (lsw & 0xFFFF);
    }

    /*
     * Bitwise rotate a 32-bit number to the left.
     */
    function bit_rol(num, cnt) {
        return (num << cnt) | (num >>> (32 - cnt));
    }

    /*
     * These functions implement the four basic operations the algorithm uses.
     */
    function md5_cmn(q, a, b, x, s, t) {
        return safe_add(bit_rol(safe_add(safe_add(a, q), safe_add(x, t)), s), b);
    }
    function md5_ff(a, b, c, d, x, s, t) {
        return md5_cmn((b & c) | ((~b) & d), a, b, x, s, t);
    }
    function md5_gg(a, b, c, d, x, s, t) {
        return md5_cmn((b & d) | (c & (~d)), a, b, x, s, t);
    }
    function md5_hh(a, b, c, d, x, s, t) {
        return md5_cmn(b ^ c ^ d, a, b, x, s, t);
    }
    function md5_ii(a, b, c, d, x, s, t) {
        return md5_cmn(c ^ (b | (~d)), a, b, x, s, t);
    }

    /*
     * Calculate the MD5 of an array of little-endian words, and a bit length.
     */
    function binl_md5(x, len) {
        /* append padding */
        x[len >> 5] |= 0x80 << ((len) % 32);
        x[(((len + 64) >>> 9) << 4) + 14] = len;

        var i, olda, oldb, oldc, oldd,
                a = 1732584193,
                b = -271733879,
                c = -1732584194,
                d = 271733878;

        for (i = 0; i < x.length; i += 16) {
            olda = a;
            oldb = b;
            oldc = c;
            oldd = d;

            a = md5_ff(a, b, c, d, x[i], 7, -680876936);
            d = md5_ff(d, a, b, c, x[i + 1], 12, -389564586);
            c = md5_ff(c, d, a, b, x[i + 2], 17, 606105819);
            b = md5_ff(b, c, d, a, x[i + 3], 22, -1044525330);
            a = md5_ff(a, b, c, d, x[i + 4], 7, -176418897);
            d = md5_ff(d, a, b, c, x[i + 5], 12, 1200080426);
            c = md5_ff(c, d, a, b, x[i + 6], 17, -1473231341);
            b = md5_ff(b, c, d, a, x[i + 7], 22, -45705983);
            a = md5_ff(a, b, c, d, x[i + 8], 7, 1770035416);
            d = md5_ff(d, a, b, c, x[i + 9], 12, -1958414417);
            c = md5_ff(c, d, a, b, x[i + 10], 17, -42063);
            b = md5_ff(b, c, d, a, x[i + 11], 22, -1990404162);
            a = md5_ff(a, b, c, d, x[i + 12], 7, 1804603682);
            d = md5_ff(d, a, b, c, x[i + 13], 12, -40341101);
            c = md5_ff(c, d, a, b, x[i + 14], 17, -1502002290);
            b = md5_ff(b, c, d, a, x[i + 15], 22, 1236535329);

            a = md5_gg(a, b, c, d, x[i + 1], 5, -165796510);
            d = md5_gg(d, a, b, c, x[i + 6], 9, -1069501632);
            c = md5_gg(c, d, a, b, x[i + 11], 14, 643717713);
            b = md5_gg(b, c, d, a, x[i], 20, -373897302);
            a = md5_gg(a, b, c, d, x[i + 5], 5, -701558691);
            d = md5_gg(d, a, b, c, x[i + 10], 9, 38016083);
            c = md5_gg(c, d, a, b, x[i + 15], 14, -660478335);
            b = md5_gg(b, c, d, a, x[i + 4], 20, -405537848);
            a = md5_gg(a, b, c, d, x[i + 9], 5, 568446438);
            d = md5_gg(d, a, b, c, x[i + 14], 9, -1019803690);
            c = md5_gg(c, d, a, b, x[i + 3], 14, -187363961);
            b = md5_gg(b, c, d, a, x[i + 8], 20, 1163531501);
            a = md5_gg(a, b, c, d, x[i + 13], 5, -1444681467);
            d = md5_gg(d, a, b, c, x[i + 2], 9, -51403784);
            c = md5_gg(c, d, a, b, x[i + 7], 14, 1735328473);
            b = md5_gg(b, c, d, a, x[i + 12], 20, -1926607734);

            a = md5_hh(a, b, c, d, x[i + 5], 4, -378558);
            d = md5_hh(d, a, b, c, x[i + 8], 11, -2022574463);
            c = md5_hh(c, d, a, b, x[i + 11], 16, 1839030562);
            b = md5_hh(b, c, d, a, x[i + 14], 23, -35309556);
            a = md5_hh(a, b, c, d, x[i + 1], 4, -1530992060);
            d = md5_hh(d, a, b, c, x[i + 4], 11, 1272893353);
            c = md5_hh(c, d, a, b, x[i + 7], 16, -155497632);
            b = md5_hh(b, c, d, a, x[i + 10], 23, -1094730640);
            a = md5_hh(a, b, c, d, x[i + 13], 4, 681279174);
            d = md5_hh(d, a, b, c, x[i], 11, -358537222);
            c = md5_hh(c, d, a, b, x[i + 3], 16, -722521979);
            b = md5_hh(b, c, d, a, x[i + 6], 23, 76029189);
            a = md5_hh(a, b, c, d, x[i + 9], 4, -640364487);
            d = md5_hh(d, a, b, c, x[i + 12], 11, -421815835);
            c = md5_hh(c, d, a, b, x[i + 15], 16, 530742520);
            b = md5_hh(b, c, d, a, x[i + 2], 23, -995338651);

            a = md5_ii(a, b, c, d, x[i], 6, -198630844);
            d = md5_ii(d, a, b, c, x[i + 7], 10, 1126891415);
            c = md5_ii(c, d, a, b, x[i + 14], 15, -1416354905);
            b = md5_ii(b, c, d, a, x[i + 5], 21, -57434055);
            a = md5_ii(a, b, c, d, x[i + 12], 6, 1700485571);
            d = md5_ii(d, a, b, c, x[i + 3], 10, -1894986606);
            c = md5_ii(c, d, a, b, x[i + 10], 15, -1051523);
            b = md5_ii(b, c, d, a, x[i + 1], 21, -2054922799);
            a = md5_ii(a, b, c, d, x[i + 8], 6, 1873313359);
            d = md5_ii(d, a, b, c, x[i + 15], 10, -30611744);
            c = md5_ii(c, d, a, b, x[i + 6], 15, -1560198380);
            b = md5_ii(b, c, d, a, x[i + 13], 21, 1309151649);
            a = md5_ii(a, b, c, d, x[i + 4], 6, -145523070);
            d = md5_ii(d, a, b, c, x[i + 11], 10, -1120210379);
            c = md5_ii(c, d, a, b, x[i + 2], 15, 718787259);
            b = md5_ii(b, c, d, a, x[i + 9], 21, -343485551);

            a = safe_add(a, olda);
            b = safe_add(b, oldb);
            c = safe_add(c, oldc);
            d = safe_add(d, oldd);
        }
        return [a, b, c, d];
    }

    /*
     * Convert an array of little-endian words to a string
     */
    function binl2rstr(input) {
        var i,
                output = '';
        for (i = 0; i < input.length * 32; i += 8) {
            output += String.fromCharCode((input[i >> 5] >>> (i % 32)) & 0xFF);
        }
        return output;
    }

    /*
     * Convert a raw string to an array of little-endian words
     * Characters >255 have their high-byte silently ignored.
     */
    function rstr2binl(input) {
        var i,
                output = [];
        output[(input.length >> 2) - 1] = undefined;
        for (i = 0; i < output.length; i += 1) {
            output[i] = 0;
        }
        for (i = 0; i < input.length * 8; i += 8) {
            output[i >> 5] |= (input.charCodeAt(i / 8) & 0xFF) << (i % 32);
        }
        return output;
    }

    /*
     * Calculate the MD5 of a raw string
     */
    function rstr_md5(s) {
        return binl2rstr(binl_md5(rstr2binl(s), s.length * 8));
    }

    /*
     * Calculate the HMAC-MD5, of a key and some data (raw strings)
     */
    function rstr_hmac_md5(key, data) {
        var i,
                bkey = rstr2binl(key),
                ipad = [],
                opad = [],
                hash;
        ipad[15] = opad[15] = undefined;
        if (bkey.length > 16) {
            bkey = binl_md5(bkey, key.length * 8);
        }
        for (i = 0; i < 16; i += 1) {
            ipad[i] = bkey[i] ^ 0x36363636;
            opad[i] = bkey[i] ^ 0x5C5C5C5C;
        }
        hash = binl_md5(ipad.concat(rstr2binl(data)), 512 + data.length * 8);
        return binl2rstr(binl_md5(opad.concat(hash), 512 + 128));
    }

    /*
     * Convert a raw string to a hex string
     */
    function rstr2hex(input) {
        var hex_tab = '0123456789abcdef',
                output = '',
                x,
                i;
        for (i = 0; i < input.length; i += 1) {
            x = input.charCodeAt(i);
            output += hex_tab.charAt((x >>> 4) & 0x0F) +
                    hex_tab.charAt(x & 0x0F);
        }
        return output;
    }

    /*
     * Encode a string as utf-8
     */
    function str2rstr_utf8(input) {
        return unescape(encodeURIComponent(input));
    }

    /*
     * Take string arguments and return either raw or hex encoded strings
     */
    function raw_md5(s) {
        return rstr_md5(str2rstr_utf8(s));
    }
    function hex_md5(s) {
        return rstr2hex(raw_md5(s));
    }
    function raw_hmac_md5(k, d) {
        return rstr_hmac_md5(str2rstr_utf8(k), str2rstr_utf8(d));
    }
    function hex_hmac_md5(k, d) {
        return rstr2hex(raw_hmac_md5(k, d));
    }

    $.md5 = function (string, key, raw) {
        if (!key) {
            if (!raw) {
                return hex_md5(string);
            } else {
                return raw_md5(string);
            }
        }
        if (!raw) {
            return hex_hmac_md5(key, string);
        } else {
            return raw_hmac_md5(key, string);
        }
    };

}(typeof jQuery === 'function' ? jQuery : this));