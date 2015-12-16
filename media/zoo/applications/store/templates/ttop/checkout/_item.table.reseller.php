<?php 
    $items = $this->cart->getAllItems() ? $this->cart->getAllItems() : $order->elements->get('items.');
?>
<table id="item-reseller-table" class="uk-table">
    <thead>
        <tr>
            <th class="uk-width-4-10">Item Name</th>
            <th>Quantity</th>
            <th class="uk-width-1-10">MSRP</th>
            <th class="uk-width-1-10">Customer Retail Price</th>
            <th class="uk-width-1-10">Dealer's Price</th>
            <th class="uk-width-1-10">Dealer Profit</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $sku => $item) : ?>
            <?php echo $item->make; ?>
            <?php $price = $item->getPrice(); ?>
            <tr id="<?php echo $sku; ?>">
                <td>
                    <div class="ttop-checkout-item-name"><?php echo $item->name ?></div>
                    <div class="ttop-checkout-item-description"><?php echo $item->description ?></div>
                    <a href="#" class="uk-text-small option-expand" data-uk-toggle="{target:'#item-reseller-table #<?php echo $sku; ?> .item-options'}" ><span class="uk-icon-plus-square-o uk-margin-small-right item-options"></span><span class="uk-icon-minus-square-o uk-margin-small-right item-options uk-hidden"></span>Options</a> 
                    <div class="ttop-checkout-item-options item-options uk-hidden"><?php echo $item->getOptionsList(); ?></div>

                </td>
                <?php if($this->page != 'payment') : ?>
                    <td class="ttop-checkout-item-total uk-width-1-10">
                        <?php echo $item->qty ?>         
                    </td>
                <?php else : ?>
                    <td class="ttop-checkout-item-total uk-width-2-10">
                        <input type="number" class="uk-width-1-3 uk-text-center" name="qty" value="<?php echo $item->qty ?>" min="1"/>
                        <button class="uk-button uk-button-primary update-qty">Update</button>                
                    </td>
                <?php endif; ?>
                <td class="ttop-checkout-item-total">
                    <?php echo $price->get('base', true); ?>
                </td>
                <td class="ttop-checkout-item-total">
                    <?php echo $price->get('markup', true); ?>
                    <?php echo '<p class="uk-text-small">('.$price->getMarkupRate(true).' Markup)</p>'; ?>
                </td>
                <td class="ttop-checkout-item-total">
                    <?php echo $price->get('reseller', true); ?>
                    <?php echo '<p class="uk-text-small">('.$price->getDiscountRate(true).' Discount)</p>'; ?>
                </td>
                <td class="ttop-checkout-item-total">
                    <?php echo $price->get('margin', true);; ?>
                    <?php echo '<p class="uk-text-small">(Total Discount '.$price->getProfitRate(true).')</p>'; ?>
                </td>
            </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="uk-text-right">
                Subtotal:
            </td>
            <td>
                <?php echo $this->app->number->currency($order->getSubtotal('reseller'),array('currency' => 'USD')); ?>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="uk-text-right">
                Shipping:
            </td>
            <td>
                <?php echo $this->app->number->currency($order->getShippingTotal(),array('currency' => 'USD')); ?>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="uk-text-right">
                Sales Tax:
            </td>
            <td>
                <?php echo $this->app->number->currency($order->getTaxTotal(),array('currency' => 'USD')); ?>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="uk-text-right">
                Total:
            </td>
            <td>
                <?php echo $this->app->number->currency($order->getTotal('reseller'),array('currency' => 'USD')); ?>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="uk-text-right">
                Dealer's Balance Due:
            </td>
            <td>
                <?php 
                    $balance = $order->params->get('payment.status') < 3 ? 0 : $order->getTotal('reseller');
                    echo $this->app->number->currency($balance,array('currency' => 'USD')); 
                ?>
            </td>
        </tr>
    </tfoot>
</table>