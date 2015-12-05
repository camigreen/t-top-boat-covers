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
<article id="bsk-2" class="uk-article">
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-1-1">
            <div class="uk-article-title">How do you want to use your T-Top Boat Shade Kit?</div>
        </div>
        <div class="uk-width-1-1">
            <div class="uk-container">
                <div class="uk-text-center">
                    <p>Choose one of the options below.</p>
                    <!-- This is the container of the toggling buttons -->
                    <div data-uk-switcher="{connect:'#bsk-usage'}">
                        <button class="uk-button uk-button-danger" type="button" data-usage="aft">Aft Only</button>
                        <button class="uk-button uk-button-danger" type="button" data-usage="bow">Bow Only</button>
                        <button class="uk-button uk-button-danger" type="button" data-usage="bow_aft">Bow or Aft</button>
                        <button class="uk-button uk-button-danger" type="button" data-usage="multi">Multipurpose Boat Shade Kit</button>
                    </div>

                    <!-- This is the container of the content items -->
                    <ul id="bsk-usage" class="uk-switcher uk-margin">
                        <li>
                            <p>I want to use my boat shade kit just on the aft of the boat.</p>
                            <img src="images/placeholders/700x500.png" height="500" width="700" />
                        </li>
                        <li>
                            <p>I want to use my boat shade kit just on the bow of the boat.</p>
                            <img src="images/placeholders/700x500.png" height="500" width="700" />
                        </li>
                        <li>
                            <p>I want to be able to use my boat shade kit on either the bow of the boat or the aft of the boat.</p>
                            <img src="images/placeholders/700x500.png" height="500" width="700" />
                        </li>
                        <li>
                            <p>The multipurpose boat shade is actually two boat shades that are installed on bow and the aft at the same time.</p>
                            <img src="images/placeholders/700x500.png" height="500" width="700" />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="uk-width-1-1">
            <a href="#" class="uk-button uk-button-primary uk-width-1-5" data-uk-switcher-item="previous">Previous</a>
            <a href="#" class="uk-button uk-button-primary uk-width-1-5 uk-align-right" data-uk-switcher-item="next">Next</a>
        </div>
        
    </div>
</article>