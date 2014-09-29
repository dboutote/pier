<?php
/**
 * List View Template
 * The wrapper template for a list of events. This includes the Past Events and Upcoming Events views 
 * as well as those same views filtered to a specific category.
 *
 * Original file: [plugins]/the-events-calendar/views/list.php
 *
 * @package TribeEventsCalendar
 * @subpackage Navy_Pier
 * @since Navy Pier 1.0
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); } ?>

<?php do_action( 'tribe_events_before_template' ); ?>

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
			
			<div class="col span-2 padded">
				<h1 class="page-title"><?php echo tribe_get_events_title() ?></h1>	
				<?php echo apply_filters('the_content', $ep->post_content ); ?>
			</div>
			
			<div class="col padded">
				<div class="page-actions align-right">
					<a href="#" data-shareid="<?php echo $ep->ID;?>" class="icon share">share page</a><a href="#" class="icon print">print page</a>
				</div>
			
				<?php  if( mbp_has_promotion($ep->ID) ){ ?>
					<?php mbp_display_promotion_box($ep->ID); ?>
				<?php }?>
			</div>
			
		</div> <!-- /.intro -->	
		
	</div><!-- /.container -->
	
<?php endif; ?>

<!-- Tribe Bar -->
<?php #3tribe_get_template_part( 'modules/bar' ); ?>

<!-- Main Events Content -->
<?php tribe_get_template_part( 'list/content' ); ?>

<div class="tribe-clear"></div>

<?php do_action( 'tribe_events_after_template' ) ?>