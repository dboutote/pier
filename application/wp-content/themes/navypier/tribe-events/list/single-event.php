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

<?php $venue_name = ( $venue_name = tribe_get_meta( 'tribe_event_venue_name' )  ) ? $venue_name : 'Navy Pier'; ?>

<div id="event-<?php echo get_the_ID();?>" class="entry">
	<div class="title clearfix">
		<div class="col entry-image"> 
			<?php echo tribe_event_featured_image($post_id = null, $size = 'full', $link = false ) ?>			
		</div>
		<div class="col span-2">
			<div class="info padded">
				<h3><?php the_title() ?></h3>
				<p><?php the_excerpt() ?></p>
				<a href="#" class="icon read-details">Read More</a> </div>
			<div class="options">
				<a href="#" class="icon calendar"><?php echo tribe_events_event_schedule_details(); ?></a><a href="#" class="icon buy-tickets">buy tickets</a><a href="41.891769,-87.606681" class="icon location map-link"><?php echo $venue_name;?></a>
			</div>
		</div>
	</div>
	<div class="details padded">
		<?php the_content(); ?>
	</div>
</div>


<!-- Event Cost -->
<?php if ( tribe_get_cost() ) : ?> 
	<div class="tribe-events-event-cost">
		<span><?php echo tribe_get_cost( null, true ); ?></span>
	</div>
<?php endif; ?>