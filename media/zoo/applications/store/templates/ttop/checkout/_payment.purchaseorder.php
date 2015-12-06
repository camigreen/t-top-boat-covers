<?php 
	$elements = $order->elements;
?>
<div class="uk-width-1-1">
    <label>Account Name:</label>
    <input type="text" name="elements[payment][account_name]" disabled class="ttop-checkout-field required" value='<?php echo $elements->get('payment.account_name'); ?>'/>
    <label>Account Number:</label>
    <input type="text" name="elements[payment][account_number]" disabled class="ttop-checkout-field required" value='<?php echo $elements->get('payment.account_number') ?>'/>
    <label>Customer Name</label>
    <input type="text" name="elements[payment][customer_name]" class="ttop-checkout-field required" value='<?php echo $elements->get('payment.customer_name') ?>'/>
    <label>P.O. Number:</label>
    <input type="text" name="elements[payment][po_number]" class="ttop-checkout-field required" value='<?php echo $elements->get('payment.po_number') ?>'/>
</div>