<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

/**
 * Deals with application events.
 *
 * @package Component.Events
 */
class AccountEvent {

	/**
	 * When an application is loaded on the frontend,
	 * load the language files from the app folder too
	 *
	 * @param  AppEvent 	$event The event triggered
	 */
	public static function init($event) {

		$account = $event->getSubject();
        $app = $account->app;

        if (is_string($account->params) || is_null($account->params)) {
            // decorate data as this
            $account->params = $app->parameter->create($account->params);
        }

        if (is_string($account->elements) || is_null($account->elements)) {
            // decorate data as this
            $account->elements = $app->parameter->create($account->elements);
        }

	}

	/**
	 * Placeholder for the saved event
	 *
	 * @param  AppEvent $event The event triggered
	 */
	public static function saved($event) {

		$account = $event->getSubject();
		$new = $event['new'];

	}

	/**
	 * Placeholder for the deleted event
	 *
	 * @param  AppEvent $event The event triggered
	 */
	public static function deleted($event) {

		$account = $event->getSubject();

	}

}