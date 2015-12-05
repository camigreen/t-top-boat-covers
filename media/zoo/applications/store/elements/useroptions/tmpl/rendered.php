<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$class = 'uk-width-1-1 item-option'.($params['required'] ? ' required' :'');

?>
<?php foreach($select as $field) : ?>
    <?php if($params['showlabel']) : ?>
        <label><?php echo isset($field['label']) ? $field['label'] : $field['name'].$this->hasModal($params, $field['field']); ?></label>
    <?php endif; ?>
    <select id="<?php echo $field['field']; ?>" class="<?php echo $class; ?>" name="<?php echo $field['field']; ?>" data-name="<?php echo $field['name']; ?>" >
        
        <?php foreach($field['choices'] as $option) : ?>
        <option value="<?php echo $option['value']; ?>" <?php echo ($option['selected'] ? 'selected' : ''); ?>><?php echo $option['name']; ?></option>
        <?php endforeach; ?>
    </select>

<?php endforeach; ?>

