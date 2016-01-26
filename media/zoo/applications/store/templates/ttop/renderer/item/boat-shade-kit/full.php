<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
$priceOptions = $this->app->parameter->create();
$priceOptions->set('group', 'bsk')->set('options.', array('A', 'full'));
$class = $item->type.'-full';
$data_item = array('id' => $item->id, 'name' => 'Boat Shade Kit');
$storeItem = $this->app->item->create($item, 'bsk');

?>
<article>
    <span class="uk-article-title"><?php echo $item->name; ?></span>
</article>
<div id="storeOrderForm" class="<?php echo $item->type; ?>">
    <div id="<?php echo $item->id; ?>-aft" data-item='<?php echo $storeItem->getItemsJSON(); ?>' class="uk-grid bsk-type bsk-type-Aft active storeItem">
    <div class="uk-form uk-margin main-item" >
        <div class="uk-grid">
                <div class="uk-width-2-3">
                    <div class="uk-width-1-1">
                        <div class="uk-grid uk-text-center bsk-chooser">
                            <div class="uk-width-1-1">
                                <ul class="uk-list full-pic">
                                    <li class="active"><img src="<?php echo JURI::root(); ?>images/bsk/order_form/aft.jpg" /></li>
                                    <li><img src="<?php echo JURI::root(); ?>images/bsk/order_form/bow.jpg" /></li>
                                    <li><img src="<?php echo JURI::root(); ?>images/bsk/order_form/bow_aft.jpg" /></li>
                                </ul>  
                            </div>
                            <div class="uk-width-1-1 uk-text-center">
                                <p>Please choose how you will be using your T-Top Covers Boat Shade Kit by clicking on one of the pictures below.</p>
                            </div>
                            <div class="uk-width-1-1">
                                <ul class="uk-grid uk-grid-width-1-4 bsk-chooser-buttons">
                                    <li class="active" data-value="Aft">
                                        <div class="bsk-button">
                                            <img src="<?php echo JURI::root(); ?>images/bsk/order_form/aft.jpg" />
                                            <p>Aft Only<br/>(One Shade)</p>
                                        </div>
                                    </li>
                                    <li data-value="Bow">
                                        <div class="bsk-button">
                                            <img src="<?php echo JURI::root(); ?>images/bsk/order_form/bow.jpg" />
                                            <p>Bow Only<br/>(One Shade)</p>
                                        </div>
                                    </li>
                                    <li data-value="Bow|Aft">
                                        <div class="bsk-button">
                                            <img src="<?php echo JURI::root(); ?>images/bsk/order_form/bow_aft.jpg" />
                                            <p>Bow and Aft<br/>(Two Shades)</p>
                                        </div>
                                    </li>
                                </ul> 
                            </div> 
                        </div>
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
                                    <div class="uk-width-1-1 options-container uk-margin-top">
                                        <?php if ($this->checkPosition('options')) : ?>
                                            <div class="uk-panel uk-panel-box">
                                                <h3><?php echo JText::_('Options'); ?></h3>
                                                <div class="validation-errors"></div>
                                                <?php echo $this->renderPosition('options', array('style' => 'user_options')); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <p class="uk-text-danger">Please refer to the note and maintenance section in the Info and Video Tab above.</p>
                                    <?php if ($this->checkPosition('aft_measurements')) : ?>
                                    <div class="uk-width-1-2">
                                        <div class="uk-margin-top">
                                            <a href="<?php echo JURI::root(); ?>/images/bsk/order_form/aft_diagram.png" data-lightbox title="">
                                                <img src="<?php echo JURI::root(); ?>/images/bsk/order_form/aft_diagram.png" />
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
                                        <label><input type="checkbox" id="use_on_bow" name="use_on_bow" /> I want to use this shade on my bow also.<a href="#multipositional-modal" class="uk-icon-button uk-icon-info-circle" data-uk-tooltip="" title="Click here for more info!" data-uk-modal=""></a></label>
                                        <fieldset class="aft-measurements"> 
                                            <legend>
                                                <?php echo JText::_('Aft Measurements'); ?>
                                            </legend>
                                            <div class="uk-grid">
                                                <div class="uk-width-1-1 beam-measurement">
                                                    <label>1) From Rod Holder to Rod Holder</label>
                                                    <div class="uk-grid">
                                                        <div class="uk-width-2-6">
                                                            <input type="number" id="beam-width-ft" name="beam-width-ft" class="item-option required" data-location="beam" data-unit="ft" min="5" value="6" />
                                                        </div>
                                                        <div class="uk-width-1-6">
                                                            ft
                                                        </div>
                                                        <div class="uk-width-2-6">
                                                           <input type="number" id="beam-width-in" name="beam-width-in" class="item-option required" data-location="beam" data-unit="in" min="0" max="11" value="0" />
                                                        </div>
                                                        <div class="uk-width-1-6">
                                                            in
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="uk-width-1-1 ttop-measurement">
                                                    <label>2) T-Top Width Measurement</label>
                                                    <div class="uk-grid">
                                                        <div class="uk-width-2-6">
                                                            <input type="number" id="ttop-width-ft" name="ttop-width-ft" class="item-option required" data-location="ttop" data-unit="ft" min="3" value="4" />
                                                        </div>
                                                        <div class="uk-width-1-6">
                                                            ft
                                                        </div>
                                                        <div class="uk-width-2-6">
                                                           <input type="number" id="ttop-width-in" name="ttop-width-in" class="item-option required" data-location="ttop" data-unit="in" min="0" max="11" value="6" />
                                                        </div>
                                                        <div class="uk-width-1-6">
                                                            in
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="uk-width-1-1 ttop-rod-measurement">
                                                    <label>3) T-Top to Rod Holders Measurement</label>
                                                    <div class="uk-grid">
                                                        <div class="uk-width-2-6">
                                                            <input type="number" id="ttop2rod-ft" name="ttop2rod-ft" class="item-option required" data-location="ttop2rod" data-unit="ft" min="1" value="2" disabled />
                                                        </div>
                                                        <div class="uk-width-1-6">
                                                            ft
                                                        </div>
                                                        <div class="uk-width-2-6">
                                                           <input type="number" id="ttop2rod-in" name="ttop2rod-in" class="item-option required" data-location="ttop2rod" data-unit="in" min="0" max="11" value="0" disabled />
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
                                    <?php if ($this->checkPosition('bow_measurements')) : ?>
                                    <div class="uk-width-1-2 ">
                                        <div class="uk-margin-top">
                                            <a href="<?php echo JURI::root(); ?>/images/bsk/order_form/bow_diagram.png" data-lightbox title="">
                                                <img src="<?php echo JURI::root(); ?>/images/bsk/order_form/bow_diagram.png" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-2">
                                        <i class="currency"></i>
                                            <span class="price">0.00</span>

                                    </div>
                                    <div class="uk-width-1-2 uk-margin-top">
                                        <fieldset class="bow-measurements"> 
                                            <legend>
                                                <?php echo JText::_('Bow Measurements'); ?>
                                            </legend>
                                            <div class="uk-grid">
                                                <div class="uk-width-1-1 measurement">
                                                    <label>1) From Rod Holder to Rod Holder</label>
                                                    <div class="uk-grid">
                                                        <div class="uk-width-2-6">
                                                            <input type="number" id="beam-width-ft" name="beam-width-ft" class="item-option required" data-location="beam" data-unit="ft" min="5" value="6" />
                                                        </div>
                                                        <div class="uk-width-1-6">
                                                            ft
                                                        </div>
                                                        <div class="uk-width-2-6">
                                                           <input type="number" id="beam-width-in" name="beam-width-in" class="item-option required" data-location="beam" data-unit="in" min="0" max="11" value="0" />
                                                        </div>
                                                        <div class="uk-width-1-6">
                                                            in
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="uk-width-1-1 measurement">
                                                    <label>2) T-Top Width Measurement</label>
                                                    <div class="uk-grid">
                                                        <div class="uk-width-2-6">
                                                            <input type="number" id="ttop-width-ft" name="ttop-width-ft" class="item-option required" data-location="ttop" data-unit="ft" min="3" value="4" />
                                                        </div>
                                                        <div class="uk-width-1-6">
                                                            ft
                                                        </div>
                                                        <div class="uk-width-2-6">
                                                           <input type="number" id="ttop-width-in" name="ttop-width-in" class="item-option required" data-location="ttop" data-unit="in" min="0" max="11" value="6" />
                                                        </div>
                                                        <div class="uk-width-1-6">
                                                            in
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="uk-width-1-1 measurement">
                                                    <label>3) T-Top to Rod Holders Measurement</label>
                                                    <div class="uk-grid">
                                                        <div class="uk-width-2-6">
                                                            <input type="number" id="ttop2rod-ft" name="ttop2rod-ft" class="item-option required" data-location="ttop2rod" data-unit="ft" min="1" value="2" disabled />
                                                        </div>
                                                        <div class="uk-width-1-6">
                                                            ft
                                                        </div>
                                                        <div class="uk-width-2-6">
                                                           <input type="number" id="ttop2rod-in" name="ttop2rod-in" class="item-option required" data-location="ttop2rod" data-unit="in" min="0" max="11" value="6" disabled/>
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
                <div class="uk-width-1-3">
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
                    <div class="uk-width-1-1 addtocart-container uk-margin-top">
                        <label>Quantity</label>
                        <input id="qty-<?php echo $item->id; ?>" type="number" class="uk-width-1-1 qty" name="qty" min="1" value ="1" />
                        <div class="uk-margin-top">
                            <button id="atc-<?php echo $item->id; ?>" class="uk-button uk-button-danger atc"><i class="uk-icon-shopping-cart" data-store-cart style="margin-right:5px;"></i>Add to Cart</button>
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
            <div id="toUBSK" class="uk-modal">
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
</div>
<script>
    var toUBSK_modal = jQuery.UIkit.modal('#toUBSK');
    var measurements = {
        type: 'Aft',
        option: {
            text: null,
            value: null
        },
        Aft: {
            name: 'Boat Shade Kit',
            price: 0.00,
            shipping: 0.00,
            measurements_changed: false,
            location: {
                beam: {
                    units: {
                        ft: 0,
                        in: 0
                    },
                    total: 0,
                    min: 72,
                    max: 126
                },
                ttop: {
                    units: {
                        ft: 0,
                        in: 0
                    },
                    total: 0,
                    min: 54,
                    max: 90
                },
                ttop2rod: {
                    units: {
                        ft: 0,
                        in: 0
                    },
                    total: 0,
                    min: 24,
                    max: 83
                }
            },
            tapered: {
                min: 54,
                max: 59
            },
            kit: {
                class: 'unknown',
                tapered: false
            }
        },
        Bow: {
            name: 'Boat Shade Kit',
            price: 0.00,
            shipping: 0.00,
            measurements_changed: false,
            location: {
                beam: {
                    units: {
                        ft: 0,
                        in: 0
                    },
                    total: 0,
                    min: 72,
                    max: 126
                },
                ttop: {
                    units: {
                        ft: 0,
                        in: 0
                    },
                    total: 0,
                    min: 54,
                    max: 90
                },
                ttop2rod: {
                    units: {
                        ft: 0,
                        in: 0
                    },
                    total: 0,
                    min: 24,
                    max: 96
                }
            },
            tapered: {
                min: 54,
                max: 59
            },
            kit: {
                class: 'unknown',
                tapered: false
            }
        }
    } 
    jQuery(document).ready(function($){
        $('#storeOrderForm').StoreItem({
            name: 'BoatShadeKit',
            validate: true,
            confirm: true,
            debug: true,
            events: {
                onInit: [
                    function (e) {
                        var self = this;
                        this.trigger('measure');
                        $('#use_on_bow').on('change',function(e){
                            self.trigger('measure',e);
                        });
                        $('.bsk-chooser .bsk-chooser-buttons li').on('click',function(e){
                                var index = $(this).index();
                                var type = $('.bsk-chooser .bsk-chooser-buttons li:eq('+index+')').data('value');
                                $('.bsk-chooser .bsk-chooser-buttons li').removeClass('active');
                                $('.bsk-chooser .bsk-chooser-buttons li:eq('+index+')').addClass('active');
                                $('.bsk-chooser .full-pic li').removeClass('active');
                                $('.bsk-chooser .full-pic li:eq('+index+')').addClass('active');
                                measurements.type = type;
                                measurements.option.value = $('[name="bsk_kit_options"]').val();
                                measurements.option.text = $('[name="bsk_kit_options"]').find('option:selected').text();
                                $('.bsk-type').removeClass('active');

                                if(type === 'Bow|Aft') {
                                    $('.bsk-type').addClass('active');
                                } else {
                                    $('.bsk-type-'+type).addClass('active');
                                }
                                
                                self.trigger('measure',e);
                        })

                        $('.bow-measurements input').on('input',function(){
                            measurements.Bow.measurements_changed = true;


                        });
                        $('.aft-measurements input').on('input',function(){
                            measurements.Aft.measurements_changed = true;
                            console.log(measurements);

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
                        if(measurements.type === 'Bow|Aft') {
                            $('#use_on_bow').closest('label').hide();
                            $('#use_on_bow').prop('checked',false);
                        } else {
                            $('#use_on_bow').closest('label').show();
                        }
                        
                        this.$atc.prop('disabled',true);
                        // Collect values from all of the inputs to calculate the measurements.
                        var self = this, m = measurements, type = m.type.split('|'), calc = $('.calc');
                        m.option.value = $('[name="bsk_kit_options"]').val();
                        m.option.text = $('[name="bsk_kit_options"]').find('option:selected').text();
                        $.each(type, function(k,v) {
                            getMeasurements(v);
                            if (checkMinAndMax(v)) {
                                $('.bsk-type-'+v+' input').prop('disabled', false);
                            } else {
                                return false;
                            };
                            getBSKClass(v);
                        });
                        function getMeasurements(type) {

                            $('.bsk-type-' + type + ' input[type="number"]:not(.qty)').each(function(k,v) {
                                console.log($(this));
                                console.log($(this).data('location'));
                                var location = $(this).data('location'), unit = $(this).data('unit'), val = parseInt($(this).val());
                                m[type].location[location].units[unit] = val;
                            });
                            $.each(m[type].location, function(k,v) {
                                v.total = (v.units.ft*12)+v.units.in;
                            });
                            
                        }
                        
                        function checkMinAndMax(type) {
                            var result = true;
                            $.each(m[type].location, function(k,v){
                                if (v.total < v.min) {
                                    self.trigger(k+'TooSmall',type);
                                    result =  false;
                                }
                                if(v.total > v.max) {
                                    self.trigger(k+'TooLarge',type);
                                    result = false;
                                }
                            });

                            m[type].kit.tapered = (m[type].location.ttop.total >= m[type].tapered.min && m[type].location.ttop.total <= m[type].tapered.max);
                            $('[name="'+type+'_kit_tapered"]').val(m[type].kit.tapered ? 'Tapered' : 'Not Tapered');
                            return result;
                        }
                        
                        function getBSKClass(type) {
                            var BSK_class = $('[name="'+type+'_kit_class"]'), kit_class;
                            switch(true) {
                                case (m[type].location.ttop2rod.total >= 24 && m[type].location.ttop2rod.total <= 48):
                                    self.$atc.prop('disabled',false);
                                    kit_class = ($('#use_on_bow').is(':checked') ? 'B' : 'A')
                                    BSK_class.val(kit_class);
                                    break;
                                case (m[type].location.ttop2rod.total >= 49 && m[type].location.ttop2rod.total <= 65):
                                    self.$atc.prop('disabled',false);
                                    kit_class = ($('#use_on_bow').is(':checked') ? 'C' : 'B')
                                    BSK_class.val(kit_class);
                                    break;
                                case (m[type].location.ttop2rod.total >= 66 && m[type].location.ttop2rod.total <= 83):
                                    self.$atc.prop('disabled',false);
                                    kit_class = ($('#use_on_bow').is(':checked') ? 'D' : 'C')
                                    BSK_class.val(kit_class);
                                    break;
								case (m[type].location.ttop2rod.total >= 84 && m[type].location.ttop2rod.total <= 96):
                                    self.$atc.prop('disabled',false);
                                    kit_class = ($('#use_on_bow').is(':checked') ? 'E' : 'D')
                                    BSK_class.val(kit_class);
                                    break;
                                default:
                                    kit_class = 'Unknown';
                                    BSK_class.val(kit_class);
                                    
                            }
                            m[type].kit.class = kit_class;
                        }
                        function getPrice(type) {
                            var BSK_class = m[type].kit.class;
                            var BSK_package = m.option.value;
                            var priceData = {group: 'bsk', options: [BSK_class, BSK_package]};
                            console.log(priceData);
                                $.ajax({
                                    type: 'POST',
                                    url: "?option=com_zoo&controller=store&task=getPrice&format=json",
                                    data: priceData,
                                    success: function(data){
                                        m[type].price = data.price;
                                        var elem = $('#'+self.item.id+'-price span');
                                        console.log(elem)
                                        var price = 0;
                                        if(m.type === 'Bow|Aft') {
                                            price = m.Aft.price + m.Bow.price;
                                        } else {
                                            price = m[type].price;
                                        }
                                        $('.bsk-type-Aft span.price').html(m.Aft.price.toFixed(2));
                                        $('.bsk-type-Bow span.price').html(m.Aft.price.toFixed(2));
                                        price = self.trigger('onPublishPrice', price);
                                        console.log(price);
                                        elem.html(price.toFixed(2));
                                        
                                    },
                                    error: function(data, status, error) {
                                        var elem = $('#'+self.item.id+'-price span');
                                        elem.html('ERROR');
                                        console.log('Error');
                                        console.log(status);
                                        console.log(error);
                                    },
                                    dataType: 'json'
                            });
                            // var price_array = self.$price.data('price').item;
                            // var shipping = self.$price.data('price').shipping;
                            // m[type].price = price_array[BSK_class][m.option.value];
                            // m[type].shipping = shipping[m.option.value];
                            // $('.bsk-type-'+type+' .price').html(m[type].price.toFixed(2));
                            // if(m.type === 'Bow|Aft') {
                            //     self.price = m.Aft.price + m.Bow.price;
                            //     self._publishPrice();
                            // } else {
                            //     self.price = m[type].price;
                            //     self._publishPrice();
                            // }
                        }
                    }
                ],
                beamTooLarge: [
                    function (e, args) {
                        var type = args[0];
                        $('#toUBSK').find('.ttop-modal-title').html('Boats with a beam measurement over 10\' 6" are too big for our Boat Shade Kit.');
                        $('#toUBSK').find('.ttop-modal-subtitle').html('Please check out our Ultimate Boat Shade Kit for larger boats.');
                        
                        $('#toUBSK button.confirm').click(function(){
                            window.location = '/products/ultimate-boat-shade';
                        }).html('Ultimate Boat Shade Kit');
                        
                        $('#toUBSK button.cancel').click(function(){
                            $('.bsk-type-'+type+' #beam-width-ft').val(10);
                            $('.bsk-type-'+type+' #beam-width-in').val(6).trigger('input');
                            $('#toUBSK button').off();
                            $('#toUBSK button.confirm').html('Show Me');
                            toUBSK_modal.hide();

                        });
                        
                        toUBSK_modal.options.bgclose = false;
                        toUBSK_modal.show();
                        return false;
                    }
                ],
                ttopTooLarge: [
                    function (e, args) {
                        var type = args[0];
                        $('#toUBSK').find('.ttop-modal-title').html('Boats with a T-Top width measurement over 7\' 6" are too big for our Boat Shade Kit.');
                        $('#toUBSK').find('.ttop-modal-subtitle').html('Please check out our Ultimate Boat Shade Kit for larger boats.');
                        
                        $('#toUBSK button.confirm').click(function(){
                            window.location = '/products/ultimate-boat-shade';
                        }).html('Ultimate Boat Shade Kit');
                        
                        $('#toUBSK button.cancel').click(function(){
                            $('.bsk-type-'+type+' #ttop-width-ft').val(7);
                            $('.bsk-type-'+type+' #ttop-width-in').val(6).trigger('input');
                            $('#toUBSK button').off();
                            toUBSK_modal.hide();

                        });
                        
                        toUBSK_modal.options.bgclose = false;
                        toUBSK_modal.show();
                        return false;
                    }
                ],
                ttop2rodTooSmall: [
                    function(e, args) {
                        var type = args[0];
                        $('#toUBSK').find('.ttop-modal-title').html('We are sorry, but the measurements that you have entered are too small for our Boat Shade Kit.');
                        $('#toUBSK').find('.ttop-modal-subtitle').html('Contact us and we may be able to make a custom shade kit for your boat.  Click the contact us button below for send us an email.');

                        $('.bsk-type-'+type+' #ttop2rod-ft').val(2);
                        $('.bsk-type-'+type+' #ttop2rod-in').val(0).trigger('input');
                        $('#toUBSK button.confirm').click(function(){
                            window.location = '/contact-us';
                        }).html('Contact Us');

                        $('#toUBSK button.cancel').click(function(){
                            $('#toUBSK button').off();
                            toUBSK_modal.hide();

                        });

                        toUBSK_modal.options.bgclose = false;
                        toUBSK_modal.show();
                        return false;
                    }
                ],
                ttop2rodTooLarge: [
                    function (e, args) {
                        var type = args[0];
                        $('#toUBSK').find('.ttop-modal-title').html('Boats with a T-Top to Rod Holder measurement over 6\' 11" on the aft are too big for our Boat Shade Kit. Boats with a T-Top to Rod Holder measurement over 8\' on the bow are too big for our Boat Shade Kit.');
                        $('#toUBSK').find('.ttop-modal-subtitle').html('Please check out our Ultimate Boat Shade Kit for larger boats.');
                        
                        $('#toUBSK button.confirm').click(function(){
                            window.location = '/products/ultimate-boat-shade';
                        }).html('Ultimate Boat Shade Kit');
                        
                        $('#toUBSK button.cancel').click(function(){
                            $('.bsk-type-'+type+' #ttop2rod-ft').val(6);
                            $('.bsk-type-'+type+' #ttop2rod-in').val(11).trigger('input');
                            $('#toUBSK button').off();
                            toUBSK_modal.hide();

                        });
                        toUBSK_modal.options.bgclose = false;
                        toUBSK_modal.show();
                        return false;
                    }
                ],
                beamTooSmall: [
                    function (e, args) {
                        var type = args[0];
                        $('#toUBSK').find('.ttop-modal-title').html('We are sorry, but the measurements that you have entered are too small for our Boat Shade Kit.');
                        $('#toUBSK').find('.ttop-modal-subtitle').html('Contact us and we may be able to make a custom shade kit for your boat.  Click the contact us button below to send us an email.');
                        
                        $('.bsk-type-'+type+' #beam-width-ft').val(6);
                        $('.bsk-type-'+type+' #beam-width-in').val(0).trigger('input');
                        $('#toUBSK button.confirm').click(function(){
                            window.location = '/contact-us';
                        }).html('Contact Us');
                        
                        $('#toUBSK button.cancel').click(function(){
                            $('#toUBSK button').off();
                            toUBSK_modal.hide();

                        });
                        
                        toUBSK_modal.options.bgclose = false;
                        toUBSK_modal.show();
                        return false;
                    }
                ],
                ttopTooSmall: [
                    function (e, args) {
                        var type = args[0];
                        $('#toUBSK').find('.ttop-modal-title').html('We are sorry, but the measurements that you have entered are too small for our Boat Shade Kit.');
                        $('#toUBSK').find('.ttop-modal-subtitle').html('Contact us and we may be able to make a custom shade kit for your boat.  Click the contact us button below for send us an email.');
                        
                        $('.bsk-type-'+type+' #ttop-width-ft').val(4);
                        $('.bsk-type-'+type+' #ttop-width-in').val(6).trigger('input');
                        $('#toUBSK button.confirm').click(function(){
                            window.location = '/contact-us';
                        }).html('Contact Us');
                        
                        $('#toUBSK button.cancel').click(function(){
                            $('#toUBSK button').off();
                            toUBSK_modal.hide();

                        });
                        
                        toUBSK_modal.options.bgclose = false;
                        toUBSK_modal.show();
                        return false;
                    }
                ],
                measurementsNotChanged: [
                    function (e, args) {
                        var self = this, type = args[0];
                        $('#toUBSK').find('.ttop-modal-title').html('The order form measurements for the '+type+' Shade Kit have not been changed.');
                        $('#toUBSK').find('.ttop-modal-subtitle').html('The measurements on the order form are initially set to the lowest sizes that will work with the Boat Shade Kit. Please make sure that the measurements entered match the measurements of your boat.  If the measurements in the order form are correct click Continue or click Back to correct them.');
                        
                        $('#toUBSK button.confirm').click(function(){
                            measurements[type].measurements_changed = true;
                            toUBSK_modal.hide();
                            self.addToCart();
                        }).html('Continue');
                            
                        $('#toUBSK button.cancel').click(function(){
                            
                            $('#toUBSK button').off();
                            toUBSK_modal.hide();
                            $(this).html('Cancel');

                        }).html('Back');

                        toUBSK_modal.options.bgclose = false;
                        toUBSK_modal.show();
                        return false;
                    }
                ],
                beforeAddToCart: [
                    function(e, args) {
                        var boat_options = this._getOptions();
                        var m = measurements, type = m.type.split('|'), item = [], self = this;
                        $.each(type, function(k,v){
                            if(!m[v].measurements_changed) {
                                self.trigger('measurementsNotChanged', v);
                                item = false;
                            }
                            var kit = m[v];
                            item.push({
                                name: m.option.text + ' - ' + v,
                                id: self.item.id,
                                qty: self.qty,
                                price: kit.price,
                                shipping: kit.shipping,
                                options: {
                                    boat_make: {
                                        name: 'Boat Make',
                                        text: boat_options.boat_make.value,
                                    },
                                    boat_model: {
                                        name: 'Boat Model',
                                        text: boat_options.boat_model.value
                                    },
                                    boat_style: {
                                        name: 'Boat Style',
                                        text: boat_options.boat_style.text
                                    },
                                    boat_year: {
                                        name: 'Boat Year',
                                        text: boat_options.year.text
                                    },
                                    ttop_type: {
                                        name: 'TTop Type',
                                        text: boat_options.top_type.text
                                    },
                                    tapered: {
                                        name: 'Tapered',
                                        text: (kit.kit.tapered ? 'Yes' : 'No'),
                                        visible: false
                                    },
                                    kit_type: {
                                        name: 'Kit Type',
                                        text: v
                                    },
                                    kit_class: {
                                        name: 'Class',
                                        text: kit.kit.class,
                                        visible: false
                                    },
                                    beam_width: {
                                        name: 'Beam Width',
                                        text: kit.location.beam.total+' in'
                                    },
                                    ttop_width: {
                                        name: 'T-Top Width',
                                        text: kit.location.ttop.total+' in'
                                    },
                                    ttop2rod: {
                                        name: 'T-Top to Rod Holders',
                                        text: kit.location.ttop2rod.total+' in'
                                    }
                                }
                            });
                            
                        })
                        
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