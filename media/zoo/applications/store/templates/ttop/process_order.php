<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$sale = $this->app->merchant->anet;
$sale->amount = "455.99";
$sale->card_num = '6011000000000012';
$sale->exp_date = '04/15';
$sale->order->invoiceNumber = uniqid();
$response = $sale->authorizeAndCapture();


$_items = json_decode($this->app->request->get('items', 'string'));
$total = 0;
$taxes = 0;
$shipping = 0;
foreach ($_items as $k => $v) {
    $t = json_decode($v);
    $cItems[$k] = $t;
    $total = $total + $t->price;
    $taxes = $taxes + ($t->price * .07);
    $shipping = $shipping + $t->shipping;
    
}
$total = $total + $shipping + $taxes;
?>

<p>Checkout Page</p>

<table class="uk-table">
    <thead>
        <tr>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($cItems as $cItem) : ?>
            <tr>
                <td><?php echo $cItem->name . ' ' . $cItem->options->Fabric . ' ' . $cItem->options->Color; ?></td>
                <td><?php echo $cItem->qty; ?></td>
                <td>$ <?php echo number_format($cItem->price, 2, '.', ''); ?></td>
            </tr>
<?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td>
                
            </td>
            <td>
                Shipping:
            </td>
            <td>
                $ <?php echo number_format($shipping, 2, '.', ''); ?>
            </td>
        </tr>
        <tr>
            <td>
                
            </td>
            <td>
                Sales Tax:
            </td>
            <td>
                $ <?php echo number_format($taxes, 2, '.', ''); ?>
            </td>
        </tr>
        <tr>
            <td>
                
            </td>
            <td>
                Total:
            </td>
            <td>
                $ <?php echo number_format($total, 2, '.', ''); ?>
            </td>
        </tr>
    </tfoot>
</table>
<div class="uk-grid">
    <div class="uk-width-1-2">
        <div class="uk-h3">
            Billing Information
        </div>
    </div>
    <div class="uk-width-1-2">
        
    </div>
</div>
