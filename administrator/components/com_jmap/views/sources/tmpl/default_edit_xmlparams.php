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
<div id="accordion_datasource_xmlparameters" class="sqlquerier panel panel-group panel-info adminform">
	<div class="panel-heading accordion-toggle" data-toggle="collapse" data-target="#datasource_xmlparameters"><h4><?php echo JText::_('COM_JMAP_XMLSITEMAP_PARAMETERS' ); ?></h4></div>
	<div class="panel-body panel-collapse collapse" id="datasource_xmlparameters">
		<table  class="admintable">
			<tr>
				<td class="paramlist_key left_title"><span class="editlinktip"><label id="paramsxmlinclude-lbl" for="paramsxmlinclude" class="hasPopover" data-content="<?php echo JText::_('COM_JMAP_ELEMENTS_INCLUDE_DESC');?>"><?php echo JText::_('COM_JMAP_ELEMENTS_INCLUDE');?></label></span></td>
				<td class="paramlist_value">
					<fieldset id="jform_datasource_xmlinclude" class="radio btn-group">
						<?php echo JHTML::_('select.booleanlist', 'params[xmlinclude]', null,  $this->record->params->get('xmlinclude', 1), 'JYES', 'JNO', 'params_xmlinclude_');?>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td class="paramlist_key left_title">
					<span class="editlinktip"><label id="paramstitle-lbl" for="paramstitle" class="hasPopover" data-content="<?php echo JText::_('COM_JMAP_ELEMENTS_PRIORITY_DESC');?>"><?php echo JText::_('COM_JMAP_ELEMENTS_PRIORITY');?></label></span>
				</td>
				<td class="paramlist_value">
					<?php echo $this->lists['priority']; ?>
				</td>
			</tr>
			<tr>
				<td class="paramlist_key left_title">
					<span class="editlinktip"><label id="paramstitle-lbl" for="paramstitle" class="hasPopover" data-content="<?php echo JText::_('COM_JMAP_ELEMENTS_CHANGEFREQUENCY_DESC');?>"><?php echo JText::_('COM_JMAP_ELEMENTS_CHANGEFREQUENCY');?></label></span>
				</td>
				<td class="paramlist_value">
					<?php echo $this->lists['changefreq']; ?>
				</td>
			</tr>
			<tr>
				<td class="paramlist_key left_title"><span class="editlinktip"><label id="paramsxmlimagesinclude-lbl" for="paramsxmlimagesinclude" class="hasPopover" data-content="<?php echo JText::_('COM_JMAP_ELEMENTS_IMAGESINCLUDE_DESC');?>"><?php echo JText::_('COM_JMAP_ELEMENTS_IMAGESINCLUDE');?></label></span></td>
				<td class="paramlist_value">
					<fieldset id="jform_datasource_xmlimagesinclude" class="radio btn-group">
						<?php echo JHTML::_('select.booleanlist', 'params[xmlimagesinclude]', null,  $this->record->params->get('xmlimagesinclude', 1), 'JYES', 'JNO', 'params_xmlimagesinclude_');?>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td class="paramlist_key left_title">
					<span class="editlinktip"><label id="paramstitle-lbl" for="paramstitle" class="hasPopover" data-content="<?php echo JText::_('COM_JMAP_ELEMENTS_IMAGES_FILTERINCLUDE_DESC');?>"><?php echo JText::_('COM_JMAP_ELEMENTS_IMAGES_FILTERINCLUDE');?></label></span>
				</td>
				<td class="paramlist_value">
					<input type="text" name="params[images_filter_include]" value="<?php echo htmlspecialchars($this->record->params->get('images_filter_include', ''), ENT_QUOTES, 'UTF-8');?>" size="100"/>
				</td>
			</tr>
			<tr>
				<td class="paramlist_key left_title">
					<span class="editlinktip"><label id="paramstitle-lbl" for="paramstitle" class="hasPopover" data-content="<?php echo JText::_('COM_JMAP_ELEMENTS_IMAGES_FILTEREXCLUDE_DESC');?>"><?php echo JText::_('COM_JMAP_ELEMENTS_IMAGES_FILTEREXCLUDE');?></label></span>
				</td>
				<td class="paramlist_value">
					<input type="text" name="params[images_filter_exclude]" value="<?php echo htmlspecialchars($this->record->params->get('images_filter_exclude', 'pdf,print,email,media,templates'), ENT_QUOTES, 'UTF-8');?>" size="100"/>
				</td>
			</tr>
			<tr>
				<td class="paramlist_key left_title"><span class="editlinktip"><label id="paramsimagetitle_processor-lbl" for="paramsimagetitle_processor" class="hasPopover" data-content="<?php echo JText::_('COM_JMAP_IMAGETITLE_PROCESSOR_DESC');?>"><?php echo JText::_('COM_JMAP_IMAGETITLE_PROCESSOR');?></label></span></td>
				<td class="paramlist_value">
					<fieldset id="jform_datasource_imagetitle_processor" class="radio btn-group">
						<?php 
						$arr = array(
								JHTML::_('select.option',  '', JText::_( 'JGLOBAL_USE_GLOBAL' ) ),
								JHTML::_('select.option',  'title_alt', JText::_( 'COM_JMAP_TITLE_ALT' ) ), 
								JHTML::_('select.option',  'title', JText::_( 'COM_JMAP_ALWAYS_TITLE' ) ),
								JHTML::_('select.option',  'alt', JText::_( 'COM_JMAP_ALWAYS_ALT' ) )
						);
						echo JHTML::_('select.radiolist',  $arr, 'params[imagetitle_processor]', '', 'value', 'text', $this->record->params->get('imagetitle_processor', ''), 'params_imagetitle_processor_');
						?>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td class="paramlist_key left_title"><span class="editlinktip"><label id="paramsxmlmobileinclude-lbl" for="paramsxmlmobileinclude" class="hasPopover" data-content="<?php echo JText::_('COM_JMAP_ELEMENTS_MOBILEINCLUDE_DESC');?>"><?php echo JText::_('COM_JMAP_ELEMENTS_MOBILEINCLUDE');?></label></span></td>
				<td class="paramlist_value">
					<fieldset id="jform_datasource_xmlmobileinclude" class="radio btn-group">
						<?php echo JHTML::_('select.booleanlist', 'params[xmlmobileinclude]', null,  $this->record->params->get('xmlmobileinclude', 0), 'JYES', 'JNO', 'params_xmlmobileinclude_');?>
					</fieldset>
				</td>
			</tr>
		</table>
	</div>
</div>