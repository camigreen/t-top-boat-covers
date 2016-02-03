<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
$class = $item->type.'-full';
$storeItem = $this->app->item->create($item, 'ubsk');
?>
<article>
    <span class="uk-article-title"><?php echo $item->name; ?></span>
</article>
<div id="storeItemForm" class="uk-form uk-margin" data-item="<?php echo $storeItem->getItemsJSON(); ?>">
    <div class="uk-grid">
        <div class="uk-width-2-3 ubsk-slideshow">
            <div class="uk-width-5-6 uk-container-center uk-margin">
                <?php if ($this->checkPosition('media')) : ?>
                    <?php echo $this->renderPosition('media', array('style' => 'blank')); ?>
                <?php endif; ?>
            </div>
            <div class="uk-width-1-1">
                <ul class="uk-tab" data-uk-tab="{connect:'#tabs'}">
                    <li>
                        <a href="#">Order Form</a>
                    </li>
                    <?php if ($this->checkPosition('measurement_info')) : ?>
                    <li>
                        <a href="#">Measurements</a>
                    </li>
                    <?php endif; ?>
                    <?php if ($this->checkPosition('tabs')) : ?>
                        <?php echo $this->renderPosition('tabs', array('style' => 'tab')); ?>
                    <?php endif; ?>
                </ul>
                <ul id="tabs" style="min-height:150px;" class="uk-width-1-1 uk-switcher uk-margin">
                    <li>
                        <?php if ($this->checkPosition('boat_options')) : ?>
                            <div class="uk-width-1-1 uk-margin-top options-container" data-id="<?php echo $storeItem->id; ?>">
                                <fieldset> 
                                    <legend>
                                        <?php echo JText::_('Boat Information'); ?>
                                    </legend>
                                    <div class="uk-grid">
                                        <?php echo $this->renderPosition('boat_options', array('style' => 'options')); ?>
                                        <div class="uk-width-1-1 options-container uk-margin-top">
                                            <?php if ($this->checkPosition('options')) : ?>
                                                <div class="uk-panel uk-panel-box">
                                                    <h3><?php echo JText::_('Options'); ?></h3>
                                                    <div class="validation-errors"></div>
                                                    <?php echo $this->renderPosition('options', array('style' => 'user_options')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        <?php endif; ?>
                        <p class="uk-text-danger">Please refer to important instructions in the measurement info tab above.</p>
                        <div class="uk-grid ubsk-measurements">
                            <?php if ($this->checkPosition('aft_measurements')) : ?>
                            <div class="uk-width-1-2">
                                <div class="uk-margin-top">
                                    <a href="<?php echo JURI::root(); ?>/images/ubs/order_form/diagram.png" data-lightbox title="">
                                        <img src="<?php echo JURI::root(); ?>/images/ubs/order_form/diagram.png" />
                                    </a>
                                </div>
                            </div>
                            <div id="ubsk-price"class="uk-width-1-2">
                                <i class="currency"></i>
                                <span class="price">0.00</span>
                            </div>
                            <div class="uk-width-1-2">
                                <p class="uk-text-danger" style="font-size:18px">Fill out the measurements below for your custom price.</p>
                            </div>
                            <div class="uk-width-1-2 uk-margin-top">
                                <fieldset> 
                                    <legend>
                                        <?php echo JText::_('Measurements'); ?>
                                    </legend>
                                    <div class="uk-grid">
                                        <div class="uk-width-1-1 ubsk-measurement">
                                            <label>1) From Rod Holder to Rod Holder</label>
                                            <div class="uk-grid">
                                                <div class="uk-width-2-6">
                                                    <input type="number" id="beam-width-ft" name="beam-width-ft" class="required" data-location="beam" data-unit="ft" min="6" value="7" />
                                                </div>
                                                <div class="uk-width-1-6">
                                                    ft
                                                </div>
                                                <div class="uk-width-2-6">
                                                   <input type="number" id="beam-width-in" name="beam-width-in" class="required" data-location="beam" data-unit="in" min="0" max="11" value="0" />
                                                </div>
                                                <div class="uk-width-1-6">
                                                    in
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1 ubsk-measurement">
                                            <label>2) Bridge Width Measurement</label>
                                            <div class="uk-grid">
                                                <div class="uk-width-2-6">
                                                    <input type="number" id="ttop-width-ft" name="bridge-width-ft" class="required" data-location="bridge_width" data-unit="ft" min="0" value="6" />
                                                </div>
                                                <div class="uk-width-1-6">
                                                    ft
                                                </div>
                                                <div class="uk-width-2-6">
                                                   <input type="number" id="ttop-width-in" name="bridge-width-in" class="required" data-location="bridge_width" data-unit="in" min="0" max="11" value="0" />
                                                </div>
                                                <div class="uk-width-1-6">
                                                    in
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1 ubsk-measurement">
                                            <label>3) Bridge to Rod Holders Measurement</label>
                                            <div class="uk-grid">
                                                <div class="uk-width-2-6">
                                                    <input type="number" id="depth-ft" name="depth-ft" class="required" data-location="depth" data-unit="ft" min="3" value="3" />
                                                </div>
                                                <div class="uk-width-1-6">
                                                    ft
                                                </div>
                                                <div class="uk-width-2-6">
                                                   <input type="number" id="depth-in" name="depth-in" class="required" data-location="depth" data-unit="in" min="0" max="11" value="10" />
                                                </div>
                                                <div class="uk-width-1-6">
                                                    in
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <?php endif; ?>
                        </div>
                    </li>
                    <?php if ($this->checkPosition('measurement_info')) : ?>
                    <li>
                        <?php echo $this->renderPosition('measurement_info', array('style' => 'bsk-measure-info')); ?>
                    </li>
                    <?php endif; ?>
                    <?php if ($this->checkPosition('tabs')) : ?>
                        <?php echo $this->renderPosition('tabs', array('style' => 'tab_content')); ?>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="uk-width-1-1 ubsk-results">

            </div>
        </div>
        <div class="uk-width-1-3 uk-margin-top">
            <div id="ubsk-total-price"class="uk-width-1-1">
                <i class="currency"></i>
                <span class="price">0.00</span>
            </div>
            <div class="uk-width-1-1">
                <p class="uk-text-danger" style="font-size:18px">Fill out the measurements below for your custom price.</p>
            </div>
            <div class="uk-width-1-1 addtocart-container uk-margin-top">
                <label>Quantity</label>
                <input id="qty-<?php echo $item->id; ?>" type="number" class="uk-width-1-1" name="qty" min="1" value ="1" />
                <div class="uk-margin-top">
                    <button id="atc-<?php echo $item->id; ?>" class="uk-button uk-button-danger"><i class="uk-icon-shopping-cart" data-store-cart style="margin-right:5px;"></i>Add to Cart</button>
                </div>
            </div>
            <div class="uk-width-1-1 uk-container-center uk-margin-top">
                <?php if ($this->checkPosition('product_info')) : ?>
                        <?php echo $this->renderPosition('product_info', array('style' => 'blank')); ?>
                <?php endif; ?>
            </div>
            <?php if ($this->checkPosition('accessories')) : ?>
            <div class="uk-width-1-1 uk-margin-top">
                    <fieldset>
                        <legend>Essential Accessories</legend>
                            <ul class="uk-list" data-uk-grid-margin>
                            <?php echo $this->renderPosition('accessories', array('style' => 'related')); ?>
                            </ul>
                    </fieldset>
            </div>
            <?php endif; ?>

        </div>
    </div>
    <div class="modals">
        <div id="confirm-modal" class="uk-modal">
            <div class="uk-modal-dialog">
                <div class="uk-grid" data-uk-grid-margin="">
                    <div class="uk-width-1-1">
                        <div class="uk-article-title uk-text-center">Confirmation</div>
                        <div class="uk-text-center uk-margin">By typing "yes" in the box below, I certify that the options that I have chosen are correct. I understand that a Boat Shade is a custom made product and that if I have chosen an option incorrectly it may lead to the Boat Shade not fitting my boat correctly.</div>
                        <div class="uk-text-center uk-margin">Your measurement will calculate the proper size of shade, because of the stretch of the fabric your shade will be sized down. This will allow tension on the shade to prevent any sag and to give your BSK a custom fit.</div>
                    </div>
                    <div class="uk-width-1-1"> 
                        <div class="item"></div>
                    </div>
                    <div class="uk-width-1-1">
                        <span>Type "yes" in the box below to confirm that your options have been chosen correctly.</span><br />
                        <span class="confirm-error uk-text-danger uk-text-small"></span><br />
                        <input type="text" name="accept" />
                    </div>
                    <div class="uk-width-1-1">
                        <div class="uk-grid">
                            <div class="uk-width-1-2">
                                <button class="uk-width-1-1 uk-button uk-button-danger confirm">Confirm</button>
                            </div>
                            <div class="uk-width-1-2">
                                <button class="uk-width-1-1 uk-button uk-button-danger cancel">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($this->checkPosition('modals')) : ?>        
            <?php echo $this->renderPosition('modals'); ?>
        <?php endif; ?>
        <div id="info_modal" class="uk-modal">
            <div class="uk-modal-dialog">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1">
                        <div class="uk-article-title uk-text-center uk-text-danger">Attention</div>
                        <p class="uk-text-center uk-margin ttop-modal-title"></p><p class="uk-text-center ttop-modal-subtitle" ></p>
                    </div>
                    <div class="uk-width-1-1">
<!--                        <img src="/images/ubs/ubs2.png" />-->
                    </div>
                    <div class="uk-width-1-1">
                        <div class="uk-grid">
                            <div class="uk-width-1-2">
                                <button class="uk-width-1-1 uk-button uk-button-danger confirm">Show Me</button>
                            </div>
                            <div class="uk-width-1-2">
                                <button class="uk-width-1-1 uk-button uk-button-danger cancel">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    var info_modal = jQuery.UIkit.modal('#info_modal');
    var mainItem = jQuery('#<?php echo $item->id; ?>:not(".related")');
    var UBSK = {
        price: 0.00,
        measurements_changed: false,
        options: {
            kit_option: {
                name: 'Kit Option',
                text: null,
                value: 'full'
            },
            shade_type: {
                name: 'Shade Type',
                text: null,
                value: 'regular',
                visible: false
            },
            beam: {
                name: 'Rod Holder to Rod Holder Measurement',
                text: null,
                value: 0
            }, 
            bridge_width: {
                name: 'Bridge Width Measurement',
                text: null,
                value: 0
            },
            depth: {
                name: 'Bridge to Rod Holder Measurement',
                text: null,
                value: 0
            }
            
        }
        
    };
    jQuery(document).ready(function($){
        mainItem.StoreItem({
            name: 'UltimateBoatShadeKit',
            validate: true,
            confirm: true,
            debug: true,
            events: {
                onInit: [
                    function (e) {
                        var self = this;
                        this.trigger('measure');
   
                        this.item.name = "Ultimate Boat Shade Kit";
                        $('.ubsk-measurement input').on('change', function(){
                            UBSK.measurements_changed = true;
                            self.trigger('measure',e);
                        });
                        }
                        
                ],
                onChanged: [
                    function (e) {
                        this.trigger('measure',e);
                        
                    }
                ],
                measure: [
                    function (e) {
                        var self = this;
                        UBSK.options = $.extend(true, UBSK.options,this._getOptions());
                        var options = this._getOptions();
                        UBSK.options.kit_option.text = options.ubsk_kit_options.text;
                        UBSK.options.kit_option.value = options.ubsk_kit_options.value;
                        getMeasurements();
                        checkMinandMax();
                        getPrice();
                        //displayResults();
                        function getMeasurements() {
                            var measurements = $('.ubsk-measurement input[type="number"]'), length = {};
                            
                            measurements.each(function(k,v){
                                
                                if(typeof length[$(this).data('location')] === 'undefined') {
                                    length[$(this).data('location')] = 0;
                                }
                                
                                if($(this).data('unit') === 'ft') {
                                    length[$(this).data('location')] += parseInt($(this).val())*12;
                                } else {
                                    length[$(this).data('location')] += parseInt($(this).val());
                                }
                                
                                $.each(length, function(k,v){
                                    UBSK.options[k].value = v;
                                    UBSK.options[k].text = v+' inches';
                                });
                            });
                        }
                        
                        function checkMinandMax() {
                            var beam = UBSK.options.beam, bridge_width = UBSK.options.bridge_width, depth = UBSK.options.depth, shade_type = UBSK.options.shade_type;
                            
                            // Checking depth and determine if it is an exended shade.
                            if (depth.value >= 54 && depth.value <= 80) {
                                shade_type.text = 'Regular';
                                shade_type.value = 'regular';
                            } else if (depth.value >= 81 ) {
                                shade_type.text = 'Extended';
                                shade_type.value = 'extended';
                            } 
                            // Checking Beam Width
                            switch (true) {
                                case beam.value < 84:
                                    self.trigger('beamTooSmall');
                                    break;
                                case beam.value > 222:
                                    self.trigger('beamTooLarge');
                            }
                            
                            // Checking Depth
                            switch (true) {
                                case depth.value < 46:
                                    self.trigger('depthTooSmall');
                                    break;
                                case depth.value > 105:
                                    self.trigger('depthTooLarge');
                            }

                            
                        }
                       
                        function getPrice() {
                            var price_array = self.$price.data('price'), price, m = UBSK.options.beam.value, shade_type = UBSK.options.shade_type.value, kit_option = UBSK.options.kit_option.value;
                            $.each(price_array.item, function(k,v){
                                if (m >= v.min && m <= v.max) {
                                    price = typeof v[shade_type][kit_option] === 'undefined' ? 'Choose Measurements' : v[shade_type][kit_option];
                                    return;
                                }
                            })
                            if(kit_option === 'fullwithcups' ) {
                                $.each(price_array.options.suction_cups, function(k,v) {
                                    if (m >= v.min && m <= v.max) {
                                        UBSK.options['suction_cups'] = {name: 'Suction Cups', text: k, value: k}; 
                                    }
                                   
                                })
                                
                            } else { 
                                delete UBSK.options.suction_cups;
                            }
                            UBSK.shipping = price_array.shipping[kit_option];
                            UBSK.price = price;
                            $('.ubsk-measurements .price').html(UBSK.price.toFixed(2));
                        }

                        function displayResults() {
                            var container = $('.ubsk-results');
                            container.html('');
                            $.each(UBSK.options, function(k,v){
                                container.append(v.name+': '+v.value+'</br>');
                            })


                        }
                        
                        this.price = UBSK.price;
                        this._publishPrice();
                    }
                ],
                beamTooSmall: [
                    function (e) {
                        var type = arguments[1][2];
                        $('#info_modal').find('.ttop-modal-title').html('We are sorry, but the measurements that you have entered are too small for our Ultimate Boat Shade Kit.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Please check out our Boat Shade Kit for smaller boats.');
                        
                        $('.ubsk-measurements #beam-width-ft').val(7);
                        $('.ubsk-measurements #beam-width-in').val(0).trigger('input');
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/store/boat-shade-kit';
                        }).html('Boat Shade Kit');
                        
                        $('#info_modal button.cancel').click(function(){
                            $('#info_modal button').off();
                            info_modal.hide();

                        });
                        
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        return false;
                    }
                ],
                beamTooLarge: [
                    function (e) {
                        var type = arguments[1][2];
                        $('#info_modal').find('.ttop-modal-title').html('The measurements you have selected falls outside of our standard Ultimate Boat Shade Kit.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Contact us for a modified custom Ultimate Boat Shade Kit.  Click the contact us button below for send us an email.');
                        
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/contact-us';
                        }).html('Contact Us');
                        
                        $('#info_modal button.cancel').click(function(){
                            $('.ubsk-measurements #beam-width-ft').val(18);
                            $('.ubsk-measurements #beam-width-in').val(6).trigger('input');
                            $('#info_modal button').off();
                            info_modal.hide();

                        });
                        
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        return false;
                    }
                ],
                bridgeTooSmall: [
                    function (e) {
                        var type = arguments[1][2];
                        $('#info_modal').find('.ttop-modal-title').html('We are sorry, but the measurements that you have entered are too small for our Boat Shade Kit.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Contact us and we may be able to make a custom shade kit for your boat.  Click the contact us button below for send us an email.');
                        
                        $('.ubsk-measurements #bridge-width-ft').val(4);
                        $('.ubsk-measurements #bridge-width-in').val(6).trigger('input');
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/contact-us';
                        }).html('Contact Us');
                        
                        $('#info_modal button.cancel').click(function(){
                            $('#info_modal button').off();
                            info_modal.hide();

                        });
                        
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        return false;
                    }
                ],
                bridgeTooLarge: [
                    function (e) {
                        var type = arguments[1][2];
                        $('#info_modal').find('.ttop-modal-title').html('Boats with a T-Top width measurement over 7\' 6" are too big for our Boat Shade Kit.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Please check out our Ultimate Boat Shade Kit for larger boats.');
                        
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/products/ultimate-boat-shade';
                        }).html('Ultimate Boat Shade Kit');
                        
                        $('#info_modal button.cancel').click(function(){
                            $('.bsk-type-'+type+' #ttop-width-ft').val(7);
                            $('.bsk-type-'+type+' #ttop-width-in').val(6).trigger('input');
                            $('#info_modal button').off();
                            info_modal.hide();

                        });
                        
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        return false;
                    }
                ],
                depthTooSmall: [
                    function(e) {
                        var type = arguments[1][2];
                        $('#info_modal').find('.ttop-modal-title').html('We are sorry, but the measurements that you have entered are too small for our Ultimate Boat Shade Kit.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Please check out our Boat Shade Kit for smaller boats.');

                        $('.ubsk-measurements #depth-ft').val(3);
                        $('.ubsk-measurements #depth-in').val(10).trigger('input');
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/store/boat-shade-kit';
                        }).html('Boat Shade Kit');

                        $('#info_modal button.cancel').click(function(){
                            $('#info_modal button').off();
                            info_modal.hide();

                        });

                        info_modal.options.bgclose = false;
                        info_modal.show();
                        return false;
                    }
                ],
                depthTooLarge: [
                    function (e) {
                        var type = arguments[1][2];
                        $('#info_modal').find('.ttop-modal-title').html('The measurements you have selected falls outside of our standard Ultimate Boat Shade Kit.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Contact us for a modified custom Ultimate Boat Shade Kit.  Click the contact us button below for send us an email.');
                        
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/contact-us';
                        }).html('Contact Us');
                        
                        $('#info_modal button.cancel').click(function(){
                            $('.ubsk-measurements #depth-ft').val(9);
                            $('.ubsk-measurements #depth-in').val(0).trigger('input');
                            $('#info_modal button').off();
                            info_modal.hide();

                        });
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        return false;
                    }
                ],
                measurementsNotChanged: [
                    function (e) {
                        var self = this;
                        $('#info_modal').find('.ttop-modal-title').html('The order form measurements have not been changed.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('The measurements on the order form are initially set to the lowest sizes that will work with the Ultimate Boat Shade Kit. Please make sure that the measurements entered match the measurements of your boat.  If the measurements in the order form are correct click Continue or click Back to correct them.');
                        
                        $('#info_modal button.confirm').click(function(){
                            UBSK.measurements_changed = true;
                            info_modal.hide();
                            self.addToCart();
                        }).html('Continue');
                            
                        $('#info_modal button.cancel').click(function(){
                            
                            $('#info_modal button').off();
                            info_modal.hide();
                            $(this).html('Cancel');

                        }).html('Back');

                        info_modal.options.bgclose = false;
                        info_modal.show();
                        return false;
                    }
                ],
                beforeAddToCart: [
                    function(e) {
                        if (!UBSK.measurements_changed) {
                            this.trigger('measurementsNotChanged');
                            return false;
                        }
                        var item = [], self = this;
                        item.push({
                            name: 'Ultimate Boat Shade -' + UBSK.options.kit_option.text,
                            id: self.item.id,
                            qty: self.qty,
                            price: self.price,
                            shipping: UBSK.shipping,
                            options: UBSK.options
                        });
                        return item;
                    }
                ]
            },
            removeValues: true,
            pricePoints: {
                item: ['aft_kit_class']
            }
            
            
            
            
        });
    })
</script>