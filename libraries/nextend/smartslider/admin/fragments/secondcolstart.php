<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php
global $smartsliderfullwidth;
$css = NextendCss::getInstance();
$css->addCssFile(NEXTEND_SMART_SLIDER2_ASSETS . 'admin/css/secondcol.css');
?>
<div class="smartslider-secondcol" style="<?php if($smartsliderfullwidth === true){?>width: 100%;<?php }?>">