<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

$this->loadFragment('headerstart');
?>

<?php
$this->loadFragment('headerend');
?>

<?php
$this->loadFragment('firstcolstart');
?>

<?php
$this->loadFragment('firstcol/sliders');
?>

<?php
$this->loadFragment('firstcolend');
?>

<?php
$this->loadFragment('secondcolstart');
?>

<div style="width: 50%" class="box y"><h3>Limited access</h3><p><?php echo NextendText::_('Access_to_this_resource_not_allowed'); ?></p></div>

<?php
$this->loadFragment('secondcolend');
?>

<?php
$this->loadFragment('footer');
