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
$width = 'uk-width-1-'.$element->config->get('field_width');
$class = $width.' element element-'.$element->getElementType();

?>
<div class="<?php echo $class; ?>" data-uk-grid-margin>
<?php echo $label; ?><?php if($element->config->get('tooltip')) : ?><span class="uk-icon-info-circle" style="margin-left:10px;"></span><?php endif; ?>
    <?php echo $element->render($params); ?>
</div>