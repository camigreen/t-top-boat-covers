<?php

	$price = $this->app->prices->get($group);

?>
<div id="<?php echo $params['id']; ?>-price">
	<i class="currency"></i>
	<span class="price"><?php echo number_format($price, 2, '.', ''); ?></span>
</div>