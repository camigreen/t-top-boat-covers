<?php
// namespace administrator\components\com_jmap\views\help;
/**
 *
 * @package JMAP::HELP::administrator::components::com_jmap
 * @subpackage views
 * @subpackage help
 * @author Joomla! Extensions Store
 * @copyright (C) 2014 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 * CPanel view
 *
 * @package JMAP::HELP::administrator::components::com_jmap
 * @subpackage views
 * @subpackage help
 * @since 1.0
 */
class JMapViewHelp extends JMapView {
	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addDisplayToolbar() {
		$doc = JFactory::getDocument();
		$doc->addStyleDeclaration('.icon-48-jmap{background-image:url("components/com_jmap/images/icon-48-help.png")}');
		JToolBarHelper::title( JText::_('COM_JMAP_HELP' ), 'jmap' );
		JToolBarHelper::custom('cpanel.display', 'home', 'home', 'COM_JMAP_CPANEL', false);
	}
	
	/**
	 * Display help and instructions
	 *
	 * @access public
	 * @param string $tpl
	 * @return void
	 */
	public function display($tpl = null) {
		$doc = $this->document;
		$this->loadJQuery($doc);
		$this->loadBootstrap($doc);
		$doc->addStylesheet ( JURI::root ( true ) . '/administrator/components/com_jmap/css/help.css' );
	 
		// Aggiunta toolbar
		$this->addDisplayToolbar();

		// Manage partial view
		$partial = $this->app->input->get('partial', false);
		if($partial) {
			$doc->addStyleDeclaration('div#accordion_help img{width:100%}');
		}
		$this->partialTpl = $partial;
		
		// Output del template
		parent::display ();
	}  
}