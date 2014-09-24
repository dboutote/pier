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
				<a href="#" data-shareid="<?php echo $post->ID;?>" class="icon share">share page</a><a href="#" class="icon print">print page</a>
			</div>
		
			<?php  if( mbp_has_promotion() ){ ?>
				<?php mbp_display_promotion_box(); ?>
			<?php }?>
		</div>
		
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
		
			<div id="lp-main" class="section-title">
				<h2><?php echo $_entries_title;?></h2>
			</div>

			<div id="lp-wrap" class="section-content no-bg clearfix">

				<?php foreach($all_entries as $post) {			
					setup_postdata($post); 
					$_alt_title = get_post_meta($post->ID, '_alt_title', true);
					$_sub_title = get_post_meta($post->ID, '_sub_title', true);
					$_deal_title = get_post_meta($post->ID, '_deal_title', true);
					$_deal_url = get_post_meta($post->ID, '_deal_url', true);
					$_tix_title = get_post_meta($post->ID, '_tix_title', true);
					$_tix_url = get_post_meta($post->ID, '_tix_url', true);	
					$_website_title = get_post_meta($post->ID, 'website_title', true);					
					$_website_url = get_post_meta($post->ID, 'website_url', true);
					$_phone_title = get_post_meta($post->ID, '_phone_title', true);
					$_phone_url = get_post_meta($post->ID, '_phone_url', true);
					$_document_title = get_post_meta($post->ID, '_document_title', true);
					$_document_url = get_post_meta($post->ID, '_document_url', true);
					if( 'tribe_events' === $post->post_type  ){
						$venue_id = tribe_get_venue_id( $post->ID );
						$_latitude = get_post_meta($venue_id, '_VenueLat', true);
						$_longitude = get_post_meta($venue_id, '_VenueLong', true);
						$_location_title = tribe_get_venue( $post->ID );
					} else {
						$_latitude = get_post_meta($post->ID, '_latitude', true);
						$_longitude = get_post_meta($post->ID, '_longitude', true);										
						$_location_title = get_post_meta($post->ID, '_location_title', true);
					}
					
					$lat_long_href = ( $_latitude && $_longitude ) ? $_latitude.','.$_longitude : false;
					$image_obj = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');				
					if($image_obj){
						$img_src = $image_obj[0];
					} else {
						$img_src = get_stylesheet_directory_uri() . '/images/promo_placeholder.jpg';
					}			
					?>		
					<div id="entry-<?php echo get_the_ID();?>" class="<?php echo get_post_type();?>-entry entry">
						<div class="title clearfix">
							<div class="col entry-image"> 
								<img src="<?php echo $img_src; ?>" width="463" height="275" class="background-cover">
							</div>
							<div class="col span-2">
								<div class="info padded">
									<h3><?php the_title() ?></h3>
									<p><?php the_excerpt() ?></p>
									<a href="#" class="icon read-details">Read More</a> 
								</div>
								<div class="options">
									<a href="#" data-shareid="<?php echo $post->ID;?>" class="icon share">share</a>
									<?php if( $_deal_url ) {?> <a href="<?php echo $_deal_url;?>" class="icon get-deal" target="_blank"><?php echo ( '' != $_deal_title ) ? $_deal_title : $_deal_url;?></a><?php ;} ?>
									<?php if( $_tix_url ) {?> <a href="<?php echo $_tix_url;?>" class="icon buy-tickets"  target="_blank"><?php echo ( '' != $_tix_title ) ? $_tix_title : $_tix_url;?></a><?php ;} ?>							
									<?php if( $_website_url ) {?> <a href="<?php echo $_website_url;?>" class="icon website" target="_blank"><?php echo ( '' != $_website_title ) ? $_website_title : $_website_url;?></a><?php ;} ?>
									<?php if( $_phone_url ) {?> <a href="<?php echo $_phone_url;?>" class="icon phone-number"><?php echo ( '' != $_phone_title ) ? $_phone_title : $_phone_url;?></a><?php ;} ?>
									<?php if( $_document_url ) {?> <a href="<?php echo $_document_url;?>" class="icon document" target="_blank"><?php echo ( '' != $_document_title ) ? $_document_title : $_document_url;?></a><?php ;} ?>
									<?php if( $lat_long_href ) {?> <a href="<?php echo $lat_long_href;?>" class="icon location map-link"><?php echo $_location_title;?></a><?php ;} ?>							
								</div>
							</div>
						</div>
						<div class="details padded">
							<?php the_content(); ?>
						</div>
					</div>
				
				<?php }; ?>

			</div><!-- /.section-content -->

		<?php else : ?>

			<p>No entries found.</p>

		<?php endif; ?>	

		<?php wp_reset_query(); ?>
		
	<?php endif;?>

</div> <!-- /.container -->

<?php get_sidebar('ads'); 

get_footer();