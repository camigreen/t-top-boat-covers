<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

	defined('_JEXEC') or die('Restricted access');

?>
        <div id="choice-<?php echo $num ?>" class="row">
                <input id="choice-name" type="text" name="<?php echo $var.'['.$num.'][name]'; ?>" value="<?php echo $name; ?>" placeholder="Name" />
                <input id="choice-value" type="text" name="<?php echo $var.'['.$num.'][value]'; ?>" value="<?php echo $value; ?>" placeholder="Value"/>
            <div class="delete" title="<?php echo JText::_('Delete option'); ?>">
                    <img alt="<?php echo JText::_('Delete option'); ?>" src="<?php echo $this->app->path->url('assets:images/delete.png'); ?>"/>
            </div>
            <div class="sort-handle hidden" title="<?php echo JText::_('Sort option'); ?>">
                    <img alt="<?php echo JText::_('Sort option'); ?>" src="<?php echo $this->app->path->url('assets:images/sort.png'); ?>"/>
            </div> 
        </div>


