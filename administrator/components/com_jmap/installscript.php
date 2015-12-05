<?php
//namespace administrator\components\com_jmap;
/**  
 * @package JMAP::administrator::components::com_jmap 
 * @author Joomla! Extensions Store
 * @copyright (C) 2014 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html   
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' ); 
jimport ( 'joomla.filesystem.file' );

/** 
 * Script to manage install/update/uninstall for component. Follow class convention
 * @package JMAP::administrator::components::com_jmap  
 */
class com_jmapInstallerScript {
	/*
	 * The release value to be displayed and checked against throughout this file.
	 */
	private $release = '1.0';
	
	/*
	* Find mimimum required joomla version for this extension. It will be read from the version attribute (install tag) in the manifest file
	*/
	private $minimum_joomla_release = '1.6.0';
	
	/*
	 * $parent is the class calling this method.
	 * $type is the type of change (install, update or discover_install, not uninstall).
	 * preflight runs before anything else and while the extracted files are in the uploaded temp folder.
	 * If preflight returns false, Joomla will abort the update and undo everything already done.
	 */
	function preflight($type, $parent) {
	
	}
	
	/*
	 * $parent is the class calling this method.
	 * install runs after the database scripts are executed.
	 * If the extension is new, the install method is run.
	 * If install returns false, Joomla will abort the install and undo everything already done.
	 */
	function install($parent) {
		$database = JFactory::getDBO ();
		$lang = JFactory::getLanguage ();
		$lang->load ( 'com_jmap' );
		
		// Execute always sql install file to get added updates in that file, disregard DBMS messages and Joomla queue for user
		$parentParent = $parent->getParent();
		$parentManifest = $parentParent->getManifest();
		try {
			// Install/update always without error handlingm case legacy JError
			JError::setErrorHandling(E_ALL, 'ignore');
			if (isset($parentManifest->install->sql)) {
				$parentParent->parseSQLFiles($parentManifest->install->sql);
			}
		} catch (Exception $e) {
			// Do nothing for user for Joomla 3.x case, case Exception handling
		}

		// All operation ok
		echo (JText::_('COM_JMAP_INSTALL_SUCCESS'));
		
		// INSTALL UTILITY PLUGIN - Current installer instance
		$componentInstaller = JInstaller::getInstance ();
		$pathToPlugin = $componentInstaller->getPath ( 'source' ) . '/plugin';
		
		// New plugin installer
		$pluginInstaller = new JInstaller ();
		if (! $pluginInstaller->install ( $pathToPlugin )) {
			echo '<p>' . JText::_ ( 'COM_JMAP_ERROR_INSTALLING_UTILITY_PLUGIN' ) . '</p>';
		} else {
			$query = "UPDATE #__extensions SET " .
					 $database->quoteName('enabled') . " = 1," .
					 $database->quoteName('ordering') . " = 0" .
					"\n WHERE type = 'plugin' AND element = " . $database->quote ( 'jmap' ) .
					"\n AND folder = " . $database->quote ( 'system' );
			$database->setQuery ( $query );
			if (! $database->execute ()) {
				echo '<p>' . JText::_ ( 'COM_JMAP_ERROR_PUBLISHING_UTILITY_PLUGIN' ) . '</p>';
			}
		}
		
		// Robots.txt images management
		$targetRobot = null;
		// Try standard robots.txt
		if(JFile::exists(JPATH_ROOT . DIRECTORY_SEPARATOR . 'robots.txt')) {
			$targetRobot = JPATH_ROOT . DIRECTORY_SEPARATOR . 'robots.txt';
		} elseif (JFile::exists(JPATH_ROOT . DIRECTORY_SEPARATOR . 'robots.txt.dist')) { // Fallback on distribution version
			$targetRobot = JPATH_ROOT . DIRECTORY_SEPARATOR . 'robots.txt.dist';
		} else {
			$targetRobot = false; // Not found do nothing
		}
		
		// Robots.txt found!
		if($targetRobot !== false) {
			// If file permissions ko
			if(!$robotContents = JFile::read($targetRobot)) {
				echo JText::_('COM_JMAP_JSITEMAP_REMEMBER_SET_ROBOTS_FOR_IMAGES');
			}
			$managedRobotContents = preg_replace('#Disallow: (.*)/images.*#', 'Disallow: ${1}/images/sampledata', $robotContents);
			// If file permissions ko on rewrite updated contents
			if($managedRobotContents) {
				if(!is_writable($targetRobot)) {
					@chmod($targetRobot, 0777);
				}
				if(@!JFile::write($targetRobot, $managedRobotContents)) {
					echo JText::_('COM_JMAP_JSITEMAP_REMEMBER_SET_ROBOTS_FOR_IMAGES');
				}
			}
		}
		
		// Processing complete
		return true;
	}
	
	/*
	 * $parent is the class calling this method.
	 * update runs after the database scripts are executed.
	 * If the extension exists, then the update method is run.
	 * If this returns false, Joomla will abort the update and undo everything already done.
	 */
	function update($parent) {
		// Install on update in same way
		$this->install($parent);
	}
	
	/*
	 * $parent is the class calling this method.
	 * $type is the type of change (install, update or discover_install, not uninstall).
	 * postflight is run after the extension is registered in the database.
	 */
	function postflight($type, $parent) { 
		// define the following parameters only if it is an original install
		if ($type == 'install') {  
			
			// Preferences
			$params ['show_title'] = '1';
			$params ['headerlevel'] = '1';
			$params ['classdiv'] = 'sitemap';
			$params ['show_pagebreaks'] = '0';
			$params ['includejquery'] = '1'; 
 			$params ['opentarget'] = '_self';
			$params ['include_external_links'] = '1';
			
			// Sitemap aspect
			$params ['show_expanded'] = '0';
			$params ['expand_location'] = 'location';
			$params ['column_sitemap'] = '0';
			$params ['show_icons'] = '1';
			$params ['multilevel_categories'] = '0';
			
			//Caching
			$params ['enable_view_cache'] = '0';
			$params ['lifetime_view_cache'] = '1';
			$params ['enable_precaching'] = '0';
			$params ['precaching_limit_xml'] = '5000';
			$params ['precaching_limit_images'] = '50';
			$params ['split_sitemap'] = '0';
			$params ['split_chunks'] = '50000';
			
			// Advanced settings
			$params ['gnews_limit_recent'] = '0';
			$params ['gnews_limit_valid_days'] = '2';
			$params ['include_archived'] = '0';
			$params ['imagetitle_processor'] = 'title|alt';
			$params ['disable_acl'] = 'enabled';
			$params ['lists_limit_pagination'] = '10';
			$params ['max_images_requests'] = '50';
			$params ['sitemap_links_sef'] = '0';
			$params ['append_livesite'] = '1';
			$params ['enable_debug'] = '0';
			
			$this->setParams ( $params );   
		} 
	}
	
	/*
	 * $parent is the class calling this method
	 * uninstall runs before any other action is taken (file removal or database processing).
	 */
	function uninstall($parent) {
		$database = JFactory::getDBO ();
		$lang = JFactory::getLanguage();
		$lang->load('com_jmap');
		 
		echo JText::_('COM_JMAP_UNINSTALL_SUCCESS' );
		
		// UNINSTALL UTILITY PLUGIN - Check if plugin exists
		$query = "SELECT extension_id" .
				"\n FROM #__extensions" .
				"\n WHERE type = 'plugin' AND element = " . $database->quote('jmap') .
				"\n AND folder = " . $database->quote('system');
		$database->setQuery($query);
		$pluginID = $database->loadResult();
		if($pluginID) {
			// New plugin installer
			$pluginInstaller = new JInstaller ();
			if(!$pluginInstaller->uninstall('plugin', $pluginID)) {
				echo '<p>' . JText::_('COM_JMAP_ERROR_UNINSTALLING_UTLITY_PLUGIN') . '</p>';
			}
		}
		
		// Processing complete
		return true;
	}
	
	/*
	 * get a variable from the manifest file (actually, from the manifest cache).
	 */
	function getParam($name) {
		$db = JFactory::getDbo ();
		$db->setQuery ( 'SELECT manifest_cache FROM #__extensions WHERE name = "jmap"' );
		$manifest = json_decode ( $db->loadResult (), true );
		return $manifest [$name];
	}
	
	/*
	 * sets parameter values in the component's row of the extension table
	 */
	function setParams($param_array) {
		if (count ( $param_array ) > 0) { 
			$db = JFactory::getDbo (); 
			// store the combined new and existing values back as a JSON string
			$paramsString = json_encode ( $param_array );
			$db->setQuery ( 'UPDATE #__extensions SET params = ' . $db->quote ( $paramsString ) . ' WHERE name = "jmap"' );
			$db->execute ();
		}
	}
}