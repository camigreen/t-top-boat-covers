<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
if (!$cProfile->canAccess($object->access)) {
	return;
}

?>

<button data-task="view" name="<?php echo $name; ?>" data-id="<?php echo $object->id; ?>" class="uk-button" ><?php echo $label; ?></button>