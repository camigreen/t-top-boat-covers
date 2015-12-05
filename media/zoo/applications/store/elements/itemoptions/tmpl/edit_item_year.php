<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

	defined('_JEXEC') or die('Restricted access');
    
?>


<div class="uk-form">

    <div class="uk-grid">
        <div class="uk-width-1-4">
            <label>Starting Year</label>
            <?php echo $this->app->html->_('control.text', $this->getControlName('start'), $this->get('start'), 'class="uk-width-1-1"'); ?>
        </div>
        <div class="uk-width-1-4">
            <label>Ending Year</label>
            <?php echo $this->app->html->_('control.text', $this->getControlName('end'), $this->get('end'), 'class="uk-width-1-1"'); ?>
        </div>
        
        

    
    </div>

</div>