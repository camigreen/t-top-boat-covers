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
<div id="accordion_datasource_parameters" class="sqlquerier panel panel-info panel-group adminform">
	<div class="panel-heading accordion-toggle" data-toggle="collapse" data-target="#datasource_parameters"><h4><?php echo JText::_('COM_JMAP_Parameters' ); ?></h4></div>
	<div class="panel-body panel-collapse collapse" id="datasource_parameters">
		<table  class="admintable">
			<tr>
				<td class="paramlist_key left_title"><span class="editlinktip"><label id="paramsopentarget-lbl" for="paramsopentarget" class="hasPopover" data-content="<?php echo JText::_('COM_JMAP_OPEN_TARGET_DESC');?>"><?php echo JText::_('COM_JMAP_OPEN_TARGET');?></label></span></td>
				<td class="paramlist_value">
					<fieldset id="jform_datasource_opentarget" class="radio btn-group">
						<?php 
							$arr = array(
								JHTML::_('select.option',  '', JText::_('JGLOBAL_USE_GLOBAL' ) ),
								JHTML::_('select.option',  '_self', JText::_('COM_JMAP_SELF_WINDOW' ) ),
								JHTML::_('select.option',  '_blank', JText::_('COM_JMAP_BLANK_WINDOW' ) ),
								JHTML::_('select.option',  '_parent', JText::_('COM_JMAP_PARENT_WINDOW' ) )
							);
							echo JHTML::_('select.radiolist',  $arr, 'params[opentarget]', '', 'value', 'text', $this->record->params->get('opentarget', ''), 'params_opentarget_');
						?>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td class="paramlist_key left_title"><span class="editlinktip"><label id="paramsdisable_acl-lbl" for="paramsdisable_acl" class="hasPopover" data-content="<?php echo JText::_('COM_JMAP_DISABLE_ACL_DESC');?>"><?php echo JText::_('COM_JMAP_DISABLE_ACL');?></label></span></td>
				<td class="paramlist_value">
					<fieldset id="jform_datasource_disable_acl" class="radio btn-group">
						<?php 
							$arr = array(
								JHTML::_('select.option',  '', JText::_('JGLOBAL_USE_GLOBAL' ) ),
								JHTML::_('select.option',  'enabled', JText::_('JENABLED' ) ),
								JHTML::_('select.option',  'disabled', JText::_('JDISABLED' ) )
							);
							echo JHTML::_('select.radiolist',  $arr, 'params[disable_acl]', '', 'value', 'text', $this->record->params->get('disable_acl', ''), 'params_disable_acl');
						?>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td class="paramlist_key left_title"><span class="editlinktip"><label id="paramshtmlinclude-lbl" for="paramshtmlinclude" class="hasPopover" data-content="<?php echo JText::_('COM_JMAP_HTML_ELEMENTS_INCLUDE_DESC');?>"><?php echo JText::_('COM_JMAP_HTML_ELEMENTS_INCLUDE');?></label></span></td>
				<td class="paramlist_value">
					<fieldset id="jform_datasource_htmlinclude" class="radio btn-group">
						<?php echo JHTML::_('select.booleanlist', 'params[htmlinclude]', null,  $this->record->params->get('htmlinclude', 1), 'JYES', 'JNO', 'params_htmlinclude_');?>
					</fieldset>
				</td>
			</tr>
			<!-- User or Menu Data source --> 
			<?php if(in_array($this->record->type, array('user', 'menu'))):?>
			<tr>
				<td class="paramlist_key left_title">
					<span class="editlinktip"><label id="paramstitle-lbl" for="paramstitle" class="hasPopover" data-content="<?php echo JText::_('COM_JMAP_SHOWED_SOURCE_TITLE_DESC');?>"><?php echo JText::_('COM_JMAP_SHOWED_SOURCE_TITLE');?></label></span>
				</td>
				<td class="paramlist_value">
					<input type="text" name="params[title]" id="paramstitle" value="<?php echo htmlspecialchars($this->record->params->get('title', ''), ENT_QUOTES, 'UTF-8');?>" class="text_area" size="50">
				</td>
			</tr>
			<tr>
				<td class="paramlist_key left_title"><span class="editlinktip"><label id="paramsshow_title-lbl" for="paramsshow_title" class="hasPopover" data-content="<?php echo JText::_('COM_JMAP_SHOW_SOURCE_TITLE_DESC');?>"><?php echo JText::_('COM_JMAP_SHOW_SOURCE_TITLE');?></label></span></td>
				<td class="paramlist_value">
					<fieldset id="jform_datasource_showtitle" class="radio btn-group">
						<?php echo JHTML::_('select.booleanlist', 'params[showtitle]', null,  $this->record->params->get('showtitle', 1), 'JYES', 'JNO', 'params_showtitle_');?>
					</fieldset>
				</td>
			</tr>
			<?php endif;?>
			<!-- User Data source --> 
			<?php if($this->hasManifest):?>
			<tr>
				<td class="paramlist_key left_title"><span class="editlinktip"><label id="paramsmultilevel_tree-lbl" for="paramsmultilevel_tree" class="hasPopover" data-content="<?php echo JText::_('COM_JMAP_MULTILEVEL_CATEGORIES_DESC');?>"><?php echo JText::_('COM_JMAP_MULTILEVEL_CATEGORIES');?></label></span></td>
				<td class="paramlist_value">
					<fieldset id="jform_datasource_multilevel_categories" class="radio btn-group">
						<?php 
							$arr = array(
								JHTML::_('select.option',  '', JText::_('JGLOBAL_USE_GLOBAL' ) ),
								JHTML::_('select.option',  1, JText::_('JENABLED' ) ),
								JHTML::_('select.option',  0, JText::_('JDISABLED' ) )
							);
							echo JHTML::_('select.radiolist',  $arr, 'params[multilevel_categories]', '', 'value', 'text', $this->record->params->get('multilevel_categories', ''), 'params_multilevel_categories_');
						?>
					</fieldset>
				</td>
			</tr>
			<?php endif;?>
			<?php if($this->hasCreatedDate):?>
			<tr>
				<td class="paramlist_key left_title"><span class="editlinktip"><label id="paramscreated_date-lbl" for="paramscreated_date" class="hasPopover" data-content="<?php echo JText::_('COM_JMAP_CREATED_DATE_DESC');?>"><?php echo JText::_('COM_JMAP_CREATED_DATE');?></label></span></td>
				<td class="paramlist_value">
					<fieldset id="jform_datasource_created_date" class="radio btn-group">
						<?php 
							$monthsOptions = array();
							$monthsOptions[] = JHTML::_('select.option',  '', JText::_('COM_JMAP_NO_DATE_LIMITS' ));
							for($months=1,$maxmonths=12;$months<=$maxmonths;$months++) {
								$monthsOptions[] = JHTML::_('select.option',  $months, JText::_('COM_JMAP_LAST_' . $months . 'MONTH' ));
							}
							echo JHTML::_('select.genericlist',  $monthsOptions, 'params[created_date]', '', 'value', 'text', $this->record->params->get('created_date', ''), 'params_created_date');
						?>
					</fieldset>
				</td>
			</tr>
			<?php endif;?>
			<?php if($this->record->type == 'user'):?>
			<tr>
				<td class="paramlist_key left_title"><span class="editlinktip"><label id="paramsdebug_mode-lbl" for="paramsdebug_mode" class="hasPopover" data-content="<?php echo JText::_('COM_JMAP_DEBUG_MODE_DESC');?>"><?php echo JText::_('COM_JMAP_DEBUG_MODE');?></label></span></td>
				<td class="paramlist_value">
					<fieldset id="jform_datasource_debugmode" class="radio btn-group">
						<?php echo JHTML::_('select.booleanlist', 'params[debug_mode]', null,  $this->record->params->get('debug_mode', 0), 'JYES', 'JNO', 'params_debugmode_');?>
					</fieldset>
				</td>
			</tr>
			<?php endif;?>
			<!-- Menu Data source --> 
			<?php if($this->record->type == 'menu'):?>
			<tr>
				<td class="paramlist_key left_title"><span class="editlinktip"><label id="paramsdounpublished-lbl" for="paramsdounpublished" class="hasPopover" data-content="<?php echo JText::_('COM_JMAP_DOUPUBLISHED_DESC');?>"><?php echo JText::_('COM_JMAP_DOUPUBLISHED');?></label></span></td>
				<td class="paramlist_value">
					<fieldset id="jform_datasource_dounpublished" class="radio btn-group">
						<?php echo JHTML::_('select.booleanlist', 'params[dounpublished]', null,  $this->record->params->get('dounpublished', 0), 'JYES', 'JNO', 'params_dounpublished_');?>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td class="paramlist_key left_title"><span class="editlinktip"><label id="paramsinclude_external_links-lbl" for="paramsinclude_external_links" class="hasPopover" data-content="<?php echo JText::_('COM_JMAP_INCLUDE_EXTERNAL_LINKS_DESC');?>"><?php echo JText::_('COM_JMAP_INCLUDE_EXTERNAL_LINKS');?></label></span></td>
				<td class="paramlist_value">
					<fieldset id="jform_datasource_include_external_links" class="radio btn-group">
						<?php echo JHTML::_('select.booleanlist', 'params[include_external_links]', null,  $this->record->params->get('include_external_links', 1), 'JYES', 'JNO', 'params_include_external_links_');?>
					</fieldset>
				</td>
			</tr>
			<?php endif;?>
		</table>
		<input type="hidden" name="params[datasource_extension]" value="<?php echo $this->record->params->get('datasource_extension', '');?>"/>
	</div>
</div> 