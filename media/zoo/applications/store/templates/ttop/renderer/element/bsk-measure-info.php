<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// create label
$label = '';
if (isset($params['showlabel']) && $params['showlabel']) {
	$label .= '<h3>';
	$label .= ($params['altlabel']) ? $params['altlabel'] : $element->config->get('name');
	$label .= '</h3>';
}
$myvalue = $element->config->get('name');
$arr = explode(' ',trim($myvalue));
$type = $arr[0];
$status = ($type == 'Aft' ? 'active' : '');
?>
<div class="bsk-type bsk-type-<?php echo $type.' '.$status ?>">
    <?php echo $label.$element->render($params); ?>
</div>