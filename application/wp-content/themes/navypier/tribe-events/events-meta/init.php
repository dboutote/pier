<?php 
/*
Plugin Name: Various Meta Boxes for Events, Venues, and Event-relates Info
Version: 1.0
Plugin URI:
Description: A tie-in for Events Calendar
Author: Darrin Boutote
Author URI: http://darrinb.com
*/

/**
 * No direct access
 */
defined( 'ABSPATH' ) or die( 'Nothing here!' );

/**
 * Define some constants
 */
define('NPEM_URL', get_stylesheet_directory_uri() . '/tribe-events/' . basename(dirname(__FILE__)) . '/');
define('NPEM_JS_URL', NPEM_URL . 'js');


# Setup files
if( ! class_exists( 'MetaBox_FeaturedEvents' ) ) {
	require(dirname(__FILE__) . '/class/class.mb_events_featured.php');
	$MetaBox_FeaturedEvents = new MetaBox_FeaturedEvents();
}

if( ! class_exists( 'MetaBox_Events' ) ) {
	require(dirname(__FILE__) . '/class/class.mb_events.php');
	$MetaBox_Events = new MetaBox_Events();
}

if( ! class_exists( 'MetaBox_VenueInfo' ) ) {
	require(dirname(__FILE__) . '/class/class.mb_addlinfo-venue.php');
	$MetaBox_VenueInfo = new MetaBox_VenueInfo();
}

if( ! class_exists( 'MetaBox_EventInfo' ) ) {
	require(dirname(__FILE__) . '/class/class.mb_addlinfo-event.php');
	$MetaBox_EventInfo = new MetaBox_EventInfo();
}