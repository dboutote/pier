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

get_header(); ?>

<div id="hero-region">

<?php
$r = Homepage_Featured::get_rotator_content();

if( $r->have_posts() ) : ?>
	<ul id="slider">
		<?php 
		while ( $r->have_posts() ) : $r->the_post(); 
		$btn_url = get_post_meta(get_the_ID(), '_rotator_btn_url', true);
		$btn_url = $alt_title = $post_title = $sub_title = $img_src = $image_url = '';
		if( '' === $btn_url) {
			$btn_url = get_permalink();
		}
		$alt_title = get_post_meta(get_the_ID(), '_rotator_title', true);
		$post_title = ( '' !== $alt_title ) ? $alt_title : get_the_title() ;
		$sub_title = get_post_meta(get_the_ID(), '_rotator_subtitle', true);
		$img_src = get_post_meta(get_the_ID(), '_rotator_img_url', true);
		if ( '' === $img_src ) {
			$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'rotator-feat');
			$img_src = $image_url[0];
		} 
		?>
		<li id="slide-<?php the_ID(); ?>">
			<img src="<?php echo $img_src; ?>" width="1200" height="800" class="background-cover" /><img src="images/hero-shadow.png" class="hero-shadow">
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

	<div class="container">
		<div class="callouts clearfix">
			<a href="/todays-events/">
				<h3>What's Happening</h3>
				<i class="fa fa-clock-o"></i>
				<p>Today at the Pier</p>
			</a> 
			<a href="/all-events/">
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
<div id="events" class="section-title">
<h2>Events</h2>
<div class="events-nav"><a href="#"><i class="fa fa-chevron-circle-left"></i></a><a href="#"><i class="fa fa-chevron-circle-right"></i></a></div>
</div>
<div class="section-content no-bg clearfix">
<div class="col">
<div class="event-container"><a href="#" class="image"><img src="images/event-image.jpg" width="463" height="275" class="background-cover"></a><a href="#" class="text">
<h3>This is an Event Header</h3>
07/24/14 | 4:30pm&ndash;6:00pm</a></div>
</div>
<div class="col">
<div class="event-container"><a href="#" class="image"><img src="images/event-image.jpg" width="463" height="275" class="background-cover"></a><a href="#" class="text">
<h3>This is an Event Header</h3>
07/24/14 | 4:30pm&ndash;6:00pm</a></div>
</div>
<div class="col">
<div class="event-container"><a href="#" class="image"><img src="images/event-image.jpg" width="463" height="275" class="background-cover"></a><a href="#" class="text">
<h3>This is an Event Header</h3>
07/24/14 | 4:30pm&ndash;6:00pm</a></div>
</div>
<div class="col">
<div class="event-container"><a href="#" class="image"><img src="images/event-image.jpg" width="463" height="275" class="background-cover"></a><a href="#" class="text">
<h3>This is an Event Header</h3>
07/24/14 | 4:30pm&ndash;6:00pm</a></div>
</div>
<div class="col">
<div class="event-container"><a href="#" class="image"><img src="images/event-image.jpg" width="463" height="275" class="background-cover"></a><a href="#" class="text">
<h3>This is an Event Header</h3>
07/24/14 | 4:30pm&ndash;6:00pm</a></div>
</div>
<div class="col">
<div class="event-container"><a href="#" class="image"><img src="images/event-image.jpg" width="463" height="275" class="background-cover"></a><a href="#" class="text">
<h3>This is an Event Header</h3>
07/24/14 | 4:30pm&ndash;6:00pm</a></div>
</div>
</div>
<div id="about" class="section-title">
<h2>About the Pier</h2>
</div>
<div class="section-content clearfix">
<div class="col span-2 home-about"> <img src="images/about-image.jpg" width="599" height="360" class="background-cover"> </div>
<div class="col home-about padded">
<h3>Navy Pier, a landmark not-for-profit</h3>
<p>Navy Pier rests at the core of many Chicagoans hearts. Since 1995, millions of visitors have passed through our gates to enjoy a day (or two) of beauty and excitement along the shore of Lake Michigan. The Pier is one of Chicago’s most treasured landmarks and we are both proud and honored to represent a piece of this city’s rich history.</p>
<a href="#" class="btn">Read More</a> </div>
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
<div class="tweet">
<p>Heading to <a href="#">#WinterWonderFest?</a> Hop on our free trolley for a ride right to the Pier! Hours and dates available here: <a href="#">http://bit.ly/1dywtaa</a></p>
<a href="#" target="_blank" class="feed-link">Today</a> </div>
<div class="tweet">
<p>The <a href="#">@ChicagoBears</a> are wrangling the <a href="#">@DallasCowboys</a> tomorrow night! Grab dinner at <a href="#">@HarrysNavyPier</a> and cheer them on!</p>
<a href="#" target="_blank" class="feed-link">Yesterday</a> </div>
<div class="tweet">
<p>Come downtown and park at the Pier for just $19 today and $10 after 5 p.m.! Perfect for holiday shopping!<a href="#"></a></p>
<a href="#" target="_blank" class="feed-link">12/16/14</a> </div>
</div>
</div>
<div class="col">
<div class="social-small padded">
<h3 class="category"><a href="http://blog.navypier.com/" target="_blank">Blog&nbsp;&nbsp;&nbsp;<i class="fa fa-comments"></i></a></h3>
<div id="blog-feed"> <a href="http://blog.navypier.com/" target="_blank" class="feed-link"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/blog-thumbnail.jpg"><br>
View Blog</a> </div>
</div>
<div class="social-small padded">
<h3 class="category"><a href="https://www.facebook.com/navypier" target="_blank">Facebook&nbsp;&nbsp;&nbsp;<i class="fa fa-facebook"></i></a></h3>
<div id="facebook-feed"> <a href="https://www.facebook.com/navypier" target="_blank" class="feed-link"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/facebook-thumbnail.jpg"><br>
Visit Facebook</a> </div>
</div>
</div>
</div>


<div id="deals" class="section-title">
<h2>Deals and Promotions</h2>
</div>
<div class="section-content no-bg clearfix no-bg">
<div class="col">
<div class="promotion-container"><a href="#" class="image"><img src="images/promotion-image.jpg" width="318" height="238" class="background-cover"></a> <a href="#" class="promotion-text">This is a Promotion or Deal Header<br>
<span class="promotion-date">July 22nd</span></a>
<div class="promotion-links"><a href="#" class="icon read-more">read more</a><a href="#" class="icon share">share</a><a href="#" class="icon get-deal">get deal</a></div>
</div>
</div>
<div class="col">
<div class="promotion-container"><a href="#" class="image"><img src="images/promotion-image.jpg" width="318" height="238" class="background-cover"></a> <a href="#" class="promotion-text">This is a Promotion or Deal Header<br>
<span class="promotion-date">July 22nd</span></a>
<div class="promotion-links"><a href="#" class="icon read-more">read more</a><a href="#" class="icon share">share</a><a href="#" class="icon get-deal">get deal</a></div>
</div>
</div>
<div class="col">
<div class="promotion-container"><a href="#" class="image"><img src="images/promotion-image.jpg" width="318" height="238" class="background-cover"></a> <a href="#" class="promotion-text">This is a Promotion or Deal Header<br>
<span class="promotion-date">July 22nd</span></a>
<div class="promotion-links"><a href="#" class="icon read-more">read more</a><a href="#" class="icon share">share</a><a href="#" class="icon get-deal">get deal</a></div>
</div>
</div>
</div>
</div>
<?php
get_footer();