<?php defined('_JEXEC') or die('Restricted access');

/**
 * Description of newPHPClass
 *
 * @author Shawn
 */
class OrderItem {
    
    public $id;
    
    public $name;
    
    public $qty;
    
    public $total = 0;
    
    public $shipping;
    
    public $options;
    
    public $attributes;
    
    public $description;
    
    public $make;
    
    public $model;
    
    public $pricing;
    
    public $sku;
    
    public $taxable = true;
    
    public $app;

    protected $price;
    
    public function __construct($app, $item) {

        
        foreach ($item as $key => $value) {
            $this->$key = $value;
        }
        
        $this->app = $app;
        $options = $this->options;
        $this->options = $this->app->parameter->create();
        foreach($options as $key => $option) {
            $opt = $this->app->parameter->create($option);
            $this->options->set($key, $opt);
        }
        $this->attributes = $app->parameter->create($this->attributes);
        $this->shipping = $app->parameter->create($this->shipping);
        $this->pricing = $app->parameter->create($this->pricing);
        $this->price = $this->app->parameter->create();
        $this->price->set('retail', $this->app->prices->getRetail($this->pricing->get('group')));
        $this->price->set('markup', $this->pricing->get('markup', 0));
        $this->price->set('discount', 0); 
        //var_dump($this->options);
        $this->generateSKU();
        
    }

    
    public function getDescription($type) {
        $lines = array();
        if ($type == 'receipt') {
            foreach($this->options as $option) {
                if (!isset($option['visible']) || $option['visible']) {
                    $lines[] = $option['name'].': '.$option['text'];
                }
            } 
            
        } else {
            foreach($this->options as $option) {
                $lines[] = $option['name'].': '.$option['text'];
            } 
        }
        $html = isset($lines) ? '<p>'.implode('</p><p>', $lines).'</p>' : '';
        return $html;
    }
    public function generateSKU() {
        if($this->sku) {
            return $this->sku;
        }
        $options = '';
        foreach($this->options as $key => $value) {
            $options .= $key.$value->get('text');
        }
        $options .= $this->getPrice();
        
        $this->sku = hash('md5', $this->id.$options);
        return $this->sku;
    }

    public function getPrice($type = 'markup') {
        $price = $this->price->get('retail', 0);

        switch($type) {
            case 'markup':
                $price += $price*$this->price->get('markup');
                break;
            case 'discount':
                $price -= $price*$this->price->get('discount');
                break;
            case 'margin':
                $markup = $this->getPrice('markup');
                $discount = $this->getPrice('discount');
                $price  = $markup - $discount;
        }

        return (float) $price;
    }

    public function getDiscountRate() {
        return $this->app->number->toPercentage($this->price->get('discount')*100,0);
    }
    
    public function getMarkupRate() {
        return $this->app->number->toPercentage($this->price->get('markup')*100,0);
    }

    public function getProfitRate() {
        $markup = $this->price->get('markup')*100;
        $discount = $this->price->get('discount')*100;
        $profit = $markup + $discount;
        return $this->app->number->toPercentage($profit,0);
    }

    public function getTotal($type = 'markup', $formatCurrency = false, $currency = 'USD') {
        $price = $this->getPrice($type);
        $this->total = $price*$this->qty;
        if($formatCurrency) {
            return $this->app->number->currency($this->total, array('currency' => $currency));
        }
        return $this->total;
    }

    public function getOptions() {
        if (count($this->options) > 0) {
            $html[] = "<ul class='uk-list options-list'>";
            foreach($this->options as $option) {
                $html[] = '<li><span class="option-name">'.$option->get('name').':</span><span class="option-text">'.$option->get('text').'</span></li>';
            }
            $html[] = "</ul>";

            return implode('',$html);
        }
    }

    public function export() {
        $result = $this->app->parameter->create();
        foreach($this as $key => $value) {
            if(is_array($value)) {
                $result->set($key.'.', $value);
            } else {
                $result->set($key, $value);
            }
        }
        return $result;
    }

    public function toLog() {
        foreach($this as $key => $value) {
            if($key != 'app') {
                $string[] = $key.': '.$value;
            }
        }
        return implode(PHP_EOL,$string).PHP_EOL.'/////// End of Log ////////'.PHP_EOL;
    }
 
}