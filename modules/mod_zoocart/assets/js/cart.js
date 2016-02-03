// the semi-colon before function invocation is a safety net against concatenated
// scripts and/or other plugins which may not be closed properly.
;(function ( $, window, document, undefined ) {

		// undefined is used here as the undefined global variable in ECMAScript 3 is
		// mutable (ie. it can be changed by someone else). undefined isn't really being
		// passed in so we can ensure the value of it is truly undefined. In ES5, undefined
		// can no longer be modified.

		// window and document are passed through as local variable rather than global
		// as this (slightly) quickens the resolution process and can be more efficiently
		// minified (especially when both are regularly referenced in your plugin).


		// The actual plugin constructor
		var ShoppingCart = function ( element, options ) {
				this.$element = $(element);
                                this.defaults = {
                                    debug: false,
                                    currency: '$',
                                    checkoutUrl: '/store/checkout'
                                };
                                this.settings = $.extend(true, this.defaults, options );
                                
                                // Initialize the Plugin
                                this.init();
                                
                                // Set the event handlers

                                this.$buttons = {
                                    continueShopping: this.$element.find('#cart-modal .continue').on('click', $.proxy(this._toggleCartModal,this)),
                                    checkout:   this.$element.find('#cart-modal .checkout').on('click', $.proxy(this._startCheckout,this)),
                                    clear: this.$element.find('#cart-modal .clear').on('click', $.proxy(this._emptyCart,this))
                                }
                                this.$element.on('click','#cart-modal .item-update', $.proxy(this.updateQuantity,this));
                                this.$element.on('click', '#cart-module[data-cart="open"]', $.proxy(this._toggleCartModal,this));
                                this.$element.on('click', '#cart-modal .item-remove', $.proxy(this.removeItem,this));
                                this.$element.on('click', 'div.option-toggle', $.proxy(this._toggleItemOptions,this));
                                
                                // Fill the cart.
				this._updateCart();
                                }

		ShoppingCart.prototype = {
//                                constructor: Gibform,,
                                items: {},
                                cookie: $.cookie,
                                templates: {
                                    cart: [
                                        '<div id="cart" class="uk-modal">',
                                            '<div class="uk-modal-dialog">',
                                                '<div class="uk-panel uk-panel-box">',
                                                    '<h3 class="uk-panel-title">Shopping Cart</h3>',
                                                    '<div class="container">',
                                                        '<table class="uk-table uk-table-hover uk-table-striped uk-table-condensed">',
                                                            '<thead>',
                                                                '<tr>',
                                                                    '<th class="uk-width-2-4">Item</th>',
                                                                    '<th class="uk-width-1-4">Quantity</th>',
                                                                    '<th class="uk-width-1-4">Price</th>',
                                                                '</tr>',
                                                            '</thead>',
                                                            '<tbody>',
                                                            '</tbody>',
                                                            '<tfoot>',
                                                                '<tr>',
                                                                    '<td class="uk-text-right" colspan="2">Total</td>',
                                                                    '<td class="item-total uk-text-bold uk-text-large"></td>',
                                                                '</tr>',
                                                            '</tfoot>',
                                                        '</table>',
                                                    '</div>',
                                                    '<div class="uk-align-right">',
                                                        '<button class="uk-button uk-button-primary continue">Continue Shopping</button>',
                                                        '<button class="uk-button uk-button-primary checkout">Checkout</button>',
                                                        '<button class="uk-button uk-button-primary clear">Empty Cart</button>',
                                                    '</div>',
                                                '</div>',
                                            '</div>',
                                        '</div>'
                                    ],
                                    cartIcon: [
                                            '<div class="uk-navbar-flip">',
                                                '<ul id="cart-icon" class="uk-navbar-nav cart-icon">',
                                                    '<li>',
                                                        '<a href="#">',
                                                            '<i class="uk-icon-shopping-cart" />',
                                                            '<span id="cart-items"></span>',
                                                            '<span id="cart-total"></span>',
                                                        '</a>',
                                                    '</li>',
                                                '</ul>',
                                            '</div>'
                                    ] 
                                },
                                $cart: {
                                    elem: null,
                                    total: null
                                },
                                $cartIcon: {
                                    elem: null,
                                    qty: null,
                                    total: null
                                },
                                $modal: null,
				                init: function () {
                                    this._log('Shopping Cart Plugin Initialized.');
                                    this._createCartModal();
                                    var self = this;
                                    $.ajax({
                                        type: 'POST',
                                        url: "?option=com_zoo&controller=cart&task=init&format=json",
                                        data: {},
                                        success: function(data){
                                            if(data.result) {
                                                self._updateCart(data);
                                            }
                                        },
                                        error: function(data, status, error) {
                                            console.log('Error');
                                            console.log(status);
                                            console.log(error);
                                        },
                                        dataType: 'json'
                                    });
                                },
                                
                                //Initialization Methods
                                
                                _createCartModal: function () {
//                                    $('.tm-block').append($(this.templates.cart.join('')));
                                    this.$cart.elem = $('#cart-modal')
                                    this.$modal = $.UIkit.modal("#cart-modal");
                                    this._log('Cart Modal Created.');
                                    this.$cart.elem = this.$element.find('#cart-modal tbody'); 
                                    this.$cart.total = $('#cart-modal .item-total');
                                    
                                    this._createCartIcon();
                                },
                                _createCartIcon: function () {
//                                    $(this.settings.icon_location).append($(this.templates.cartIcon.join('')));
                                    this.$cartIcon.elem = $('#cart-module');
                                    this.$cartIcon.qty = $('[data-cart="quantity"]');
                                    this.$cartIcon.total = $('[data-cart="total"]');
                                    this.$cartIcon.elem.find('.currency').html(this.settings.currency);
                                    this._log(['Cart icon created.']);
                                },
                                
                                // Utility Methods
                                _updateCart: function (data) {
                                    if($.type(data) === 'undefined') {
                                        this.items = {};
                                        this.total = 0.00;
                                        this.itemCount = 0;
                                    } else {
                                        this.items = data.items;
                                        this.total = data.total;
                                        this.itemCount = data.item_count;
                                    }
                                    
                                    this._fillCart();
                                    this.$cartIcon.qty.html(this.itemCount);
                                    this.$cartIcon.total.html(this.total.toFixed(2));
                                    this.$cart.total.html(this.settings.currency+this.total.toFixed(2));
                                    this._buttonStates();
                                    this._log('Cart updated.');
                                },
                                _fillCart: function () {
                                    var items = this.items;
                                    var self = this;
                                    this.$cart.elem.find('tr').remove();
                                    if (Object.keys(items).length < 1)
                                        {
                                            this._log('No items to fill in the Cart.');
                                            this.$cart.elem.append('<tr id="empty"><td colspan="3" class="uk-text-center">There are no items in your cart!</td></tr>');
                                            return;
                                        }
                                    $.each(items,function(k,v){
                                        self.$cart.elem.append(self._createCartRow(k,v));
                                    })
                                    this._log('Cart filled with Items.');
                                        
                                },
                                _createCartRow: function (key,data) {
                                    var price = data.total;
                                    var row = $('<tr id="'+key+'" />').append('<td><div class="item-name">'+data.name+'</div></td>')
                                        .append('<td class="item-qty"><input type="number" name="item-qty" class="uk-width-1-3" value="'+data.qty+'" /><a class="item-update uk-link-muted uk-text-small uk-margin-left" href="#">update</a></td>')
                                        .append('<td class="item-price">'+this.settings.currency+price.toFixed(2)+'<a href="#" class="item-remove"><i class="uk-icon-trash-o"></i></a></td>')
                                    this._log('Cart Row ID - '+key+' created.');
                                    if (!$.isEmptyObject(this.items[key].options)) {
                                        $('<div class="option-container"></div>').append(this._renderItemOptions(key)).insertAfter(row.find('div.item-name'));
                                    }
                                    return row;
                                },
                                _getCartQuantity: function () {
                                    
                                    var items = this.items;
                                    var qty = 0;
                                    $.each(items, function(k,v){
                                        qty += v.qty;
                                    })
                                    this._checkoutButton(qty > 0 ? false : true );
                                    this._log('Cart Quantity - '+qty+'.');
                                    return qty;
                                },
                                _removeCartItem: function (id) {
                                    
                                    if (confirm('Are you sure you want to remove \n\ this item from your cart?'))
                                    {
                                        delete this.items[id];
                                        this._log(['Item ID-'+id+' Removed.',this.items]);
                                        this._updateCart();
                                        
                                    }
                                    
                                },
                                _renderItemOptions: function (id) {
          
                                    var $table = $('<table class="uk-table uk-table-condensed"><thead><th>Option</th><th>Value</th></thead><tbody></tbody></table>'),
                                    tbody = $table.find('tbody'),
                                    toggle = $('<div class="option-toggle"></div>'),
                                    container = $('<div class="item-options uk-hidden"></div>');
                                    toggle.append('<i class="uk-icon-plus-square-o"></i><span>Show Options</span>');

                                    var items = this.items;
                                    $.each(items[id].options, function (k,v) {
                                        if (typeof v.visible === 'undefined' || v.visible === true ) {
                                            tbody.append('<tr><td>'+v.name+'</td><td>'+v.text+'</td></tr>');
                                        }
                                    })
                                    container.append($table);
                                    return toggle.append(container);
                                },
                                _emptyCart: function () {
                                    if (confirm('Are you sure you want to remove \n\ all items from your cart?')) {
                                        var self = this;
                                    $.ajax({
                                        type: 'POST',
                                        url: "?option=com_zoo&controller=cart&task=emptyCart&format=json",
                                        data: {},
                                        success: function(data){
                                            console.log(data);
                                            if(data.result) {
                                                self._updateCart(data);
                                            }
                                        },
                                        error: function(data, status, error) {
                                            console.log('Error');
                                            console.log(status);
                                            console.log(error);
                                        },
                                        dataType: 'json'
                                    });
                                    }
                                    
                                },
                                
                                updateQuantity: function (e) {
                                    e.preventDefault();
                                    var row = $(e.target).closest('tr');
                                    var sku = row.prop('id');
                                    var qty = parseInt(row.find('input[name="item-qty"]').val());
                                    var self = this;
                                    if(qty == 0) {
                                        if (!confirm('Are you sure you want to remove \n\ this item from your cart?')) {
                                            return;
                                        }
                                    }
                                    $.ajax({
                                        type: 'POST',
                                        url: "?option=com_zoo&controller=cart&task=updateQty&format=json",
                                        data: {sku: sku, qty: qty},
                                        success: function(data){
                                            console.log(data);
                                            if(data.result) {
                                                self._updateCart(data);
                                                self._log(['Item Quantity Updated by User:',{ItemID: sku,itemQty: qty}]);
                                            }
                                        },
                                        error: function(data, status, error) {
                                            console.log('Error');
                                            console.log(status);
                                            console.log(error);
                                        },
                                        dataType: 'json'
                                    });
                                    
                                },
                                removeItem: function (e) {
 
                                    e.preventDefault();
                                    if (!confirm('Are you sure you want to remove \n\ this item from your cart?')) {
                                        return;
                                    }
                                    var sku = $(e.target).closest('tr').prop('id');
                                    var self = this;
                                    console.log(sku);
                                    $.ajax({
                                        type: 'POST',
                                        url: "?option=com_zoo&controller=cart&task=remove&format=json",
                                        data: {sku: sku},
                                        success: function(data){
                                            console.log(data);
                                            if(data.result) {
                                                self._updateCart(data);
                                            }
                                        },
                                        error: function(data, status, error) {
                                            console.log('Error');
                                            console.log(status);
                                            console.log(error);
                                        },
                                        dataType: 'json'
                                    });
                                },
                                addToCart: function (items) {
                                    var self = this;
                                    $.ajax({
                                        type: 'POST',
                                        url: "?option=com_zoo&controller=cart&task=add&format=json",
                                        data: {cartitems: items},
                                        success: function(data){
                                            console.log(data);
                                            if(data.result) {
                                                self._updateCart(data);
                                                self._toggleCartModal();
                                            }
                                        },
                                        error: function(data, status, error) {
                                            console.log('Error');
                                            console.log(status);
                                            console.log(error);
                                        },
                                        dataType: 'json'
                                    });

                                    
                                },
                                _calculateSubTotal: function () { 
                                    var total = 0.00;
                                    if (!Object.keys(this.items).length < 1)
                                        {
                                            $.each(this.items,function(k,v){
                                                
                                                total += (v.qty * v.price);
                                            });
                                        }
                                    this._log('Grand total calculated: '+total.toFixed(2)+'.');
                                    return total.toFixed(2);
                                },
                                _toggleCartModal: function () {
                                    if ( this.$modal.isActive() ) {
                                        this.$modal.hide();
                                        this._log('Cart hidden.');
                                    } else {
                                        this.$modal.show();
                                        this._log('Cart visible.');
                                    }
                                    
                                    
                                },
                                _toggleItemOptions: function(e) {
                                    var target = $(e.target).closest('tr');
                                    var panel = target.closest('tr').find('.item-options');
                                    var label = target.find('span');
                                    var icon = target.find('.option-toggle i');
                                    if (panel.is(':visible')) {
                                        label.html('Show Options');
                                        icon.removeClass('uk-icon-minus-square-o').addClass('uk-icon-plus-square-o')
                                        panel.addClass('uk-hidden');
                                    } else { 
                                        label.html('Hide Options');
                                        icon.removeClass('uk-icon-plus-square-o').addClass('uk-icon-minus-square-o')
                                        panel.removeClass('uk-hidden');
                                    }
                                    
                                    
                                },
                                _buttonStates: function() {
                                    var itemExists = (this.itemCount > 0) ? false : true;
                                    // Checkout button
                                    this.$buttons.checkout.prop('disabled',itemExists);
                                    // Empty Cart Button
                                    this.$buttons.clear.prop('disabled',itemExists);
                                },
                                _startCheckout: function () {
                                    window.location.href = this.settings.checkoutUrl;
                                    this._toggleCartModal();
                                },
                                _log: function (message) {
                                    if(this.settings.debug)
                                        {
                                            if(typeof message === 'string')
                                            {
                                                console.log(message)
                                            }
                                            else
                                            {
                                                $.each(message, function(k,v) {
                                                    console.log(v);
                                                })
                                            }
                                            
                                            
                                        }
                                    
                                }
                             
                                
                            }

		// A really lightweight plugin wrapper around the constructor,
		// preventing against multiple instantiations
		$.fn.ShoppingCart = function ( option ) {
                    var args = Array.prototype.slice.call( arguments, 1 );
                    var methodReturn;
                    var plugin = 'ShoppingCart-'+this.attr('id');
                    var $set = this.each(function () {
                        var $this   = $( this );
                        var data    = $this.data( plugin );
                        var options = typeof option === 'object' && option;
                        if( !data ) $this.data(plugin, (data = new ShoppingCart( this, options ) ) );
                        if( typeof option === 'string' ) 
                        {
                            methodReturn = data[ option ].apply( data, args );
                        }
                    });

                    return ( methodReturn === undefined ) ? $set : methodReturn;
        
                };

})( jQuery, window, document );


jQuery(document).ready(function(){
    jQuery('body').ShoppingCart();
    
    
})
   