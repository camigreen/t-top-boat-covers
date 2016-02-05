<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$elements = $this->order->elements;
?>

<div class="uk-width-1-1 uk-container-center"> 
    <div class="uk-grid">
        <div class="uk-width-1-2">
            <?php $this->form->setValues($elements); ?>
            <?php if($this->form->checkGroup('billing')) : ?>
                <div class="uk-form-row">
                    <?php echo $this->form->render('billing')?>
                </div>
            <?php endif; ?>
        </div>
        <div class="uk-width-1-2">
            <?php if($this->form->checkGroup('shipping')) : ?>
                <div class="uk-form-row">
                    <legend>Shipping Address<label class="uk-text-small uk-margin-left" ><input type="checkbox" id="same_as_billing" class="ttop-checkout-field" name="same_as_billing" style="height:15px; width:15px;" />Same as billing</label></legend>
                    <?php echo $this->form->render('shipping')?>
                </div>
            <?php endif; ?>
        </div>
        <div class="uk-width-1-2">
            <?php if($this->form->checkGroup('email-address')) : ?>
                <div class="uk-form-row">
                    <?php echo $this->form->render('email-address')?>
                </div>
            <?php endif; ?>
        </div>
        <div class="uk-width-1-2">    
            <?php if($this->form->checkGroup('shipping_selection')) : ?>
                <div class="uk-form-row">
                    <?php echo $this->form->render('shipping_selection')?>
                </div>
            <?php endif; ?>
        </div> 
    </div>
</div>
<script>
jQuery(function($){
    $(document).ready(function(){})
})
</script>