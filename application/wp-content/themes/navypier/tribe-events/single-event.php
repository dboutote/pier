<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 * 
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); }

$event_id = get_the_ID();
?>
<div id="inside-hero-region">
<?php
if( has_post_thumbnail() ){
	$image_obj = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
	$img_src = $image_obj[0];
	$img_width = $image_obj[1];
	$img_height = $image_obj[2];
	?>
	<img src="<?php echo $img_src; ?>" width="<?php echo $img_width;?>" height="<?php echo $img_height;?>" class="background-cover" /><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/inside-hero-shadow.png" class="hero-shadow"> 
<?php }; ?>
</div>  <!-- /#inside-hero-region -->

<div class="container">  <!-- <?php echo basename(__FILE__); ?> -->

	<div class="intro clearfix">
		
		<div class="col span-2 padded">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();
					the_title( '<h1 class="entry-title">', '</h1>' );
					the_content();
				endwhile;
			?>
		</div>
		
		<div class="col padded">
			<div class="page-actions align-right">
				<a href="#" class="icon share">share page</a><a href="#" class="icon print">print page</a>
			</div>
		
			<?php  if( mbp_has_promotion() ){ ?>
				<?php mbp_display_promotion_box(); ?>
			<?php }?>
		</div>
		
	</div> <!-- /.intro -->


</div> <!-- /.container -->

<?php get_sidebar('ads');?>