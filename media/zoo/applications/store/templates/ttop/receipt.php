<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$billing = $this->order->billing;
$shipping = $this->order->shipping;
?>
<div class="ttop-receipt">
    <div class="uk-width-1-1 uk-margin ttop-checkout-printonly">
        <img src="/images/logos/ttop/TTop_100x100.png" height="100" width="100" />
    </div>
    <div class="uk-width-1-1 uk-margin uk-text-center ttop-checkout-pagetitle">
        <button class="uk-button uk-button-primary uk-align-right ttop-checkout-printbutton" onclick="window.print()"><i class="uk-icon-print"></i> Print Receipt</button>
        <div class="uk-article-title">Order Receipt</div>
        <div class="uk-article-lead"></div>
    </div>
    
    <div class="uk-width-1-1 uk-container-center uk-margin-top">
        <div class="uk-grid">
            <div class="uk-width-1-2">
                <?php echo $this->partial('receipt_billing',compact('billing')); ?>
            </div>
            <div class="uk-width-1-2">
                <?php echo $this->partial('receipt_shipping',compact('shipping')); ?>
            </div>
            <div class="uk-width-1-1 uk-margin-top">
                <table class="uk-table uk-table-condensed">
                    <thead>
                        <tr>
                            <th>
                                Sales Rep
                            </th>
                            <th>
                                Order Date
                            </th>
                            <th>
                                Order Number
                            </th>
                            <th>
                                Delivery Method
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?php echo $this->order->getSalesperson(); ?>
                            </td>
                            <td>
                                <?php echo $this->order->getOrderDate(); ?>
                            </td>
                            <td>
                                <?php echo $this->order->id; ?>
                            </td>
                            <td>
                                <?php echo $this->order->localPickup ? 'Local Pickup' : 'UPS Ground'; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="uk-width-1-1 uk-margin-top">
                <table class="uk-table uk-table-condensed uk-table-striped">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php foreach ($this->order->items as $item) : ?>
                            <tr>
                                <td>
                                    <?php echo $item->name; ?>
                                    <div class="ttop-checkout-item-description"><?php echo $item->description; ?></div>
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
                            <td>
                                Subtotal:
                            </td>
                            <td>
                                <?php echo '$'.number_format($this->order->subtotal,2,'.',''); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>
                                Shipping:
                            </td>
                            <td>
                                <?php echo '$'.number_format($this->order->ship_total,2,'.',''); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>
                                Sales Tax:
                            </td>
                            <td>
                                <?php echo '$'.number_format($this->order->tax_total,2,'.',''); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <p>Total:</p>
                            </td>
                            <td>
                                <p class="ttop-checkout-total"><?php echo '$'.number_format($this->order->total,2,'.',''); ?></p>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php //echo $this->partial(); ?>