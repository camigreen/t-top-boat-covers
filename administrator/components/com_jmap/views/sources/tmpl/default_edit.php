<?php 
/** 
 * @package JMAP::SOURCES::administrator::components::com_jmap
 * @subpackage views
 * @subpackage sources
 * @subpackage tmpl
 * @author Joomla! Extensions Store
 * @copyright (C) 2014 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' ); 
?>
<form action="index.php" method="post" name="adminForm" id="adminForm"> 
	<!-- Data source details --> 
	<?php echo $this->loadTemplate('edit_details'); ?>
	<!-- Data source parameters --> 
	<?php echo $this->loadTemplate('edit_params'); ?>
	<!-- Data source parameters for XML format --> 
	<?php echo $this->loadTemplate('edit_xmlparams'); ?>
	<!-- Menu Data source only --> 
	<?php if($this->record->type == 'menu') {
		echo $this->loadTemplate('edit_menu');
	}?>
	<!-- Content Data source only --> 
	<?php if($this->record->type == 'content') {
		echo $this->loadTemplate('edit_content');
	}?>
	<!-- User Data source only --> 
	<?php if ($this->record->type == 'user') {
		echo $this->loadTemplate('edit_sqlquery');
	}?>  
	<input type="hidden" name="option" value="<?php echo $this->option?>" />
	<input type="hidden" name="id" value="<?php echo $this->record->id; ?>" />
	<input type="hidden" id="regenerate_query" name="regenerate_query" value="" />
	<input type="hidden" name="task" value="" />
</form>

<!-- Modal -->
<div class="modal fade" id="suggestions_modal" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="Suggestions" aria-hidden="true">
	<div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><?php echo JText::_('COM_JMAP_EXAMPLE_DATA_SUGGESTIONS');?></h4>
        </div>
        <div class="modal-body">
        	<iframe id="dialog_iframe"></iframe>
        </div>
      </div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Go to bottom -->
<div class="label label-default" id="gobottom">
	<span class="glyphicon glyphicon-arrow-down"></span> <?php echo JText::_('COM_JMAP_GO_TO_BOTTOM');?>
</div>

<!-- Back to top -->
<div class="label label-default" id="backtop">
	<span class="glyphicon glyphicon-arrow-up"></span> <?php echo JText::_('COM_JMAP_BACK_TO_TOP');?>
</div>