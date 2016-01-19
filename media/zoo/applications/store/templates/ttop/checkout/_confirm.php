<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$order = $this->order;
$items = $this->cart->getAllItems();
$elements = $order->elements;
$article = JTable::getInstance("content"); 
$article->load(22); // Get Article ID  
$salesperson = null;
list($page) = explode('.',$this->page, 2);
?>
<div class="uk-width-1-1 uk-container-center ttop-receipt">
    <div class="uk-grid">
        <div class='uk-width-1-1'>
            <p class='uk-text-center'>Orders are shipped within 5-15 business days.</p>

        </div>
        <div class="uk-width-1-1 uk-margin-top">
            <div class="uk-grid">
                <?php echo $this->partial('billing',compact('elements')); ?>
                <?php 
                    if(!$order->elements->get('localPickup')) {
                        echo $this->partial('shipping',compact('elements'));
                    }
                ?>
            </div>
        </div>
        
        <div class="uk-width-1-1 uk-margin-top">
            <div>E-mail: <?php echo $elements->get('email'); ?></div>
        </div>
        <?php if($salesperson) : ?>
            <div class="uk-width-1-1 uk-margin-top">
                <div>Sales Rep: <?php echo $salesperson; ?></div>
            </div>
        <?php endif; ?>
        <div class="uk-width-1-1 uk-margin-top">
            <div>Delivery Method: <?php echo $elements->get('localPickup') ? 'Local Pickup' : 'UPS Ground' ?></div>
        </div>
        <div class="uk-width-1-1 uk-margin-top">
            <h3>Payment</h3>
            <div>Account Name:  <?php echo $elements->get('payment.account_name'); ?></div>
            <div>Account Number:  <?php echo $elements->get('payment.account_number'); ?></div>
            <div>Customer Name:  <?php echo $elements->get('payment.customer_name'); ?></div>
            <div>Purchase Order Number:  <?php echo $elements->get('payment.po_number'); ?></div>
        </div>
        <div class='uk-width1-1 uk-margin-top'>
            <?php if($this->app->customer->isReseller()) : ?>
            <div class='uk-width1-1 items-table'>
                <?php echo $this->partial('item.table.reseller',compact('order', 'page')); ?>
            </div>
        <?php else : ?>
            <div class='uk-width1-1 items-table'>
                <?php echo $this->partial('item.table',compact('order', 'page')); ?>
            </div>
        <?php endif; ?>
        </div>
        <div class="uk-width-1-1">
            <?php if($elements->get('shipping_method') == 'LP') : ?>
                You have chosen the Local Pickup option.  Your item will be available for pickup at our warehouse in North Charleston, SC.  It is located at
                4651 Franchise Street, North Charleston, SC  29418.  Please call ahead during our normal business hours to ensure your items are ready for pickup.
            <?php endif; ?>
        </div>
        <div class="uk-width-1-1 uk-text-center ttop-checkout-validation-errors">
        
        </div>
        <div class="uk-width-1-1 uk-text-center uk-margin-top">
            <h4 class="uk-text-warning">T-Top Boat Covers holds the right to adjust product pricing for any reason.</h4>
        </div>
        <div class="uk-width-1-1 uk-text-center">
            <input type="checkbox" name="TC_Agree" /><span style="margin-left:10px;">I agree with <a href="#terms_and_conditions" data-uk-modal>terms and conditions.</a></span>
        </div>
        <div id="terms_and_conditions" class="uk-modal">
            <div class="uk-modal-dialog">
                <div class="uk-modal-dialog">
                    <div class="uk-overflow-container">
                        <div style="margin-top: 10px;">
                            
                        </div>
                        <?php 
                            echo $article->get('introtext');
                        ?>
                    </div>
                    <div class="uk-grid uk-margin-top">
                        <div class="uk-width-1-2">
                            <button class="uk-button uk-button-primary uk-width-1-1" name="agree">I agree</button>
                        </div>
                        <div class="uk-width-1-2">
                            <button class="uk-button uk-button-primary uk-width-1-1" name="disagree">I Disagree</button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(function($) {
        $('[name="agree"]').on('click', function(e){
            e.preventDefault();
            $('[name="TC_Agree"]').prop('checked', true);
            var modal = UIkit.modal(".terms_and_conditions");

            if ( modal.isActive() ) {
                modal.hide();
            } else {
                modal.show();
            }
        })
        $('[name="disagree"]').on('click', function(e){
            e.preventDefault();
            $('[name="TC_Agree"]').prop('checked', false);
            var modal = UIkit.modal(".terms_and_conditions");

            if ( modal.isActive() ) {
                modal.hide();
            } else {
                modal.show();
            }
        })
    })
</script>