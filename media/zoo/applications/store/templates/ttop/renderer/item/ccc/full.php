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
$prices = $this->app->prices->create('ccc');
$data_item = array('id' => $item->id, 'name' => 'Center Console Curtain');
?>
<article>
    <span class="uk-article-title"><?php echo $item->name; ?></span>
</article>
<div id="<?php echo $item->id;?>" class="uk-form uk-margin" data-item='<?php echo json_encode($data_item); ?>'>
    <div class="uk-grid">
        <div class="uk-width-2-3 ccc-slideshow">
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
                            <div class="uk-width-1-1 uk-margin-top">
                                <fieldset> 
                                    <legend>
                                        <?php echo JText::_('Boat Information'); ?>
                                    </legend>
                                    <div class="uk-grid">
                                        <?php echo $this->renderPosition('boat_options', array('style' => 'options')); ?>
                                        
                                    </div>
                                </fieldset>
                            </div>
                        <?php endif; ?>
                        <p class="uk-text-danger">Please refer to the maintenance section in the Info & Video Tab above.</p>
                        <div class="uk-grid ccc-measurements">
                            <div class="uk-width-1-2">
                                <div class="uk-margin-top">
                                    <a href="<?php echo JURI::root(); ?>/images/curtain/order_form/diagram1.png" data-lightbox title="">
                                        <img src="<?php echo JURI::root(); ?>/images/curtain/order_form/diagram1.png" />
                                    </a>
                                </div>
                            </div>
                            <div class="uk-width-1-2">
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
                                        <div class="uk-width-1-1 ccc-measurement">
                                            <label>1) Height from T-Top to the Deck</label>
                                            <div class="uk-grid">
                                                <div class="uk-width-2-6">
                                                    <input type="number" id="ttop2deck-ft" name="ttop2deck-ft" class="required" data-unit="ft" min="5" value="6" />
                                                </div>
                                                <div class="uk-width-1-6">
                                                    ft
                                                </div>
                                                <div class="uk-width-2-6">
                                                   <input type="number" id="ttop2deck-in" name="ttop2deck-in" class="required" data-unit="in" min="0" max="11" value="4" />
                                                </div>
                                                <div class="uk-width-1-6">
                                                    in
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1 1 ccc-measurement">
                                            <label>2) Rear of Helm Seat to Front of Console Seat</label>
                                            <div class="uk-grid">
                                                <div class="uk-width-2-6">
                                                    <input type="number" id="helm2console-ft" name="helm2console-ft" class="required" data-unit="ft" min="5" value="6" />
                                                </div>
                                                <div class="uk-width-1-6">
                                                    ft
                                                </div>
                                                <div class="uk-width-2-6">
                                                   <input type="number" id="helm2console-in" name="helm2console-in" class="required" data-unit="in" min="0" max="11" value="3" />
                                                </div>
                                                <div class="uk-width-1-6">
                                                    in
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1 1 ccc-measurement">
                                            <label>3) Width of the Helm Seat</label>
                                            <div class="uk-grid">
                                                <div class="uk-width-2-6">
                                                    <input type="number" id="helmSeatWidth-ft" name="helmSeatWidth-ft" class="required" data-unit="ft" min="2" value="3" />
                                                </div>
                                                <div class="uk-width-1-6">
                                                    ft
                                                </div>
                                                <div class="uk-width-2-6">
                                                   <input type="number" id="helmSeatWidth-in" name="helmSeatWidth-in" class="required" data-unit="in" min="0" max="11" value="2" />
                                                </div>
                                                <div class="uk-width-1-6">
                                                    in
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="uk-width-1-1">
                                <label>Additional Information<span class="uk-text-small uk-margin-left">(other)</span></label>
                                <textarea class="uk-width-1-1 item-option" style="height:120px;" name="add_info" data-name="Additional Information"></textarea>
                            </div>
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
            <div class="uk-width-1-1 ccc-results">

            </div>
        </div>
        <div class="uk-width-1-3 uk-margin-top">
            <div class="uk-width-1-1 price-container">
                <span class="price"><i class="currency"></i><span id="price" data-price='<?php echo json_encode($prices); ?>'>0.00</span></span>
            </div>
            <div class="uk-width-1-1">
                <p class="uk-text-danger" style="font-size:18px">Fill out the measurements below for your custom price.</p>
            </div>
            <div class="uk-width-1-1 options-container uk-margin-top">
                <?php if ($this->checkPosition('options')) : ?>
                    <div class="uk-panel uk-panel-box">
                        <h3><?php echo JText::_('Options'); ?></h3>
                        <div class="validation-errors"></div>
                        <?php echo $this->renderPosition('options', array('style' => 'options')); ?>
                    </div>
                <?php endif; ?>
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
                        <div class="uk-text-center uk-margin">By typing "yes" in the box below, I certify that the options that I have chosen are correct. I understand that the Center Console Curtain is a custom made product and that if I have chosen an option incorrectly it may lead to the Curtain not fitting my boat correctly.</div>
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
    var CCC = {
        price: 0.00,
        type: null,
        measurements_changed: false,
        options: {
            ttop2deck: {
                name: 'T-Top to Deck Measurement',
                text: null,
                value: 0
            }, 
            helm2console: {
                name: 'Rear of Helm Seat to Front of Console Seat Measurement',
                text: null,
                value: 0
            },
            helmSeatWidth: {
                name: 'Width of Helm Seat Measurement',
                text: null,
                value: 0,
                min: 38,
                max: 50
            },
            curtain_class: {
                name: 'Curtain Class',
                text: null,
                value: null,
                visible: false
            }
            
        }
        
    };

    jQuery(document).ready(function($){
        function changeColor (w) {
            var colorValue = $('.item-option[name="color"]').val();
            var colors = {
                    '9oz': ['navy','black','gray','tan'],
                    '8oz': ['navy','black']
                }
            $('[name="color"] option').each(function(k,v){
                $(this).find('span').html('');
                if ($(this).prop('value') !== 'X') {
                    if($.inArray($(this).prop('value'), colors[w]) === -1) {
                        $(this).prop('disabled',true);
                        $(this).append('<span>- 9oz Fabric Only</span>');
                    } else {
                        $(this).prop('disabled',false);
                    }
                }
            });
            if ($('[name="color"] [value="'+colorValue+'"]').prop('disabled')) {
                $('.item-option[name="color"]').val('navy').trigger('input');
            }
        };
        mainItem.StoreItem({
            name: 'CenterConsoleCurtain',
            validate: true,
            confirm: true,
            debug: true,
            events: {
                onInit: [
                    function (e) {
                        var self = this;
                        this.trigger('measure',e);
   
                        this.item.name = "Center Console Curtain";
                        $('.ccc-measurement input').on('change', function(e){
                            CCC.measurements_changed = true;
                            self.trigger('measure',e);

                        });
                        $('[name="fabric"]').on('change',function(){
                            changeColor($(this).val());
                        })
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
                        CCC.options = $.extend(true, CCC.options,this._getOptions());
                        getMeasurements();
                        getCCCClass();
                        if (typeof e !== 'undefined') {
                            var pattern = /^helm2console/;
                            if(pattern.test($(e.target).prop('name'))) {
                                adjustHelmSeatWidth();
                            };    
                        }
                        checkMinandMax();
                        getPrice();
                        //displayResults();
                        function getMeasurements() {
                            var measurements = $('.ccc-measurement input[type="number"]'), length = {};
                            
                            measurements.each(function(k,v){

                                var name = $(this).prop('name');
                                name = name.substring(0,name.length - 3);
                                
                                if(typeof length[name] === 'undefined') {
                                    length[name] = 0;
                                }
                                
                                if($(this).data('unit') === 'ft') {
                                    length[name] += parseInt($(this).val())*12;
                                } else {
                                    length[name] += parseInt($(this).val());
                                }
                                $.each(length, function(k,v){
                                    CCC.options[k].value = v;
                                    CCC.options[k].text = v+' inches';
                                });
                            });
                        }
                        
                        function checkMinandMax() {
                            var ttop2deck = CCC.options.ttop2deck, helm2console = CCC.options.helm2console, helmSeatWidth = CCC.options.helmSeatWidth
                            
                            // Checking ttop2deck Width
                            switch (true) {
                                case ttop2deck.value < 76:
                                    self.trigger('ttop2deckTooSmall');
                                    break;
                                case ttop2deck.value > 88:
                                    self.trigger('ttop2deckTooLarge');
                                    break;
                            }
                            // Checking helm2console
                            switch(true) {
                                case helm2console.value < 75:
                                    self.trigger('helm2consoleTooSmall');
                                    break;
                                case helm2console.value > 133:
                                    self.trigger('helm2consoleTooLarge');
                                    break;
                            }
                            // Checking helmSeatWidth
                            switch(true) {
                                case helmSeatWidth.value < helmSeatWidth.min:
                                    self.trigger('helmSeatWidthTooSmall');
                                    break;
                                case helmSeatWidth.value > helmSeatWidth.max:
                                    self.trigger('helmSeatWidthTooLarge');
                                    break;
                            }

                            
                        }
                        function getCCCClass() {
                            
                            switch(true) {
                                case (CCC.options.helm2console.value >= 75 && CCC.options.helm2console.value <= 94):
                                    CCC.type = 'A';
                                    break;
                                case (CCC.options.helm2console.value >= 95 && CCC.options.helm2console.value <= 107):
                                    CCC.type = 'B';
                                    break;
                                case (CCC.options.helm2console.value >= 108 && CCC.options.helm2console.value <= 120):
                                    CCC.type = 'C';
                                    break;
                                case (CCC.options.helm2console.value >= 121 && CCC.options.helm2console.value <= 133):
                                    CCC.type = 'D';
                                    break;
                                default:
                                    CCC.type = 'Unknown';
                            }
                            CCC.options.curtain_class.value = CCC.type;
                            CCC.options.curtain_class.text = CCC.type + ' Class';

                                    
                        }
                        function adjustHelmSeatWidth() {
                            console.log('Helm Seat');
                            var elemFt = $('[name="helmSeatWidth-ft"]');
                            var elemIn = $('[name="helmSeatWidth-in"]');
                            switch(CCC.type) {
                                case 'A':
                                case 'B':
                                    CCC.options.helmSeatWidth.min = 38;
                                    CCC.options.helmSeatWidth.max = 50;
                                    CCC.options.helmSeatWidth.value = 38;
                                    elemFt.prop('min',2).val(3);
                                    elemIn.val(2);
                                    break;
                                case 'C':
                                    CCC.options.helmSeatWidth.min = 44;
                                    CCC.options.helmSeatWidth.max = 56;
                                    CCC.options.helmSeatWidth.value = 44;
                                    elemFt.prop('min',2).val(3);
                                    elemIn.val(8);
                                    break;
                                case 'D':
                                    CCC.options.helmSeatWidth.min = 45;
                                    CCC.options.helmSeatWidth.max = 62;
                                    CCC.options.helmSeatWidth.value = 50;
                                    elemFt.prop('min',3).val(4);
                                    elemIn.val(2);
                                    break;

                            }
                        }
                       
                        function getPrice() {
                            var price_array = self.$price.data('price'), price, $class = CCC.$class;
                            console.log(CCC);
                            price = price_array.item[CCC.type][CCC.options.fabric.value];
                            CCC.shipping = price_array.shipping
                            CCC.price = price;
                            $('.ccc-measurements .price').html(CCC.price.toFixed(2));
                        }

                        function displayResults() {
                            var container = $('.ccc-results');
                            container.html('');
                            $.each(CCC.options, function(k,v){
                                container.append(v.name+': '+v.value+'</br>');
                            })
                            container.append('Price: '+CCC.price+'</br>').append('Class: '+CCC.type+'</br>');
                            var inches = (CCC.options.helmSeatWidth.min%12)
                            var feet = Math.floor(CCC.options.helmSeatWidth.min / 12);
                            container.append(feet+' ft '+inches+' in </br>');


                        }
                        
                        this.price = CCC.price;
                        this._publishPrice();

                        }
                ],
                ttop2deckTooSmall: [
                    function (e) {
                        $('#info_modal').find('.ttop-modal-title').html('We are sorry, but the measurements that you have entered are too small for our Center Console Curtain.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Contact us for a modified custom Center Console Curtain.  Click the contact us button below to send us an email.');
                        
                        $('.ccc-measurement #ttop2deck-ft').val(6);
                        $('.ccc-measurement #ttop2deck-in').val(4);
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/contact-us';
                        }).html('Contact Us');
                        
                        $('#info_modal button.cancel').click(function(){
                            $('#info_modal button').off();
                            info_modal.hide();

                        });
                        this.trigger('measure',e);
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        return false;
                    }
                ],
                ttop2deckTooLarge: [
                    function (e) {
                        $('#info_modal').find('.ttop-modal-title').html('The measurements you have selected falls outside of our standard Center Console Curtain.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Contact us for a modified custom Center Console Curtain.  Click the contact us button below to send us an email.');
                        
                        $('.ccc-measurement #ttop2deck-ft').val(7);
                        $('.ccc-measurement #ttop2deck-in').val(4);
                        
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/contact-us';
                        }).html('Contact Us');
                        
                        $('#info_modal button.cancel').click(function(){
                            $('#info_modal button').off();
                            info_modal.hide();
                        });

                        this.trigger('measure',e);
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        return false;
                    }
                ],
                helm2consoleTooSmall: [
                    function (e) {
                        $('#info_modal').find('.ttop-modal-title').html('We are sorry, but the measurements that you have entered are too small for our Center Console Curtain.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Contact us and we may be able to make a custom curtain for your boat.  Click the contact us button below to send us an email.');
                        
                        $('.ccc-measurement #helm2console-ft').val(6);
                        $('.ccc-measurement #helm2console-in').val(3);
                        
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/contact-us';
                        }).html('Contact Us');
                        
                        $('#info_modal button.cancel').click(function(){
                            $('#info_modal button').off();
                            info_modal.hide();

                        });
                        this.trigger('measure',e);
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        return false;
                    }
                ],
                helm2consoleTooLarge: [
                    function (e) {
                        $('#info_modal').find('.ttop-modal-title').html('Boats with a helm to console measurement over 11\' 1" are too big for our Center Console Curtain.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Please call for a custom curtain.');
                        
                        $('.ccc-measurement #helm2console-ft').val(11);
                        $('.ccc-measurement #helm2console-in').val(1);
                        
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/contact-us';
                        }).html('Contact Us');
                        
                        $('#info_modal button.cancel').click(function(){  
                            $('#info_modal button').off();
                            info_modal.hide();
                        });
                        
                        this.trigger('measure',e);
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        return false;
                    }
                ],
                helmSeatWidthTooSmall: [
                    function(e) {
                        $('#info_modal').find('.ttop-modal-title').html('The helm seat width is too small.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Contact us for a modified custom Center Console Curtain.  Click the contact us button below to send us an email.');
                        
                        var inches = (CCC.options.helmSeatWidth.min%12)
                        var feet = Math.floor(CCC.options.helmSeatWidth.min / 12);
                        $('.ccc-measurement #helmSeatWidth-ft').val(feet);
                        $('.ccc-measurement #helmSeatWidth-in').val(inches);
                        
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/store/boat-shade-kit';
                        }).html('Boat Shade Kit');

                        $('#info_modal button.cancel').click(function(){
                            $('#info_modal button').off();
                            info_modal.hide();
                        });
                        this.trigger('measure',e);
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        return false;
                    }
                ],
                helmSeatWidthTooLarge: [
                    function (e) {
                        $('#info_modal').find('.ttop-modal-title').html('The helm seat width is too small.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Contact us for a modified custom Center Console Curtain.  Click the contact us button below to send us an email.');
                        
                        var inches = (CCC.options.helmSeatWidth.max%12)
                        var feet = Math.floor(CCC.options.helmSeatWidth.max / 12);
                        $('.ccc-measurement #helmSeatWidth-ft').val(feet);
                        $('.ccc-measurement #helmSeatWidth-in').val(inches);
                        
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/contact-us';
                        }).html('Contact Us');
                            
                        $('#info_modal button.cancel').click(function(){
                            
                            $('#info_modal button').off();
                            info_modal.hide();

                        });

                        this.trigger('measure',e);
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        return false;
                    }
                ],
                measurementsNotChanged: [
                    function (e) {
                        var self = this;
                        $('#info_modal').find('.ttop-modal-title').html('The order form measurements have not been changed.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('The measurements on the order form are initially set to the lowest sizes that will work with the Center Console Curtain. Please make sure that the measurements entered match the measurements of your boat.  If the measurements in the order form are correct click Continue or click Back to correct them.');
                        
                        $('#info_modal button.confirm').click(function(){
                            CCC.measurements_changed = true;
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
                        if (!CCC.measurements_changed) {
                            this.trigger('measurementsNotChanged');
                            return false;
                        }
                        var item = [], self = this;
                        item.push({
                            name: 'Center Console Curtain',
                            id: self.item.id,
                            qty: self.qty,
                            price: self.price,
                            shipping: self.shipping,
                            options: CCC.options
                        });
                        console.log(item);
                        return item;
                    }
                ]
            },
            removeValues: true,
            pricePoints: {
                item: ['']
            }
            
            
            
            
        });
    })
</script>