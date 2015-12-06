<?php
    $elements = $order->elements;
?>
<div class="uk-width-1-1 uk-text-center">
    We Accept
    <img class="uk-align-center" style="width:225px;" src="images/cc/cc_all.png" />
</div>
<div class="uk-width-1-1">
    <label>Card Number</label>

    <input type="text" name="elements[creditcard][cardNumber]" class="ttop-checkout-field required" placeholder="Credit Card Number" value='<?php echo $elements->get('creditcard.cardNumber') ?>'/>
</div>
<div class="uk-width-1-1">
    <div class="uk-grid">
        <div class="uk-width-2-6">
            <label>Exp Month</label>
            <?php echo $this->app->field->render('ccmonthlist', 'expMonth', $elements->get('creditcard.expMonth'), null, array('control_name' => 'elements[creditcard]', 'class' => 'ttop-checkout-field required uk-width-1-1')); ?>
        </div>
        <div class="uk-width-2-6">
            <label>Exp Year</label>
            <?php echo $this->app->field->render('ccyearlist', 'expYear', $elements->get('creditcard.expYear'), null, array('control_name' => 'elements[creditcard]', 'class' => 'ttop-checkout-field required uk-width-1-1')); ?>
        </div>
        <div class="uk-width-2-6">
            <label>CVV Code</label>
            <input type="text" name="elements[creditcard][card_code]" class="ttop-checkout-field required" placeholder="CVV Number" value='<?php echo $elements->get('creditcard.card_code'); ?>'/>
        </div>
    </div>
</div> 
<div class="uk-width-1-3">
    <input type="hidden" name="payment[creditCard][auth_code]" value="<?php echo $elements->get('creditcard.auth_code'); ?>"/>
    <input type="hidden" name="payment[creditCard][card_type]" value="<?php echo $elements->get('creditcard.card_type'); ?>" />
    <input type="hidden" name="payment[creditCard][card_name]" value="<?php echo $elements->get('creditcard.card_name'); ?>" />
</div>