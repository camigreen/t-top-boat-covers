<?php 

	$billing = $this->order->billing;
	$shipping = $this->order->shipping;
	$items = $this->order->items;
	

	
?>
<div class="uk-width-1-1 uk-margin-bottom">
	<a href="/orders/all-orders" class="uk-button uk-button-primary">Back to All Orders</a>
	<a href="/store/checkout?task=getPDF&type=workorder&id=<?php echo $this->order->id; ?>" target="_blank" class="uk-button uk-button-primary">Print Work Order</a>
	<a href="/store/checkout?task=getPDF&type=receipt&id=<?php echo $this->order->id; ?>" target="_blank" class="uk-button uk-button-primary">Download Receipt</a>
</div>
<div class="uk-width-1-1">
	<div class="uk-grid">
		<?php echo $this->partial('billing', compact('billing')); ?>
		<?php echo $this->partial('shipping', compact('shipping')); ?>
	</div>
</div>
<div class="uk-width-1-1 uk-margin-top">
    <div>E-mail: <?php echo $billing->get('email'); ?></div>
    <div>Delivery Preference: <?php echo $this->order->localPickup ? 'Local Pickup' : 'UPS Ground'; ?></div>
</div>
<div class="uk-width-1-1 uk-margin-top">
    <div>Sales Rep: <?php echo $this->order->getSalesperson(); ?></div>
</div>
<div class="uk-width-1-1">
	<?php echo $this->partial('items_table', compact('items')); ?>
</div>
<div class="uk-width-1-1">
	<p>Credit Card Transaction Details</p>
	<div class="uk-panel uk-panel-box" style="word-wrap:break-word;">
		<?php echo $this->order->creditCard; ?>
	</div>
	
</div>