<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$order = $CR->order;
$states = new SimpleUPS\PostalCodes();
?>

<div class="uk-width-2-3 uk-container-center">
    <?php if($order->hasSalesperson()) : ?>
    <div class="uk-width-1-1 uk-margin-bottom">
        <fieldset id="salesperson">
            <div class="uk-grid" data-uk-margin>
                <div class="uk-width-1-1">
                    <legend>Salesperson Info</legend>
                </div>
                <div class="uk-width-1-3">
                    <label>Service Fee</label>
                    <select class="uk-width-1-1" name="service_fee" >
                        <option value='0' <?php echo $order->service_fee == 0 ? 'selected' : ''; ?>>No Fee</option>
                        <option value='0.01' <?php echo $order->service_fee == 0.01 ? 'selected' : ''; ?>>1%</option>
                        <option value='0.02' <?php echo $order->service_fee == 0.02 ? 'selected' : ''; ?>>2%</option>
                        <option value='0.03' <?php echo $order->service_fee == 0.03 ? 'selected' : ''; ?>>3%</option>
                    </select>
                </div>
                <div class="uk-width-1-3">
                    <label>Dealer Discount</label>
                    <select class="uk-width-1-1" name="discount" value="<?php echo $order->discount; ?>">
                        <option value='0' <?php echo $order->service_fee == 0 ? 'selected' : ''; ?>>Not a Dealer</option>
                        <option value='0.2' <?php echo $order->service_fee == 0.2 ? 'selected' : ''; ?>>20%</option>
                        <option value='0.25' <?php echo $order->service_fee == 0.25 ? 'selected' : ''; ?>>25%</option>
                        <option value='0.3' <?php echo $order->service_fee == 0.3 ? 'selected' : ''; ?>>30%</option>
                        <option value='0.35' <?php echo $order->service_fee == 0.35 ? 'selected' : ''; ?>>35%</option>
                    </select>
                </div>
            </div>
        </fieldset>
    </div>
    <?php endif; ?>   
        <div class="uk-width-1-1">
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
                    <div class="uk-width-1-2">
                        <input type="text" name="customer[billing][firstname]" class="ttop-checkout-field required" placeholder="First Name" value="<?php echo $order->billing->get('firstname'); ?>"/>
                    </div>
                    <div class="uk-width-1-2">
                        <input type="text" name="customer[billing][lastname]" class="ttop-checkout-field required" placeholder="Last" value="<?php echo $order->billing->get('lastname'); ?>"/>
                    </div>
                    <div class="uk-width-1-1">
                        <input type="text" name="customer[billing][address]" class="ttop-checkout-field required"  placeholder="Address" value="<?php echo $order->billing->get('address'); ?>"/>
                    </div>
                    <div class="uk-width-5-10">
                        <input type="text" name="customer[billing][city]" class="ttop-checkout-field required"  placeholder="City" value="<?php echo $order->billing->get('city'); ?>"/>
                    </div>
                    <div class="uk-width-2-10">
                        <?php echo $this->app->html->_('select.genericList',$states->getStates('US',true),'customer[billing][state]',array('class' => 'ttop-checkout-field required'),'value','text',$order->billing->get('state'))?>
                    </div>
                    <div class="uk-width-3-10">
                        <input type="text" name="customer[billing][zip]" class="ttop-checkout-field required"  placeholder="Zip" value="<?php echo $order->billing->get('zip'); ?>"/>
                    </div>
                    <div class="uk-width-1-1">
                        <input type="text" name="customer[billing][phoneNumber]" class="ttop-checkout-field required" placeholder="Phone Number" value="<?php echo $order->billing->get('phoneNumber'); ?>"/>
                    </div>
                    <div class="uk-width-1-1">
                        <input type="text" name="customer[billing][altNumber]" class="ttop-checkout-field" placeholder="Alternate Phone Number" value="<?php echo $order->billing->get('altNumber'); ?>"/>
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
                    <div class="uk-width-1-2">
                        <input type="text" name="customer[shipping][firstname]"  class="ttop-checkout-field required" placeholder="First Name" value="<?php echo $order->shipping->get('firstname'); ?>"/>
                    </div>
                    <div class="uk-width-1-2">
                        <input type="text" name="customer[shipping][lastname]"  class="ttop-checkout-field required" placeholder="Last" value="<?php echo $order->shipping->get('lastname'); ?>"/>
                    </div>
                    <div class="uk-width-1-1">
                        <input type="text" name="customer[shipping][address]"  class="ttop-checkout-field required" placeholder="Address" value="<?php echo $order->shipping->get('address'); ?>"/>
                    </div>
                    <div class="uk-width-5-10">
                        <input type="text" name="customer[shipping][city]"  class="ttop-checkout-field required" placeholder="City" value="<?php echo $order->shipping->get('city'); ?>"/>
                    </div>
                    <div class="uk-width-2-10">
                        <?php echo $this->app->html->_('select.genericList',$states->getStates('US',true),'customer[shipping][state]',array('class' => 'ttop-checkout-field required'),'value','text',$order->shipping->get('state'))?>
                    </div>
                    <div class="uk-width-3-10">
                        <input type="text" name="customer[shipping][zip]"  class="ttop-checkout-field required" placeholder="Zip" value="<?php echo $order->shipping->get('zip'); ?>" />
                    </div>
                    <div class="uk-width-1-1">
                        <input type="text" name="customer[shipping][phoneNumber]" class="ttop-checkout-field required" placeholder="Phone Number" value="<?php echo $order->shipping->get('phoneNumber'); ?>"/>
                    </div>
                    <div class="uk-width-1-1">
                        <input type="text" name="customer[shipping][altNumber]" class="ttop-checkout-field" placeholder="Alternate Phone Number" value="<?php echo $order->shipping->get('altNumber'); ?>"/>
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
                        <input type="email" class="uk-width-1-1 ttop-checkout-field required" name="customer[billing][email]" placeholder="E-mail Address" value="<?php echo $order->billing->get('email'); ?>"/>
                    </div>
                    <div class="uk-width-1-1">
                        <input type="email" class="uk-width-1-1 ttop-checkout-field" name="customer[billing][confirm_email]" placeholder="Confirm E-mail Address" value="<?php echo $order->billing->get('confirm_email'); ?>"/>
                    </div>
                    <div class='uk-width-1-1'>
                        <div class='uk-text-large'>Local Pickup</div>
                        <div class="uk-form-controls uk-form-controls-text">
                            <p class="uk-form-controls-condensed">
                                <input id="localPickup" type="checkbox" style="height:15px; width:15px;" <?php echo ($order->get('localPickup') == "1" ? 'checked' : ''); ?>/>
                                <input type="hidden" name="customer[localPickup]" style="height:15px; width:15px;" value="<?php echo $order->get('localPickup',0); ?>"/>
                                <label class="uk-text-small uk-margin-left" >I want to pickup my order at the T-top Covers location in North Charleston, SC.</label> 
                            </p>
                        </div>
                    </div>
                    
                </div>
            </fieldset>
        </div>
</div>