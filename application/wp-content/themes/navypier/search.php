<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Navy_Pier
 * @since Navy Pier 1.0
 */

get_header(); ?>

<?php global $post; ?>
<?php $ep = get_page_by_title( 'Search' ); ?>
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

<div class="container">  <!-- <?php echo basename(__FILE__); ?> -->

	<div class="intro clearfix">
		
		<div class="padded">

			<h1 class="page-title"><?php _e('Search Navy Pier'); ?></h1>
		</div>
				
	</div> <!-- /.intro -->
	
	<?php if ( have_posts() ) : ?>

		<div id="search-main" class="section-title">
			<h2><?php printf( __( 'Search Results for: %s', 'navypier' ), get_search_query() ); ?></h2>			
		</div>
			

		<div id="search-wrap" class="section-content no-bg search-results clearfix">

			<?php
			// Start the Loop.
			while ( have_posts() ) : the_post(); ?>
			
				<?php if( '' === trim( get_the_content()) ) {
					continue;
				}; ?>
				
				<?php 
				$post_id = get_the_ID();				
				$post_type = get_post_type();
				$_alt_title = get_post_meta($post_id, '_alt_title', true);
				$_sub_title = get_post_meta($post_id, '_sub_title', true);
				$_deal_title = get_post_meta($post_id, '_deal_title', true);
				$_deal_url = get_post_meta($post_id, '_deal_url', true);
				$_tix_title = get_post_meta($post_id, '_tix_title', true);
				$_tix_url = get_post_meta($post_id, '_tix_url', true);	
				$_website_title = get_post_meta($post_id, '_website_title', true);					
				$_website_url = get_post_meta($post_id, '_website_url', true);
				$_phone_title = get_post_meta($post_id, '_phone_title', true);
				$_phone_url = get_post_meta($post_id, '_phone_url', true);
				$_document_title = get_post_meta($post_id, '_document_title', true);
				$_document_url = get_post_meta($post_id, '_document_url', true);
				if( 'tribe_events' === $post_type  ){
					$venue_id = tribe_get_venue_id( $post_id );
					$_latitude = get_post_meta($venue_id, '_VenueLat', true);
					$_longitude = get_post_meta($venue_id, '_VenueLong', true);
					$_location_title = tribe_get_venue( $post_id );
				} else {
					$_latitude = get_post_meta($post_id, '_latitude', true);
					$_longitude = get_post_meta($post_id, '_longitude', true);										
					$_location_title = get_post_meta($post_id, '_location_title', true);
				}
				$lat_long_href = ( $_latitude && $_longitude ) ? $_latitude.','.$_longitude : false;
				$image_obj = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'large');
					if($image_obj){
						$img_src = $image_obj[0];
						$img_width = $image_obj[1];
						$img_height = $image_obj[2];
						
					} else {
						$img_src = get_stylesheet_directory_uri() . '/images/promo_placeholder.jpg';
						$img_width = '463';
						$img_height = '275';
					}				
				?>
				<div id="entry-<?php echo get_the_ID();?>" <?php post_class('search-result entry');?>>
					<div class="title clearfix">
						<div class="col entry-image"> 
							<img src="<?php echo $img_src; ?>" width="<?php echo $img_width;?>" height="<?php echo $img_height;?>" class="background-cover">
						</div>
						<div class="col span-2">
							<div class="info padded">
								<h3><?php the_title() ?></h3>
								<p><?php the_excerpt() ?></p>
								<?php if( '' !== $post->post_content ) {?> <a href="#" class="icon read-details">Read More</a> <?php } ?>
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
				
			<?php endwhile; ?>	

		</div>

		<?php else : ?>
			
			<div id="search-wrap" class="section-content no-search-results clearfix">			
				<div id="entry-0" <?php post_class('no-result entry');?>>
					<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'navypier' ); ?></p>
				</div>
			</div>

	<?php endif; ?>


</div> <!-- /.container -->

<?php //get_sidebar('search'); ?>

<?php get_sidebar('ads'); 

get_footer();
