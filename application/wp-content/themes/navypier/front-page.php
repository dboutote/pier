<?php
/**
 * The template for displaying the Front Page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Navy_Pier
 * @since Navy Pier 1.0
 */

get_header();
?>

<div id="hero-region">

	<?php
	$r = Homepage_Featured::get_rotator_content();

	if( $r->have_posts() ) : ?>
		<ul id="slider">
			<?php
			while ( $r->have_posts() ) : $r->the_post();
				$btn_url = $alt_title = $post_title = $sub_title = $img_src = $image_obj =  $img_width = $img_height = '';

				$btn_url = get_post_meta(get_the_ID(), '_rotator_btn_url', true);

				if( '' === $btn_url) {
					$btn_url = get_permalink();
				}
				$alt_title = get_post_meta(get_the_ID(), '_rotator_title', true);
				$post_title = ( '' !== $alt_title ) ? $alt_title : get_the_title() ;
				$sub_title = get_post_meta(get_the_ID(), '_rotator_subtitle', true);
				$img_src = get_post_meta(get_the_ID(), '_rotator_img_url', true);
				if ( '' === $img_src ) {
					$image_obj = wp_get_attachment_image_src( get_post_thumbnail_id(), 'rotator-feat');
					$img_src = $image_obj[0];
					$img_width = $image_obj[1];
					$img_height = $image_obj[2];
				} else {
					list($img_width, $img_height, $type, $attr) = getimagesize($img_src);					
				}
				?>
				<li id="slide-<?php the_ID(); ?>">
					<img src="<?php echo $img_src; ?>" width="<?php echo $img_width;?>" height="<?php echo $img_height;?>" class="background-cover" /><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/hero-shadow.png" class="hero-shadow">
					<div class="container">
						<div class="hero-text">
							<h1><?php echo $post_title;?></h1>
							<?php if('' !== $sub_title) {?><p><?php echo $sub_title; ?></p> <?php } ?>
							<a href="<?php echo $btn_url; ?>" class="btn">Find Out More</a>
						</div>
					</div>
				</li>
			<?php endwhile; // end of the loop. ?>
		</ul>
		<a href="#" id="prev"><i class="fa fa-angle-left"></i></a>
		<a href="#" id="next"><i class="fa fa-angle-right"></i></a>
	<?php else: ?>
		<p>Nothing to display.</p>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>


	<div class="container">
		<div class="callouts clearfix">
			<a href="/events/today/">
				<h3>What's Happening</h3>
				<i class="fa fa-clock-o"></i>
				<p>Today at the Pier</p>
			</a>
			<a href="/events/upcoming/">
				<h3>What's Coming Up</h3>
				<i class="fa fa-calendar"></i>
				<p>View all Events</p>
			</a>
			<a href="/buy-tickets/">
				<h3>Buy Tickets</h3>
				<i class="fa fa-ticket"></i>
				<p>For Popular Attractions</p>
			</a>
		</div>
	</div>

</div> <!-- /.hero-region -->

<div class="container">

	<?php
	$all_events = np_get_events(12);

	if( !empty($all_events) ) : ?>
		<?php global $post;?>

		<div id="events" class="section-title">
			<h2>Events</h2>
			<?php if( count($all_events) > 6 ) { ?>
				<div class="events-nav"><a id="events-prev" href="#"><i class="fa fa-chevron-circle-left"></i></a><a id="events-next" href="#"><i class="fa fa-chevron-circle-right"></i></a></div>
			<?php } ?>
		</div>

		<div id="events-wrap" class="section-content no-bg clearfix">

			<?php $count = 0; ?>

			<?php if( count($all_events) > 6 ) { ?> <div class="slide"> <?php } ?>

				<?php foreach($all_events as $post) { ?>
					<?php ++$count; ?>
					<?php setup_postdata($post); ?>
					<div class="col">
						<div class="event-container">
							<?php
							if( has_post_thumbnail() ){
								$image_obj = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
								$img_src = $image_obj[0];
								$img_width = $image_obj[1];
								$img_height = $image_obj[2];
								?>
								<a href="<?php the_permalink();?>" class="image"><img src="<?php echo $img_src; ?>" width="<?php echo $img_width; ?>" height="<?php echo $img_height; ?>" class="background-cover" /></a>
							<?php }; ?>
							<a href="<?php the_permalink(); ?>" class="text">
								<h3><?php the_title(); ?></h3>
								<?php echo tribe_events_event_schedule_details(); ?>
							</a>
						</div>
					</div>

					<?php if( count($all_events) > 6 && ($count % 6 == 0) ) { ?>
						</div> <!-- /.slide --> <div class="slide">
					<?php }; ?>

				<?php }; ?>

			<?php if( count($all_events) > 6 ) { ?> </div> <!-- /.slide --> <?php } ?>

		</div><!-- /.section-content -->

	<?php else : ?>

		<p>No events found.</p>

	<?php endif; ?>
	<?php wp_reset_query(); ?>



	<div id="about" class="section-title">
	<h2>About the Pier</h2>
	</div>
	<div class="section-content clearfix">
		<?php
		$page = get_page_by_title( 'About Us' );
		$excerpt = ( '' !== $page->post_excerpt ) ? abbreviate($page->post_excerpt, $max = '500') : abbreviate($page->post_content, $max = '500') ;
		?>
		<div class="col span-2 home-about">
			<?php
				$image_obj = wp_get_attachment_image_src( get_post_thumbnail_id( $page->ID ), 'large');
				if($image_obj){
					$img_src = $image_obj[0];
					$img_width = $image_obj[1];
					$img_height = $image_obj[2];
					echo '<img src="'.$img_src.'" width="'.$img_width.'" height="'.$img_height.'" class="background-cover" />';
				}
			?>
		</div>
		<div class="col home-about padded">
			<?php echo wpautop($excerpt);?>
			<a href="<?php echo get_permalink($page->ID);?>" class="btn">Read More</a>
		</div>
	</div>

	<div id="social" class="section-title">
		<h2>Get Social</h2>
	</div>
	<div class="section-content clearfix">
		<div class="col padded">
			<h3 class="category"><a href="http://instagram.com/navypierchicago" target="_blank">Instagram&nbsp;&nbsp;&nbsp;<i class="fa fa-instagram"></i></a></h3>
			<div id="instagram-feed" class="clearfix">
				<?php echo np_get_instagram_feed('navypierchicago', 6); ?>
			</div>
		</div>

		<div class="col padded">
			<h3 class="category"><a href="https://twitter.com/navypier" target="_blank">Twitter&nbsp;&nbsp;&nbsp;<i class="fa fa-twitter"></i></a></h3>
			<div id="twitter-feed">
				<?php echo get_simple_tweets(); ?>
			</div> <!-- /#twitter-feed -->
		</div>

		<div class="col">
			<div class="social-small padded">
				<h3 class="category"><a href="http://blog.navypier.com/" target="_blank">Blog&nbsp;&nbsp;&nbsp;<i class="fa fa-comments"></i></a></h3>
				<div id="blog-feed">
					<a href="http://blog.navypier.com/" target="_blank" class="feed-link"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/blog-thumbnail.jpg"><br />
					View Blog</a> </div>
			</div>
			<div class="social-small padded">
				<h3 class="category"><a href="https://www.facebook.com/navypier" target="_blank">Facebook&nbsp;&nbsp;&nbsp;<i class="fa fa-facebook"></i></a></h3>
				<div id="facebook-feed">
					<a href="https://www.facebook.com/navypier" target="_blank" class="feed-link"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/facebook-thumbnail.jpg"><br />
					Visit Facebook</a>
				</div>
			</div>
		</div>
	</div>

	<?php
		$promos = get_posts(
			array(
			'posts_per_page' => 3,
			'post_type' => 'cpt_promotion',
			'orderby' => 'menu_order',
			'order' => 'ASC'
			)
		);


		if( !empty($promos) ) : ?>

			<?php global $post;?>

			<div id="deals" class="section-title">
				<h2>Deals and Promotions</h2>
			</div>

			<div class="section-content no-bg clearfix no-bg">

				<?php foreach($promos as $post) {
					setup_postdata($post);
					$_alt_title = get_post_meta($post->ID, '_alt_title', true);
					$_sub_title = get_post_meta($post->ID, '_sub_title', true);
					$_deal_title = get_post_meta($post->ID, '_deal_title', true);
					$_deal_url = get_post_meta($post->ID, '_deal_url', true);
					$_tix_title = get_post_meta($post->ID, '_tix_title', true);
					$_tix_url = get_post_meta($post->ID, '_tix_url', true);
					$_latitude = get_post_meta($post->ID, '_latitude', true);
					$_longitude = get_post_meta($post->ID, '_longitude', true);
					$_location_title = get_post_meta($post->ID, '_location_title', true);
					$lat_long_href = ( $_latitude && $_longitude ) ? $_latitude.','.$_longitude : '';
					$image_obj = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
					if($image_obj){
						$img_src = $image_obj[0];
						$img_width = $image_obj[1];
						$img_height = $image_obj[2];
					} else {
						$img_src = get_stylesheet_directory_uri() . '/images/promo_placeholder.jpg';
						$img_width = '318';
						$img_height = '238';
					}
					?>
					<div class="col">
					  <div class="promotion-container"><a href="<?php the_permalink(); ?>" class="image"><img src="<?php echo $img_src; ?>" width="<?php echo $img_width; ?>" height="<?php echo $img_height; ?>" class="background-cover" /></a> <a href="<?php the_permalink(); ?>" class="promotion-text"><?php echo ( $_alt_title ) ? $_alt_title : get_the_title(); ?><br />
						<?php if($_sub_title) { ?><span class="promotion-date"><?php echo $_sub_title;?></span><?php } ?></a>
						<div class="promotion-links"><a href="<?php the_permalink(); ?>" class="icon read-more">Read More</a><a href="#" data-shareid="<?php echo $post->ID;?>" class="icon share">share</a><?php if($_deal_url) {?><a href="<?php echo $_deal_url;?>" class="icon get-deal"><?php echo $_deal_title;?></a><?php }; ?></div>
					  </div>
					</div>
				<?php }; ?>
			</div>

		<?php else : ?>

			<p>No entries found.</p>

		<?php endif; ?>

		<?php wp_reset_query(); ?>

</div> <!-- /.container -->
<?php
get_footer();
