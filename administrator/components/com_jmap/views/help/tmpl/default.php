<?php 
/** 
 * @package JMAP::CPANEL::administrator::components::com_jmap
 * @subpackage views
 * @subpackage help
 * @subpackage tmpl
 * @author Joomla! Extensions Store
 * @copyright (C) 2014 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' ); 
?> 
<div class="panel-group" id="accordion_help">
	<div class="panel panel-default">
	    <div class="panel-heading accordion-toggle" data-toggle="collapse" data-parent="#accordion_help" data-target="#jmap_datasources">
			<h4 class="panel-title">
				<?php echo JText::_('COM_JMAP_JMAP_DATASOURCES');?>
			</h4>
	    </div>
	    <div id="jmap_datasources"  class="panel-collapse collapse">
	    	<div class="slidercontents">
				<div id="datasources"> 
					<!-- INFO 1 -->
					<div id="componentstatus">
						 <?php echo $this->loadTemplate('datasources');?>
					</div>
				</div>
			</div>  
	   </div>
	</div>
	
	<div class="panel panel-default">
	    <div class="panel-heading accordion-toggle" data-toggle="collapse" data-parent="#accordion_help" data-target="#jmap_sqlcompiler">
			<h4 class="panel-title">
				<?php echo JText::_('COM_JMAP_JMAP_SQLQUERY_COMPILER');?>
			</h4>
	    </div>
	    <div id="jmap_sqlcompiler"  class="panel-collapse collapse">
	    	<div class="slidercontents">
				<div id="sqlcompiler"> 
					<!-- INFO 1 -->
					<div id="componentstatus">
						 <?php echo $this->loadTemplate('sqlcompiler');?>
					</div>
				</div>
			</div>  
	   </div>
	</div>
</div>

<form name="adminForm" id="adminForm" action="index.php">
	<input type="hidden" name="option" value="<?php echo $this->option;?>"/>
	<input type="hidden" name="task" value=""/>
</form>