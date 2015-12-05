<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

	defined('_JEXEC') or die('Restricted access');
?>
<div class="uk-grid">
    <?php foreach($options as $key => $value) { ?>
    <?php $name = str_replace(' ','_',strtolower($key)); ?>
    <div class="uk-width-1-2">
        <input id="<?php echo $key; ?>" type="checkbox" name="<?php echo $key; ?>" value='true' class="uk-margin-right item-option"/><label for="name1"><?php echo $value; ?></label>
    </div>
    <?php } ?>
</div>
