<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$order = $CR->order;
$billing = $order->billing;
$shipping = $order->shipping;
$creditCard = $order->creditCard;
$items = $order->items;

?>
<div class='ttop-receipt'>
    <div class="uk-width-1-1 uk-container-center uk-text-right uk-margin-bottom">
        <a href="/store/checkout?task=getPDF&type=receipt&id=<?php echo $order->id; ?>" class="uk-button uk-button-primary" target="_blank"><i class="uk-icon-print"></i> Print Receipt</a>
    </div>
    <div class="uk-width-1-1 uk-container-center">
        <table class="uk-table uk-table-condensed">
            <thead>
                <tr>
                    <th class="uk-text-center">Salesperson</th>
                    <th class="uk-text-center">Order Number</th>
                    <th>Order Date</th>
                    <th>Delivery Method</th>
                </tr>
            </thead>
            <tfoot>

            </tfoot>
            <tbody>
                <tr>
                    <td class="uk-text-center"><?php echo $order->getSalesperson(); ?></td>
                    <td class="uk-text-center"><?php echo $order->id; ?></td>
                    <td class="uk-text-center"><?php echo $order->getOrderDate(); ?></td>
                    <td class="uk-text-center"><?php echo $order->localPickup ? 'Local Pickup' : 'UPS Ground'; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="uk-width-1-1 uk-container-center">
        <div class="uk-grid">
            <div class='uk-width-1-2'>
                <table class='uk-table billing'>
                    <thead>
                        <tr>
                            <th>Bill To:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p><?php echo $billing->get('firstname').' '.$billing->get('lastname'); ?></p>
                                <p><?php echo $billing->get('address'); ?></p>
                                <p><?php echo $billing->get('city').', '.$billing->get('state').'  '.$billing->get('zip'); ?></p>
                                <p><?php echo $billing->get('phoneNumber'); ?></p>
                                <p><?php echo $billing->get('altNumber'); ?></p>
                                <p><?php echo $billing->get('email'); ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php if(!$order->localPickup) : ?>
            <div class='uk-width-1-2'>
                <table class='uk-table shipping'>
                    <thead>
                        <tr>
                            <th>Ship To:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p><?php echo $shipping->get('firstname').' '.$shipping->get('lastname'); ?></p>
                                <p><?php echo $shipping->get('address'); ?></p>
                                <p><?php echo $shipping->get('city').', '.$shipping->get('state').'  '.$shipping->get('zip'); ?></p>
                                <p><?php echo $shipping->get('phoneNumber'); ?></p>
                                <p><?php echo $shipping->get('altNumber'); ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
            <div class="uk-width-1-1 payment uk-margin-top">
                <div class="uk-grid" data-uk-margin>
                    <div class="uk-width-1-1">
                        <h4>Payment Details:</h4>
                    </div>
                    <div class="uk-width-1-1">

                        <div class="payment-data">Last 4 of Credit Card: <?php echo substr($creditCard->get('cardNumber'), -4).' '.$creditCard->get('card_name'); ?></div>
                    </div>

                </div>
            </div>
            <div class='uk-width1-1 items-table'>
                <table class="uk-table uk-table-condensed uk-table-striped">
                    <thead>
                        <tr>
                            <th class="uk-width-4-6">Item Name</th>
                            <th class="uk-width-1-6">Quantity</th>
                            <th class="uk-width-1-6">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php foreach ($items as $item) : ?>
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
                                    <?php echo $item->getTotal() ?>
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
                            <td class="uk-text-right">
                                <?php echo '$'.number_format($order->subtotal,2,'.',''); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>
                                Shipping:
                            </td>
                            <td class="uk-text-right">
                                <?php echo '$'.number_format($order->ship_total,2,'.',''); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>
                                Sales Tax:
                            </td>
                            <td class="uk-text-right">
                                <?php echo '$'.number_format($order->tax_total,2,'.',''); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <p>Total:</p>
                            </td>
                            <td>
                                <p class="ttop-checkout-total uk-text-right"><?php echo '$'.number_format($order->total,2,'.',''); ?></p>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>