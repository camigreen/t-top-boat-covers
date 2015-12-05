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
            <label>Value</label>
            <?php echo $this->app->html->_('control.text', $this->getControlName('value'), $this->get('value', $this->config->get('default')), 'class="uk-width-1-1"'); ?>
        </div>
        <div class="uk-width-3-4">
            <label>Text</label>
            <?php echo $this->app->html->_('control.text', $this->getControlName('name'), $this->get('name', $this->config->get('default')), 'class="uk-width-1-1"'); ?>
        </div>
        
        

    
    </div>

</div>