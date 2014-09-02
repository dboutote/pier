<?php 
/**
 * List View Loop
 * This file sets up the structure for the list loop
 *
 * Original file: [plugins]/the-events-calendar/views/list/loop.php
 *
 * @package TribeEventsCalendar
 * @subpackage Navy_Pier
 * @since Navy Pier 1.0
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); } ?>

<?php 
global $more;
$more = false;
?>
<div class="tribe-events-loop vcalendar">

	<?php while ( have_posts() ) : the_post(); ?>
		<?php do_action( 'tribe_events_inside_before_loop' ); ?>

		<!-- Month / Year Headers -->
		<?php #tribe_events_list_the_date_headers(); ?>

		<!-- Event  -->
		<?php tribe_get_template_part( 'list/single', 'event' ) ?>
		
		<?php do_action( 'tribe_events_inside_after_loop' ); ?>
	<?php endwhile; ?>

</div><!-- .tribe-events-loop -->
