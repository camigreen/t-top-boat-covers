<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$user = $zoo->customer->getUser();
$testMode = $zoo->merchant->testMode();
?>

<div class="uk-grid cart-module"> 
    <div class="uk-width-1-2 uk-vertical-align account-menu uk-text-center">
        <ul class="uk-subnav uk-subnav-line uk-vertical-align-middle">
            <li data-uk-dropdown="{mode:'click'}">
                <a href="#"><?php echo $user->name; ?><i class="uk-icon-caret-down uk-margin-left"></i></a>
                <div class="uk-dropdown uk-dropdown-small uk-dropdown-bottom uk-text-left" style="top: 26px; left: 0px;">
                    <ul class="uk-nav uk-nav-dropdown">
                        <li><a href="#">My Profile</a></li>
                        <li><a href="#">Dealership Account</a></li>
                        <li><a href="#">Logout</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div class="uk-width-1-2">
        <div id="cart-module" class="uk-vertical-align" data-cart="open">
            <div class="uk-vertical-align-middle">
                <span class="icon"></span>
                <span class="currency">$</span>
                <span data-cart="total">0.00</span>
                <span class="items">(<span data-cart="quantity">0</span> Items)</span>
            </div>
        </div>
    </div>
</div>
<div id="cart-modal" class="uk-modal">
    <div class="uk-modal-dialog uk-modal-dialog-large">
        <div class="uk-panel uk-panel-box">
            <h3 class="uk-panel-title">Shopping Cart</h3>
                <table class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
                    <thead>
                        <tr>
                            <th class="uk-width-2-4">Item</th>
                            <th class="uk-width-1-4">Quantity</th>
                            <th class="uk-width-1-4">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="uk-text-right" colspan="2">Total</td>
                            <td class="item-total uk-text-bold uk-text-large"></td>
                        </tr>
                    </tfoot>
                </table>
            <div class="uk-align-right">
                <button class="uk-button uk-button-primary continue">Continue Shopping</button>
                <button class="uk-button uk-button-primary checkout">Checkout</button>
                <button class="uk-button uk-button-primary clear">Empty Cart</button>
            </div>
        </div>
    </div>
</div>








