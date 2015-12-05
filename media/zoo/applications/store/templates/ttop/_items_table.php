<table class="uk-table uk-table-condensed uk-table-striped uk-table-hover">
    <thead>
        <tr>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($items as $sku => $item) : ?>
            <tr>
                <td>
                    <div class="ttop-checkout-item-name"><?php echo $item->name ?></div>
                    <div class="ttop-checkout-item-description"><?php echo $item->description ?></div>
                    <div class="ttop-checkout-item-options"><?php echo $item->getOptions(); ?></div>

                </td>
                <td class="ttop-checkout-item-qty">
                    <?php echo $item->qty; ?>
                </td>
                <td class="ttop-checkout-item-total">
                    <?php echo $item->getTotal(); ?>
                </td>
            </tr>
<?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td>
                
            </td>
            <td class="uk-text-right">
                Subtotal:
            </td>
            <td>
                <?php echo $this->app->number->currency($this->order->subtotal,array('currency' => 'USD')); ?>
            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td class="uk-text-right">
                Shipping:
            </td>
            <td>
                <?php echo $this->app->number->currency($this->order->ship_total,array('currency' => 'USD')); ?>
            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td class="uk-text-right">
                Sales Tax:
            </td>
            <td>
                <?php echo $this->app->number->currency($this->order->tax_total,array('currency' => 'USD')); ?>
            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td class="uk-text-right">
                Total:
            </td>
            <td>
                <?php echo $this->app->number->currency($this->order->total,array('currency' => 'USD')); ?>
            </td>
        </tr>
    </tfoot>
</table>