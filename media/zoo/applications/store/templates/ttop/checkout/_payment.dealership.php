<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$order = $this->order;
?>
<div class="uk-width-1-1 uk-container-center ttop-checkout-payment">
    <div class="uk-grid">
        <?php if($this->app->customer->isReseller()) : ?>
            <div class="uk-width-1-1">
                <button class="uk-button uk-button-primary uk-width-1-3 uk-margin-bottom items-table uk-hidden" data-uk-toggle="{target:'.items-table'}">Hide Full Invoice</button>
                <button class="uk-button uk-button-primary uk-width-1-3 uk-margin-bottom items-table" data-uk-toggle="{target:'.items-table', animation: 'uk-animation-fade'}">View Full Invoice</button>
            </div>
            <div class='uk-width1-1 items-table uk-hidden'>
                <?php echo $this->partial('item.table.reseller',compact('order')); ?>
            </div>
             <div class='uk-width1-1 items-table'>
                <?php echo $this->partial('item.table',compact('order')); ?>
            </div>
            <script>
                jQuery(function($) {
                    $('button.items-table').on('click', function(e){
                        e.preventDefault();
                    })
                })
            </script>
        <?php else : ?>
            <div class='uk-width1-1 items-table retail'>
                <?php echo $this->partial('item.table',compact('order')); ?>
            </div>
        <?php endif; ?>
        
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
                    </div>
                    <?php if($this->app->customer->isReseller()) : ?>
                        <div class="uk-width-1-1">
                            <?php echo $this->partial('payment.purchaseorder',compact('order')); ?>
                        </div>
                        <?php if($this->app->customer->getAccountTerms() == 'DUR') : ?>
                            <div class="uk-width-1-1">
                                <?php echo $this->partial('payment.creditcard',compact('order')); ?>
                            </div>
                        <?php endif; ?>
                    <?php else : ?> 
                        <div class="uk-width-1-1">
                            <?php echo $this->partial('payment.creditcard',compact('order')); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </fieldset>
        </div>
    </div>
</div>