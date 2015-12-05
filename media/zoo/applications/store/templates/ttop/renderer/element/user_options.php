<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');


$hidden = (isset($params['hidden']) ? $params['hidden'] : 0);
// create class attribute
$width = 'uk-width-1-'.$params['field_width'];
$fName = str_replace(' ','_',strtolower($element->config->get('name')));
$class = $width.($hidden == 1 ? ' uk-hidden' : '');
$content = $element->render($params); 
?>
<?php if ($content) : ?>
<div class="<?php echo $class; ?>">
    <?php echo $content; ?>
</div>
<?php endif; ?>