=== TheTwo Ajax Search  ===

Contributors: amitrahav
Tags: ajax, search, front
Requires at least: 5.2
Tested up to: 5.2
Stable tag: 1.0
Requires PHP: 7.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A beutiful display of ajax search and results. Using Shortcode alone - not hurting the default wp search functoin.

== Description ==

Using `[thetwo-ajax-search]` shortcode, you can easily include a beautiful display of ajax secure search.
After typing 3 letters at the search input - a search popup will come up, body will go dark and the search term will be sent via ajax with jQuery to the search fucntion.
This Plugin has languages support with .pot file at the /languages/ folder.


== Logic ==

The search Process:
1. Retrive terms and add it to args array.
2. Apply `thetwo_ajax_search_query_vars_before_get_posts` filter to alter the args.
3. If you have installed and activated [Relevanssi plugin](https://he.wordpress.org/plugins/relevanssi/) the args will be sent to `relevanssi_do_query` function.
4. Otherwise it will be sent to wp `get-posts` function.
5. Each post found will be set as an object with those parmeters:
    * title
    * id
    * date
    * link
    * content
    * thumbnail
    * thumbnail_url
    * post_type
6. Apply `thetwo_ajax_search_psot_details_before_added_to_results_array` filter - in case you want to change each post details.
7. Add post details to returend array.
8. Return results array with json encode into js to handle.


It is easily ajustable for your needs with a few filters you can applay in your functions.php file.

= Query only certain post type =
add this to your functions.php file:
`
add_filter( 'thetwo_ajax_search_query_vars_before_get_posts', 'only_pages_search' );
function only_pages_search($args){
    $args['post_type'] = 'page'
    return $args;
}
`
= Adding post first category name to the search results =
add this to your functions.php file:
`
add_filter( 'thetwo_ajax_search_psot_details_before_added_to_results_array', 'add_first_cat_name' );
function add_first_cat_name($post_details){
    $post_details['cat_name'] = get_the_category( $post_details['id'] )[0]->name
    return $post_details;
}
`

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `thetwo-ajax-search.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `<?php do_shortcode('[thetwo-ajax-search]'); ?>` in your templates

== Screenshots ==

1. ![Open popup with no results example](/assets/screenshot.png)

== Changelog ==

= 1.0 =
* Initialize plugin

== Upgrade Notice == 
No Upgrade Yet

== Frequently Asked Questions == 
No Questions has been asked
