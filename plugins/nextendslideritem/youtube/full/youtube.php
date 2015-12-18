<?php

class plgNextendSliderItemYoutube extends plgNextendSliderItemYoutubeFree {

    var $_title = 'YouTube';
    
    function getTemplate(){
    
        return '<img alt="" src="//img.youtube.com/vi/{code}/{defaultimage}.jpg" style="width: 100%; height: 100%;" />';
    }
    
    function _render($data, $id, $sliderid, $items){
    
        $youtubeurl = $this->parseYoutubeUrl($data->get('youtubeurl', ''));
        
        $js = NextendJavascript::getInstance();
        $js->addLibraryJsFile('jquery', $this->getPath() . 'youtube.js');
            
        return '<div id="'.$id.'" data-youtubecode="'.$youtubeurl.'" data-reset="'.$data->get('reset', 0).'" data-autoplay="'.$data->get('autoplay').'" data-related="'.$data->get('related').'" data-loop="'.$data->get('loop', 0).'" data-mute="'.$data->get('mute', 1).'" data-cover="'.$data->get('cover').'" data-controls="'.$data->get('controls', 1).'" data-showinfo="'.$data->get('showinfo', 1).'" data-vq="'.$data->get('vq').'" data-theme="'.$data->get('theme').'" style="position: absolute; top:0; left: 0; display: none; width: 100%; height: 100%;"></div>
    <script type="text/javascript">
        njQuery(document).ready(function () {
            ssCreateYouTubePlayer("'.$id.'", "'.$sliderid.'");
        });
    </script>';
    }
    
    function _renderAdmin($data, $id, $sliderid, $items){
        $youtubeurl = $this->parseYoutubeUrl($data->get('youtubeurl', ''));
        return '<img alt="" src="//img.youtube.com/vi/'.$youtubeurl.'/'.$data->get('defaultimage').'.jpg" style="width: 100%; height: 100%;" />';
    }
    
    function parseYoutubeUrl($youtubeurl){
        preg_match('/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/', $youtubeurl, $matches);
        if ($matches && isset($matches[7]) && strlen($matches[7]) == 11){ 
            return $matches[7];
        }
        return $youtubeurl;
    }
    
    function onNextendSliderRender(&$slider, $id){
        preg_match_all('/<!\-\-smartslideryoutubeitem,([a-zA-Z0-9\-]*?),([a-zA-Z0-9\-_]*?)\-\->/', $slider, $out, PREG_SET_ORDER);
        if(count($out)){
            $js = NextendJavascript::getInstance();
            $js->addLibraryJsFile('jquery', $this->getPath() . 'youtube.js');
            
            foreach($out AS $o){
                $slider .="<script type='text/javascript'>
                          njQuery(document).ready(function () {
                              ssCreateYouTubePlayer('".$o[1].$o[2]."', '".$id."');
                          });
                      </script>";
            }
        }
    }
}