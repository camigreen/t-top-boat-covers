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
        this.$element.on('input','.item-option:not(select)', $.proxy(this, '_refresh'));
        this.$element.on('change','select.item-option', $.proxy(this, '_refresh'));
        this.trigger('onComplete');

    };

    StoreItem.prototype = {
        type: null,
        current_items: {},
        fields: {},
        cart: {
            validated: false,
            items: {},
            id: null,
            confirmed: false
        },
        validation: {
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
                }); 
            });
            
            this._getFields();
            this._getOptions();
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
                function (data) {
                    this._debug('StoreItem Plugin Initialized.', false);
                    return data;
                }
            ],
            beforeAddToCart: [
                function (data) {
                    // The beforeAddToCart must return an array of item objects
                    this._debug('beforeAddToCart Callback');
                    return data;
                }
            ],
            afterAddToCart: [
                function (data) {
                    this._clearConfirm();
                    this.$qty.val(1);
                    this.validation.status = null;
                    return data;
                }
            ],
            beforeChange: [],
            afterchange: [],
            onComplete: [
                function (data) {
                    this._debug('StoreItem Plugin Complete.', true);
                    return data;
                }
            ],
            beforeValidation: [],
            afterValidation: [],
            beforeConfirmation: [],
            afterConfirmation: [],
            validation_pass: [
                function (data) {
                    this._debug('Validation Passed!');
                    this.validation.complete = true;
                    this.validation.closeMessage();
                    return data;
                }
            ],
            validation_fail: [
                function (data) {
                    this._debug('Validation Failed!');
                    this.validation.status = 'failed';
                    this.validation.sendMessage();
                    return data;
                }
            ],
            confirmation: [],
            beforePublishPrice: [],
            afterPublishPrice: []
        },
        trigger: function (event, args) {
            
            var self = this;

            var type = this.type;
            if(typeof args === 'undefined') {
                args = {};
            }
            
            result = {};
            result.args = args;
            result.triggerResult = true;
            var events = this.getEvents(event, type);
            $.each(events, function (k, v) {
                self._debug('Starting ' + event + ' ['+k+']');
                result = v.call(self,result);
                if (result.triggerResult === 'break') {
                    self._debug('Breaking from '+event+' event.');
                    return false;
                }
                self._debug(event + ' Complete. ['+k+']');
            });
            return result;
        },
        addToCart: function (e) {
            var self = this;
            var id = $(e.target).data('id');
            this.cart.items = {};

            this.cart.items[this.items[id].id] = $.extend(true,{},this.items[id]);

            // trigger beforeAddToCart
            var triggerData = this.trigger('beforeAddToCart', {event: e, items: this.cart.items});
            this.cart.items = triggerData.args.items;
            console.log(this.cart.items);
            if(!triggerData.triggerResult) {
                return;
            }
            // Validate
            this.cart.validated = this._validate(this.cart.items);
            if(!this.cart.validated) {
                return;
            }
            // Trigger the confirmation.
            this.cart.confirmed = this._confirmation(this.cart.items, id);
            if(!this.cart.confirmed) {
                return;
            }
            $('body').ShoppingCart('addToCart', this.cart.items);
            this.clearCart();
            this.trigger('afterAddToCart', {items: this.cart.items});
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
        _confirmation: function (items, cart_id) { 
            var result = false;
            $.each(items, function (k,item) {
                if(item.confirm) {
                    result = true;
                }
            })                   

            if (this.cart.confirmed) {
                return true;
            }

            if (!result) {
                return true;
            }

            this._debug('Starting Confirmation');
            var triggerData = this.trigger('beforeConfirmation', {items: items});
            items = triggerData.args.items;
            var result = false;
            $.each(items, function (k,item) {
                if(item.confirm) {
                    result = true;
                }
            })

            var self = this, container;
            this.confirm.elem.find('[name="cart_id"]').val(cart_id);
            $.each(items, function(k,item) {
                console.log('loading items into modal');
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
        },
        _confirm: function() {
            var modal = this.confirm.elem;
            var accept = modal.find('[name="accept"]');
            var error = modal.find('.confirm-error');
            if (accept.val().toLowerCase() === 'yes') {
                modal.hide();
                this._clearConfirm();
                this.cart.confirmed = true;
                var id = this.confirm.elem.find('[name="cart_id"]').val();
                $('#atc-'+id).trigger('click');
            } else {
                error.html('You must type "yes" or press cancel.');            
            }
        },

        _clearConfirm: function() {
            var modal = this.confirm.elem;
            var accept = modal.find('[name="accept"]');
            var error = modal.find('.confirm-error');
            
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
        _publishPrice: function (item) {
            this._debug('Publishing Price');
            var triggerData = this.trigger('beforePublishPrice', {item: item});
            item = triggerData.args.item;
            var self = this;
            $.ajax({
                type: 'POST',
                url: "?option=com_zoo&controller=store&task=getPrice&format=json",
                data: {item: item},
                success: function(data){
                    var elem = $('#'+item.id+'-price span');
                    elem.html(data.price.toFixed(2));
                    self.trigger('afterPublishPrice', {price: data.price, item: item});
                },
                error: function(data, status, error) {
                    var elem = $('#'+item.id+'-price span');
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
                var id = $(this).closest('.options-container').data('id');
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
            this.trigger('onChanged', {e: e});
        },
        _refresh: function (e) {
            var id = $(e.target).closest('.options-container').data('id'), self = this;
            triggerData = this.trigger('beforeChange', {event: e, item: this.items[id]});
            this._getOptions();
            var publishPrice = typeof triggerData.publishPrice === 'undefined' ? true : triggerData.args.publishPrice;
            if(publishPrice) {
                self._publishPrice(this.items[id]);
            }
            if (this.validation.status === 'failed') {
                this._validate(id);
            }
            this.trigger('afterChange', {event: e, item: this.items[id]});
            
        },
        _validate: function (items) {

            if(!this.settings.validate || this.cart.validated) {
                return true;
            }

            var self = this, validated = true;
            self.$element.find('.validation-fail').removeClass('validation-fail');
            $.each(items, function (key, item) {
                var fields = !self.fields[item.id] ? {} : self.fields[item.id];
                $.each(fields, function (k, v) {
                    if($(this).hasClass('required') && ($(this).val() === 'X' || $(this).val() === '')) {
                        $(this).addClass('validation-fail');
                        self._debug($(this).prop('name') + 'Failed Validation');
                        validated = false;
                    }; 
                });
            })

            if(validated) {
                this.trigger('validation_pass');
            } else {
                this.trigger('validation_fail');
            }
            return validated;
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