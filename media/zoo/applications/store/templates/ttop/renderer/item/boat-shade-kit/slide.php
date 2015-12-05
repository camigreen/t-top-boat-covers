<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
$renderer = $this->app->renderer->create('item')->addPath(array($this->app->path->path('component.site:'), $item->getApplication()->getTemplate()->getPath()));
?>
<!-- This is the nav containing the toggling elements -->
<ul style="display:none;" data-uk-switcher="{connect:'#bsk'}">
    <li><a href=""></a></li>
    <li><a href=""></a></li>
    <li><a href=""></a></li>
    <li><a href=""></a></li>
    <li><a href=""></a></li>
</ul>

<!-- This is the container of the content items -->
<ul id="bsk" class="uk-switcher">
    <li class="uk-active">
        <?php echo $renderer->render('item.boat-shade-kit.order1', array('item' => $item)); ?>
    </li>
    <li>
        <?php echo $renderer->render('item.boat-shade-kit.order2', array('item' => $item)); ?>
    </li>
    <li>
        <?php echo $renderer->render('item.boat-shade-kit.order3', array('item' => $item)); ?>
    </li>
    <li>
        <?php echo $renderer->render('item.boat-shade-kit.order4', array('item' => $item)); ?>
    </li>
    <li>
        <?php echo $renderer->render('item.boat-shade-kit.order5', array('item' => $item)); ?>
    </li>
</ul>

<div id="bsk-details">
    <div id="bsk_type">Type: Unknown</div><br/>
    <div id="bsk_usage"></div>
</div>

<script>
    var bsk = {
        type: null,
        usage: null
    };
    
    function bsk_usage() {
        var btn = jQuery('#bsk-2 button.uk-active');
        bsk.usage = btn.data('usage');
        jQuery('#bsk_usage').html('Usage: '+btn.data('usage'));
    }
    jQuery(function($) {
        $('[data-uk-switcher]').on('show.uk.switcher', function(event, area){
            bsk_usage();
        });
        $('#bsk-3 [name="beam"]').on('input', function() {
            var type;
            if ($(this).val() === '0') {
                type = 'unknown'; 
                $('#bsk-3 .bsk-next').prop('disabled',true);
            } else {
                type = $(this).val();
                $('#bsk-3 .bsk-next').prop('disabled',false);
            }
            bsk.type = type;
            $('#bsk_type').html('Type: '+type);
        });
            
        console.log(bsk);
    });
</script>