<?php 
/**
 * List View Single Event
 * This file contains one event in the list view
 *
 * Original file: [plugins]/the-events-calendar/views/list/single-event.php
 *
 * @package TribeEventsCalendar
 * @subpackage Navy_Pier
 * @since Navy Pier 1.0
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); } ?>

<?php 
$_latitude = ( $_latitude = np_tribe_get_lat()  ) ? $_latitude : np_tribe_get_default_lat() ; 
$_longitude = ( $_longitude = np_tribe_get_long()  ) ? $_longitude : np_tribe_get_default_long(); 
$lat_long_href = ( $_latitude && $_longitude ) ? $_latitude.','.$_longitude : false;
$_location_title = ( $_location_title = tribe_get_meta( 'tribe_event_venue_name' )  ) ? $_location_title : 'Navy Pier';					

$_tix_title = get_post_meta(get_the_ID(), '_tix_title', true);
$_tix_url = get_post_meta(get_the_ID(), '_tix_url', true);	
					
?>

<div id="entry-<?php echo get_the_ID();?>" class="<?php echo get_post_type();?>-entry entry">
	<div class="title clearfix">
		<div class="col entry-image"> 
			<?php echo tribe_event_featured_image($post_id = null, $size = 'full', $link = false ) ?>			
		</div>
		<div class="col span-2">
			<div class="info padded">
				<h3><?php the_title() ?></h3>
				<p><?php the_excerpt() ?></p>
				<?php if( '' !== $post->post_content ) {?> <a href="#" class="icon read-details">Read More</a> <?php } ?>
			</div>
			<div class="options">
				<a href="#" class="icon calendar"><?php echo tribe_events_event_schedule_details(); ?></a>
				<?php if( $_tix_url ) {?> <a href="<?php echo $_tix_url;?>" class="icon buy-tickets"  target="_blank"><?php echo $_tix_title;?></a><?php ;} ?>
				<?php if( $lat_long_href ) {?> <a href="<?php echo $lat_long_href;?>" class="icon location map-link"><?php echo $_location_title;?></a><?php ;} ?>							
			</div>
		</div>
	</div>
	<div class="details padded">
		<?php the_content(); ?>
	</div>
</div>
