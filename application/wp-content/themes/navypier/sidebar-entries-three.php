<?php 
/**
 * Landing Page Entries - One
 */
?>

<div id="lp-main-3" class="section-title">
	<h2><?php echo $_entries_title_three;?></h2>
</div>

<div id="lp-wrap-3" class="section-content no-bg clearfix">

	<?php foreach($all_entries as $post) {			
		setup_postdata($post); 
		$_alt_title = get_post_meta($post->ID, '_alt_title', true);
		$_sub_title = get_post_meta($post->ID, '_sub_title', true);
		$_deal_title = get_post_meta($post->ID, '_deal_title', true);
		$_deal_url = get_post_meta($post->ID, '_deal_url', true);
		$_tix_title = get_post_meta($post->ID, '_tix_title', true);
		$_tix_url = get_post_meta($post->ID, '_tix_url', true);	
		$_website_title = get_post_meta($post->ID, '_website_title', true);					
		$_website_url = get_post_meta($post->ID, '_website_url', true);
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
			$img_width = $image_obj[1];
			$img_height = $image_obj[2];
			
		} else {
			$img_src = get_stylesheet_directory_uri() . '/images/promo_placeholder.jpg';
			$img_width = '463';
			$img_height = '275';
		}			
		?>		
		<div id="entry-<?php echo get_the_ID();?>" class="<?php echo get_post_type();?>-entry entry">
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
	
	<?php }; ?>

</div><!-- /.section-content -->