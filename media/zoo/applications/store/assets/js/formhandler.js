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
    var FormHandler = function (element, options) {
        this.$element = $(element);
        this.defaults = {
            validate: true,
            debug: true,
            events: {}
        };
        this.settings = $.extend(true, this.defaults, options);
        // Initialize the Plugin
        this.init();
       
        // Set the event handlers
        this.$element.on('input', '.ttop-checkout-field', $.proxy(this, 'trigger', 'onChanged'));
        this.$element.on('change', 'select.ttop-checkout-field', $.proxy(this, 'trigger', 'onChanged'));
        
        this.trigger('onComplete');

    };

    FormHandler.prototype = {
        validation: null,
        fields: null,
        init: function () {
            this._getFields();
            this.trigger('onInit');
        },
        getEvents: function (id) {
            
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
            return events;
        },
        _events: {
            onInit: [
                function () {
                    this._debug('FormHandler Plugin Initialized.');
                    return true;
                }
            ],
            onChanged: [
                function (e) {
                    this._debug('onChanged Callback', true);
                    this._refresh();
                    this._debug('FormHandler Plugin Change Detected.');
                    this._debug('Field {' + $(e.target).prop("name") + '} changed to ' + $(e.target).val() + '.');
                    return true;
                }   
            ],
            beforeSubmit: [
                function(e) {
                    e.preventDefault();
                    this._debug('Before Form Submission');
                    return true;
                }
            ],
            onSubmit: [
                function(e) {
                    //$('#checkout-data :input').not(':submit').clone().appendTo('#ttop-checkout');
                    // if($('[name="step"]').val() === 'receipt') {
                    //     window.location.href = "?task=receipt";
                    //     return true;
                    // }
                    this.$element.submit();
                    this._debug('Form Submission');
                    return true;
                }
            ],
            onComplete: [
                function () {
                    this._debug('FormHandler Plugin Complete.', true);
                    return true;
                }
            ],
            validate: [
                function () {

                    if (!this.settings.validate) {
                        return 'break';
                    }
                    return true;
                }
            ],
            validation_pass: [
                function () {
                    this._debug('Validation Passed!');
                    return true;
                }
            ],
            validation_fail: [
                function () {
                    this._debug('Validation Failed!');
                    return true;
                    
                }
            ]
        },
        trigger: function (event, e) {
                        var self = this, args = Array.prototype.slice.call(arguments, 1);
            var dfd = $.Deferred();
            var events = this.getEvents(event);
            var result = true;
            var d = [];
            $.each(events, function (k, v) {
                d.push(v.call(self,e,args));
            });
            self._debug('Starting '+event+' event.');
            $.when.apply($, d).done(function(){
                $.each(arguments, function(k,v){
                    if (v === 'break' || v === false) {
                        result = false;
                    }
                    self._debug('Trigger is returning '+ v +' from '+event+' event.');
                });
                dfd.resolve(result);
            });
            return dfd.promise();
        },
        _getFields: function () {
            this.fields = this.$element.find('.ttop-checkout-field');
            return this.fields;
        },
        _getFieldValue: function (name) {
            var result = false;
            $.each(this.fields, function() {
                if($(this).prop('name') === name) {
                    result = $(this).val();
                }
            });
            return result;
        },
        _refresh: function () {
            if (!this.validation.valid()) {
                this._validate();
            };
            this._getFields();
        },
        _validate: function () {
            this.trigger('validate');
            var status = this.validation.valid();
            if(status) {
                this.trigger('validation_pass');
            } else {
                this.trigger('validation_fail');
            }
            return status;
        },
        _submit: function (e) {
            e.preventDefault();
            var self = this;
            if(this.formDirty) {
                $('[name="process"]').val(true);
            }
            $.when(this.trigger('beforeSubmit',e), this._validate()).then(function(v1, v2){
                if (v1 && v2) {
                    self.trigger('onSubmit',e);
                }
            });
        },
        formDirty: function() {
                var dirty = false;
                this.element.find('.ttop-checkout-field').each(function(){
                    if (this.defaultValue === this.val()) {
                        dirty = true;
                    }
                });
                return dirty;
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
    $.fn.FormHandler = function (option) {
        var args = Array.prototype.slice.call(arguments, 1);
        var methodReturn;
        var plugin = 'FormHandler';

        var $set = this.each(function () {
            var $this = $(this);
            var data = $this.data(plugin);
            var options = typeof option === 'object' && option;
            if (!data)
                $this.data(plugin, (data = new FormHandler(this, options)));
                if (typeof option === 'string') {
                    methodReturn = data[ option ].apply(data, args);
                }
        });
        return (methodReturn === undefined) ? $set : methodReturn;
        
    };

})(jQuery, window, document);