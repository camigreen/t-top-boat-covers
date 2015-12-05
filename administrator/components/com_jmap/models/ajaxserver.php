<?php
//namespace components\com_jmap\models; 
/** 
 * @package JMAP::AJAXSERVER::components::com_jmap 
 * @subpackage models
 * @author Joomla! Extensions Store
 * @copyright (C)2013 Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.filesystem.file');

/**
 * Ajax Server model responsibilities
 *
 * @package JMAP::AJAXSERVER::components::com_jmap  
 * @subpackage models
 * @since 1.0
 */
interface IAjaxserverModel {
	public function loadAjaxEntity($id, $param, $DIModels) ;
}

/** 
 * Classe che gestisce il recupero dei dati per il POST HTTP
 * @package JMAP::AJAXSERVER::components::com_jmap  
 * @subpackage models
 * @since 1.0
 */
class JMapModelAjaxserver extends JMapModel implements IAjaxserverModel {
	/**
	 * Check if an extension is currently installed on Joomla system and answer accordingly with an encoded object
	 *
	 * @access private
	 * @param string $tableName
	 * @param Object[] $additionalModels Array for additional injected models type hinted by interface
	 * @return Object
	 */
	private function checkExtension($extensionName, $additionalModels = null) {
		// Query to check
		$query = "SELECT " . $this->_db->quoteName('extension_id') . 
				 "\n FROM " . $this->_db->quoteName('#__extensions') . 
				 "\n WHERE " . $this->_db->quoteName('element') . " = " . $this->_db->Quote($extensionName);
		$this->_db->setQuery($query);
		$extensionID = $this->_db->loadResult();

		$response = (object) array('extensionFound' => (bool) $extensionID);

		return $response;
	}
	
	/**
	 * Check if an extension is currently installed on Joomla system and answer accordingly with an encoded object
	 *
	 * @access private
	 * @param string $tableName
	 * @param Object[] $additionalModels Array for additional injected models type hinted by interface
	 * @return Object
	 */
	private function loadDataSources($additionalModels = null) {
		// Response JSON object
		$response = new stdClass();

		try {
			// Resource Action detection dall'HTTP method name
			$HTTPMethod = $this->app->input->server->get('REQUEST_METHOD', 'GET');

			if ($HTTPMethod !== 'GET') {
				throw new JMapException(JText::_('COM_JMAP_INVALID_RESTFUL_METHOD'), 'error');
			}
			// Default for published data sources
			$where[] = "\n v.published = 1";
			
			$query = "SELECT v.id, v.type, v.name" .
					"\n FROM #__jmap AS v" .
					"\n WHERE " . implode(' AND ', $where) .
					"\n ORDER BY v.ordering ASC";
			$this->_db->setQuery ( $query );
			
			$response->datasources = $this->_db->loadObjectList ();
			if ($this->_db->getErrorNum ()) {
				throw new JMapException(JText::sprintf('COM_JMAP_ERROR_RETRIEVING_DATA', $this->_db->getErrorMsg()), 'error');
			}
			
			// All completed succesfully
			$response->result = true;
		} catch (JMapException $e) {
			$response->result = false;
			$response->exception_message = $e->getMessage();
			return $response;
		} catch (Exception $e) {
			$jmapException = new JMapException(JText::sprintf('COM_JMAP_ERROR_RETRIEVING_DATA', $e->getMessage()), 'error');
			$response->result = false;
			$response->exception_message = $jmapException->getMessage();
			return $response;
		}
		
		return $response;
	}
	
	/**
	 * Check what sitemaps are cached on disk to show accordingly green labels
	 *
	 * @access private
	 * @param $idEntity
	 * @param $additionalModels
	 *
	 * @Return array
	 */
	private function getPrecachedSitemaps($queryStringLinksArray, $additionalModels = null) {
		// Response JSON object
		$response = new stdClass ();
		
		try {
			// Resource Action detection dall'HTTP method name
			$HTTPMethod = $this->app->input->server->get ( 'REQUEST_METHOD', 'GET' );
			
			if ($HTTPMethod !== 'GET') {
				throw new JMapException ( JText::_ ( 'COM_JMAP_INVALID_RESTFUL_METHOD' ), 'error' );
			}
			
			// Init empty status
			$response->sitemapLinksStatus = array ();
			
			// Start to set an associative array based on url parsing and file existance
			if (! empty ( $queryStringLinksArray ) && is_array ( $queryStringLinksArray )) {
				$joomlaConfig = JFactory::getConfig();
				$localTimeZone = new DateTimeZone($joomlaConfig->get('offset'));
				foreach ( $queryStringLinksArray as $singlePostedSitemapLink ) {
					$filename = 'sitemap_';
					$extractedQuery = parse_url ( $singlePostedSitemapLink, PHP_URL_QUERY );
					parse_str ( $extractedQuery, $parsedLink );
					// Evaluate format
					if (! empty ( $parsedLink ['format'] )) {
						$filename .= $parsedLink ['format'];
					}
					// Evaluate language
					if (! empty ( $parsedLink ['lang'] )) {
						$filename .= '_' . $parsedLink ['lang'];
					}
					// Evaluate language
					if (! empty ( $parsedLink ['Itemid'] )) {
						$filename .= '_menuid' . $parsedLink ['Itemid'];
					}
					
					if (JFile::exists ( JPATH_COMPONENT_SITE . '/precache/' . $filename . '.xml' )) {
						// get last generation time
						$lastGenerationTimestamp = filemtime ( JPATH_COMPONENT_SITE . '/precache/' . $filename . '.xml' );
						$dateObject = new JDate($lastGenerationTimestamp);
						$dateObject->setTimezone($localTimeZone);
						
						$response->sitemapLinksStatus [$singlePostedSitemapLink] = array (
								'cached' => true,
								'lastgeneration' => $dateObject->format('Y-m-d', true) 
						);
					} else {
						$response->sitemapLinksStatus [$singlePostedSitemapLink] = false;
					}
				}
			}
			
			// All completed succesfully
			$response->result = true;
		} catch ( Exception $e ) {
			$jmapException = new JMapException ( $e->getMessage (), 'error' );
			$response->result = false;
			$response->exception_message = $jmapException->getMessage ();
			return $response;
		}
		
		return $response;
	}

	/**
	 * Get file info to delete and check if file for precache exists
	 * In that case delete the file and clear cache
	 *
	 * @access private
	 * @param $fileInfo
	 * @param $additionalModels
	 *
	 * @Return array
	 */
	private function deletePrecachedSitemap($fileInfo, $additionalModels = null) {
		// Response JSON object
		$response = new stdClass();
	
		try {
			// Resource Action detection dall'HTTP method name
			$HTTPMethod = $this->app->input->server->get('REQUEST_METHOD', 'POST');
	
			if ($HTTPMethod !== 'POST') {
				throw new JMapException(JText::_('COM_JMAP_INVALID_RESTFUL_METHOD'), 'error');
			}
	
			// Start to set an associative array based on url parsing and file existance
			if(!empty($fileInfo)) {
				$filename = 'sitemap_';
				// Evaluate format
				if(!empty($fileInfo->format)) {
					$filename .= $fileInfo->format;
				}
				// Evaluate language
				if(!empty($fileInfo->lang)) {
					$filename .= '_' . $fileInfo->lang;
				}
				// Evaluate language
				if(!empty($fileInfo->Itemid)) {
					$filename .= '_menuid' . $fileInfo->Itemid;
				}
					
				if(JFile::exists(JPATH_COMPONENT_SITE . '/precache/' . $filename . '.xml')) {
					if(!@unlink(JPATH_COMPONENT_SITE . '/precache/' . $filename . '.xml')) {
						throw new JMapException(JText::_('COM_JMAP_PRECACHING_ERROR_DELETING_FILE'), 'error');
					}
					
					// Check also if a temp precached file is still present and clear it
					if(JFile::exists(JPATH_COMPONENT_SITE . '/precache/temp_' . $filename . '.xml')) {
						@unlink(JPATH_COMPONENT_SITE . '/precache/temp_' . $filename . '.xml');
					}
				}
			}
	
			// All completed succesfully
			$response->result = true;
		} catch (Exception $e) {
			$jmapException = new JMapException($e->getMessage(), 'error');
			$response->result = false;
			$response->exception_message = $jmapException->getMessage();
			return $response;
		}
	
		return $response;
	}
	
	/**
	 * Load fields for selected database table
	 * 
	 * @access private
	 * @param string $tableName
	 * @param Object[] $additionalModels Array for additional injected models type hinted by interface
	 * @return array
	 */
	private function loadTableFields($tableName, $additionalModels = null) {
		// Fields select list
		$queryFields = "SHOW COLUMNS " . 
					   "\n FROM " . $this->_db->quoteName($tableName);
		$this->_db->setQuery($queryFields);
		$elements = $this->_db->loadColumn();

		return $elements;
	}

	/**
	 * Manage store/update Pingomatic entity record
	 * 
	 * @access private
	 * @param $idEntity
	 * @param $additionalModels
	 *
	 * @Return array
	 */
	private function storeUpdatePingomatic($idEntity, $additionalModels = null) {
		// Response JSON object
		$response = new stdClass();

		// Store on ORM Table
		$table = $this->getTable('Pingomatic');
		$_POST['lastping'] = date('Y-m-d H:i:s');
		try {
			if (!$table->bind($_POST, true)) {
				throw new JMapException($table->getError(), 'error');
			}

			if (!$table->check()) {
				throw new JMapException($table->getError(), 'error');
			}

			if (!$table->store(false)) {
				throw new JMapException($table->getError(), 'error');
			}
		} catch (JMapException $e) {
			$response->result = false;
			$response->errorMsg = $e->getMessage();
			return $response;
		} catch (Exception $e) {
			$jmapException = new JMapException($e->getMessage(), 'error');
			$response->result = false;
			$response->errorMsg = $jmapException->getMessage();
			return $response;
		}

		// Manage exceptions from DB Model and return to JS domain
		$response->result = true;
		$response->id = $table->id;
		$response->lastping = $table->lastping;

		return $response;
	}
	
	/**
	 * Manage store/update for menu priorities
	 *
	 * @access private
	 * @param $params
	 * @param $additionalModels
	 *
	 * @Return array
	 */
	private function storeUpdateMenuPriority($params, $additionalModels = null) {
		// Response JSON object
		$response = new stdClass();
	
		// Store on ORM Table
		$table = $this->getTable('MenuPriorities');
		$table->load((int)$params->menuItemid);
		$table->priority = $params->priorityValue;
	
		try {
			// Switch on subaction
			if(!isset($params->task)) {
				throw new JMapException(JText::_('COM_JMAP_VALIDATON_ERROR_NOPRIORITY'), 'warning');
			}
			if($params->task == 'store') {
				if (!$table->store(false, $params->menuItemid)) {
					throw new JMapException($table->getError(), 'warning');
				}
			} else {
				// Check if record still exists in database
				if(!$table->id) {
					throw new JMapException(JText::_('COM_JMAP_VALIDATON_ERROR_NOPRIORITY'), 'warning');
				}
				// Delete always
				if (!$table->delete()) {
					throw new JMapException($table->getError(), 'warning');
				}
			}
		} catch (JMapException $e) {
			$response->result = false;
			$response->errorMsg = $e->getMessage();
			return $response;
		} catch (Exception $e) {
			$jmapException = new JMapException($e->getMessage(), 'warning');
			$response->result = false;
			$response->errorMsg = $jmapException->getMessage();
			return $response;
		}
	
		// Manage exceptions from DB Model and return to JS domain
		$response->result = true;
	
		return $response;
	}
	/**
	 * Get existing priority value for menu items
	 *
	 * @access private
	 * @param $params
	 * @param $additionalModels
	 *
	 * @Return array
	 */
	private function getMenuPriority($idEntity, $additionalModels = null) {
		// Response JSON object
		$response = new stdClass();
		
		// Store on ORM Table
		$table = $this->getTable('MenuPriorities');
		
		try {
			if (!$table->load((int)$idEntity)) {
				throw new JMapException($table->getError(), 'warning');
			}
			
			// Load a non existing record
			if(!$table->id) {
				throw new JMapException('nopriority', 'warning');
			}
		} catch (JMapException $e) {
			$response->result = false;
			$response->errorMsg = $e->getMessage();
			return $response;
		} catch (Exception $e) {
			$jmapException = new JMapException($e->getMessage(), 'warning');
			$response->result = false;
			$response->errorMsg = $jmapException->getMessage();
			return $response;
		}
		
		// Manage exceptions from DB Model and return to JS domain
		$response->result = true;
		$response->priority = $table->priority;
		
		return $response;
	}

	/**
	 * Manage robots.txt entry
	 *
	 * @access private
	 * @param $idEntity
	 * @param $additionalModels
	 *
	 * @Return array
	 */
	private function robotsSitemapEntry($queryStringLink, $additionalModels = null) {
		// Response JSON object
		$response = new stdClass();

		try {
			// Resource Action detection dall'HTTP method name
			$HTTPMethod = $this->app->input->server->get('REQUEST_METHOD', 'GET');

			if ($HTTPMethod !== 'POST') {
				throw new JMapException(JText::_('COM_JMAP_INVALID_RESTFUL_METHOD'), 'error');
			}

			// Update robots.txt add entry Sitemap if not exists
			$targetRobot = null;
			// Try standard robots.txt
			if(JFile::exists(JPATH_ROOT . '/robots.txt')) {
				$targetRobot = JPATH_ROOT . '/robots.txt';
			} elseif (JFile::exists(JPATH_ROOT . '/robots.txt.dist')) { // Fallback on distribution version
				$targetRobot = JPATH_ROOT . '/robots.txt.dist';
			} else {
				throw new JMapException(JText::_('COM_JMAP_ROBOTS_NOTFOUND'), 'error');
			}
			
			// Robots.txt found!
			if($targetRobot !== false) {
				// If file permissions ko
				if(!$robotContents = JFile::read($targetRobot)) {
					throw new JMapException(JText::_('COM_JMAP_ERROR_READING_ROBOTS'), 'error');
				}
				
				$newEntry = null;
				// Entry for this sitemap 
				if(!stristr($robotContents, 'Sitemap: ' . $queryStringLink)) {
					$toAppend = null;
					// Check if JSitemap added already some entries
					if(!stristr($robotContents, '# JSitemap')) {
						// Empty line double EOL
						$toAppend = PHP_EOL . PHP_EOL . '# JSitemap entries';
					}
					$toAppend .= PHP_EOL . 'Sitemap: ' . $queryStringLink;
					$newEntry = $robotContents . $toAppend;
				}
				
				// If file permissions ko on rewrite updated contents
				if($newEntry) {
					if(!is_writable($targetRobot)) {
						@chmod($targetRobot, 0777);
					}
					if(@!JFile::write($targetRobot, $newEntry)) {
						throw new JMapException(JText::_('COM_JMAP_ERROR_WRITING_ROBOTS'), 'error');
					}
				} else {
					throw new JMapException(JText::_('COM_JMAP_ENTRY_ALREADY_ADDED'), 'error');
				}
			}
			
			// All completed succesfully
			$response->result = true;
		} catch (JMapException $e) {
			$response->result = false;
			$response->errorMsg = $e->getMessage();
			return $response;
		} catch (Exception $e) {
			$jmapException = new JMapException($e->getMessage(), 'error');
			$response->result = false;
			$response->errorMsg = $jmapException->getMessage();
			return $response;
		}
		
		return $response;
	}

	/**
	 * Mimic an entities list, as ajax calls arrive are redirected to loadEntity public responsibility to get handled
	 * by specific subtask. Responses are returned to controller and encoded from view over HTTP to JS client
	 * 
	 * @access public 
	 * @param string $id Rappresenta l'op da eseguire tra le private properties
	 * @param mixed $param Parametri da passare al private handler
	 * @param Object[]& $DIModels
	 * @return Object& $utenteSelezionato
	 */
	public function loadAjaxEntity($id, $param , $DIModels) {
		//Delega la private functions delegata dalla richiesta sulla entity
		$response = $this->$id($param, $DIModels);

		return $response;
	}
}
