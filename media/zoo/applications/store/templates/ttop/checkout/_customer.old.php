<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$elements = $this->order->elements;
$states = new SimpleUPS\PostalCodes();
?>

<div class="uk-width-2-3 uk-container-center"> 
        <div class="uk-width-1-1">
            <?php $this->form->setValues($elements->get('billing.')); ?>
            <?php if($this->form->checkGroup('billing')) : ?>
                <div class="uk-form-row">
                    <fieldset id="billing">
                        <legend>Billing Address</legend>
                        <?php echo $this->form->render('billing')?>
                    </fieldset>
                </div>
            <?php endif; ?>
            <?php $this->form->setValues($elements->get('shipping.')); ?>
            <?php if($this->form->checkGroup('shipping')) : ?>
                <div class="uk-form-row">
                    <fieldset id="shipping">
                        <legend>Shipping Address</legend>
                        <?php echo $this->form->render('shipping')?>
                    </fieldset>
                </div>
            <?php endif; ?>
            <fieldset id="billing">
                <div class="uk-grid" data-uk-margin>
                    <div class="uk-width-1-1">
                        <div class="uk-grid" data-uk-grid-match>
                            <div class="uk-width-1-1">
                                <legend>
                                    Billing Address 
                                </legend>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-1">
                        <input type="text" name="elements[billing][name]" class="ttop-checkout-field required" placeholder="First Name" value="<?php echo $elements->get('billing.name'); ?>"/>
                    </div>
                    <div class="uk-width-1-1">
                        <input type="text" name="elements[billing][street1]" class="ttop-checkout-field required"  placeholder="Street Address 1" value="<?php echo $elements->get('billing.street1'); ?>"/>
                    </div>
                    <div class="uk-width-1-1">
                        <input type="text" name="elements[billing][street2]" class="ttop-checkout-field"  placeholder="Street Address 2" value="<?php echo $elements->get('billing.street2'); ?>"/>
                    </div>
                    <div class="uk-width-5-10">
                        <input type="text" name="elements[billing][city]" class="ttop-checkout-field required"  placeholder="City" value="<?php echo $elements->get('billing.city'); ?>"/>
                    </div>
                    <div class="uk-width-2-10">
                        <?php echo $this->app->html->_('select.genericList',$states->getStates('US',true),'elements[billing][state]',array('class' => 'ttop-checkout-field required'),'value','text',$elements->get('billing.state'))?>
                    </div>
                    <div class="uk-width-3-10">
                        <input type="text" name="elements[billing][zip]" class="ttop-checkout-field required"  placeholder="Zip" value="<?php echo $elements->get('billing.zip'); ?>"/>
                    </div>
                    <div class="uk-width-1-1">
                        <input type="text" name="elements[billing][phoneNumber]" class="ttop-checkout-field required" placeholder="Phone Number" value="<?php echo $elements->get('billing.phoneNumber'); ?>"/>
                    </div>
                    <div class="uk-width-1-1">
                        <input type="text" name="elements[billing][altNumber]" class="ttop-checkout-field" placeholder="Alternate Phone Number" value="<?php echo $elements->get('billing.altNumber'); ?>"/>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="uk-width-1-1">
            <fieldset id="shipping">
                <div class="uk-grid" data-uk-margin>
                    <div class="uk-width-1-1">
                        <div class="uk-grid" data-uk-grid-match>
                            <div class="uk-width-1-1">
                                <legend>
                                    Shipping Address
                                    <div class="uk-form-controls uk-form-controls-text" style="float:right">
                                        <p class="uk-form-controls-condensed">
                                            <input type="checkbox" id="same_as_billing" class="ttop-checkout-field" name="same_as_billing" style="height:15px; width:15px;" />
                                            <label class="uk-text-small uk-margin-left" >Same as billing</label> 
                                        </p>
                                    </div>
                                </legend>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-1">
                        <input type="text" name="elements[shipping][name]"  class="ttop-checkout-field required" placeholder="First Name" value="<?php echo $elements->get('shipping.name'); ?>"/>
                    </div>
                    <div class="uk-width-1-1">
                        <input type="text" name="elements[shipping][street1]"  class="ttop-checkout-field required" placeholder="Street Address 1" value="<?php echo $elements->get('shipping.street1'); ?>"/>
                    </div>
                    <div class="uk-width-1-1">
                        <input type="text" name="elements[shipping][street2]"  class="ttop-checkout-field" placeholder="Street Address 2" value="<?php echo $elements->get('shipping.street2'); ?>"/>
                    </div>
                    <div class="uk-width-5-10">
                        <input type="text" name="elements[shipping][city]"  class="ttop-checkout-field required" placeholder="City" value="<?php echo $elements->get('shipping.city'); ?>"/>
                    </div>
                    <div class="uk-width-2-10">
                        <?php echo $this->app->html->_('select.genericList',$states->getStates('US',true),'elements[shipping][state]',array('class' => 'ttop-checkout-field required'),'value','text',$elements->get('shipping.state'))?>
                    </div>
                    <div class="uk-width-3-10">
                        <input type="text" name="elements[shipping][zip]"  class="ttop-checkout-field required" placeholder="Zip" value="<?php echo $elements->get('shipping.zip'); ?>" />
                    </div>
                    <div class="uk-width-1-1">
                        <input type="text" name="elements[shipping][phoneNumber]" class="ttop-checkout-field required" placeholder="Phone Number" value="<?php echo $elements->get('shipping.phoneNumber'); ?>"/>
                    </div>
                    <div class="uk-width-1-1">
                        <input type="text" name="elements[shipping][altNumber]" class="ttop-checkout-field" placeholder="Alternate Phone Number" value="<?php echo $elements->get('shipping.altNumber'); ?>"/>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class='uk-width-1-1'>
            <fieldset id="contact-info">
                <legend>
                    Other Information
                </legend>
                <div class="uk-grid" data-uk-margin>

                    <div class="uk-width-1-1">
                        <input type="email" class="uk-width-1-1 ttop-checkout-field required" name="elements[email]" placeholder="E-mail Address" value="<?php echo $elements->get('email'); ?>"/>
                    </div>
                    <div class="uk-width-1-1">
                        <input type="email" class="uk-width-1-1 ttop-checkout-field" name="elements[confirm_email]" placeholder="Confirm E-mail Address" value="<?php echo $elements->get('confirm_email'); ?>"/>
                    </div>
                    <div class="uk-width-1-1">
                        <fieldset id="shipping_method">
                            <input type="email" class="uk-width-1-1 ttop-checkout-field" name="elements[confirm_email]" placeholder="Confirm E-mail Address" value="<?php echo $elements->get('confirm_email'); ?>"/>
                        </fieldset>
                        
                    </div>
                    <div class='uk-width-1-1'>
                        <div class='uk-text-large'>Local Pickup</div>
                        <div class="uk-form-controls uk-form-controls-text">
                            <p class="uk-form-controls-condensed">
                                <input id="localPickup" type="checkbox" name="elements[localPickup]" style="height:15px; width:15px;" <?php echo ($elements->get('localPickup') ? 'checked' : ''); ?>/>
                                <label class="uk-text-small uk-margin-left" >I want to pickup my order at the T-top Covers location in North Charleston, SC.</label> 
                            </p>
                        </div>
                    </div>
                    
                </div>
            </fieldset>
        </div>
</div>