<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$elements = $this->order->elements;
?>

<div class="uk-width-2-3 uk-container-center"> 
    <div class="uk-width-1-1">
        <?php $this->form->setValues($elements->get('billing.')); ?>
        <?php if($this->form->checkGroup('billing')) : ?>
                    <?php echo $this->form->render('billing')?>
        <?php endif; ?>
        <?php $this->form->setValues($elements->get('shipping.')); ?>
        <?php if($this->form->checkGroup('shipping')) : ?>
            <div class="uk-form-row">
                <fieldset id="shipping">
                    <legend>
                        Shipping Address
                        <div class="uk-form-controls uk-form-controls-text" style="float:right">
                            <p class="uk-form-controls-condensed">
                                <input type="checkbox" id="same_as_billing" class="ttop-checkout-field" name="same_as_billing" style="height:15px; width:15px;" />
                                <label class="uk-text-small uk-margin-left" >Same as billing</label> 
                            </p>
                        </div>
                    </legend>
                    <?php echo $this->form->render('shipping')?>
                </fieldset>
            </div>
        <?php endif; ?>
        <?php $this->form->setValues($elements); ?>
        <?php if($this->form->checkGroup('email')) : ?>
            <?php echo $this->form->render('email')?>
        <?php endif; ?>    
        <?php $this->form->setValues($elements); ?>
        <?php if($this->form->checkGroup('shipping_method')) : ?>
            <?php echo $this->form->render('shipping_method')?>
        <?php endif; ?> 
    </div>
</div>