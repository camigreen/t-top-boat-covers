<?php

nextendimportsmartslider2('nextend.smartslider.plugin.slideritem');

class plgNextendSliderItemYoutubeFree extends plgNextendSliderItemAbstract
{

    var $_identifier = 'youtube';

    var $_title = 'YouTube - full';

    function getTemplate()
    {
        return "
          <div>
              Only in full version!
          </div>
        ";
    }

    function getValues(){
        return array(
            'code' => 'qesNtYIBDfs',
            'youtubeurl' => 'http://www.youtube.com/watch?v=qesNtYIBDfs',
            'autoplay' => 0,
            'defaultimage' => 'maxresdefault',
            'related' => '1',
            'vq' => 'default'
        );
    }

    function getPath()
    {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . $this->_identifier . DIRECTORY_SEPARATOR;
    }
}

$full = dirname(__FILE__) . '/full/' . basename(__FILE__);
if (NextendFilesystem::existsFile($full)) {
    require_once dirname(__FILE__) . '/full/' . basename(__FILE__);
} else {
    class plgNextendSliderItemYoutube extends plgNextendSliderItemYoutubeFree
    {
    }
}

NextendPlugin::addPlugin('nextendslideritem', 'plgNextendSliderItemYoutube');