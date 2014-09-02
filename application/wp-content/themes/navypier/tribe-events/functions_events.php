<?php
/**
 * A Library of functions to modify the default behavior of the Events Calendar Plugin
 *
 * @package TribeEventsCalendar
 * @subpackage Navy_Pier
 * @since Navy Pier 1.0
 *
 */


/**
 * Get the post object for the page designated as the Events Landing Page
 */
function np_get_events_landing_page(){
	$ep = get_page_by_title( 'Events'); 
	return $ep;
}

/**
 * Override the Events Calendar Featured image
 */
function np_event_featured_image( $featured_image, $post_id, $size, $image_src ){
	$featured_image = '';
	if( !empty( $image_src ) ){
		$featured_image .= '<img src="'.  $image_src[0] .'" title="'. get_the_title( $post_id ) .'" width="400" height="569" class="background-cover"/>';
	}
	return $featured_image;
}
add_filter('tribe_event_featured_image', 'np_event_featured_image', 0, 4);


/**
 * Generate the url for a single Event
 */
function np_get_event_url($post_id = null)
{
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	$url =  home_url('/events/upcoming/') . '#event-' . $post_id;
	
	return apply_filters('np_event_url', $url, $post_id);
}


/**
 * Load the Meta Box for Venue Lat/Long
 */
require('metabox_venue_info.php');




/**
 * Function to return Venue Latitude
 */
function np_tribe_get_lat($postId = null){
	$postId = tribe_get_venue_id( $postId );
	$output = esc_html( tribe_get_event_meta( $postId, '_VenueLat', true ) );
	return apply_filters('tribe_get_lat', $output);
}

/**
 * Function to return Venue Longitude
 */
function np_tribe_get_long($postId = null){
	$postId = tribe_get_venue_id( $postId );
	$output = esc_html( tribe_get_event_meta( $postId, '_VenueLong', true ) );
	return apply_filters('tribe_get_long', $output);
}

/**
 * Function to return default venue latitude
 */
function np_tribe_get_default_lat(){
	// this really should be an option
	$output = '41.8917374';
	return apply_filters('tribe_get_default_lat', $output);
}

/**
 * Function to return default venue latitude
 */
function np_tribe_get_default_long(){
	// this really should be an option
	$output = '-87.5998759';
	return apply_filters('tribe_get_default_long', $output);
}