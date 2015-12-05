<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php
$js = NextendJavascript::getInstance();
$js->addLibraryJsFile('jquery', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'slider.js');
?>
<script type="text/javascript">
    window['<?php echo $id; ?>-onresize'] = [];
</script>

<div id="<?php echo $id; ?>" class="<?php echo $this->_sliderParams->get('accordionverticalthemeclass', 'dark'); ?> <?php echo $sliderClasses; ?>" style="font-size: <?php echo intval($fontsize[0]); ?>px;" data-allfontsize="<?php echo intval($fontsize[0]); ?>" data-desktopfontsize="<?php echo intval($fontsize[0]); ?>" data-tabletfontsize="<?php echo intval($fontsize[1]); ?>" data-phonefontsize="<?php echo intval($fontsize[2]); ?>">
    <div class="smart-slider-border1">
        <div class="smart-slider-border2">
            <?php foreach ($this->_slides AS $i => $slide): ?>
                <div class="accordion-vertical-title">
                    <div class="accordion-vertical-title-inner">
                        <?php echo $slide['title']; ?>
                    </div>
                </div>
                <div class="accordion-vertical-slide smart-slider-bg-colored" style="<?php echo $slide['style']; ?>"<?php echo $slide['link']; ?>>
                    <div class="<?php echo $slide['classes']; ?>">
                        <?php if (!$this->_backend && $slide['bg']['desktop']): ?>
                            <img<?php echo $this->makeImg($slide['bg'], $i); ?> class="nextend-slide-bg"/>
                        <?php endif; ?>
                        <?php if ($this->_backend && strpos($slide['classes'], 'smart-slider-slide-active') !== false): ?>
                            <img src="<?php echo ($slide['bg']['desktop'] ? $slide['bg']['desktop'] : 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'); ?>" class="nextend-slide-bg"/>
                        <?php endif; ?>
                        <div class="smart-slider-canvas-inner">
                            <?php echo $items->render($slide['slide'], $i); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    $widgets->echoRemainder();
    ?>
</div>

<?php
$properties['type'] = 'ssVerticalAccordionSlider';
?>
<script type="text/javascript">
    njQuery(document).ready(function () {
        njQuery('#<?php echo $id; ?>').smartslider(<?php echo json_encode($properties); ?>);
    });
</script>
<div style="clear: both;"></div>