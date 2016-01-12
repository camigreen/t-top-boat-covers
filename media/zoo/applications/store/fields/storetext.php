<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

// set attributes

$id = $parent->getValue('id');
$type = $parent->getValue('type');
$permissions = $parent->getValue('permissions');

if($permissions['canEdit']) {
	$attributes = array('type' => 'text', 'name' => "{$control_name}[{$name}]", 'value' => $value, 'class' => isset($class) ? $class : '');

	$disabled = (bool) $node->attributes()->disabled ? 'disabled' : ''; 
	printf('<input %s '.$disabled.'/>', $this->app->field->attributes($attributes, array('label', 'description', 'default')));
} else {
	printf('<div class="uk-text-large uk-text-bold">%s</div>', $value);
}
