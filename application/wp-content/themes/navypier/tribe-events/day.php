<?php
/**
 * Day View Template
 * The wrapper template for day view.
 *
 * Original file: [plugins]/the-events-calendar/views/day.php
 *
 * @package TribeEventsCalendar
 * @subpackage Navy_Pier
 * @since Navy Pier 1.0
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); } ?>

<?php do_action( 'tribe_events_before_template' ) ?>

<?php  
$ep = np_get_events_landing_page();
if( $ep ) : ?>
	<div id="inside-hero-region">
		<?php
		if( has_post_thumbnail( $ep->ID) ){
			$image_obj = wp_get_attachment_image_src( get_post_thumbnail_id($ep->ID), 'full');
			$img_src = $image_obj[0];
			$img_width = $image_obj[1];
			$img_height = $image_obj[2];
			?>
			<img src="<?php echo $img_src; ?>" width="<?php echo $img_width;?>" height="<?php echo $img_height;?>" class="background-cover" /><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/inside-hero-shadow.png" class="hero-shadow"> 
		<?php } ?>
	</div>  <!-- /#inside-hero-region -->	
	
	<div class="container">
	
		<div class="intro clearfix">
			
			<div class="padded">
				<h1 class="page-title"><?php echo apply_filters('the_title', 'Today&#8217;s Events');?></h1>	
			</div>
			
			<?php /*<div class="col padded">
				<div class="page-actions align-right">
					<a href="#" data-shareid="<?php echo $ep->ID;?>" class="icon share">share page</a><a href="#" class="icon print">print page</a>
				</div>
			</div>*/ ?>
			
		</div> <!-- /.intro -->	
		
	</div><!-- /.container -->
	
<?php endif; ?>


<div class="container">
	<!-- Tribe Bar -->
	<?php #tribe_get_template_part( 'modules/bar' ); ?>

	<!-- Main Events Content -->
	<?php tribe_get_template_part( 'day/content' ) ?>
</div><!-- /.container -->

<?php do_action( 'tribe_events_after_template' ) ?>
