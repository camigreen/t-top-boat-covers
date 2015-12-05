<?php if(!$this->order->localPickup) : ?>
    <div class="uk-width-1-2">
        <h3>Ship To:</h3>
        <div><?php echo $shipping->get('firstname').' '.$shipping->get('lastname'); ?></div>
        <div><?php echo $shipping->get('address') ?></div>
        <div><?php echo $shipping->get('city').', '.$shipping->get('state').'  '.$shipping->get('zip') ?></div>
        <div>Phone: <?php echo $shipping->get('phoneNumber') ?></div>
        <div>Alternate Phone: <?php echo $shipping->get('altNumber') ?></div>
    </div>
<?php endif; ?>