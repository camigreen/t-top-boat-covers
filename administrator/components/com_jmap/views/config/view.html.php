<?php
// namespace administrator\components\com_jmap\views\config;
/**
 *
 * @package JMAP::CONFIG::administrator::components::com_jmap
 * @subpackage views
 * @subpackage config
 * @author Joomla! Extensions Store
 * @copyright (C) 2014 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 * Config view
 *
 * @package JMAP::CONFIG::administrator::components::com_jmap
 * @subpackage views
 * @subpackage config
 * @since 1.0
 */
class JMapViewConfig extends JMapView {
	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addDisplayToolbar() {
		$doc = JFactory::getDocument();
		$doc->addStyleDeclaration('.icon-48-jmap{background-image:url("components/com_jmap/images/icon-48-config.png")}');
		JToolBarHelper::title( JText::_( 'COM_JMAP_JMAPCONFIG' ), 'jmap' );
		JToolBarHelper::save('config.saveentity', 'COM_JMAP_SAVECONFIG');
		JToolBarHelper::custom('cpanel.display', 'home', 'home', 'COM_JMAP_CPANEL', false);
	}
	
	/**
	 * Configuration panel rendering for component settings
	 *
	 * @access public
	 * @param string $tpl
	 * @return void
	 */
	public function display($tpl = null) {
		$doc = JFactory::getDocument();
		$this->loadJQuery($doc);
		$this->loadBootstrap($doc);
		
		$params = $this->get('Data');
		$form = $this->get('form');
		
		// Bind the form to the data.
		if ($form && $params) {
			$form->bind($params);
		}
		
		$this->params_form = $form;
		$this->params = $params;
		$this->app = JFactory::getApplication();
		
		// Aggiunta toolbar
		$this->addDisplayToolbar();
		
		// Output del template
		parent::display();
	}
}
?>