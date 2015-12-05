<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

	defined('_JEXEC') or die('Restricted access');
        $class = 'helper-zipper';
        echo $test;
?>
<a href="#<?php echo $class; ?>"class="uk-icon-button uk-icon-info-circle" style="margin-left:10px;" data-uk-tooltip title="Click here for more info!" data-uk-modal></a>
<div id="<?php echo $class; ?>" class="uk-modal">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <?php echo $element->render($params);?>
    </div>
</div>