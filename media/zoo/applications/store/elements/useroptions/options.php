<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/



?>

<div class="user-options" >
    <div class="options">
        <?php foreach($select as $k => $v) : ?>
        <div id="option-<?php echo $k; ?>" class="row" data-index="<?php echo $k; ?>" data-element="<?php echo $element_id; ?>">
            <div class="option-box">
                <div class="data">
                    <div class="row">
                        <input id="option-label" type="text" name="<?php echo $v['label_field']; ?>" value="<?php echo $v['label_value'] ?>" placeholder="Label" />
                    </div>
                    <div class="row">
                        <input id="option-name" type="text" name="<?php echo $v['name_field']; ?>" value="<?php echo $v['name_value'] ?>" placeholder="Option Name" />
                    </div>
                    <div class="row">
                        <input id="option-field" type="text" name="<?php echo $v['field_field']; ?>" value="<?php echo $v['field_value'] ?>" placeholder="Field Name" />
                    </div>
                    <div class="row">
                        <input id="option-default" type="text" name="<?php echo $v['default_field']; ?>" value="<?php echo $v['default_value'] ?>" placeholder="Default Value" />
                    </div>
                </div>
                <div class="choices">
                    <?php echo $v['choices']; ?>
                    <div class="add">
                        <button>Add an Option Choice</button>
                    </div>
                </div>

            </div>
            <div class="delete delete-option" title="<?php echo JText::_('Delete option'); ?>">
                <img alt="<?php echo JText::_('Delete option'); ?>" src="<?php echo $this->app->path->url('assets:images/delete.png'); ?>"/>
            </div>
            
        </div>
        <?php endforeach; ?>
        <div class="add add-option" disabled>
            <button>Add an Option</button>
        </div>
    </div>
    
    
    <script>
        jQuery(document).ready(function($){
            $('.user-options .options>.row').each(function(){
                $(this).ElementSelect({element: $(this).data('element'), index: $(this).data('index')});
            });
        })
    </script>
</div>

