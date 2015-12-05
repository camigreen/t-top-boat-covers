<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<table class="uk-table">
    <thead>
        <tr>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($items as $item) : ?>
            <tr>
                <td>
                    <?php echo $item->name; ?>
                    <div class="uk-text-small uk-text-contrast"><?php echo $item->description; ?></div>
                    <input type="hidden" name="item[][name]" value="<?php echo $item->name ?>"/>
                    <input type="hidden" name="item[][description]" value="<?php echo $item->description; ?>"/>
                </td>
                <td>
                    <?php echo $item->qty; ?>
                    <input type="hidden" name="item[][qty]" value="<?php echo $item->qty ?>"/>
                </td>
                <td>
                    <?php echo $item->formatCurrency($item->price) ?>
                    <input type="hidden" name="item[][price]" value="<?php echo $item->price ?>" />
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
                <?php echo $this->CashRegister->get('subtotal'); ?>
            </td>
        </tr>
        <tr>
            <td>
                
            </td>
            <td>
                Shipping:
            </td>
            <td>
                <?php echo $this->CashRegister->get('shipping'); ?>
            </td>
        </tr>
        <tr>
            <td>
                
            </td>
            <td>
                Sales Tax:
            </td>
            <td>
                <?php echo $this->CashRegister->get('taxTotal'); ?>
            </td>
        </tr>
        <tr>
            <td>
                
            </td>
            <td>
                Total:
            </td>
            <td>
                <?php echo $this->CashRegister->get('total'); ?>
            </td>
        </tr>
    </tfoot>
</table>

