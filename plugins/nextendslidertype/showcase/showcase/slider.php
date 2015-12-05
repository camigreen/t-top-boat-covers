<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php
$js = NextendJavascript::getInstance();
$js->addLibraryJsFile('jquery', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'slider.js');

$backgroundimage = $this->_sliderParams->get('showcasebackgroundimage', '');
$backgroundimagecss = '';
if ($backgroundimage && $backgroundimage != '-1') $backgroundimagecss = 'background-image: url(' . NextendUri::fixrelative($backgroundimage) . ');';

$direction = '';
switch($this->_sliderParams->get('showcasedirection', 'horizontal')){
    case 'vertical':
      $sliderClasses.= ' smart-slider-showcase-vertical';
      $direction = 'vertical';
    break;
    default:
      $sliderClasses.= ' smart-slider-showcase-horizontal';
      $direction = 'horizontal';
}

?>
<script type="text/javascript">
    window['<?php echo $id; ?>-onresize'] = [];
</script>

<div id="<?php echo $id; ?>" class="<?php echo $sliderClasses; ?>" style="font-size: <?php echo intval($fontsize[0]); ?>px;" data-allfontsize="<?php echo intval($fontsize[0]); ?>" data-desktopfontsize="<?php echo intval($fontsize[0]); ?>" data-tabletfontsize="<?php echo intval($fontsize[1]); ?>" data-phonefontsize="<?php echo intval($fontsize[2]); ?>">
    <div class="smart-slider-border1" style="<?php echo $backgroundimagecss . $this->_sliderParams->get('showcaseslidercss', ''); ?>">
        <div class="smart-slider-border2">
            <div class="smart-slider-pipeline">
                <?php foreach ($this->_slides AS $i => $slide): ?>
                    <div class="<?php echo $slide['classes']; ?> smart-slider-bg-colored" style="<?php echo $slide['style'].$this->_sliderParams->get('showcaseslidecss', ''); ?>"<?php echo $slide['link']; ?>>
                        <?php if (!$this->_backend && $slide['bg']['desktop']): ?>
                            <img<?php echo $this->makeImg($slide['bg'], $i); ?> class="nextend-slide-bg"/>
                        <?php endif; ?>
                        <?php if ($this->_backend && strpos($slide['classes'], 'smart-slider-slide-active') !== false): ?>
                            <img src="<?php echo ($slide['bg']['desktop'] ? $slide['bg']['desktop'] : 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'); ?>" class="nextend-slide-bg"/>
                        <?php endif; ?>
                        <div class="smart-slider-canvas-inner">
                            <?php echo $items->render($slide['slide'], $i); ?>
                        </div>
                        <div class="smart-slider-overlay"></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php
    $widgets->echoRemainder();
    ?>
</div>

<?php

$properties['type'] = 'ssShowcaseSlider';

$animationproperties = NextendParse::parse($this->_sliderParams->get('showcaseanimationproperties', '1500|*|0|*|easeInOutQuint'));
$properties['animationSettings'] = array(
    'duration' => intval($animationproperties[0]),
    'delay' => intval($animationproperties[1]),
    'easing' => $animationproperties[2]
);

$properties['responsive']['maxwidth'] = intval($this->_sliderParams->get('showcaseresponsivemaxwidth', 3000));

$opacity = NextendParse::parse($this->_sliderParams->get('showcaseopacity', '0|*|100|*|100|*|100'));
if($opacity[0] != 1){
    $opacity = null;
}else{
    $opacity = array(
        'before' => $opacity[1]/100,
        'active' => $opacity[2]/100,
        'after' => $opacity[3]/100
    );
}

$scale = NextendParse::parse($this->_sliderParams->get('showcasescale', '0|*|100|*|100|*|100'));
if($scale[0] != 1){
    $scale = null;
}else{
    $scale = array(
        'before' => $scale[1]/100,
        'active' => $scale[2]/100,
        'after' => $scale[3]/100
    );
}

if(!function_exists('ss_showcase_anim_prop')){
    function ss_showcase_anim_prop($params, $prop){
        $a = NextendParse::parse($params->get($prop, '0|*|0|*|0|*|0'));
        if($a[0] != 1){
            return null;
        }else{
            return array(
                'before' => intval($a[1]),
                'active' => intval($a[2]),
                'after' => intval($a[3])
            );
        }
    }
}

$properties['showcase'] = array(
    'direction' => $direction,
    'distance' => intval($this->_sliderParams->get('showcasedistance', 60)),
    'animate' => array(
        'opacity' => $opacity,
        'scale' => $scale,
        'x' => ss_showcase_anim_prop($this->_sliderParams, 'showcasetranslatex'),
        'y' => ss_showcase_anim_prop($this->_sliderParams, 'showcasetranslatey'),
        'z' => ss_showcase_anim_prop($this->_sliderParams, 'showcasetranslatez'),
        'rotateX' => ss_showcase_anim_prop($this->_sliderParams, 'showcaserotatex'),
        'rotateY' => ss_showcase_anim_prop($this->_sliderParams, 'showcaserotatey'),
        'rotateZ' => ss_showcase_anim_prop($this->_sliderParams, 'showcaserotatez'),
    )
);

?>
<script type="text/javascript">
    njQuery(document).ready(function () {
        njQuery('#<?php echo $id; ?>').smartslider(<?php echo json_encode($properties); ?>);
    });
</script>
<div style="clear: both;"></div>
