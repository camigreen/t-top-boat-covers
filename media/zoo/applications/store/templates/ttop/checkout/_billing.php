<div class="uk-width-1-2">
	<h3>Bill To:</h3>
	<div><?php echo $billing->get('firstname').' '.$billing->get('lastname'); ?></div>
	<div><?php echo $billing->get('address') ?></div>
	<div><?php echo $billing->get('city').', '.$billing->get('state').'  '.$billing->get('zip') ?></div>
	<div>Phone: <?php echo $billing->get('phoneNumber') ?></div>
	<div>Alternate Phone: <?php echo $billing->get('altNumber') ?></div>
</div>