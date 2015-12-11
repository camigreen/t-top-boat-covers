<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

/*
    Class: DefaultController
        Site controller class
*/
class CheckoutController extends AppController {

    public $account = null;
    public $processCC = 'true';

    
    public function __construct($default = array()) {
        parent::__construct($default);

        // set table
        $this->table = $this->app->table->account;

        // get application
        $this->application = $this->app->zoo->getApplication();

        // get Joomla application
        $this->joomla = $this->app->system->application;

        // get params
        $this->params = $this->joomla->getParams();

        // get pathway
        $this->pathway = $this->joomla->getPathway();

        // set base url
        $this->baseurl = $this->app->link(array('controller' => $this->controller), false);


        $this->cart = $this->app->cart;

        // registers tasks
        $this->registerTask('receipt', 'display');
        $this->registerTask('customer', 'display');
        $this->registerTask('payment', 'display');
        $this->registerTask('confirm', 'display');
        $this->registerTask('save', 'display');
        $this->registerTask('processPO', 'display');
        // $this->taskMap['display'] = null;
        // $this->taskMap['__default'] = null;
    }
    
    /*
            Function: display
                    View method for MVC based architecture

            Returns:
                    Void
    */
    public function display($cachable = false, $urlparams = false) {

        // if($this->cart->isEmpty()) {
        //     $this->setRedirect('/');
        // }

        if($this->task != 'receipt') {
            $this->CR = $this->app->cashregister->start();
        }
        $task = $this->task;
        $this->$task();

    }

    public function customer() {
        if (!$this->template = $this->application->getTemplate()) {
            return $this->app->error->raiseError(500, JText::_('No template selected'));
        }
        $this->app->document->addScript('assets:js/formhandler.js');

        $order = $this->CR->order;
        $account = $order->getAccount();
        $user = $order->getUser();
        $this->page = 'customer';
        if($account && $account->type != 'store') {
            if(!$order->elements->get('billing.')) {
                $order->elements->set('billing.', $account->elements->get('billing.'));
                $order->elements->set('billing.phoneNumber', $user->elements->get('office_phone'));
                $order->elements->set('billing.altNumber', $user->elements->get('mobile_phone'));
            }
            if(!$order->elements->get('shipping.')) {
                $order->elements->set('shipping.', $account->elements->get('shipping.'));
                $order->elements->set('shipping.phoneNumber', $user->elements->get('office_phone'));
                $order->elements->set('shipping.altNumber', $user->elements->get('mobile_phone'));
            }
            if(!$order->elements->get('email')) {
                $order->elements->set('email', $user->getUser()->email);
                $order->elements->set('confirm_email', $user->getUser()->email);
            }
            
        }
        $type = 'customer';

        $this->form = $this->app->form->create(array($this->template->getPath().'/checkout/config.xml', compact('type')));

        $layout = 'checkout';
        
        $this->title = 'Customer Information';
        $this->subtitle = 'Please enter your information below.';
        $this->buttons = array(
            'back' => array(
                    'active' => false
                ),
            'proceed' => array(
                    'active' => true,
                    'next' => 'payment',
                    'disabled' => false,
                    'label' => 'Proceed'
                )
        );

        $this->order = $order;

        $this->getView()->addTemplatePath($this->template->getPath().'/checkout')->setLayout($layout)->display();

    }

    public function payment() {

        if (!$this->template = $this->application->getTemplate()) {
            return $this->app->error->raiseError(500, JText::_('No template selected'));
        }
 
        $this->page = 'payment';

        $order = $this->CR->order;
        $account = $order->getAccount();
        $user = $order->getUser();

        if($account && $account->type != 'store') {
            $order->elements->set('payment.account_name', $account->name);
            $order->elements->set('payment.account_number', $account->elements->get('account_number'));
            $this->app->session->set('order',(string) $order,'checkout');
        }

        $this->app->document->addScript('assets:js/formhandler.js');

        $layout = 'checkout';

        $type = $this->page;

        $this->form = $this->app->form->create(array($this->template->getPath().'/checkout/config.xml', compact('type')));
        
        $this->title = 'Payment Information';
        $this->subtitle = 'Please enter your payment information below.';
        $this->buttons = array(
            'back' => array(
                    'active' => true,
                    'next' => 'customer',
                    'disabled' => false,
                    'label' => 'Back'
                ),
            'proceed' => array(
                    'active' => true,
                    'next' => 'confirm',
                    'disabled' => false,
                    'label' => 'Proceed'
                )
        );

        $this->order = $order;

        $this->getView()->addTemplatePath($this->template->getPath().'/checkout')->setLayout($layout)->display();

    }

    public function confirm() {
        if (!$this->template = $this->application->getTemplate()) {
            return $this->app->error->raiseError(500, JText::_('No template selected'));
        }

        $this->app->document->addScript('assets:js/formhandler.js');

        $order = $this->CR->order;
        $account = $order->getAccount();
        $user = $order->getUser();
        $next = 'processCC';
        $layout = 'checkout';
        $this->page = 'confirm';
        if($account && $account->type != 'store') {
            $this->page .= '.'.$account->type;
            $this->processCC = 'false';
            $next = 'processPO';
            
        }
        

        
        $this->title = 'Order Confirmation';
        $this->subtitle = '<span class="uk-text-danger">Please make sure that your order is correct.</span>';
        $this->buttons = array(
            'back' => array(
                    'active' => true,
                    'next' => 'payment',
                    'disabled' => false,
                    'label' => 'Back'
                ),
            'proceed' => array(
                    'active' => true,
                    'next' => $next,
                    'disabled' => false,
                    'label' => 'Proceed'
                )
        );

        

        

        $this->order = $order;

        $this->getView()->addTemplatePath($this->template->getPath().'/checkout')->setLayout($layout)->display();
    }

    public function receipt() {
        if (!$this->template = $this->application->getTemplate()) {
            return $this->app->error->raiseError(500, JText::_('No template selected'));
        }
        if(!$id = $this->app->request->get('oid', 'int', 0)) {
            return $this->app->error->raiseError(500, JText::_('Unable to locate that order.'));
        }
        $this->app->document->addScript('assets:js/formhandler.js');
        $order = $this->app->orderdev->get($id);
        $order->save();
        $account = $order->getAccount();
        $layout = 'checkout';
        $this->page = 'receipt';

        $this->title = 'Order Receipt';
        $this->subtitle = 'Thank you for your purchase.';
        $this->buttons = array(
            'back' => array(
                    'active' => false,
                    'next' => 'payment',
                    'disabled' => false,
                    'label' => 'Back'
                ),
            'proceed' => array(
                    'active' => true,
                    'next' => 'home',
                    'disabled' => false,
                    'label' => 'Return to Home Page'
                )
        );
        $this->order = $order;
        $this->getView()->addTemplatePath($this->template->getPath().'/checkout')->setLayout($layout)->display();
    }

    public function processPO () {
        $order = $this->CR->processPayment('PO');
        $link = $this->baseurl.'&task=receipt&oid='.$order->id;
        $this->setRedirect($link);

    }

    public function getPDF() {
        $type = $this->app->request->get('type','word');
        if (!$this->app->path->path('classes:fpdf/scripts/'.$type.'.xml')) {
            return $this->app->error->raiseError(500, JText::_('PDF template does not exist'));
        }
        $this->app->document->setMimeEncoding('application/pdf');
        
        $pdf = $this->app->pdf->$type;
        $id = $this->app->request->get('id','int');
        $order = $this->app->orderdev->get($id);
        $pdf->setData($order)->generate()->toBrowser();
    }

    public function notify() {
        $CR = $this->app->cashregister->start();

        $CR->sendNotificationEmail(6371, 'invoice');
        $CR->sendNotificationEmail(6371, 'payment');
    }

    public function home() {
        $this->setRedirect('/');
    }

    public function save() {

        $order = $this->CR->order;
        $next = $this->app->request->get('next','word', 'customer');
        $post = $this->app->request->get('post:', 'array', array());
        
        if(isset($post['elements'])) {
            foreach($post['elements'] as $key => $value) {
                if (is_array($value)) {
                    $order->elements->set($key.'.', $value);
                } else {
                    $order->elements->set($key, $value);
                }
            }
        }
        
        if(isset($post['params'])) {
            foreach($post['params'] as $key => $value) {
                if (is_array($value)) {
                    $order->params->set($key.'.', $value);
                } else {
                    $order->params->set($key, $value);
                }
            }
        }
        $order->save();

        $this->setRedirect($this->baseurl.'&task='.$next);

    }




}