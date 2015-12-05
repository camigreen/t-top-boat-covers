<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php
$this->loadFragment('headerstart');
?>
    <div class="smartslider-button smartslider-save" onclick="setTimeout(function(){njQuery('#smartslider-form').submit();}, 300);"><?php echo NextendText::_('Save'); ?></div>
<?php
$this->loadFragment('headerend');
?>

<?php
$this->loadFragment('firstcolstart');
?>

<?php
$this->loadFragment('firstcol/slide');
?>

<?php
$this->loadFragment('firstcolend');
?>

<?php
$this->loadFragment('secondcolstart');
?>
<form id="smartslider-form" action="" method="post">
    <?php
    NextendForm::tokenize();
    $layoutsModel = $this->getModel('layouts');
    $layoutsModel->renderAddForm();
    ?>
    <input name="save" value="1" type="hidden" />
</form>

<?php
global $ss2sliderafterform;
echo $ss2sliderafterform;
?>

<?php
$this->loadFragment('secondcolend');
?>

<?php
$this->loadFragment('footer');
