<?php
$item = $params['item'];
$price = $item->getPrice();
?>
<div id="<?php echo $item->id; ?>-price">
	<i class="currency"></i>
	<span class="price"><?php echo number_format($this->app->customer->isReseller() ? $price->get('base') : $this->price->get('discount'), 2, '.', ''); ?></span>
</div>