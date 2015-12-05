<?php
// namespace administrator\components\com_jmap\controllers;
/**
 * @package JMAP::SOURCES::administrator::components::com_jmap
 * @subpackage controllers
 * @author Joomla! Extensions Store
 * @copyright (C) 2014 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 * Main sitemap sources controller manager
 * @package JMAP::SOURCES::administrator::components::com_jmap
 * @subpackage controllers
 * @since 1.0
 */
class JMapControllerSources extends JMapController {
	/**
	 * Set model state from session userstate
	 * @access protected
	 * @param string $scope
	 * @return void
	 */
	protected function setModelState($scope = 'default', $ordering = true) {
		$option = $this->option;
	
		// Get default model
		$defaultModel = $this->getModel();
	
		$filter_state = $this->getUserStateFromRequest ( "$option.sources.filterstate", 'filter_state', '*' );
		$filter_type = $this->getUserStateFromRequest ( "$option.sources.filtertype", 'filter_type', '' );
		parent::setModelState($scope, true);
	
		// Set model state
		$defaultModel->setState('state', $filter_state); 
		$defaultModel->setState('type', $filter_type);
	
		return $defaultModel;
	}
	
	/**
	 * Default listEntities
	 * 
	 * @access public
	 * @param $cachable string
	 *       	 the view output will be cached
	 * @return void
	 */
	function display($cachable = false, $urlparams = false) {
		// Set model state
		$defaultModel = $this->setModelState('sources');
		 
		// Parent construction and view display
		parent::display($cachable);
	}
	  
	/**
	 * Edit entity
	 *
	 * @access public
	 * @return void
	 */
	public function editEntity() { 
		$option = $this->option;
		$this->app->input->set ( 'hidemainmenu', 1 );
		$cid = $this->app->input->get ( 'cid', array (
				0
		), 'array' );
		$idEntity = ( int ) $cid [0];
		$user = $this->user;
		
		$model = $this->getModel();
		$model->setState('option', $option);
		
		// Try to load record from model 
		if(!$record = $model->loadEntity($idEntity)) {
			// Model set exceptions for something gone wrong, so enqueue exceptions and levels on application object then set redirect and exit
			$modelExceptions = $model->getErrors();
			foreach ($modelExceptions as $exception) {
				$this->app->enqueueMessage($exception->getMessage(), $exception->getErrorLevel());
			}
			$this->setRedirect ( 'index.php?option=com_jmap&task=sources.display');
			return false;
		}
		
		// Check out control on record
		if ($record->checked_out && $record->checked_out != $user->id) {
			$this->setRedirect ( 'index.php?option=' . $option . '&task=sources.display', JText::_('COM_JMAP_CHECKEDOUT_RECORD'), 'notice');
			return false;
		}
		
		// Access check
		if($record->id && !$this->allowEdit($model->getState('option'))) {
			$this->setRedirect('index.php?option=com_jmap&task=sources.display', JText::_('COM_JMAP_ERROR_ALERT_NOACCESS'), 'notice');
			return false;
		}
		
		if(!$record->id && !$this->allowAdd($model->getState('option'))) {
			$this->setRedirect('index.php?option=com_jmap&task=sources.display', JText::_('COM_JMAP_ERROR_ALERT_NOACCESS'), 'notice');
			return false;
		}
		
		// Check out del record
		if ($record->id) {
			$record->checkout ( $user->id );
		}
		
		// Get view and pushing model
		$view = $this->getView();
		$view->setModel ( $model, true );
		
		// Call edit view
		$view->editEntity($record); 
	}
  
	/**
	 * Manage entity apply/save after edit entity
	 *
	 * @access public
	 * @return void
	 */
	public function saveEntity() {
		// Ensure magic quotes is not active to preserve SQL Compiler work
		@ini_set('magic_quotes_runtime', 0);
		
		$task = $this->task;
		$option = $this->option;
		$context = implode('.', array($option, strtolower($this->getNames()), 'errordataload')); 
		$regenerateQuery = $this->app->input->get('regenerate_query', false);
		$sqlQueryManagedChunks = $this->app->input->get ( 'params', array (), 'array' );
		$targetExtension = $sqlQueryManagedChunks['datasource_extension'];
		
		// Get sources model and make dependency injection
		$wizardModel = $this->getModel('Wizard', 'JMapModel', array('extension' => $targetExtension, 'sourcesModel' => null));
		
		//Load della  model e bind store
		$model = $this->getModel ();
		
		if(!$result = $model->storeEntity($regenerateQuery, false, $wizardModel)) {
			// Model set exceptions for something gone wrong, so enqueue exceptions and levels on application object then set redirect and exit
			$modelException = $model->getError(null, false);
			$this->app->enqueueMessage($modelException->getMessage(), $modelException->getErrorLevel());
			
			// Store data for session recover
			$this->app->setUserState($context, $_POST);
			$this->setRedirect ( 'index.php?option=com_jmap&task=sources.editEntity&cid[]=' . $this->app->input->get ( 'id' ), JText::_('COM_JMAP_ERROR_SAVING'));
			return false;
		}

		// Security safe if not model record id detected
		if(!$id = $result->id) {
			$id = $this->app->input->get ( 'id' );
		}
		
		$redirects = $task == 'saveEntity' ? array('task'=>'display', 'msgsufix'=>'_SAVING') : array('task'=>'editEntity&cid[]=' . $id, 'msgsufix'=>'_APPLY');
		$msg = 'COM_JMAP_SUCCESS' . $redirects['msgsufix'];
		$controllerTask = $redirects['task'];
	
		$this->setRedirect ( "index.php?option=$option&task=sources.$controllerTask", JText::_($msg));
	}
	
	/**
	 * Manage cancel edit for entity and unlock record checked out
	 *
	 * @access public
	 * @return void
	 */
	public function cancelEntity() { 
		$id = $this->app->input->get ( 'id' );
		$option = $this->option;
		//Load della  model e checkin before exit
		$model = $this->getModel ( );
		
		if(!$model->cancelEntity($id)) {
			// Model set exceptions for something gone wrong, so enqueue exceptions and levels on application object then set redirect and exit
			$modelException = $model->getError(null, false);
			$this->app->enqueueMessage($modelException->getMessage(), $modelException->getErrorLevel());
		}
		 
		$this->setRedirect ( "index.php?option=$option&task=sources.display", JText::_('COM_JMAP_CANCELED_OPERATION') );
	}
	
	/**
	 * Copies one or more items
	 * 
	 * @access public
	 * @return void
	 */
	public function copyEntity() { 
		$cids = $this->app->input->get ( 'cid', array (), 'array' );
		$option = $this->option;
		//Load della  model e checkin before exit
		$model = $this->getModel ( );
		
		if(!$model->copyEntity($cids)) {
			// Model set exceptions for something gone wrong, so enqueue exceptions and levels on application object then set redirect and exit
			$modelException = $model->getError(null, false);
			$this->app->enqueueMessage($modelException->getMessage(), $modelException->getErrorLevel());
			$this->setRedirect ( "index.php?option=$option&task=sources.display", JText::_('COM_JMAP_ERROR_DUPLICATING'));
			return false;
		}
		
		$this->setRedirect ( "index.php?option=$option&task=sources.display", JText::_('COM_JMAP_SUCCESS_DUPLICATING'));
	}
	
	/**
	 * Delete a db table entity
	 *
	 * @access public
	 * @return void
	 */
	public function deleteEntity() {
		$cids = $this->app->input->get ( 'cid', array (), 'array' );
		$option = $this->option;
		// Access check
		if(!$this->allowDelete($option)) {
			$this->setRedirect('index.php?option=com_jmap&task=sources.display', JText::_('COM_JMAP_ERROR_ALERT_NOACCESS'), 'notice');
			return false;
		}
		//Load della  model e checkin before exit
		$model = $this->getModel ( );
		
		if(!$model->deleteEntity($cids)) {
			// Model set exceptions for something gone wrong, so enqueue exceptions and levels on application object then set redirect and exit
			$modelException = $model->getError(null, false);
			$this->app->enqueueMessage($modelException->getMessage(), $modelException->getErrorLevel());
			$this->setRedirect ( "index.php?option=$option&task=sources.display", JText::_('COM_JMAP_ERROR_DELETE'));
			return false;
		}
	
		$this->setRedirect ( "index.php?option=$option&task=sources.display", JText::_('COM_JMAP_SUCCESS_DELETE') );
	}
	
	/**
	 * Moves the order of a record
	 * 
	 * @access public
	 * @param integer The increment to reorder by
	 * @return void
	 */
	public function moveOrder() {
		// Set model state
		$this->setModelState('sources');
		$option = $this->option;
		// ID Entity
		$cid = $this->app->input->get ( 'cid', array (
				0
		), 'array' );
		$idEntity = $cid[0];
		// Task direction
		$model = $this->getModel();
		$orderDir = $model->getState('order_dir');
		
		switch ($orderDir) {
			case 'desc':
				$orderUp = 1;
				$orderDown = -1;
				break;
				
			case 'asc':
			default:
				$orderUp = -1;
				$orderDown = 1;
				break;
		}
		
		$direction = $this->task == 'moveorder_up' ? $orderUp : $orderDown;
		
		if(!$model->changeOrder($idEntity, $direction)) {
			// Model set exceptions for something gone wrong, so enqueue exceptions and levels on application object then set redirect and exit
			$modelException = $model->getError(null, false);
			$this->app->enqueueMessage($modelException->getMessage(), $modelException->getErrorLevel());
			$this->setRedirect ( "index.php?option=$option&task=sources.display", JText::_('COM_JMAP_ERROR_REORDER'));
			return false;
		}
		
		$this->setRedirect("index.php?option=$option&task=sources.display", JText::_('COM_JMAP_SUCCESS_REORDER'));
	}
	
	/**
	 * Save ordering
	 *
	 * @access public
	 * @return void
	 */
	public function saveOrder() { 
		$cid = $this->app->input->get ( 'cid', array (), 'array' );
		$order = $this->app->input->get ( 'order', array (), 'array' );
		$option = $this->option;
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);
	
		$model = $this->getModel();
		
		if(! $model->saveOrder($cid, $order)) {
			// Model set exceptions for something gone wrong, so enqueue exceptions and levels on application object then set redirect and exit
			$modelException = $model->getError(null, false);
			$this->app->enqueueMessage($modelException->getMessage(), $modelException->getErrorLevel());
			$this->setRedirect ( "index.php?option=$option&task=sources.display", JText::_('COM_JMAP_ERROR_REORDER'));
			return false;
		}
		
		$this->setRedirect("index.php?option=$option&task=sources.display",  JText::_('COM_JMAP_SUCCESS_REORDER'));
	}
	
	/**
	 * Publishing entities
	 * 
	 * @access public
	 * @return void
	 */
	public function publishEntities() {
		// Access check
		if(!$this->allowEditState($this->option)) {
			$this->setRedirect('index.php?option=com_jmap&task=sources.display', JText::_('COM_JMAP_ERROR_ALERT_NOACCESS'), 'notice');
			return false;
		}
		
		$cid = $this->app->input->get ( 'cid', array (
				0
		), 'array' );
		$idEntity = (int) $cid[0];
		$option = $this->option;
		
		$model = $this->getModel();
		
		if(! $model->publishEntities($idEntity, $this->task)) {
			// Model set exceptions for something gone wrong, so enqueue exceptions and levels on application object then set redirect and exit
			$modelException = $model->getError(null, false);
			$this->app->enqueueMessage($modelException->getMessage(), $modelException->getErrorLevel());
			$this->setRedirect ( "index.php?option=$option&task=sources.display", JText::_('COM_JMAP_ERROR_STATE_CHANGE'));
			return false;
		}
		
		$this->setRedirect( "index.php?option=$option&task=sources.display",  JText::_('COM_JMAP_SUCCESS_STATE_CHANGE'));
	}
	
	/**
	 * Class Constructor
	 * 
	 * @access public
	 * @return Object&
	 */
	public function __construct($config = array()) {
		parent::__construct ( $config );
		// Register Extra tasks
		$this->registerTask ( 'moveorder_up', 'moveOrder' );
		$this->registerTask ( 'moveorder_down', 'moveOrder' );
		$this->registerTask ( 'applyEntity', 'saveEntity' );
		$this->registerTask ( 'unpublish', 'publishEntities' );
		$this->registerTask ( 'publish', 'publishEntities' );
	}
}