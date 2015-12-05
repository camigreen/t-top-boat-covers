<?php
/**
 * @author Joomla! Extensions Store
 * @package JMAP::plugins::system
 * @copyright (C) 2013 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.plugin.plugin');

/**
 * Observer class notified on events
 * 
 * @author Joomla! Extensions Store
 * @package JMAP::plugins::system
 * @since 2.1
 */
class plgSystemJMap extends JPlugin {
	/**
	 * Joomla config object
	 * 
	 * @access private
	 * @var Object
	 */
	private $joomlaConfig;
	
	/**
	 * Detect mobile requests
	 * 
	 * @access private
	 * @return boolean
	 */
	private function isBotRequest() {
		$crawlers = array(
				'Google' => 'Google',
				'MSN' => 'msnbot',
				'Rambler' => 'Rambler',
				'Yahoo' => 'Yahoo',
				'Yandex' => 'Yandex',
				'AbachoBOT' => 'AbachoBOT',
				'accoona' => 'Accoona',
				'AcoiRobot' => 'AcoiRobot',
				'ASPSeek' => 'ASPSeek',
				'CrocCrawler' => 'CrocCrawler',
				'Dumbot' => 'Dumbot',
				'FAST-WebCrawler' => 'FAST-WebCrawler',
				'GeonaBot' => 'GeonaBot',
				'Gigabot' => 'Gigabot',
				'Lycos spider' => 'Lycos',
				'MSRBOT' => 'MSRBOT',
				'Altavista robot' => 'Scooter',
				'AltaVista robot' => 'Altavista',
				'ID-Search Bot' => 'IDBot',
				'eStyle Bot' => 'eStyle',
				'Scrubby robot' => 'Scrubby',
				'Facebook' => 'facebookexternalhit',
		);
		// to get crawlers string used in function uncomment it
		// global $crawlers
		if(isset($_SERVER['HTTP_USER_AGENT'])) {
			$currentUserAgent = $_SERVER['HTTP_USER_AGENT'];
			// it is better to save it in string than use implode every time
			$crawlers_agents='/'.  implode("|", $crawlers).'/';
			if(preg_match($crawlers_agents, $currentUserAgent, $matches)) {
				return true;
			}
		}
			
		return false;
	}
	
	/**
	 * Main dispatch method
	 *
	 * @access private
	 * @return boolean
	 */
	public function onAfterInitialise() {
		$app = JFactory::getApplication();
		
		// Detect if current request come from a bot user agent
		if($this->isBotRequest() && $app->input->get('option') == 'com_jmap') {
			$this->joomlaConfig->set('sef', false);
			$_SERVER['REQUEST_METHOD'] = 'POST';
			
			// Set dummy nobot var
			$app->input->post->set('nobotsef', true);
			$_POST['nobotsef'] = true;
		}
	}
	
	/**
	 * Class constructor, manage params from component
	 *
	 * @access private
	 * @return boolean
	 */
	public function __construct(&$subject) {
		parent::__construct($subject);
		$this->joomlaConfig = JFactory::getConfig();
	}
}