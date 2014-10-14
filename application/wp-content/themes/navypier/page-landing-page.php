<?php
/**
 * Template Name: Landing Page
 *
 * @package WordPress
 * @subpackage Navy_Pier
 * @since Navy Pier 1.0
 */

get_header(); ?>

<?php global $post; ?>

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
		
		<div class="padded">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();
					the_title( '<h1 class="entry-title">', '</h1>' );
					the_content();
				endwhile;
			?>
		</div>
		
		
	<?php /*
		<div class="col padded">
			<div class="page-actions align-right">
				<a href="#" data-shareid="<?php echo $post->ID;?>" class="icon share">share page</a><a href="#" class="icon print">print page</a>
			</div>
		
			<?php  if( mbp_has_promotion() ){ ?>
				<?php mbp_display_promotion_box(); ?>
			<?php }?>
		</div>
	*/ ?>
		
	</div> <!-- /.intro -->

	<!-- show Featured Events if they've selected it -->
	<?php if( mbp_has_feat_events() ) { ?>
		<?php get_sidebar('events-feat');?>
	<?php } ?>

	<!-- show upcoming events if they've selected it -->
	<?php if( mbp_has_events() ) { ?>
		<?php get_sidebar('events');?>
	<?php } ?>

	<?php 
	$_entries_type = get_post_meta(get_the_ID(), '_entries_type', true);
	
	if( $_entries_type ) : ?>
		<?php
		$_entries_title = get_post_meta(get_the_ID(), '_entries_title', true);		
		$_entries_tax = get_post_meta(get_the_ID(), '_entries_tax', true);
		$_entries_number = get_post_meta( get_the_ID(), '_entries_number', true ); 
		$posts_per_page = ('all' === $_entries_number) ? '-1' : $_entries_number ;
		$tax_query_args = '';

		if( '' !== $_entries_tax ){
			$meta_tax = explode(':', $_entries_tax);
			$selected_tax = $meta_tax[0];
			$selected_term = $meta_tax[1];
			$tax_query_args = array(
				'taxonomy' => $selected_tax,
				'field' => 'slug',
				'terms' => $selected_term
			);
		};
					
		$all_entries = get_posts(
			array(
				'post_type'			=> $_entries_type,
				'posts_per_page'	=> $posts_per_page,
				'orderby'			=> 'menu_order',
				'order'             => 'ASC',
				'tax_query'			=> array($tax_query_args)		
			)
		);
		
		if( !empty($all_entries) ) : ?>

			<?php 
			ob_start();
			include( get_stylesheet_directory() . '/sidebar-entries-one.php');
			$output = ob_get_contents();
			ob_end_clean();
			echo $output;
			?>
		
		<?php else : ?>
		
			<div class="section-content no-search-results clearfix">			
				<div class="no-results">
					<p><?php _e( 'No entries found', 'navypier' ); ?></p>					
				</div>
			</div>

		<?php endif; ?>	

		<?php wp_reset_query(); ?>
		
	<?php endif;?>
	
	
	<?php 
	$_entries_type_two = get_post_meta(get_the_ID(), '_entries_type_two', true);
	
	if( $_entries_type_two ) : ?>
		<?php
		$_entries_title_two = get_post_meta(get_the_ID(), '_entries_title_two', true);		
		$_entries_tax_two = get_post_meta(get_the_ID(), '_entries_tax_two', true);
		$_entries_number_two = get_post_meta( get_the_ID(), '_entries_number_two', true ); 
		$posts_per_page = ('all' === $_entries_number_two) ? '-1' : $_entries_number_two ;
		$tax_query_args = '';

		if( '' !== $_entries_tax_two ){
			$meta_tax = explode(':', $_entries_tax_two);
			$selected_tax = $meta_tax[0];
			$selected_term = $meta_tax[1];
			$tax_query_args = array(
				'taxonomy' => $selected_tax,
				'field' => 'slug',
				'terms' => $selected_term
			);
		};
					
		$all_entries = get_posts(
			array(
				'post_type'			=> $_entries_type_two,
				'posts_per_page'	=> $posts_per_page,
				'orderby'			=> 'menu_order',
				'order'             => 'ASC',
				'tax_query'			=> array($tax_query_args)		
			)
		);
		
		if( !empty($all_entries) ) : ?>

			<?php 
			ob_start();
			include( get_stylesheet_directory() . '/sidebar-entries-two.php');
			$output = ob_get_contents();
			ob_end_clean();
			echo $output;
			?>
		
		<?php else : ?>

			<div class="section-content no-search-results clearfix">			
				<div class="no-results">
					<p><?php _e( 'No entries found', 'navypier' ); ?></p>
				</div>
			</div>

		<?php endif; ?>	

		<?php wp_reset_query(); ?>
		
	<?php endif;?>
	
	
	<?php 
	$_entries_type_three = get_post_meta(get_the_ID(), '_entries_type_three', true);
	
	if( $_entries_type_three ) : ?>
		<?php
		$_entries_title_three = get_post_meta(get_the_ID(), '_entries_title_three', true);		
		$_entries_tax_three = get_post_meta(get_the_ID(), '_entries_tax_three', true);
		$_entries_number_three = get_post_meta( get_the_ID(), '_entries_number_three', true ); 
		$posts_per_page = ('all' === $_entries_number_three) ? '-1' : $_entries_number_three ;
		$tax_query_args = '';

		if( '' !== $_entries_tax_three ){
			$meta_tax = explode(':', $_entries_tax_three);
			$selected_tax = $meta_tax[0];
			$selected_term = $meta_tax[1];
			$tax_query_args = array(
				'taxonomy' => $selected_tax,
				'field' => 'slug',
				'terms' => $selected_term
			);
		};
					
		$all_entries = get_posts(
			array(
				'post_type'			=> $_entries_type_three,
				'posts_per_page'	=> $posts_per_page,
				'orderby'			=> 'menu_order',
				'order'             => 'ASC',
				'tax_query'			=> array($tax_query_args)		
			)
		);
		
		if( !empty($all_entries) ) : ?>

			<?php 
			ob_start();
			include( get_stylesheet_directory() . '/sidebar-entries-three.php');
			$output = ob_get_contents();
			ob_end_clean();
			echo $output;
			?>
		
		<?php else : ?>

			<div class="section-content no-search-results clearfix">			
				<div class="no-results">
					<p><?php _e( 'No entries found', 'navypier' ); ?></p>
				</div>
			</div>

		<?php endif; ?>	

		<?php wp_reset_query(); ?>
		
	<?php endif;?>	
	

</div> <!-- /.container -->

<?php get_sidebar('ads'); 

get_footer();
