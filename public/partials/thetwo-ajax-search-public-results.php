<?php

$args = array(
	"s" => $term,
	"posts_per_page" => 25,
	"post_type" => $type,
	"order" => "DESC",
	"post_status" => "publish"
);

$args = apply_filters("thetwo_ajax_search_query_vars_before_get_posts", $args);

if (function_exists("relevanssi_do_query")) {
	$query = new WP_Query();
	$query->parse_query($args);
	relevanssi_do_query($query);

	$results = $query->posts;
	wp_reset_postdata();
} else {
	$results = get_posts($args);
}

$return = array();

foreach ($results as $result) {

	$id = $result->ID;
	$post_type = get_post_type($id);
	$date_format = 'j F, Y';

	$date_format = apply_filters("thetwo_ajax_search_date_format", $date_format);

	$post_details = array(
		'id'	=> $id,
		'date'	=> get_the_date($date_format, $id),
		'title' => get_the_title($id),
		'link' => get_post_permalink($id),
		'content'	=> get_the_content($id),
		'thumbnail_url'	=> get_the_post_thumbnail_url($id),
		'thumbnail'	=> get_the_post_thumbnail($id),
		'post_type' => $post_type
	);

	$post_details = apply_filters("thetwo_ajax_search_psot_details_before_added_to_results_array", $post_details);

	$return[] = $post_details;
}

echo json_encode($return);
