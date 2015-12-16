<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$elements = $order->elements;
$items = $order->elements->get('items.');
$query = $order->params->get('terms') == 'DUR' ? '&form=receipt' : '&form=invoice';
$query .= $order->getAccount()->isReseller() ? '&type=reseller' : '&type=default';
?>
<div class='ttop-receipt'>
    <div class="uk-width-1-1 uk-container-center uk-text-right uk-margin-bottom">
        <a href="/store/checkout?task=getPDF<?php echo $query; ?>&id=<?php echo $order->id; ?>&format=raw" class="uk-button uk-button-primary" target="_blank"><i class="uk-icon-print"></i> Print <?php echo $order->params->get('payment.status') == 3 ? 'Receipt' : 'Invoice'; ?></a>
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
                    <td class="uk-text-center"><?php echo $this->app->html->_('date', $order->created, JText::_('DATE_FORMAT_STORE1'), $this->app->date->getOffset()); ?></td>
                    <td class="uk-text-center"><?php echo $elements->get('localPickup') ? 'Local Pickup' : 'UPS Ground'; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="uk-width-1-1 uk-container-center">
        <div class="uk-grid">
            <?php echo $this->partial('billing',compact('elements')); ?>
            <?php if(!$order->elements->get('localPickup')) : ?>
                <?php echo $this->partial('shipping',compact('elements')); ?>
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