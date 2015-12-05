<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

?>
<article id="bsk-3" class="uk-article uk-form">
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-1-1">
            <div class="uk-article-title">Select the measurement between the rod holder that you plan to use.</div>
        </div>
        <div class="uk-width-1-1">
            <label>Select the measurement</label>
            <select name='beam'>
                <option value='0'>- Select -</option>
                <option value='bsk'>6’ to 6’6”</option>
                <option value='bsk'>6’-7” to 6’-11”</option>
                <option value='bsk'>7’ to 7’6”</option>
                <option value='bsk'>7’-7” to 7’-11”</option>
                <option value='bsk'>8’ to 8’-6”</option>
                <option value='bsk'>8’-7” to 8’-11”</option>
                <option value='bsk'>9’ to 9’6”</option>
                <option value='bsk'>9’-6” to 9’-11”</option>
                <option value='bsk'>10’ to 10’ 6”</option>
                <option value='ubsk'>Greater than 10’-6”</option>
            </select>
        </div>
        <div class='uk-width-1-1'>
            <img src="images/bsk/measuringtool_beam.png" />
        </div>
        <div class="uk-width-1-1">
            <button class="bsk-previous uk-button uk-button-primary uk-width-1-5" data-uk-switcher-item="previous">Previous</button>
            <button class="bsk-next uk-button uk-button-primary uk-width-1-5 uk-align-right" data-uk-switcher-item="next" disabled>Next</button>
        </div>
        
    </div>
</article>