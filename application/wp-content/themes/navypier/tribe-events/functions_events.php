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