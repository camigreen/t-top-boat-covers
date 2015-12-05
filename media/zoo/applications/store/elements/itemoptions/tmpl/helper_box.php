<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

	defined('_JEXEC') or die('Restricted access');
        $helper_name = 'helper-'.$option_name;
?>
<a href="#<?php echo $helper_name; ?>"class="uk-icon-button uk-icon-info-circle" style="margin-left:10px;" data-uk-tooltip title="Click here for more info!" data-uk-modal></a>
<div id="<?php echo $helper_name; ?>" class="uk-modal">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <?php echo $helper_content;?>
    </div>
</div>
