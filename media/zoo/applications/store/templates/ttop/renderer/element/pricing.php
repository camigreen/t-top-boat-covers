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
	$label .= '<label>';
	$label .= ($params['altlabel']) ? $params['altlabel'] : $element->config->get('name');
	$label .= '</label>';
}
// create class attribute
$width = (isset($params['field_width']) ? 'uk-width-1-'.$params['field_width'] : 'uk-width-1-1');
?>
<div class="<?php echo $width; ?>" data-uk-grid-margin>
<?php echo $label; ?>
    <?php echo $element->hasModal(); ?>
    <?php echo $element->render($params); ?>
</div>