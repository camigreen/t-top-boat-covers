<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php
nextendimport('nextend.image.color');

$params = $this->_sliderParams;

switch($params->get('showcasedirection', 'horizontal')){
    case 'vertical':
      $context['distanceh'] = 0;
      $context['distancev'] = intval($params->get('showcasedistance', 60)).'px';
    break;
    default:
      $context['distancev'] = 0;
      $context['distanceh'] = intval($params->get('showcasedistance', 60)).'px';
}


$context['perspective'] = intval($params->get('showcaseperspective', 1000)).'px';



$width = intval($context['width']);
$height = intval($context['height']);

$context['bgsize'] = NextendParse::parse($params->get('showcasebackgroundimagesize', 'auto'));

$border = NextendParse::parse($params->get('showcaseborder', '0|*|3E3E3Eff'));
$border1 = intval($border[0]);

$padding = NextendParse::parse($params->get('showcasepadding', '0|*|0|*|0|*|0'));
$context['paddingt'] = $padding[0] . 'px';
$context['paddingr'] = $padding[1] . 'px';
$context['paddingb'] = $padding[2] . 'px';
$context['paddingl'] = $padding[3] . 'px';


$context['border'] = $border1 . 'px';

$rgba = NextendColor::hex2rgba($border[1]);
$context['borderrgba'] = 'RGBA(' . $rgba[0] . ',' . $rgba[1] . ',' . $rgba[2] . ',' . round($rgba[3] / 127, 2) . ')';
$context['borderhex'] = '#' . substr($border[1], 0, 6);

$borderradius = NextendParse::parse($params->get('showcaseborderradius', '0|*|0|*|0|*|0'));

$context['tl'] = $borderradius[0] . 'px';
$context['tr'] = $borderradius[1] . 'px';
$context['br'] = $borderradius[2] . 'px';
$context['bl'] = $borderradius[3] . 'px';

$width = $width -  ($padding[1] + $padding[3]) - $border1 * 2;
$height = $height -  ($padding[0] + $padding[2]) - $border1 * 2;
$context['inner1height'] = $height . 'px';

$context['fullcanvaswidth'] = $width. 'px';
$context['fullcanvasheight'] = $height. 'px';


$showcaseslidesize = NextendParse::parse($params->get('showcaseslidesize', '600|*|400'));

$context['canvaswidth'] = $showcaseslidesize[0].'px';
$context['canvasheight'] = $showcaseslidesize[1].'px';

if($this->_backend){
    $context['fullcanvaswidth'] = $context['width'] = $context['canvaswidth'];
    $context['fullcanvasheight'] = $context['inner1height'] = $context['height'] = $context['canvasheight'];
    $context['paddingt'] = '0px';
    $context['paddingr'] = '0px';
    $context['paddingb'] = '0px';
    $context['paddingl'] = '0px';
}
