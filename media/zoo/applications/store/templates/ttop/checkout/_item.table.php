<?php 
    $items = $this->cart->getAllItems();
?>
<table id="item-default-table" class="uk-table">
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
                    <a href="#" class="uk-text-small option-expand" data-uk-toggle="{target:'#item-default-table #<?php echo $sku; ?> .item-options'}" ><span class="uk-icon-plus-square-o uk-margin-small-right item-options"></span><span class="uk-icon-minus-square-o uk-margin-small-right item-options uk-hidden"></span>Options</a> 
                    <div class="ttop-checkout-item-options item-options uk-hidden"><?php echo $item->getOptionsList(); ?></div>

                </td>
                <?php if($page != 'payment') : ?>
                    <td class="ttop-checkout-item-total">
                        <div><?php echo $item->qty ?></div>             
                    </td>
                <?php else : ?>
                    <td class="ttop-checkout-item-total">
                        <input type="number" class="uk-width-1-3 uk-text-center" name="qty" value="<?php echo $item->qty ?>" min="1"/>
                        <button class="uk-button uk-button-primary update-qty">Update</button>                
                    </td>
                <?php endif; ?>
                <td class="ttop-checkout-item-total">
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
                    <?php echo $this->app->number->currency($order->getShippingTotal(true),array('currency' => 'USD')); ?>
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