<?php 

class ReceiptFormPDF extends FormPDF {

	/**
	 * @var [string]
	 */
	public $resource = 'reseller';

	/**
	 * @var [string]
	 */
	public $type = 'receipt';


	public function setData($order) {
		$order = $this->app->data->create(get_object_vars($order));

		$billto = array(
            $order->elements->get('billing.name'),
            $order->elements->get('billing.street1'),
            ($order->elements->get('billing.street2') ? $order->elements->get('billing.street2') : null),
            $order->elements->get('billing.city').', '.$order->elements->get('billing.state').' '.$order->elements->get('billing.postalCode'),
            $order->elements->get('billing.phoneNumber').'  '.$order->elements->get('billing.altNumber'),
            $order->elements->get('email')
        );

		$order->set('billto', $billto);
		
		if($order->elements->get('shipping_method') != 'LP') {
        	$shipto = array(
	            $order->elements->get('shipping.name'),
	            $order->elements->get('shipping.street1'),
	            $order->elements->get('shipping.street2'),
	            $order->elements->get('shipping.city').', '.$order->elements->get('shipping.state').' '.$order->elements->get('shipping.postalCode'),
	            $order->elements->get('shipping.phoneNumber').' '.$order->elements->get('shipping.altNumber')
        	);
        	$order->set('shipto', $shipto);
    	}
    	$item_array = array();
	    foreach($order->elements->get('items.', array()) as $item) {
	    	$options = array();
	    	foreach($item->options as $option) {
	    		$options[] = $option['name'].': '.$option['text'];
	    	}
	    	$item_array[] = array(
	    		'item_description' => array(
	    			array('format' => 'item-name','text' => $item->name),
	    			array('format' => 'item-options','text' => implode("\n",$options))
	    		),
	    		'qty' => array('text' => $item->qty),
	    		'msrp' => array('text' => $item->getTotal('base')),
	    		'markup_price' => array('text' => $this->app->number->currency($item->getTotal('markup'), array('currency' => 'USD'))."\n".$item->getPrice()->getMarkupRate(true).' Markup'),
	    		'dealer_price' => array('text' => $this->app->number->currency($item->getTotal('reseller'), array('currency' => 'USD'))."\n".$item->getPrice()->getDiscountRate(true).' Discount'),
	    		'dealer_profit' => array('text' => $this->app->number->currency($item->getTotal('margin'), array('currency' => 'USD'))."\nTotal Discount ".$item->getPrice()->getProfitRate(true))
	    	);

	    }

	    $order->set('items', $item_array);
	    $tzoffset = $this->app->date->getOffset();
	    $order->set('created', $this->app->html->_('date', $order->created, JText::_('DATE_FORMAT_STORE1'), $tzoffset));
	    $order->set('salesperson', $this->app->account->get($order->created_by)->name);
	    $order->set('delivery_method', JText::_(($ship = $order->elements->get('shipping_method')) ? 'SHIPPING_METHOD_'.$ship : ''));
	    $order->set('account_name', $order->elements->get('payment.account_name'));
	    $order->set('account_number', $order->elements->get('payment.account_number'));
	    $order->set('po_number', $order->elements->get('payment.po_number'));
	    $order->set('customer', $order->elements->get('payment.customer_name'));
	    $order->set('terms', JText::_(($terms = $order->params->get('terms')) ? 'ACCOUNT_TERMS_'.$terms : ''));
	    $order->set('balance_due', $order->params->get('payment.status') == 3 ? '0.00' : $order->total);

	    $order->remove('app');

		return parent::setData($order);
	}
	
}

?>