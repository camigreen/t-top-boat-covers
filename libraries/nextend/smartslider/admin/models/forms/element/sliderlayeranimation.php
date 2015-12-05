<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.form.element.list');

class NextendElementSliderLayerAnimation extends NextendElementList {

    function fetchElement() {
        static $options;
        if(!$options){
            $options = array(
                0 => 'No_animation',
                'fade' => 'Fade',
                'slidelefttoright' => 'Slide_left_to_right',
                'sliderighttoleft' => 'Slide_right_to_left',
                'slidetoptobottom' => 'Slide_top_to_bottom',
                'slidebottomtotop' => 'Slide_bottom_to_top',
                'flipx' => 'Flip_X',
                'fadeup' => 'Fade_up',
                'fadedown' => 'Fade_down',
                'fadeleft' => 'Fade_left',
                'faderight' => 'Fade_right',
                'bounce' => 'Bounce',
                'rotate' => 'Rotate',
                'rotateupleft' => 'Rotate_up_left',
                'rotatedownleft' => 'Rotate_down_left',
                'rotateupright' => 'Rotate_up_right',
                'rotatedownright' => 'Rotate_down_right',
                'rollin' => 'Roll_in',
                'rollout' => 'Roll_out',
                'scale' => 'Scale'
            );
            NextendPlugin::callPlugin('nextendslider', 'onNextendSliderLayerAnimations', array(&$options));
        }

        if (count($options)) {
            foreach ($options AS $k => $v) {
                $this->_xml->addChild('option', $v)->addAttribute('value', $k);
            }
        }
        $this->_value = $this->_form->get($this->_name, $this->_default);
        $html = parent::fetchElement();
        return $html;
    }

}
