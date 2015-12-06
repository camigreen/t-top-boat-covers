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
class OrderEvent {

	/**
	 * When an application is loaded on the frontend,
	 * load the language files from the app folder too
	 *
	 * @param  AppEvent 	$event The event triggered
	 */
	public static function init($event) {

		$order = $event->getSubject();
        $app         = $order->app;

        $order->table = $app->table->orderdev;
        $order->params = $app->parameter->create($order->params);
        $order->elements = $app->parameter->create($order->elements);
       	$app->loader->register('OrderItem', 'classes:orderitem.php');
        $items = $order->elements->get('items.', array());
        foreach($items as $key => $item) {
        	$item = new OrderItem($app, $item);
         	$order->elements->set('items.'.$key, $item);
         }
        //$order->elements->set('items', $app->parameter->create($items));
        $order->calculateTotals();

	}

	/**
	 * Placeholder for the saved event
	 *
	 * @param  AppEvent $event The event triggered
	 */
	public static function saved($event) {

		$order = $event->getSubject();
		$new = $event['new'];

	}

	/**
	 * Placeholder for the deleted event
	 *
	 * @param  AppEvent $event The event triggered
	 */
	public static function deleted($event) {

		$order = $event->getSubject();

	}

	/**
	 * Placeholder for the installed event
	 *
	 * @param  AppEvent $event The event triggered
	 */
	public static function installed($event) {

		$order = $event->getSubject();
		$update = $event['update'];

	}

	/**
	 * Placeholder for the addmenuitems event
	 *
	 * @param  AppEvent $event The event triggered
	 */
	public static function addmenuitems($event) {

		$order = $event->getSubject();

		// Tab object
		$tab = $event['tab'];

		// add child

		// return the tab object
		$event['tab'] = $tab;
	}

	/**
	 * Placeholder for the statusChanged event
	 *
	 * @param  AppEvent $event The event triggered
	 */

	public static function statusChanged($event) {

		$item = $event->getSubject();
		$old_status = $event['old_status'];

	}

	/**
	 * Placeholder for the deleted event
	 *
	 * @param  AppEvent $event The event triggered
	 */
	public static function paymentFailed($event) {

		$order = $event->getSubject();
		$response = $event['response'];
		$app = $order->app;
		$app->log->createLogger('email',array('sgibbons@palmettoimages.com'));
		foreach ($response as $key => $value) {
			if ($key == 'response') {
				continue;
			}
				$value = is_bool($value) ? ($value ? 'True' : 'False') : $value;
				$data[] = $key.': '.$value;
		}
		foreach ($order->items as $key => $value) {
				$data[] = $value->name."\n";
		}
		$message = implode("\n", $data);
        $app->log->notice($message,'Process Payment Failed');


	}


}