<?php 
//$this->app->document->addScript('libraries:jquery/jquery-ui.custom.min.js'); 
$item_id = (isset($params['item_id']) ? $params['item_id'] : uniqid());
?>

<label>Quantity</label>
<input id="qty-<?php echo $item_id; ?>" type="number" class="uk-width-1-1" name="qty" min="1" value ="1" />
<div class="uk-margin-top">
    <button id="atc-<?php echo $item_id; ?>" class="uk-button uk-button-danger"><i class="uk-icon-shopping-cart" data-store-cart style="margin-right:5px;"></i>Add to Cart</button>
</div>

    

    