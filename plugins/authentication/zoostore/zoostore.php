<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  User.joomla
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Joomla User plugin
 *
 * @since  1.5
 */
class PlgAuthenticationZooStore extends JPlugin
{

	public $app;

	public function plgAuthenticationZooStore($subject, $params) {

		// make sure ZOO exists
		if (!JComponentHelper::getComponent('com_zoo', true)->enabled) {
			return;
		}

		parent::__construct($subject, $params);

		// load config
		jimport('joomla.filesystem.file');
		if (!JFile::exists(JPATH_ADMINISTRATOR.'/components/com_zoo/config.php') || !JComponentHelper::getComponent('com_zoo', true)->enabled) {
			return;
		}
		require_once(JPATH_ADMINISTRATOR.'/components/com_zoo/config.php');

		$this->app = App::getInstance('zoo');

		$this->application = $this->app->zoo->getApplication();
	}

	/**
	 * This method should handle any authentication and report back to the subject
	 *
	 * @param   array   $credentials  Array holding the user credentials
	 * @param   array   $options      Array of extra options
	 * @param   object  &$response    Authentication response object
	 *
	 * @return  void
	 *
	 * @since   1.5
	 */
	public function onUserAuthenticate($credentials, $options, &$response)
	{
		// var_dump($response);
		// die();
		$response->type = 'Zoo Store';

		// Joomla does not like blank passwords
		if (empty($credentials['password']))
		{
			$response->status        = JAuthentication::STATUS_FAILURE;
			$response->error_message = JText::_('JGLOBAL_AUTH_EMPTY_PASS_NOT_ALLOWED');

			return;
		}

		// Get a database object

		// Trying by email
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true)
				->select('id, password')
				->from('#__users')
				->where('email=' . $db->quote($credentials['username']));


			$db->setQuery($query);
			$result = $db->loadObject();
		

		if ($result)
		{
			$match = JUserHelper::verifyPassword($credentials['password'], $result->password, $result->id);

			if ($match === true)
			{
				// Bring this in line with the rest of the system
				$user               = JUser::getInstance($result->id);
				$response->email    = $user->email;
				$response->fullname = $user->name;
				$response->username = $user->username;

				if (JFactory::getApplication()->isAdmin())
				{
					$response->language = $user->getParam('admin_language');
				}
				else
				{
					$response->language = $user->getParam('language');
				}

				$response->status        = JAuthentication::STATUS_SUCCESS;
				$response->error_message = '';

				// Check if the Zoo Store Account is active.

				$this->verifyZooStoreAccount($user, $response);

				// var_dump($response);
				// die();

			}
			else
			{
				// Invalid password
				$response->status        = JAuthentication::STATUS_FAILURE;
				$response->error_message = JText::_('JGLOBAL_AUTH_INVALID_PASS');
			}
		}
		else
		{
			// Invalid user
			$response->status        = JAuthentication::STATUS_FAILURE;
			$response->error_message = JText::_('JGLOBAL_AUTH_NO_USER');
		}

		// Check the two factor authentication
		if ($response->status == JAuthentication::STATUS_SUCCESS)
		{
			require_once JPATH_ADMINISTRATOR . '/components/com_users/helpers/users.php';

			$methods = UsersHelper::getTwoFactorMethods();

			if (count($methods) <= 1)
			{
				// No two factor authentication method is enabled
				return;
			}

			require_once JPATH_ADMINISTRATOR . '/components/com_users/models/user.php';

			$model = new UsersModelUser;

			// Load the user's OTP (one time password, a.k.a. two factor auth) configuration
			if (!array_key_exists('otp_config', $options))
			{
				$otpConfig             = $model->getOtpConfig($result->id);
				$options['otp_config'] = $otpConfig;
			}
			else
			{
				$otpConfig = $options['otp_config'];
			}

			// Check if the user has enabled two factor authentication
			if (empty($otpConfig->method) || ($otpConfig->method == 'none'))
			{
				// Warn the user if he's using a secret code but he has not
				// enabed two factor auth in his account.
				if (!empty($credentials['secretkey']))
				{
					try
					{
						$app = JFactory::getApplication();

						$this->loadLanguage();

						$app->enqueueMessage(JText::_('PLG_AUTH_JOOMLA_ERR_SECRET_CODE_WITHOUT_TFA'), 'warning');
					}
					catch (Exception $exc)
					{
						// This happens when we are in CLI mode. In this case
						// no warning is issued
						return;
					}
				}

				return;
			}

			// Load the Joomla! RAD layer
			if (!defined('FOF_INCLUDED'))
			{
				include_once JPATH_LIBRARIES . '/fof/include.php';
			}

			// Try to validate the OTP
			FOFPlatform::getInstance()->importPlugin('twofactorauth');

			$otpAuthReplies = FOFPlatform::getInstance()->runPlugins('onUserTwofactorAuthenticate', array($credentials, $options));

			$check = false;

			/*
			 * This looks like noob code but DO NOT TOUCH IT and do not convert
			 * to in_array(). During testing in_array() inexplicably returned
			 * null when the OTEP begins with a zero! o_O
			 */
			if (!empty($otpAuthReplies))
			{
				foreach ($otpAuthReplies as $authReply)
				{
					$check = $check || $authReply;
				}
			}

			// Fall back to one time emergency passwords
			if (!$check)
			{
				// Did the user use an OTEP instead?
				if (empty($otpConfig->otep))
				{
					if (empty($otpConfig->method) || ($otpConfig->method == 'none'))
					{
						// Two factor authentication is not enabled on this account.
						// Any string is assumed to be a valid OTEP.

						return;
					}
					else
					{
						/*
						 * Two factor authentication enabled and no OTEPs defined. The
						 * user has used them all up. Therefore anything he enters is
						 * an invalid OTEP.
						 */
						return;
					}
				}

				// Clean up the OTEP (remove dashes, spaces and other funny stuff
				// our beloved users may have unwittingly stuffed in it)
				$otep  = $credentials['secretkey'];
				$otep  = filter_var($otep, FILTER_SANITIZE_NUMBER_INT);
				$otep  = str_replace('-', '', $otep);
				$check = false;

				// Did we find a valid OTEP?
				if (in_array($otep, $otpConfig->otep))
				{
					// Remove the OTEP from the array
					$otpConfig->otep = array_diff($otpConfig->otep, array($otep));

					$model->setOtpConfig($result->id, $otpConfig);

					// Return true; the OTEP was a valid one
					$check = true;
				}
			}

			if (!$check)
			{
				$response->status        = JAuthentication::STATUS_FAILURE;
				$response->error_message = JText::_('JGLOBAL_AUTH_INVALID_SECRETKEY');
			}
		}
	}
	/**
	 * This method should handle any logout logic and report back to the subject
	 *
	 * @param   array  $user     Holds the user data.
	 * @param   array  $options  Array holding options (client, ...).
	 *
	 * @return  object  True on success
	 *
	 * @since   1.5
	 */
	public function onUserLogout($user, $options = array())
	{
		return true;
	}

	public function verifyZooStoreAccount($user, &$response) {
		$account = $this->app->account->getByUser($user);
		// var_dump($user);
		// var_dump($account);
		// var_dump($account->getParent());
		// die();

		// Bypass Account verification if the user is an administrator
		if($this->app->user->isJoomlaAdmin($user)) {
				$response->status        = JAuthentication::STATUS_SUCCESS;
				$response->error_message = '';
				return;
		}

		$state = $account->getParentAccount()->getState();
		if ($state == JText::_('ACCOUNT_STATUS_ACTIVE')) {
			$state = $account->getState();
		}

		switch($state) {
			case 'Active':
				// Account Active
				$response->status        = JAuthentication::STATUS_SUCCESS;
				$response->error_message = '';
				break;
			case 'Suspended':
				// Account Suspended
				$response->status        = JAuthentication::STATUS_FAILURE;
				$response->error_message = JText::_('ACCOUNT_AUTH_FAIL_SUSPENDED');
				break;
			case 'Trashed':
				// Account Trashed
				$response->status        = JAuthentication::STATUS_FAILURE;
				$response->error_message = JText::_('ACCOUNT_AUTH_FAIL_TRASHED');
				break;
		}
	}

}
