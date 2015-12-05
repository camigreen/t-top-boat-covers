<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php
$js = NextendJavascript::getInstance();
$js->addLibraryJsFile('jquery', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'slider.js');

$backgroundimage = $this->_sliderParams->get('fullpagebackgroundimage', '');
$backgroundimagecss = '';
if ($backgroundimage && $backgroundimage != '-1') $backgroundimagecss = 'background-image: url(' . NextendUri::fixrelative($backgroundimage) . ');';

$flux = (array)NextendParse::parse($this->_sliderParams->get('fullpagebackgroundanimation', '0|*|bars||blocks'));
$flux[0] = $this->_backend ? 0 : intval($flux[0]);
foreach($this->_slides AS $slide){
    if ($slide['bg']['desktop'] == ''){
        $flux[0] = 0;
        break;
    }
}

if (!isset($flux[1])) $flux[1] = 'bars';
$flux[1] = (array)$flux[1];
if ($flux[0]) {
    $js->addLibraryJsFile('jquery', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'flux.jquery.js');
}

?>
<script type="text/javascript">
    window['<?php echo $id; ?>-onresize'] = [];
</script>

<div id="<?php echo $id; ?>" class="<?php echo $sliderClasses; ?>" style="font-size: <?php echo intval($fontsize[0]); ?>px;" data-allfontsize="<?php echo intval($fontsize[0]); ?>" data-desktopfontsize="<?php echo intval($fontsize[0]); ?>" data-tabletfontsize="<?php echo intval($fontsize[1]); ?>" data-phonefontsize="<?php echo intval($fontsize[2]); ?>">
    <div class="smart-slider-border1" style="<?php echo $backgroundimagecss . $this->_sliderParams->get('fullpageslidercss', ''); ?>">
        <div class="smart-slider-border2">
            <?php if ($flux[0]): ?>
                <div class="nextend-flux">
                    <?php foreach ($this->_slides AS $i => $slide): ?>
                        <img<?php echo $this->makeImg($slide['bg'], $i); ?> class="nextend-slide-bg"<?php if ($slide['first']) echo ' style="z-index:2;position: absolute; top: 0px; left: 0px;" '; ?>/>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <?php foreach ($this->_slides AS $i => $slide): ?>
                <div class="<?php echo $slide['classes']; ?> smart-slider-bg-colored" style="<?php echo $slide['style']; ?>"<?php echo $slide['link']; ?>>
                    <?php if (!$this->_backend && !$flux[0] && $slide['bg']['desktop']): ?>
                        <img<?php echo $this->makeImg($slide['bg'], $i); ?> class="nextend-slide-bg"/>
                    <?php endif; ?>
                    <?php if ($this->_backend && strpos($slide['classes'], 'smart-slider-slide-active') !== false): ?>
                        <img src="<?php echo ($slide['bg']['desktop'] ? $slide['bg']['desktop'] : 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'); ?>" class="nextend-slide-bg"/>
                    <?php endif; ?>
                    <div class="smart-slider-canvas-inner">
                        <?php echo $items->render($slide['slide'], $i); ?>
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

$properties['type'] = 'ssFullpageSlider';
$properties['animation'] = explode('||', $this->_sliderParams->get('fullpageanimation', 'no'));

$animationproperties = NextendParse::parse($this->_sliderParams->get('fullpageanimationproperties', '1500|*|0|*|easeInOutQuint|*|0.45'));
$properties['animationSettings'] = array(
    'duration' => intval($animationproperties[0]),
    'delay' => intval($animationproperties[1]),
    'easing' => $animationproperties[2],
    'parallax' => floatval($animationproperties[3])
);

$properties['flux'] = $flux;

$properties['responsive']['maxwidth'] = intval($this->_sliderParams->get('fullpageresponsivemaxwidth', 3000));

$fullscale = NextendParse::parse($this->_sliderParams->get('fullscale', '0|*|0'));
$properties['responsive']['horizontal'] = intval($fullscale[0]);
$properties['responsive']['vertical'] = intval($fullscale[1]);

$properties['carousel'] = intval($this->_sliderParams->get('fullcarousel', 0));

$fullfocus = NextendParse::parse($this->_sliderParams->get('fullfocus', '1|*|0'));

$properties['focus'] = array(
    'user' => intval($fullfocus[0]),
    'autoplay' => intval($fullfocus[1])
);

?>
<script type="text/javascript">
    njQuery(document).ready(function () {
        njQuery('#<?php echo $id; ?>').smartslider(<?php echo json_encode($properties); ?>);
    });
</script>
<div style="clear: both;"></div>
