<?php
    if ($path = $this->app->path->path('prices:'.$price_schedule.'.php')) {
        include($path); 
    }   else {
        $prices[$this->_item->type] = array('item' => 0, 'shipping' => 0);
    }
    $data = "data-price='".json_encode($prices[$type])."'";
    
//        print_r($data);
?>
<span class="price"><i class="currency"></i><span id="price" <?php echo $data; ?>>0.00</span></span>