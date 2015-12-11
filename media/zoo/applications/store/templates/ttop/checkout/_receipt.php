<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$elements = $order->elements;
$items = $order->elements->get('items.');
?>
<div class='ttop-receipt'>
    <div class="uk-width-1-1 uk-container-center uk-text-right uk-margin-bottom">
        <a href="/store/checkout?task=getPDF&type=invoice&id=<?php echo $order->id; ?>&format=raw" class="uk-button uk-button-primary" target="_blank"><i class="uk-icon-print"></i> Print Inovice</a>
    </div>
    <div class="uk-width-1-1 uk-container-center">
        <table class="uk-table uk-table-condensed">
            <thead>
                <tr>
                    <th class="uk-width-3-10 uk-text-center">Salesperson</th>
                    <th class="uk-width-2-10 uk-text-center">Order Number</th>
                    <th class="uk-width-3-10">Order Date</th>
                    <th class="uk-width-2-10">Delivery Method</th>
                </tr>
            </thead>
            <tfoot>

            </tfoot>
            <tbody>
                <tr>
                    <td class="uk-text-center"><?php echo $this->app->account->get($order->created_by)->name ?></td>
                    <td class="uk-text-center"><?php echo $order->id; ?></td>
                    <td class="uk-text-center"><?php echo $this->app->html->_('date', $order->created, JText::_('DATE_FORMAT_STORE_ORDER'), $this->app->date->getOffset()); ?></td>
                    <td class="uk-text-center"><?php echo $elements->get('localPickup') ? 'Local Pickup' : 'UPS Ground'; ?></td>
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
                                <div><?php echo $elements->get('billing.name'); ?></div>
                                <div><?php echo $elements->get('billing.street1'); ?></div>
                                <div><?php echo $elements->get('billing.street2'); ?></div>
                                <div><?php echo $elements->get('billing.city').', '.$elements->get('billing.state').'  '.$elements->get('billing.zip'); ?></div>
                                <div><?php echo $elements->get('billing.phoneNumber'); ?></div>
                                <div><?php echo $elements->get('billing.altNumber'); ?></div>
                                <div><?php echo $elements->get('email'); ?></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php if(!$order->elements->get('localPickup')) : ?>
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
                                <div><?php echo $elements->get('shipping.name'); ?></div>
                                <div><?php echo $elements->get('shipping.street1'); ?></div>
                                <div><?php echo $elements->get('shipping.street2'); ?></div>
                                <div><?php echo $elements->get('shipping.city').', '.$elements->get('shipping.state').'  '.$elements->get('shipping.zip'); ?></div>
                                <div><?php echo $elements->get('shipping.phoneNumber'); ?></div>
                                <div><?php echo $elements->get('shipping.altNumber'); ?></div>
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

                        <div class="payment-data">
                            <div>Account Name:  <?php echo $order->elements->get('payment.account_name'); ?></div>
                            <div>Account Number:  <?php echo $order->elements->get('payment.account_number'); ?></div>
                            <div>P.O. Number:  <?php echo $order->elements->get('payment.po_number'); ?></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class='uk-width1-1 items-table'>
                <?php echo $this->partial('item.table.reseller',compact('order')); ?>
            </div>
        </div>
    </div>
</div>