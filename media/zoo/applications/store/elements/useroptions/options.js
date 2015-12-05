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
    var ElementSelect = function (element, options) {
        this.$element = $(element);
        this.defaults = {
            element: null,
            index: 0,
            formHandler: false
        };
        this.settings = $.extend(true, this.defaults, options);
        // Initialize the Plugin
        
       
        this.buttons = {
            addChoice: this.$element.find('.choices .add button'),
            deleteChoice: this.$element.find('.choices .delete'),
            addOption: $('.options .add-option button'),
            deleteOption: $('.delete-option')
        };
        
        this.init();
        // Set the event handlers

    };

    ElementSelect.prototype = {
        name: null,
        dirty: null,
        init: function () {
            this.name = 'elements['+this.settings.element+'][select]';
            
            this.dirty = false;
            this._eventAssignments();
            this._formHandler();
            this.create();
        },
        create: function() {
            this.option.add($('#option-0'));
        },
        option: {
            items: [],
            add: function(elem) {
                this.items.push(elem);
                console.log(this.items);
            }
        }, 
        createClone: function (e) {
            e.preventDefault();
            var index = this.settings.index+1;
            var clone = this.$element.clone();
            var controlName = this.name+'['+index+']';
            var lastOption = $('.user-options .options > .row:last');
            
            clone.find('.option-box .choices .row:not(:first)').remove();
            clone.find('.option-box .choices .row').prop('id','choice-0');
            clone.prop('id','option-'+index).find('.data input').each(function(k,v){
                var name = $(this).prop('id').replace('option-','');
                $(this).prop('name',controlName+'['+name+']').val('');
            });
            clone.prop('id','option-'+index).find('.choices input').each(function(k,v){
                var name = $(this).prop('id').replace('choice-','');
                $(this).prop('name',controlName+'[choices][0]['+name+']').val('');
            });
            clone.ElementSelect({element: this.settings.element, index: index}).insertAfter(lastOption);
        },
        createChoiceClone: function(e) {
            e.preventDefault();
            var index = this.$element.find('.choices .row').length;
            var lastRow = this.$element.find('.choices .row:last');
            var clone = lastRow.clone();
            var controlName = this.name+'['+this.settings.index+']';
            clone.prop('id','choice-'+index).find('input').each(function(k,v){
                var name = $(this).prop('id').replace('choice-','');
                $(this).prop('name',controlName+'[choices]['+index+']['+name+']').val('');
            });
            clone.insertAfter(lastRow);
        },
        _delete: function (e) {
            var elem = $(e.target).closest('.row');
            var parent = elem.parent();
            if (parent.children('.row').length === 1) {
                this._clearRow(elem);
            } else {
                this._deleteRow(elem);
            }
        },
        _deleteRow: function(elem) {
            elem.remove();
            console.log('Deleted');
        },
        _clearRow: function(elem) {
            elem.find('input').each(function(k,v) {
                $(this).val('');
            });
            console.log('Cleared');
        },
        _changed: function () {
            this._formHandler();
        },
        _checkFormStatus: function() {
            var result = false;
            $('.user-options input').each(function(){
                console.log($(this).val())
                if ($(this).val() !== '') {
                    result = true;
                }
            });
            this.dirty = result;
            console.log(this.dirty)
        },
        _formHandler: function () {
            if (!this.settings.formHandler){
                return;
            }
            this._checkFormStatus();
            this.buttons.addOption.prop('disabled',!this.dirty);
            if (this.dirty && $('#option-name').val() === '') {
                $('.vFail').addClass('active');
            }
            
        },
        _eventAssignments: function() {
            var self = this;
            $.each(this.buttons, function(){
               this.on('input',$.proxy(self, '_changed')); 
            });
            this.$element.find('.delete').on('click',$.proxy(this,'_delete'));
            this.buttons.addChoice.on('click',$.proxy(this,'createChoiceClone'));
//            this.$element.on('input', '#option-name', $.proxy(this, '_changed'));
            this.buttons.addOption.on('click', $.proxy(this, 'createClone'));
        },
        _toggleValidation: function(elem, valid) {
            var e = $(elem).sibling('.vFail');
            e.removeClass('.active');
            if(!valid) {
                e.addClass('active')
            }
            
            
        }
        
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn.ElementSelect = function (option) {
        var args = Array.prototype.slice.call(arguments, 1);
        var methodReturn;
        var plugin = 'ElementSelect';

        var $set = this.each(function () {
            var $this = $(this);
            var data = $this.data(plugin);
            var options = typeof option === 'object' && option;
            if (!data)
                $this.data(plugin, (data = new ElementSelect(this, options)));
                if (typeof option === 'string') {
                    methodReturn = data[ option ].apply(data, args);
                }
        });
        return (methodReturn === undefined) ? $set : methodReturn;
        
    };

})(jQuery, window, document);


//function addOptionRow() {
//            var row = $('.user-options .select.row:last').clone();
//            var elemID = $('.user-options').data('element');
//            var i = $('.user-options .select').length;
//            var name = 'elements['+elemID+'][select]['+i+']';
//            row.find('.field_name input[type="text"]').prop('name',name+'[name]').val('');
//            row.find('.field_name input[type="text"]').prop('name',name+'[default_value]').val('');
//            row.prop('id','select-'+i);
//            row.find('.option-box .option.row:not(:first)').remove();
//            row.find('.option-box .option.row').prop('id','option-0');
//            row.find('.name-input input[type="text"]').prop('name',name+'[options][0][name]').val('');
//            row.find('.value-input input[type="text"]').prop('name',name+'[options][0][value]').val('');
//            row.insertAfter('.user-options .select.row:last');
//            createEvents();
//        }
//        function addChoiceRow(id) {
//            console.log(id);
//            var row = $('.user-options #'+id+' .option-box .option.row:last').clone();
//            var elemID = $('.user-options').data('element');
//            var i = $('.user-options #'+id+' .option-box .option.row').length;
//            var name = 'elements['+elemID+'][select]['+i+']';
//            var name = row.find('.name-input input[type="text"]').prop('name');
//            var value = row.find('.value-input input[type="text"]').prop('name');
//            var pattern=/^(\S+\[options\])\[\d+\](\[name\]|\[value\])$/;
//            var count = row.length;
//            row.prop('id','option-'+count);
//            row.find('.name-input input[type="text"]').val('').prop('name',name.replace(pattern,"$1["+count+"]$2"));
//            row.find('.value-input input[type="text"]').val('').prop('name',value.replace(pattern,"$1["+count+"]$2"));
//            row.insertAfter('.user-options #'+id+' .option-box .row:last');
//            createEvents();
//        }
//        function clearRow(id){
//            $('.user-options #'+id+' input').val('');
//            console.log('Cleared');
//        }
//        function deleteRow(id) {
//            $('.user-options #'+id).remove();
//            console.log('Removed');
//        }
//        
//        function createEvents() {
//            $('.user-options .add-choice button').on('click', function(e) {
//                e.preventDefault();
//                addChoiceRow($(e.target).closest('.select.row').prop('id'));
//            });
//            $('.user-options .add-option button').on('click', function(e) {
//                e.preventDefault();
//                addOptionRow();
//            });
//            $('.user-options .delete').on('click', function(e) {
//                e.preventDefault();
//                var elem = $(e.target).closest('.row').parent().children('.row');
//                var id = $(e.target).closest('.row').prop('id');
//                if (elem.length === 1) {
//                    clearRow(id);
//                } else {
//                    deleteRow(id);
//                }         
//            });
//        }
//        
//        createEvents();