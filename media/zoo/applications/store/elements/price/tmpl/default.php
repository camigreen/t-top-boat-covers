<?php
$item = $params['item'];
$price = $item->getPrice();
?>
<div id="<?php echo $item->id; ?>-price">
	<i class="currency"></i>
	<span class="price"><?php echo number_format($price->discount, 2, '.', ''); ?></span>
</div>