<?php
/**
 * @package   Package Name
 * @author    Shawn Gibbons http://www.palmettoimages.com
 * @copyright Copyright (C) Shawn Gibbons
 * @license   
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Class Description
 *
 * @package Class Package
 */
class TestController extends AppController {

	/**
	 * Class constructor
	 *
	 * @param datatype	$value	Parameter Description
	 */
	public function __construct($default = array()) {

		parent::__construct($default);

        // set table
        $this->table = $this->app->table->account;

        // registers tasks
        //$this->registerTask('receipt', 'display');



	}

	/**
	 * Describe the Function
	 *
	 * @param 	datatype		Description of the parameter.
	 *
	 * @return 	datatype	Description of the value returned.
	 *
	 * @since 1.0
	 */
	public function sessionIn() {

		$user = $this->app->account->get(10);

		var_dump($user);

		$this->app->session->set('account', $user, 'test');
		
	}

	public function clearOrder() {
		$this->app->session->clear('order', 'checkout');
	}

	public function sessionOut() {
		$user = $this->app->session->get('account', array(), 'test');

		var_dump($user);
	}


}
?>