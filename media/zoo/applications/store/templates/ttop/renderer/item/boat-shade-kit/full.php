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
    <div id="<?php echo $item->id; ?>" data-item='<?php echo $storeItem->getItemsJSON(); ?>' class="uk-grid storeItem">
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
                                    <li class="active" data-value="aft">
                                        <div class="bsk-button">
                                            <img src="<?php echo JURI::root(); ?>images/bsk/order_form/aft.jpg" />
                                            <p>Aft Only<br/>(One Shade)</p>
                                        </div>
                                    </li>
                                    <li data-value="bow">
                                        <div class="bsk-button">
                                            <img src="<?php echo JURI::root(); ?>images/bsk/order_form/bow.jpg" />
                                            <p>Bow Only<br/>(One Shade)</p>
                                        </div>
                                    </li>
                                    <li data-value="bow|aft">
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
                                <div class="uk-grid bsk-type bsk-type-aft active">
                                    <?php if ($this->checkPosition('aft_measurements')) : ?>
                                    <div class="uk-width-1-2">
                                        <div class="uk-margin-top">
                                            <a href="<?php echo JURI::root(); ?>/images/bsk/order_form/aft_diagram.png" data-lightbox title="">
                                                <img src="<?php echo JURI::root(); ?>/images/bsk/order_form/aft_diagram.png" />
                                            </a>
                                        </div>
                                    </div>
                                    <div id="bsk-aft-price"class="uk-width-1-2">
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
                                                           <input type="number" id="beam-width-in" name="beam-width-in" class="required" data-location="beam" data-unit="in" min="0" value="72" />
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
                                                           <input type="number" id="ttop-width-in" name="ttop-width-in" class="required" data-location="ttop" data-unit="in" min="0" value="54" />
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
                                                           <input type="number" id="ttop2rod-in" name="ttop2rod-in" class="required" data-location="ttop2rod" data-unit="in" min="0" value="24" disabled />
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
                                <div class="uk-grid bsk-type bsk-type-bow">
                                    <?php if ($this->checkPosition('bow_measurements')) : ?>
                                    <div class="uk-width-1-2 ">
                                        <div class="uk-margin-top">
                                            <a href="<?php echo JURI::root(); ?>/images/bsk/order_form/bow_diagram.png" data-lightbox title="">
                                                <img src="<?php echo JURI::root(); ?>/images/bsk/order_form/bow_diagram.png" />
                                            </a>
                                        </div>
                                    </div>
                                    <div id="bsk-bow-price" class="uk-width-1-2">
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
                                                           <input type="number" id="beam-width-in" name="beam-width-in" class="required" data-location="beam" data-unit="in" min="0" value="72" />
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
                                                           <input type="number" id="ttop-width-in" name="ttop-width-in" class="required" data-location="ttop" data-unit="in" min="0" value="54" />
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
                                                           <input type="number" id="ttop2rod-in" name="ttop2rod-in" class="required" data-location="ttop2rod" data-unit="in" min="0" value="24" disabled/>
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
                    <div class="uk-width-1-3">
                    </div>
                </div>
                <div class="uk-width-1-3 uk-margin-top">
                    <div id="bsk-total-price"class="uk-width-1-1">
                        <i class="currency"></i>
                        <span class="price">0.00</span>
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
    var total = {};
    var tempItem = {};
    var measurements = {
        types: ['aft'],
        aft: {
            name: 'Boat Shade Kit',
            price: 0.00,
            shipping: 0.00,
            measurements_changed: false,
            location: {
                beam: {
                    total: 0,
                    min: 72,
                    max: 126
                },
                ttop: {
                    total: 0,
                    min: 54,
                    max: 90
                },
                ttop2rod: {
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
        bow: {
            name: 'Boat Shade Kit',
            price: 0.00,
            shipping: 0.00,
            measurements_changed: false,
            location: {
                beam: {
                    total: 0,
                    min: 72,
                    max: 126
                },
                ttop: {
                    total: 0,
                    min: 54,
                    max: 90
                },
                ttop2rod: {
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
                            $.each(self.items, function(k,v) {
                                if(v.type === 'bsk') {
                                    tempItem = v;
                                    createItems();
                                }
                            });

                            var type = measurements.types;

                            self.type = 'bsk';

                            $('#use_on_bow').on('change',function(e){
                                self.trigger('measure', {type: ['aft']});
                            });

                            $('.bsk-chooser .bsk-chooser-buttons li').on('click',function(e){
                                    var index = $(this).index();
                                    var type = $('.bsk-chooser .bsk-chooser-buttons li:eq('+index+')').data('value');
                                    $('.bsk-chooser .bsk-chooser-buttons li').removeClass('active');
                                    $('.bsk-chooser .bsk-chooser-buttons li:eq('+index+')').addClass('active');
                                    $('.bsk-chooser .full-pic li').removeClass('active');
                                    $('.bsk-chooser .full-pic li:eq('+index+')').addClass('active');
                                    $('.bsk-type').removeClass('active');

                                    if(type === 'bow|aft') {
                                        $('.bsk-type').addClass('active');
                                        type = ['aft','bow'];
                                    } else {
                                        $('.bsk-type-'+type).addClass('active');
                                        type = [type];
                                    }
                                    measurements.types = type;
                                    createItems();
                                    self.trigger('measure', {type: type});
                            })

                            $('.bow-measurements input').on('change',function(){
                                measurements.bow.measurements_changed = true;
                                self.current_items['bsk-bow'] = self.items['bsk-bow'];
                                self.trigger('measure', {type: ['bow']});
                                

                            });
                            $('.aft-measurements input').on('change',function(e){
                                measurements.aft.measurements_changed = true;
                                self.current_items['bsk-aft'] = self.items['bsk-aft'];
                                self.trigger('measure', {type: ['aft']});

                            });

                            this.trigger('measure', {type: type});

                            function createItems() {
                                var item = tempItem;
                                delete self.items[item.id];
                                var fields = self.fields[item.id];
                                delete self.fields[item.id];
                                self.current_items = {};
                                $.each(measurements.types, function(k, type) {
                                    self.items['bsk-'+type] = item;
                                    self.items['bsk-'+type].price_group = 'bsk.'+measurements.aft.kit.class
                                    self.items['bsk-'+type].id = 'bsk-'+type;
                                    self.fields['bsk-'+type] = fields;
                                    self.current_items['bsk-'+type] = self.items['bsk-'+type];
                                });
                            }
                            
                        }
                            
                            
                    ],
                    measure: [
                        function (args) {
                            var types = args.type;
                            if(measurements.types.length > 1) {
                                $('#use_on_bow').closest('label').hide();
                                $('#use_on_bow').prop('checked',false);
                            } else {
                                $('#use_on_bow').closest('label').show();
                            }
                            
                            this.$atc.prop('disabled',true);
                            // Collect values from all of the inputs to calculate the measurements.
                            var self = this, m = measurements;
                            console.log(types)
                            $.each(types, function(k, type) {
                                getMeasurements(type);
                                if (checkMinAndMax(type)) {
                                    $('.bsk-type-'+type+' input').prop('disabled', false);
                                } else {
                                    return false;
                                };
                                getBSKClass(type);
                            })

                            function getMeasurements(type) {

                                $('.bsk-type-' + type + ' input[type="number"]:not(.qty)').each(function(k,v) {
                                    var location = $(this).data('location'), val = parseInt($(this).val());
                                    m[type].location[location].total = val;
                                });  
                            }
                            
                            function checkMinAndMax(type) {
                                var result = true;
                                var args = {type: type};
                                $.each(m[type].location, function(k,v){
                                    if (v.total < v.min) {
                                        self.trigger(k+'TooSmall',args);
                                        result =  false;
                                    }
                                    if(v.total > v.max) {
                                        self.trigger(k+'TooLarge',args);
                                        result = false;
                                    }
                                });

                                m[type].kit.tapered = (m[type].location.ttop.total >= m[type].tapered.min && m[type].location.ttop.total <= m[type].tapered.max);
                                $('[name="'+type+'_kit_tapered"]').val(m[type].kit.tapered ? 'Tapered' : 'Not Tapered');
                                return result;
                            }
                            
                            function getBSKClass(type) {
                                var kit_class;
                                var old_class = m[type].kit.class;
                                switch(true) {
                                    case (m[type].location.ttop2rod.total >= 24 && m[type].location.ttop2rod.total <= 48):
                                        self.$atc.prop('disabled',false);
                                        kit_class = ($('#use_on_bow').is(':checked') ? 'B' : 'A');
                                        break;
                                    case (m[type].location.ttop2rod.total >= 49 && m[type].location.ttop2rod.total <= 65):
                                        self.$atc.prop('disabled',false);
                                        kit_class = ($('#use_on_bow').is(':checked') ? 'C' : 'B');
                                        break;
                                    case (m[type].location.ttop2rod.total >= 66 && m[type].location.ttop2rod.total <= 83):
                                        self.$atc.prop('disabled',false);
                                        kit_class = ($('#use_on_bow').is(':checked') ? 'D' : 'C');
                                        break;
    								case (m[type].location.ttop2rod.total >= 84 && m[type].location.ttop2rod.total <= 96):
                                        self.$atc.prop('disabled',false);
                                        kit_class = ($('#use_on_bow').is(':checked') ? 'E' : 'D');
                                        break;
                                    default:
                                        kit_class = 'Unknown';
                                        
                                }

                                m[type].kit.class = kit_class;
                                if(old_class !== kit_class) {
                                    self.items['bsk-'+type].price_group = 'bsk.'+kit_class;
                                    self._publishPrice(self.items['bsk-'+type]);
                                }
                            }
                        }
                    ],
                    onChanged: [
                    ],
                    onPublishPrice: [
                        function (args) {
                            total[args.id] = args.price;
                            var t = 0;
                            $.each(total, function(k, v){
                                t = t+v;
                            })
                            $('#bsk-total-price span').html(t.toFixed(2));
                            return args;
                        }
                    ],
                    beamTooLarge: [
                        function (args) {
                            var type = args.type;
                            $('#toUBSK').find('.ttop-modal-title').html('Boats with a beam measurement over '+measurements[type].location.beam.max+' inches are too big for our Boat Shade Kit.');
                            $('#toUBSK').find('.ttop-modal-subtitle').html('Please check out our Ultimate Boat Shade Kit for larger boats.');
                            
                            $('#toUBSK button.confirm').click(function(){
                                window.location = '/products/ultimate-boat-shade';
                            }).html('Ultimate Boat Shade Kit');
                            
                            $('#toUBSK button.cancel').click(function(){
                                $('.bsk-type-'+type+' #beam-width-in').val(measurements[type].location.beam.max).trigger('input');
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
                        function (args) {
                            var type = args.type;
                            $('#toUBSK').find('.ttop-modal-title').html('Boats with a T-Top width measurement over '+measurements[type].location.ttop.max+' inches are too big for our Boat Shade Kit.');
                            $('#toUBSK').find('.ttop-modal-subtitle').html('Please check out our Ultimate Boat Shade Kit for larger boats.');
                            
                            $('#toUBSK button.confirm').click(function(){
                                window.location = '/products/ultimate-boat-shade';
                            }).html('Ultimate Boat Shade Kit');
                            
                            $('#toUBSK button.cancel').click(function(){
                                $('.bsk-type-'+type+' #ttop-width-in').val(measurements[type].location.ttop.max).trigger('input');
                                $('#toUBSK button').off();
                                toUBSK_modal.hide();

                            });
                            
                            toUBSK_modal.options.bgclose = false;
                            toUBSK_modal.show();
                            return false;
                        }
                    ],
                    ttop2rodTooSmall: [
                        function(args) {
                            var type = args.type;
                            $('#toUBSK').find('.ttop-modal-title').html('We are sorry, but boats with a T-Top to Rod Holder measurement less than '+measurements[type].location.ttop2rod.min+' inches are too small for our Boat Shade Kit.');
                            $('#toUBSK').find('.ttop-modal-subtitle').html('Contact us and we may be able to make a custom shade kit for your boat.  Click the contact us button below for send us an email.');

                            $('.bsk-type-'+type+' #ttop2rod-in').val(measurements[type].location.ttop2rod.min).trigger('change');
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
                        function (args) {
                            var type = args.type;
                            console.log(type);
                            $('#toUBSK').find('.ttop-modal-title').html('Boats with a T-Top to Rod Holder measurement over '+measurements[type].location.ttop2rod.max+' inches on the '+type+' are too big for our Boat Shade Kit.');
                            $('#toUBSK').find('.ttop-modal-subtitle').html('Please check out our Ultimate Boat Shade Kit for larger boats.');
                            
                            $('#toUBSK button.confirm').click(function(){
                                window.location = '/products/ultimate-boat-shade';
                            }).html('Ultimate Boat Shade Kit');
                            
                            $('#toUBSK button.cancel').click(function(){
                                $('.bsk-type-'+type+' #ttop2rod-in').val(measurements[type].location.ttop2rod.max).trigger('change');
                                $('#toUBSK button').off();
                                toUBSK_modal.hide();

                            });
                            toUBSK_modal.options.bgclose = false;
                            toUBSK_modal.show();
                            return false;
                        }
                    ],
                    beamTooSmall: [
                        function (args) {
                            var type = args.type;
                            $('#toUBSK').find('.ttop-modal-title').html('We are sorry, but boats with a beam measurement less than '+measurements[type].location.beam.min+' inches are too small for our Boat Shade Kit.');
                            $('#toUBSK').find('.ttop-modal-subtitle').html('Contact us and we may be able to make a custom shade kit for your boat.  Click the contact us button below to send us an email.');
                            
                            $('.bsk-type-'+type+' #beam-width-in').val(measurements[type].location.beam.min).trigger('input');
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
                        function (args) {
                            var type = args.type;
                            $('#toUBSK').find('.ttop-modal-title').html('We are sorry, but boats with a beam measurement less than '+measurements[type].location.ttop.min+' inches are too small for our Boat Shade Kit.');
                            $('#toUBSK').find('.ttop-modal-subtitle').html('Contact us and we may be able to make a custom shade kit for your boat.  Click the contact us button below for send us an email.');
                            
                            $('.bsk-type-'+type+' #ttop-width-in').val(measurements[type].location.ttop.min).trigger('input');
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
                        function (args) {
                            var self = this, type = args.type;
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
                        function (args) {
                            var boat_options = this._getOptions();
                            var m = measurements, types = m.types, self = this;
                            var items = [];
                            $.each(types, function(k,v){
                                if(!m[v].measurements_changed) {
                                    self.trigger('measurementsNotChanged', {type: v});
                                    items = false;
                                    return false;
                                }
                                var kit = m[v];
                                var item = self.items['bsk-'+v];
                                item.name = 'Boat Shade Kit - '+v;
                                item.options.tapered = {
                                        name: 'Tapered',
                                        value: 'y',
                                        text: (kit.kit.tapered ? 'Yes' : 'No'),
                                        visible: false
                                    };
                                item.options.kit_type = {
                                        name: 'Kit Type',
                                        value: v,
                                        text: v
                                    };
                                item.options.kit_class = {
                                        name: 'Class',
                                        value: kit.kit.class,
                                        text: kit.kit.class,
                                        visible: false
                                    };
                                item.options.beam_width = {
                                        name: 'Beam Width',
                                        value: kit.location.beam.total,
                                        text: kit.location.beam.total+' in'
                                    };
                                item.options.ttop_width = {
                                        name: 'T-Top Width',
                                        value: kit.location.ttop.total,
                                        text: kit.location.ttop.total+' in'
                                    };
                                item.options.ttop2rod = {
                                        name: 'T-Top to Rod Holders',
                                        value: kit.location.ttop2rod.total,
                                        text: kit.location.ttop2rod.total+' in'
                                    };  
                                items.push(item);
                            });
                            console.log(items);
                            return items;
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