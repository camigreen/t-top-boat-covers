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
$data_item = array('id' => $item->id, 'name' => 'Center Console Curtain');
$storeItem = $this->app->item->create($item, 'ccc');
?>
<article>
    <span class="uk-article-title"><?php echo $item->name; ?></span>
</article>
<div id="storeItemForm" class="uk-form uk-margin" data-item='<?php echo json_encode($data_item); ?>'>
    <div id="<?php echo $storeItem->id ?>" class="uk-grid storeItem" data-item="<?php echo $storeItem->getItemsJSON(); ?>">
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
                            <div class="uk-width-1-1 uk-margin-top options-container" data-id="ccc">
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
                                <div class="uk-width-1-1 uk-grid price-container">
                                    <?php if ($this->checkPosition('pricing')) : ?>
                                            <?php echo $this->renderPosition('pricing', array('item' => $storeItem)); ?>
                                    <?php endif; ?>
                                </div>
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
                                                   <input type="number" id="ttop2deck" name="ttop2deck" class="required" min="0" value="76" />
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
                                                   <input type="number" id="helm2console" name="helm2console" class="required" min="0" value="75" />
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
                                                   <input type="number" id="helmSeatWidth" name="helmSeatWidth" class="required" min="0" value="38" />
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
            <div class="uk-width-1-1 uk-grid price-container">
                <?php if ($this->checkPosition('pricing')) : ?>
                        <?php echo $this->renderPosition('pricing', array('item' => $storeItem)); ?>
                <?php endif; ?>
            </div>
            <div class="uk-width-1-1">
                <p class="uk-text-danger" style="font-size:18px">Fill out the measurements below for your custom price.</p>
            </div>
            <div class="uk-width-1-1 options-container uk-margin-top" data-id="ccc">
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
                <input id="qty-ccc" type="number" class="uk-width-1-1 qty" name="qty" min="1" value ="1" />
                <div class="uk-margin-top">
                    <button id="atc-ccc" class="uk-button uk-button-danger atc" data-id="ccc"><i class="uk-icon-shopping-cart" style="margin-right:5px;"></i>Add to Cart</button>
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
                    <div class="uk-width-1-1">
                        <input type="hidden" name="cart_id" value="" />
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
        $('#storeItemForm').StoreItem({
            name: 'CenterConsoleCurtain',
            validate: false,
            debug: true,
            events: {
                onInit: [
                    function (data) {
                        var self = this;
                        this.trigger('measure');
   
                        $('.ccc-measurement input').on('change', function(e){
                            CCC.measurements_changed = true;
                            var adjust = false;
                            if($(e.target).prop('name') === 'helm2console') {
                                adjust = true;
                            }
                            self.trigger('measure',{adjustHSW: adjust});

                        });
                        $('[name="fabric"]').on('change',function(){
                            changeColor($(this).val());
                        })
                        return data;
                    }
                       
                ],
                beforeChange: [
                    function (data) {
                        return data;
                    }
                ],
                measure: [
                    function (data) {
                        var self = this;
                        CCC.options = $.extend(true, CCC.options,this._getOptions());
                        getMeasurements();
                        getCCCClass();
                        var adjust = typeof data.args.adjustHSW === 'undefined' ? false : data.args.adjustHSW;
                        if(adjust) {
                            adjustHelmSeatWidth();
                        }
                        checkMinandMax();


                        function getMeasurements() {
                            var measurements = $('.ccc-measurement input[type="number"]'), length = {};
                            
                            measurements.each(function(k,v){

                                var name = $(this).prop('name');
                                console.log(name);
                                value = $(v).val();
                                CCC.options[name].value = value;
                                CCC.options[name].text = value+' inches';
                            });
                            console.log(CCC);
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
                            self.items['ccc'].price_group = 'ccc.'+CCC.type;

                                    
                        }
                        function adjustHelmSeatWidth() {
                            console.log('Helm Seat');
                            var elem = $('[name="helmSeatWidth"]');
                            switch(CCC.type) {
                                case 'A':
                                case 'B':
                                    CCC.options.helmSeatWidth.min = 38;
                                    CCC.options.helmSeatWidth.max = 50;
                                    CCC.options.helmSeatWidth.value = 38;
                                    elem.val(38);
                                    break;
                                case 'C':
                                    CCC.options.helmSeatWidth.min = 44;
                                    CCC.options.helmSeatWidth.max = 56;
                                    CCC.options.helmSeatWidth.value = 44;
                                    elem.val(44);
                                    break;
                                case 'D':
                                    CCC.options.helmSeatWidth.min = 45;
                                    CCC.options.helmSeatWidth.max = 62;
                                    CCC.options.helmSeatWidth.value = 50;
                                    elem.val(50);
                                    break;

                            }
                        }
                        console.log(this.items);
                        this._publishPrice(this.items['ccc']);
                        return data;
                        }
                ],
                beforePublishPrice: [],
                afterPublishPrice: [],
                ttop2deckTooSmall: [
                    function (data) {
                        $('#info_modal').find('.ttop-modal-title').html('We are sorry, but the measurements that you have entered are too small for our Center Console Curtain.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Contact us for a modified custom Center Console Curtain.  Click the contact us button below to send us an email.');
                        
                        $('.ccc-measurement #ttop2deck').val(76);
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/contact-us';
                        }).html('Contact Us');
                        
                        $('#info_modal button.cancel').click(function(){
                            $('#info_modal button').off();
                            info_modal.hide();

                        });
                        this.trigger('measure');
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        data.triggerResult = false;
                        return data;
                    }
                ],
                ttop2deckTooLarge: [
                    function (data) {
                        $('#info_modal').find('.ttop-modal-title').html('The measurements you have selected falls outside of our standard Center Console Curtain.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Contact us for a modified custom Center Console Curtain.  Click the contact us button below to send us an email.');
                        
                        $('.ccc-measurement #ttop2deck').val(85);
                        
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/contact-us';
                        }).html('Contact Us');
                        
                        $('#info_modal button.cancel').click(function(){
                            $('#info_modal button').off();
                            info_modal.hide();
                        });

                        this.trigger('measure');
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        data.triggerResult = false;
                        return data;
                    }
                ],
                helm2consoleTooSmall: [
                    function (data) {
                        $('#info_modal').find('.ttop-modal-title').html('We are sorry, but the measurements that you have entered are too small for our Center Console Curtain.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Contact us and we may be able to make a custom curtain for your boat.  Click the contact us button below to send us an email.');
                        
                        $('.ccc-measurement #helm2console').val(75);
                        
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/contact-us';
                        }).html('Contact Us');
                        
                        $('#info_modal button.cancel').click(function(){
                            $('#info_modal button').off();
                            info_modal.hide();

                        });
                        this.trigger('measure');
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        data.triggerResult = false;
                        return data;
                    }
                ],
                helm2consoleTooLarge: [
                    function (data) {
                        $('#info_modal').find('.ttop-modal-title').html('Boats with a helm to console measurement over 11\' 1" are too big for our Center Console Curtain.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Please call for a custom curtain.');
                        
                        $('.ccc-measurement #helm2console').val(133);
                        
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/contact-us';
                        }).html('Contact Us');
                        
                        $('#info_modal button.cancel').click(function(){  
                            $('#info_modal button').off();
                            info_modal.hide();
                        });
                        
                        this.trigger('measure');
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        data.triggerResult = false;
                        return data;
                    }
                ],
                helmSeatWidthTooSmall: [
                    function (data) {
                        $('#info_modal').find('.ttop-modal-title').html('The helm seat width is too small.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Contact us for a modified custom Center Console Curtain.  Click the contact us button below to send us an email.');
                        
                        $('.ccc-measurement #helmSeatWidth').val(38);
                        
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/store/boat-shade-kit';
                        }).html('Boat Shade Kit');

                        $('#info_modal button.cancel').click(function(){
                            $('#info_modal button').off();
                            info_modal.hide();
                        });
                        this.trigger('measure');
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        data.triggerResult = false;
                        return data;
                    }
                ],
                helmSeatWidthTooLarge: [
                    function (data) {
                        $('#info_modal').find('.ttop-modal-title').html('The helm seat width is too small.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Contact us for a modified custom Center Console Curtain.  Click the contact us button below to send us an email.');
                        
                        $('.ccc-measurement #helmSeatWidth').val(50);
                        
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/contact-us';
                        }).html('Contact Us');
                            
                        $('#info_modal button.cancel').click(function(){
                            
                            $('#info_modal button').off();
                            info_modal.hide();

                        });

                        this.trigger('measure');
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        data.triggerResult = false;
                        return data;
                    }
                ],
                measurementsNotChanged: [
                    function (data) {
                        var self = this;
                        $('#info_modal').find('.ttop-modal-title').html('The order form measurements have not been changed.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('The measurements on the order form are initially set to the lowest sizes that will work with the Center Console Curtain. Please make sure that the measurements entered match the measurements of your boat.  If the measurements in the order form are correct click Continue or click Back to correct them.');
                        
                        $('#info_modal button.confirm').click(function(){
                            CCC.measurements_changed = true;
                            info_modal.hide();
                            $('#atc-ccc').trigger('click');
                        }).html('Continue');
                            
                        $('#info_modal button.cancel').click(function(){
                            
                            $('#info_modal button').off();
                            info_modal.hide();
                            $(this).html('Cancel');

                        }).html('Back');

                        info_modal.options.bgclose = false;
                        info_modal.show();
                        data.triggerResult = false;
                        return data;
                    }
                ],
                beforeAddToCart: [
                    function(data) {
                        console.log(CCC);
                        if (!CCC.measurements_changed) {
                            this.trigger('measurementsNotChanged');
                            data.triggerResult = false;
                            return data;
                        }
                        var item = data.args.items['ccc'], items = {};
                        item.options = $.extend(true,item.options,CCC.options);
                        data.args.items['ccc'] = item;

                        console.log(item);
                        return data;
                    }
                ],
                afterAddToCart: [
                    function (data) {
                        CCC.measurements_changed = false;
                        return data;
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