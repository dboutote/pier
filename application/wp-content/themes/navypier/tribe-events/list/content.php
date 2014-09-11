<?php
/**
 * List View Content Template
 * The content template for the list view. This template is also used for
 * the response that is returned on list view ajax requests.
 *
 * Original file: [plugins]/the-events-calendar/views/list/content.php
 * 
 * @package TribeEventsCalendar
 * @subpackage Navy_Pier
 * @since Navy Pier 1.0
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); } ?>

	
<div class="container">
		
	<!-- FEATURED EVENTS HERE -->


	<div id="tribe-events-content" class="tribe-events-list">
	
		<div id="entries" class="section-title">
			<!-- List Title -->
			<?php do_action( 'tribe_events_before_the_title' ); ?>
			<h2><?php echo tribe_get_events_title() ?></h2>
			<?php do_action( 'tribe_events_after_the_title' ); ?>
		</div>

		<!-- Notices -->
		<?php tribe_events_the_notices() ?>
		<!-- List Header -->
		
		<div class="section-content no-bg">
		
			<!-- Events Loop -->
			<?php if ( have_posts() ) : ?>
				<?php do_action( 'tribe_events_before_loop' ); ?>
				<?php tribe_get_template_part( 'list/loop' ) ?>
				<?php do_action( 'tribe_events_after_loop' ); ?>
			<?php endif; ?>		
		
		</div><!-- /.section-content -->
		
			<!-- List Footer -->
	<?php do_action( 'tribe_events_before_footer' ); ?>
	<div id="tribe-events-footer">

		<!-- Footer Navigation -->
		<?php do_action( 'tribe_events_before_footer_nav' ); ?>
		<?php tribe_get_template_part( 'list/nav', 'footer' ); ?>
		<?php do_action( 'tribe_events_after_footer_nav' ); ?>

	</div><!-- #tribe-events-footer -->
	
		

	</div><!-- #tribe-events-content -->

</div> <!-- /.container -->

