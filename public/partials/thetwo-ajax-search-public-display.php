<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Thetwo_Ajax_Search
 * @subpackage Thetwo_Ajax_Search/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="popup" id="popup-search">
    <div class="popup-background"></div>
    <div class="inner search" id="main-search-wrapper">
        <div class="search-wrapper">
            <form role="search" method="get" class="searchform" action="<?php echo home_url(); ?>">
                <input class="main-search-field bp" id="main-search-field" placeholder="<?= _e('Search'); ?>" type="text" value="" name="s">
                <i class="fa fa-search" aria-hidden="true"></i>
                <i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>
                <i class="fa fa-times-circle" aria-hidden="true" id="main-search-x"></i>
            </form>
        </div>
        <div class="search-results-wrapper">
            <ul id="main-search-results">

            </ul>
        </div>
    </div>
</div>