<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

	defined('_JEXEC') or die('Restricted access');

?>

<div>
    <div class="row">
        <?php echo $this->app->html->_('select.genericlist', $options, $this->getControlName('option', true), $style, 'value', 'text',$this->get('option',array())); ?>
    </div>

</div>