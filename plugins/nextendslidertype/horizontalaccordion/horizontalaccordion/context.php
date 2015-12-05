<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php
nextendimport('nextend.image.color');
nextendimport('nextend.parse.font');

$params = $this->_sliderParams;

$width = intval($context['width']);
$height = intval($context['height']);

$titlewidth = 30;

$border = NextendParse::parse($params->get('accordionhorizontalborder','6|*|3E3E3Eff|*|6|*|222222ff'));

$border1 = $border[0];
$context['border1'] = $border1 . 'px';

$rgba = NextendColor::hex2rgba($border[1]);
$context['border1rgba'] = 'RGBA('.$rgba[0].','.$rgba[1].','.$rgba[2].','.round($rgba[3]/127, 2).')';
$context['border1hex'] = '#'.substr($border[1], 0,6);

$border2 = $border[2];
$context['border2'] = $border2 . 'px';

$rgba = NextendColor::hex2rgba($border[3]);
$context['border2rgba'] = 'RGBA('.$rgba[0].','.$rgba[1].','.$rgba[2].','.round($rgba[3]/127, 2).')';
$context['border2hex'] = '#'.substr($border[3], 0,6);

$borderradius = NextendParse::parse($params->get('accordionhorizontalborderradius','6|*|6|*|6|*|6'));

$context['tl'] = $borderradius[0].'px';
$context['tr'] = $borderradius[1].'px';
$context['bl'] = $borderradius[3].'px';
$context['br'] = $borderradius[2].'px';

$tagmargin = NextendParse::parse($params->get('accordionhorizontaltagmargin','10|*|10'));
$context['tagmargintop'] = $tagmargin[0].'px';
$context['tagmarginbottom'] = $tagmargin[1].'px';


$tabbg = $params->get('accordionhorizontaltabbg','3E3E3E');

$context['tabbg'] = '#'.$tabbg;

$tabbgactive = $params->get('accordionhorizontaltabbgactive','87B801');

$context['tabbgactive'] = '#'.$tabbgactive;

$slidemargin = 2;

$context['slidemargin'] = $slidemargin . 'px';
$context['slidemarginneg'] = -$slidemargin . 'px';


$titlewidths = $titlewidth*$context['count'];

$context['inner1margin'] = '0';

if ($context['canvas']) {
    $width += 2 * ($border1+$border2)+$titlewidths+$slidemargin * 2 * $context['count'];
    $height += 2 * ($border1+$border2+$slidemargin);

    $context['width'] = $width . "px";
    $context['height'] = $height . "px";
}

$width = $width - 2 * $border1;
$height = $height - 2 * $border1;
$context['border1width'] = $width . 'px';
$context['border1height'] = $height . 'px';

$width = $width - 2 * $border2;
$height = $height - 2 * $border2;
$context['border2width'] = $width . 'px';
$context['border2height'] = $height . 'px';


$width = $width - 2 * ($context['count']) * $slidemargin;
$height = $height - 2 * $slidemargin;

$context['titlewidth'] = $titlewidth . "px";
$context['titleheight'] = $height . "px";

$context['innerborderradius'] = "2px";

$context['canvaswidth'] = $width-$titlewidths . "px";
$context['canvasheight'] = $height . "px";

$f = $params->get('accordionhorizontaltabfont', '{"firsttab":"Text","Text":{"color":"e4eaeeff","size":"112||%","tshadow":"0|*|1|*|0|*|000000FF","afont":"google(@import url(http://fonts.googleapis.com/css?family=Open Sans);),Arial","lineheight":"normal","bold":1,"italic":0,"underline":0,"align":"right","paddingleft":0},"Active":{"paddingleft":0,"color":"222222ff","tshadow":"0|*|1|*|0|*|ffffff3d"},"Link":{"paddingleft":0},"Hover":{"paddingleft":0,"color":"222222ff","tshadow":"0|*|1|*|0|*|ffffffff"},"firsttab":"Text"}');
if(json_decode($f)===null) $f = base64_decode($f);
$font = new NextendParseFont($f);
$context['tabfont-text'] = '";'.$font->printTab().'"';
$font->mixinTab('Active');
$context['tabfont-active'] = '";'.$font->printTab('Active').'"';
