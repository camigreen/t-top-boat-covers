<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$order = $CR->order;
$items = $order->items;
$creditCard = $order->creditCard;
?>
<div class="uk-width-1-1 uk-container-center ttop-checkout-payment">
    <div class="uk-grid">
        <div class='uk-width1-1 items-table'>
            <table class="uk-table">
                <thead>
                    <tr>
                        <th class="uk-width-3-10">Item Name</th>
                        <th class="uk-width-2-10">Quantity</th>
                        <th class="uk-width-1-10">Price</th>
                        <th class="uk-width-1-10">Remove</th>
                    </tr>
                </thead>
                <tbody>
            <?php foreach ($items as $sku => $item) : ?>
                        <tr id="<?php echo $sku; ?>">
                            <td>
                                <div class="ttop-checkout-item-name"><?php echo $item->name ?></div>
                                <div class="ttop-checkout-item-description"><?php echo $item->description ?></div>
                                <div class="ttop-checkout-item-options"><?php echo $item->getOptions(); ?></div>

                            </td>
                            <td>
                                <input type="number" class="uk-width-1-3 uk-text-center" name="qty" value="<?php echo $item->qty ?>" min="1"/>
                                <button class="uk-button uk-button-primary update-qty">Update</button>                
                            </td>
                            <td>
                                <?php echo $item->getTotal(); ?>
                            </td>
                            <td>
                                <div id="<?php echo $sku; ?>" class="uk-icon-button uk-icon-trash trash-item"></div>
                            </td>
                        </tr>
            <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="uk-text-right">
                            Subtotal:
                        </td>
                        <td>
                            <?php echo $this->app->number->currency($order->subtotal,array('currency' => 'USD')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="uk-text-right">
                            Shipping:
                        </td>
                        <td>
                            <?php echo $this->app->number->currency($order->ship_total,array('currency' => 'USD')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="uk-text-right">
                            Sales Tax:
                        </td>
                        <td>
                            <?php echo $this->app->number->currency($order->tax_total,array('currency' => 'USD')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="uk-text-right">
                            Total:
                        </td>
                        <td>
                            <?php echo $this->app->number->currency($order->total,array('currency' => 'USD')); ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="uk-width-1-1 uk-text-center uk-margin-top">
            <h4 class="uk-text-warning">T-Top Boat Covers holds the right to adjust product pricing for any reason.</h4>
        </div>
    </div>
</div>
<div class="uk-width-1-2 uk-container-center">
    <div class="uk-grid" data-uk-grid-margin>
        <div class='uk-width-1-1'>
            <fieldset id="payment-info">
                <div class="uk-grid" data-uk-margin>
                    <div class="uk-width-1-1">
                        <legend>
                            Payment Information
                        </legend>
                        <div class="uk-width-1-1 uk-text-center">
                            We Accept
                            <img class="uk-align-center" style="width:225px;" src="images/cc/cc_all.png" />
                        </div>
                    </div>
                    <div class="uk-width-1-1">
                        <label>Card Number</label>
                        <input type="text" name="payment[creditCard][cardNumber]" class="ttop-checkout-field required" placeholder="Credit Card Number" value='<?php echo $creditCard->get('cardNumber') ?>'/>
                    </div>
                    <div class="uk-width-1-1">
                        <!-- <input type="text" name="payment[creditCard][expirationDate]" class="ttop-checkout-field required" placeholder="Exp Date" value='<?php echo $creditCard->get('expirationDate'); ?>'/> -->
                        <div class="uk-grid">
                            <div class="uk-width-2-6">
                                <label>Exp Month</label>
                                <?php echo $creditCard->getMonthDropDown(); ?>
                            </div>
                            <div class="uk-width-2-6">
                                <label>Exp Year</label>
                                <?php echo $creditCard->getYearDropDown(); ?>
                            </div>
                            <div class="uk-width-2-6">
                                <label>CVV Code</label>
                                <input type="text" name="payment[creditCard][card_code]" class="ttop-checkout-field required" placeholder="CVV Number" value='<?php echo $creditCard->get('card_code'); ?>'/>
                            </div>
                        </div>
                    </div> 
                    <div class="uk-width-1-3">
                        <input type="hidden" name="payment[creditCard][auth_code]" value="<?php echo $creditCard->get('auth_code'); ?>"/>
                        <input type="hidden" name="payment[creditCard][card_type]" value="<?php echo $creditCard->get('card_type'); ?>" />
                        <input type="hidden" name="payment[creditCard][card_name]" value="<?php echo $creditCard->get('card_name'); ?>" />
                        <input type="hidden" name="amount" value="<?php echo $CR->getCurrency('total'); ?>"/>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>