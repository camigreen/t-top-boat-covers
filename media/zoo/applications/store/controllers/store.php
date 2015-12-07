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
class StoreController extends AppController {

    public $version = '1.0.1';
    
    public function __construct($default = array()) {
        parent::__construct($default);

        // get application
        $this->application = $this->app->zoo->getApplication();

        // get Joomla application
        $this->joomla = $this->app->system->application;

        // get params
        $this->params = $this->joomla->getParams();

        // get pathway
        $this->pathway = $this->joomla->getPathway();

        // registers tasks
//      $this->registerTask('checkout', 'checkout');
//                $this->registerTask('products', 'product');
    }
    
    /*
            Function: display
                    View method for MVC based architecture

            Returns:
                    Void
    */
    public function display($cachable = false, $urlparams = false) {

            // execute task
            $this->taskMap['display'] = null;
            $this->taskMap['__default'] = null;
            $page = $this->params->get('page');
            $this->execute($page);
    }

    public function version () {
        if (!$this->template = $this->application->getTemplate()) {
            return $this->app->error->raiseError(500, JText::_('No template selected'));
        }

        echo '<p>Store App</p>';
        echo "<p>Version: $this->version</p>";
        echo "<p>Version Date: 08/11/2015 1:08 PM</p>";
        echo '<p>Author: Shawn Gibbons</p>';
    }
 
    
    public function testship() {
        print_r(get_declared_classes());
        try {
            //set shipper
            $fromAddress = new \SimpleUPS\InstructionalAddress();
            $fromAddress->setAddressee('Mark Stevens');
            $fromAddress->setStreet('10571 Pico Blvd');
            $fromAddress->setStateProvinceCode('CA');
            $fromAddress->setCity('Los Angeles');
            $fromAddress->setPostalCode(90064);
            $fromAddress->setCountryCode('US');

            $shipper = new \SimpleUPS\Shipper();
            $shipper->setNumber('CCE85AD5154DDC46');
            $shipper->setAddress($fromAddress);

            \SimpleUPS\UPS::setShipper($shipper);

            //define a shipping destination
            $shippingDestination = new \SimpleUPS\InstructionalAddress();
            $shippingDestination->setStreet('220 Bowery');
            $shippingDestination->setStateProvinceCode('NY');
            $shippingDestination->setCity('New York');
            $shippingDestination->setPostalCode(10453);
            $shippingDestination->setCountryCode('US');

            //define a package, we could specify the dimensions of the box if we wanted a more accurate estimate
            $package = new \SimpleUPS\Rates\Package();
            $package->setWeight('7');

            $shipment = new \SimpleUPS\Rates\Shipment();
            $shipment->setDestination($shippingDestination);
            $shipment->addPackage($package);

            echo 'Rates: ';

            echo '<ul>';
                foreach (UPS::getRates($shipment) as $shippingMethod)
                    echo '<li>'.$shippingMethod->getService()->getDescription().' ($'.$shippingMethod->getTotalCharges().')</li>';

            echo '</ul>';

        } catch (Exception $e) {
            //doh, something went wrong
            echo 'Failed: ('.get_class($e).') '.$e->getMessage().'<br/>';
           echo 'Stack trace:<br/><pre>'.$e->getTraceAsString().'</pre>';
        }

    }

    public function order() {
        if (!$this->template = $this->application->getTemplate()) {
            return $this->app->error->raiseError(500, JText::_('No template selected'));
        }
        // Get the order id from the URL
        $id = $this->app->request->get('id','int');

        // Initialize the order object
        $this->order = $this->app->order->create($id);

        // Check ACL
        //if(!$this->order->canAccess()) {
        //    return $this->app->error->raiseError(500, JText::_('You do not have access to view this content.'));
        //}

        // Page Title
        $this->app->document->setTitle($this->app->zoo->buildPageTitle('Order Details'));
        

        $layout = 'order';
        // display view
        $this->getView()->addTemplatePath($this->template->getPath())->setLayout($layout)->display();
        

    }

    public function orders() {
        if (!$this->template = $this->application->getTemplate()) {
            return $this->app->error->raiseError(500, JText::_('No template selected'));
        }
        $filters = array(
            'active' => 'status IN (0,1,2,3)',
            'closed' => 'status = 4'
        );
        $conditions = null;
        if($order_number = $this->app->request->get('order_number','int')) {
            $conditions = "id = $order_number";
        }
        $filter = $this->app->request->get('filter','word') ? $this->app->request->get('filter','word') : $this->params->get('filter');
        if ($filter && isset($filters[$filter])) {
            $conditions = is_null($conditions) ? $filters[$filter] : "$conditions AND {$filters[$filter]}";
        }
        //$conditions = is_null($conditions) ? "orderDate BETWEEN '2015-06-01' AND '2015-06-30'" : "$conditions AND orderDate BETWEEN '2015-06-01' AND '2015-06-30'";
        $this->orders = $this->app->table->order->all(array('conditions' => $conditions, 'order' => 'id DESC'));
        $this->record_count = count($this->orders);
        $layout = 'orders';
        // Page Title
        $this->title = ucfirst($filter).' Orders';
        $this->app->document->setTitle($this->app->zoo->buildPageTitle($this->title));

        // display view
        $this->getView()->addTemplatePath($this->template->getPath())->setLayout($layout)->display();

    }

    public function test() {
        echo 'test';
    }

    public function receipt() {
        // set template and params
        if (!$this->template = $this->application->getTemplate()) {
                return $this->app->error->raiseError(500, JText::_('No template selected'));
        }

        $pdf_receipt = $this->app->pdf->receipt;
        $id = $this->app->request->get('id','int');
        $order = $this->app->order->create($id);

        $url_receipt = $pdf_receipt->setData($order)->generate();
        
        $data = array('url' => $this->app->path->url('assets:pdfs/'.$url_receipt));
        $this->app->document->setMimeEncoding('application/json');
        echo json_encode($data);

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
    
    public function checkout() {
            // set template and params
            if (!$this->template = $this->application->getTemplate()) {
                    return $this->app->error->raiseError(500, JText::_('No template selected'));
            }
            
            $this->app->document->addScript('assets:js/formhandler.js');

            $step = $this->app->request->get('step','string', 'customer');

            $layout = 'checkout';
            $this->params   = $this->application->getParams('site');

            // Initialize the Cash Register
            $CR = $this->app->cashregister->start();
            
            // Import Transfer Data
            if ($step != 'receipt') {
                $CR->import();
            }
            
            //Setup Page Variables
            $page = $CR->page;

            // $customer = $this->app->request->get('customer','array');
            // $CR->order->billing = $this->app->data->create($customer['billing']);
            // $CR->order->shipping = $this->app->data->create($customer['shipping']);
            
            switch($step) {
                case 'customer':
                    $page->title = 'Customer Information';
                    $page->subtitle = 'Please enter your information below.';
                    $page->id = $step;
                    $page->inProgress = array($step);
                    $page->addButton('print', '', 'Print', false)->addButton('back','', 'Back', false)->addButton('proceed', 'payment', 'Proceed');
                    break;
                case 'payment':
                    $page->title = 'Payment Information';
                    $page->subtitle = 'Please enter your payment information below.';
                    $page->id = $step;
                    $page->complete = array('customer');
                    $page->inProgress = array($step);
                    $page->addButton('print', '', '', false)->addButton('back', 'customer', 'Back')->addButton('proceed', 'confirm', 'Proceed');
                    break;
                case 'confirm':
                    $page->title = 'Order Confirmation';
                    $page->subtitle = '<span class="uk-text-danger">Please make sure that your order is correct.</span>';
                    $page->id = $step;
                    $page->complete = array('customer','payment');
                    $page->inProgress = array($step);
                    $page->addButton('print','','',false)->addButton('back', 'payment', 'Back')->addButton('proceed', 'processPayment', 'Pay Now');
                    break;
                case 'receipt':
                    $page->title = 'Order Receipt';
                    $page->subtitle = 'Thank you for your purchase.';
                    $page->id = $step;
                    $page->complete = array('customer','payment', 'confirm');
                    $page->inProgress = array($step);
                    $page->addButton('print','Print Receipt')->addButton('back','', 'Back', false)->addButton('proceed','home','Return to Home Page');
                    $this->app->document->addStyleSheet('assets:css/receipt.css');

                    break;
                case 'home':
                    
                    JControllerLegacy::setRedirect('/');
                    JControllerLegacy::Redirect();
                    break;
                default:
                    $page->title = 'Customer Information';
                    $page->subtitle = 'Please enter your information below.';
                    $page->id = 'customer';
                    $page->inProgress = array('customer');
                    $page->addButton('print', '', 'Print', false)->addButton('back','', 'Back', false)->addButton('proceed', 'payment', 'Proceed');
            }

            $this->CashRegister = $CR;

            // display view
            $this->getView()->addTemplatePath($this->template->getPath())->setLayout($layout)->display();

    }

    public function pricing() {

        //$id = $this->app->request->get('item_id');

        $id = 405;

        $item = $this->app->table->item->get($id);

        $type = $item->getType()->id;

        foreach($item->getElements() as $element) {
            var_dump($element->config->get('name'));
        }

        var_dump($item);

    }

    public function product() {
        // get request vars
        $page        = $this->app->request->getInt('page', 1);
            $category_id = (int) $this->app->request->getInt('category_id', $this->params->get('category'));
            $this->products = $this->app->table->application->all();

            // init vars
            $this->categories = $this->application->getCategoryTree(true, $this->app->user->get(), true);

            // raise 404 if category does not exist
            if ($category_id && !$this->app->table->category->get($category_id)) {
                    return $this->app->error->raiseError(404, JText::_('Category not found'));
            }

            // raise warning when category can not be accessed
            if (!isset($this->categories[$category_id])) {
                    return $this->app->error->raiseError(403, JText::_('Unable to access category'));
            }

            $this->category   = $this->categories[$category_id];
            $params           = $category_id ? $this->category->getParams('site') : $this->application->getParams('frontpage');
            $this->item_order = $params->get('config.item_order');
            $layout           = 'product_frontpage';
            $items_per_page   = $params->get('config.items_per_page', 15);
            $offset           = max(($page - 1) * $items_per_page, 0);
            // get categories and items
            $this->items      = $this->app->table->item->getByCategory($this->application->id, $category_id, true, null, $this->item_order, $offset, $items_per_page);
            $item_count       = $this->category->id == 0 ? $this->app->table->item->getItemCountFromCategory($this->application->id, $category_id, true) : $this->category->itemCount();

            // set categories to display
            $this->selected_categories = $this->category->getChildren();

            // get item pagination
            $this->pagination = $this->app->pagination->create($item_count, $page, $items_per_page, 'page', 'app');
            $this->pagination->setShowAll($items_per_page == 0);
            $this->pagination_link = $layout == 'category' ? $this->app->route->category($this->category, false) : $this->app->route->frontpage($this->application->id);

            // create pathway
            $addpath = false;
            $catid   = $this->params->get('category');
            foreach ($this->category->getPathway() as $cat) {
                    if (!$catid || $addpath) {
                            $this->pathway->addItem($cat->name, $this->app->route->category($cat));
                    }
                    if ($catid && $catid == $cat->id) {
                            $addpath = true;
                    }
            }

            // get metadata
            $title       = $params->get('metadata.title') ? $params->get('metadata.title') : ($category_id ? $this->category->name : '');
            $description = $params->get('metadata.description');
            $keywords    = $params->get('metadata.keywords');

            if ($menu = $this->app->menu->getActive() and in_array(@$menu->query['view'], array('category', 'frontpage')) and $menu_params = $this->app->parameter->create($menu->params) and $menu_params->get('category') == $category_id) {

                    if ($page_title = $menu_params->get('page_title') or $page_title = $menu->title) {
                            $title = $page_title;
                    }

                    if ($page_description = $menu_params->get('menu-meta_description')) {
                            $description = $page_description;
                    }

                    if ($page_keywords = $menu_params->get('menu-meta_keywords')) {
                            $keywords = $page_keywords;
                    }

            }

            // set page title
            if ($title) {
                    $this->app->document->setTitle($this->app->zoo->buildPageTitle($title));
            }

            if ($description) {
                    $this->app->document->setDescription($description);
            }

            if ($keywords) {
                    $this->app->document->setMetadata('keywords', $keywords);
            }

            // set metadata
            foreach (array('author', 'robots') as $meta) {
                    if ($value = $params->get("metadata.$meta")) $this->app->document->setMetadata($meta, $value);
            }

            // add feed links
            if ($params->get('config.show_feed_link') && $this->app->system->document instanceof JDocumentHTML) {
                    if ($alternate = $params->get('config.alternate_feed_link')) {
                            $this->app->document->addHeadLink($alternate, 'alternate', 'rel', array('type' => 'application/rss+xml', 'title' => 'RSS 2.0'));
                    } else {
                            $this->app->document->addHeadLink(JRoute::_($this->app->route->feed($this->category, 'rss')), 'alternate', 'rel', array('type' => 'application/rss+xml', 'title' => 'RSS 2.0'));
                            $this->app->document->addHeadLink(JRoute::_($this->app->route->feed($this->category, 'atom')), 'alternate', 'rel', array('type' => 'application/atom+xml', 'title' => 'Atom 1.0'));
                    }
            }

            // set template and params
            if (!$this->template = $this->application->getTemplate()) {
                    return $this->app->error->raiseError(500, JText::_('No template selected'));
            }
            $this->params   = $params;

            // set renderer
            $this->renderer = $this->app->renderer->create('item')->addPath(array($this->app->path->path('component.site:'), $this->template->getPath()));

            // display view
            $this->getView()->addTemplatePath($this->template->getPath())->setLayout($layout)->display();

    }
    public function boatmakes() {

        // get request vars
        $page        = $this->app->request->getInt('page', 1);
        $category_id = 43;

        // init vars
        $this->categories = $this->application->getCategoryTree(true, $this->app->user->get(), true);

        // raise 404 if category does not exist
        if ($category_id && !$this->app->table->category->get($category_id)) {
            return $this->app->error->raiseError(404, JText::_('Category not found'));
        }

        // raise warning when category can not be accessed
        if (!isset($this->categories[$category_id])) {
            return $this->app->error->raiseError(403, JText::_('Unable to access category'));
        }

        $this->category   = $this->categories[$category_id];
        $params           = $category_id ? $this->category->getParams('site') : $this->application->getParams('frontpage');
        $this->item_order = $params->get('config.item_order');
        $layout           = 'boat_makes';
        $items_per_page   = $params->get('config.items_per_page', 15);
        $offset           = max(($page - 1) * $items_per_page, 0);

        // get categories and items
        $this->items      = $this->app->table->item->getByCategory($this->application->id, $category_id, true, null, $this->item_order, $offset, $items_per_page);
        $item_count       = $this->category->id == 0 ? $this->app->table->item->getItemCountFromCategory($this->application->id, $category_id, true) : $this->category->itemCount();

        // set categories to display
        $this->selected_categories = $this->category->getChildren();

        // get item pagination
        $this->pagination = $this->app->pagination->create($item_count, $page, $items_per_page, 'page', 'app');
        $this->pagination->setShowAll($items_per_page == 0);
        $this->pagination_link = $layout == 'category' ? $this->app->route->category($this->category, false) : $this->app->route->frontpage($this->application->id);

        // create pathway
        $addpath = false;
        $catid   = $this->params->get('category');
        foreach ($this->category->getPathway() as $cat) {
            if (!$catid || $addpath) {
                $this->pathway->addItem($cat->name, $this->app->route->category($cat));
            }
            if ($catid && $catid == $cat->id) {
                $addpath = true;
            }
        }

        // get metadata
        $title       = $params->get('metadata.title') ? $params->get('metadata.title') : ($category_id ? $this->category->name : '');
        $description = $params->get('metadata.description');
        $keywords    = $params->get('metadata.keywords');

        if ($menu = $this->app->menu->getActive() and in_array(@$menu->query['view'], array('category', 'frontpage')) and $menu_params = $this->app->parameter->create($menu->params) and $menu_params->get('category') == $category_id) {

            if ($page_title = $menu_params->get('page_title') or $page_title = $menu->title) {
                $title = $page_title;
            }

            if ($page_description = $menu_params->get('menu-meta_description')) {
                $description = $page_description;
            }

            if ($page_keywords = $menu_params->get('menu-meta_keywords')) {
                $keywords = $page_keywords;
            }

        }

        // set page title
        if ($title) {
            $this->app->document->setTitle($this->app->zoo->buildPageTitle($title));
        }

        if ($description) {
            $this->app->document->setDescription($description);
        }

        if ($keywords) {
            $this->app->document->setMetadata('keywords', $keywords);
        }

        // set metadata
        foreach (array('author', 'robots') as $meta) {
            if ($value = $params->get("metadata.$meta")) $this->app->document->setMetadata($meta, $value);
        }

        // add feed links
        if ($params->get('config.show_feed_link') && $this->app->system->document instanceof JDocumentHTML) {
            if ($alternate = $params->get('config.alternate_feed_link')) {
                $this->app->document->addHeadLink($alternate, 'alternate', 'rel', array('type' => 'application/rss+xml', 'title' => 'RSS 2.0'));
            } else {
                $this->app->document->addHeadLink(JRoute::_($this->app->route->feed($this->category, 'rss')), 'alternate', 'rel', array('type' => 'application/rss+xml', 'title' => 'RSS 2.0'));
                $this->app->document->addHeadLink(JRoute::_($this->app->route->feed($this->category, 'atom')), 'alternate', 'rel', array('type' => 'application/atom+xml', 'title' => 'Atom 1.0'));
            }
        }

        // set alphaindex
        if ($params->get('template.show_alpha_index')) {
            $this->alpha_index = $this->_getAlphaindex();
        }

        // set template and params
        if (!$this->template = $this->application->getTemplate()) {
            return $this->app->error->raiseError(500, JText::_('No template selected'));
        }
        $this->params   = $params;

        // set renderer
        $this->renderer = $this->app->renderer->create('item')->addPath(array($this->app->path->path('component.site:'), $this->template->getPath()));

        // display view
        $this->getView($layout)->addTemplatePath($this->template->getPath())->setLayout($layout)->display();
    }
    public function photoUpload() {
            
//        $files = $this->app->request->get('files[]','array');
        $this->app->document->setMimeEncoding('application/json');
        $id = uniqid();
        $files = jRequest::get('FILES')['files'];
        $post = jRequest::get('GET');
        $path = $files['tmp_name'][0];
        $upload_path = 'images'.DIRECTORY_SEPARATOR.'customer_upload'.DIRECTORY_SEPARATOR.'tm'.DIRECTORY_SEPARATOR.$id.DIRECTORY_SEPARATOR.$files['name'][0];
        
        try
            {
                $success = JFile::upload($path, $upload_path);
                $data = array(
                    'path' => JURI::root().$upload_path,
                    'uniqID' => $id
                );
                $message = null;
                
                echo new JResponseJson($data,$message,!$success);
            }
        catch(Exception $e)
            {
              echo new JResponseJson($e);
            }
    }
    public function authorizeCard() {
        $CR = $this->app->store2->CashRegister;
        $CR->import();
        $data = $this->app->store2->processPayment($CR);
        $this->app->document->setMimeEncoding('application/json');
        echo json_encode($data);
    }
    
    public function processPayment() {
        $CR = $this->app->cashregister->start();
        $CR->import();
        $order = $CR->processPayment();
        $this->app->document->setMimeEncoding('application/json');
        echo json_encode($order->result);
    }

    public function getPrice() {
        $pricing = $this->app->request->get('post:pricing','array', array());
        $pricing = $this->app->parameter->create($pricing);
        $prices = $this->app->prices->get($pricing->get('group'), $pricing->get('markup'));
        $result['price'] = $prices;
        $this->outputToJSON($result);

    }

    public function outputToJSON($output = null) {
        $this->app->document->setMimeEncoding('application/json');
        echo json_encode($output);
    }

}

/*
    Class: StoreControllerException
*/
class StoreControllerException extends AppException {}
