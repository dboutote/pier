<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Navy_Pier
 * @since Navy Pier 1.0
 */

get_header(); ?>

<div id="inside-hero-region">
<?php
if( has_post_thumbnail() ){
	$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
	$img_src = $image_url[0];
	?>
	<img src="<?php echo $img_src; ?>" width="1198" height="720" class="background-cover" /><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/inside-hero-shadow.png" class="hero-shadow"> 
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


<!-- show Featured Events if they've selected it -->

<!-- show upcoming events if they've selected it -->


</div> <!-- /.container -->

<?php get_sidebar('ads');?>



<?php
get_footer();