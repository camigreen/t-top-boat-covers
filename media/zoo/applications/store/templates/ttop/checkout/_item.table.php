<?php 
    $items = $this->cart->getAllItems();
?>
<table class="uk-table">
    <thead>
        <tr>
            <th class="uk-width-7-10">Item Name</th>
            <th class="uk-width-2-10">Quantity</th>
            <th class="uk-width-1-10">Price</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $sku => $item) : ?>
            <tr id="<?php echo $sku; ?>">
                <td>
                    <div class="ttop-checkout-item-name"><?php echo $item->name ?></div>
                    <div class="ttop-checkout-item-description"><?php echo $item->description ?></div>
                    <div class="ttop-checkout-item-options"><?php echo $item->getOptionsList(); ?></div>

                </td>
                <?php if($page != 'payment') : ?>
                    <td>
                        <input type="number" class="uk-width-1-3 uk-text-center" name="qty" value="<?php echo $item->qty ?>" min="1"/>
                        <button class="uk-button uk-button-primary update-qty">Update</button>                
                    </td>
                <?php else : ?>
                    <td>
                        <div><?php echo $item->qty ?></div>             
                    </td>
                <?php endif; ?>
                <td>
                    <?php echo $item->getTotal('markup', true); ?>
                </td>
            </tr>
    <?php endforeach; ?>
    </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="uk-text-right">
                    Subtotal:
                </td>
                <td>
                    <?php echo $this->app->number->currency($order->getSubTotal('markup'),array('currency' => 'USD')); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="uk-text-right">
                    Shipping:
                </td>
                <td>
                    <?php echo $this->app->number->currency($order->getShippingTotal(),array('currency' => 'USD')); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="uk-text-right">
                    Sales Tax:
                </td>
                <td>
                    <?php echo $this->app->number->currency($order->getTaxTotal(),array('currency' => 'USD')); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="uk-text-right">
                    Total Balance Due:
                </td>
                <td>
                    <?php echo $this->app->number->currency($order->getTotal('markup'),array('currency' => 'USD')); ?>
                </td>
            </tr>
        </tfoot>
</table>