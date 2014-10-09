<?php
/**
 * Day View Content
 * The content template for the day view. This template is also used for
 * the response that is returned on day view ajax requests.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/day/content.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); } ?>

<!--<div class="container">-->
		
	<!-- FEATURED EVENTS HERE -->


	<div id="tribe-events-content" class="tribe-events-list tribe-events-day">
	
		<div id="entries" class="section-title">
			<!-- List Title -->
			<?php do_action( 'tribe_events_before_the_title' ); ?>
			<h2><?php echo tribe_get_events_title() ?></h2>
			<?php do_action( 'tribe_events_after_the_title' ); ?>
		</div>
				
		<div class="section-content no-bg">
		
			<!-- Events Loop -->
			<?php if ( have_posts() ) : ?>
				<?php do_action( 'tribe_events_before_loop' ); ?>
				<?php tribe_get_template_part( 'day/loop' ) ?>
				<?php do_action( 'tribe_events_after_loop' ); ?>
			<?php else : ?>
				<?php 
				$msg = sprintf(
					__( 'No events scheduled for <strong>%s</strong>. Please try another day.', 'tribe-events-calendar-pro' ),
					date_i18n( 
						tribe_get_date_format( true ), 
						strtotime(
							get_query_var( 'eventDate' ) 
						) 
					) 
				);
				?>
			<div class="tribe-events-notices"><?php echo $msg;?> <a class="btn" href="<?php echo home_url('/events/upcoming/');?>">View all upcoming events.</a></div>
			<?php endif; ?>		
		
		</div><!-- /.section-content -->

	</div><!-- #tribe-events-content -->

<!--</div> /.container -->

