
<?php 

class ReceiptFormPDF extends FormPDF {

	/**
	 * @var [string]
	 */
	public $resource = 'default';

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
	    		'price' => array('text' => $item->getTotal('base'))
	    	);

	    }

	    $order->set('items', $item_array);
	    $tzoffset = $this->app->date->getOffset();
	    $salesperson = $this->app->user->get($order->created_by) ?  $this->app->user->get($order->created_by)->name : 'Website';
	    $order->set('created', $this->app->html->_('date', $order->created, JText::_('DATE_FORMAT_STORE1'), $tzoffset));
	    $order->set('salesperson', $salesperson);
	    $order->set('payment_info', $order->params->get('payment.creditcard.card_name').' '.$order->params->get('payment.creditcard.cardNumber'));
	    $order->set('delivery_method', JText::_(($ship = $order->elements->get('shipping_method')) ? 'SHIPPING_METHOD_'.$ship : ''));
	    $order->set('terms', JText::_(($terms = $order->params->get('terms')) ? 'ACCOUNT_TERMS_'.$terms : ''));
	    $order->set('tax_total', $order->tax_total);
	    $order->set('ship_total', $order->ship_total);
	    $order->remove('app');

		return parent::setData($order);
	}
	
}

?>