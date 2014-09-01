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
<?php } ?>

</div>  <!-- /#inside-hero-region -->

<div class="container">

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


<div id="featured" class="section-title">
<h2>Featured Events</h2>
<div class="events-nav"><a href="#"><i class="fa fa-chevron-circle-left"></i></a><a href="#"><i class="fa fa-chevron-circle-right"></i></a></div>
</div>
<div class="section-content no-bg clearfix no-bg">
<div class="col">
<div class="promotion-container"><a href="#" class="image"><img src="images/event-image.jpg" width="463" height="275" class="background-cover"></a> <a href="#" class="promotion-text">This is a Featured Event Header<br>
<span class="promotion-date">July 22nd</span></a>
<div class="promotion-links"><a href="#" class="icon read-more">read more</a><a href="#" class="icon share">share</a><a href="#" class="icon get-deal">get deal</a></div>
</div>
</div>
<div class="col">
<div class="promotion-container"><a href="#" class="image"><img src="images/event-image.jpg" width="463" height="275" class="background-cover"></a> <a href="#" class="promotion-text">This is a Featured Event Header<br>
<span class="promotion-date">July 22nd</span></a>
<div class="promotion-links"><a href="#" class="icon read-more">read more</a><a href="#" class="icon share">share</a><a href="#" class="icon get-deal">get deal</a></div>
</div>
</div>
<div class="col">
<div class="promotion-container"><a href="#" class="image"><img src="images/event-image.jpg" width="463" height="275" class="background-cover"></a> <a href="#" class="promotion-text">This is a Featured Event Header<br>
<span class="promotion-date">July 22nd</span></a>
<div class="promotion-links"><a href="#" class="icon read-more">read more</a><a href="#" class="icon share">share</a><a href="#" class="icon get-deal">get deal</a></div>
</div>
</div>
</div>
<div id="entries" class="section-title">
<h2>Upcoming Events</h2>
</div>
<div class="section-content no-bg">
<div class="entry">
<div class="title clearfix">
<div class="col entry-image"> <img src="images/cirque.jpg" width="400" height="569" class="background-cover"> </div>
<div class="col span-2">
<div class="info padded">
<h3>Cirque Shanghai: Warriors</h3>
<p>Cirque Shanghai combines impressive acrobatics with martial prowess. This summer’s production of Cirque Shanghai: Warriors brings an extraordinary line-up of thrilling acts to the stage, including China’s premier daredevil steel globe motorcycle troupe, “Imperial Thunder.”</p>
<a href="#" class="icon read-details">Read More</a> </div>
<div class="options"><a href="#" class="icon calendar">May 24&ndash;Sep 1</a><a href="#" class="icon buy-tickets">buy tickets</a><a href="41.891769,-87.606681" class="icon location map-link">Pepsi&reg; Skyline Stage</a></div>
</div>
</div>
<div class="details padded">
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent eget lacus sit amet mauris interdum fringilla. In mattis nibh dui, in luctus massa tincidunt vel. Mauris vitae nisi mattis, congue nunc in, hendrerit lacus. Suspendisse imperdiet tortor a sapien eleifend lobortis. Aenean egestas fringilla ipsum eu ullamcorper. Proin condimentum interdum eros, quis rhoncus justo tristique dictum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec cursus lacus quis arcu gravida iaculis. In vulputate sollicitudin nunc in congue.</p>
<p>Donec tristique laoreet risus non lacinia. Vivamus quis ipsum a ligula dictum convallis. Suspendisse venenatis eleifend enim non posuere. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque condimentum dictum mi vitae convallis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus sollicitudin viverra fermentum. Donec vitae ligula eu purus blandit mollis. Aliquam eu scelerisque velit. Quisque imperdiet congue lacus, vel commodo urna semper id. Cras dignissim malesuada augue eget lacinia. Donec vitae malesuada lorem, ut consequat tellus. Etiam eleifend iaculis nisi ut cursus. Vestibulum eu libero non tortor dictum suscipit sit amet et leo. Aliquam eu nibh a nisl rutrum pharetra.</p>
</div>
</div>
<div class="entry">
<div class="title clearfix">
<div class="col entry-image"> <img src="images/cirque.jpg" width="400" height="569" class="background-cover"> </div>
<div class="col span-2">
<div class="info padded">
<h3>Cirque Shanghai: Warriors</h3>
<p>Cirque Shanghai combines impressive acrobatics with martial prowess. This summer’s production of Cirque Shanghai: Warriors brings an extraordinary line-up of thrilling acts to the stage, including China’s premier daredevil steel globe motorcycle troupe, “Imperial Thunder.”</p>
<p>Cirque Shanghai combines impressive acrobatics with martial prowess. This summer’s production of Cirque Shanghai: Warriors brings an extraordinary line-up of thrilling acts to the stage, including China’s premier daredevil steel globe motorcycle troupe, “Imperial Thunder.”</p>
<a href="#" class="icon read-details">Read More</a> </div>
<div class="options"><a href="#" class="icon calendar">May 24&ndash;Sep 1</a><a href="#" class="icon buy-tickets">buy tickets</a><a href="41.8949282,-87.6123777" class="icon location map-link">Guest Services</a></div>
</div>
</div>
<div class="details padded">
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent eget lacus sit amet mauris interdum fringilla. In mattis nibh dui, in luctus massa tincidunt vel. Mauris vitae nisi mattis, congue nunc in, hendrerit lacus. Suspendisse imperdiet tortor a sapien eleifend lobortis. Aenean egestas fringilla ipsum eu ullamcorper. Proin condimentum interdum eros, quis rhoncus justo tristique dictum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec cursus lacus quis arcu gravida iaculis. In vulputate sollicitudin nunc in congue.</p>
<p>Donec tristique laoreet risus non lacinia. Vivamus quis ipsum a ligula dictum convallis. Suspendisse venenatis eleifend enim non posuere. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque condimentum dictum mi vitae convallis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus sollicitudin viverra fermentum. Donec vitae ligula eu purus blandit mollis. Aliquam eu scelerisque velit. Quisque imperdiet congue lacus, vel commodo urna semper id. Cras dignissim malesuada augue eget lacinia. Donec vitae malesuada lorem, ut consequat tellus. Etiam eleifend iaculis nisi ut cursus. Vestibulum eu libero non tortor dictum suscipit sit amet et leo. Aliquam eu nibh a nisl rutrum pharetra.</p>
</div>
</div>
<div class="entry">
<div class="title clearfix">
<div class="col entry-image"> <img src="images/cirque.jpg" width="400" height="569" class="background-cover"> </div>
<div class="col span-2">
<div class="info padded">
<h3>Cirque Shanghai: Warriors</h3>
<p>Cirque Shanghai combines impressive acrobatics with martial prowess. This summer’s production of Cirque Shanghai: Warriors brings an extraordinary line-up of thrilling acts to the stage, including China’s premier daredevil steel globe motorcycle troupe, “Imperial Thunder.”</p>
<a href="#" class="icon read-details">Read More</a> </div>
<div class="options"><a href="#" class="icon calendar">May 24&ndash;Sep 1</a><a href="#" class="icon buy-tickets">buy tickets</a><a href="41.8916071,-87.6089848" class="icon location map-link">IMAX Theatre</a></div>
</div>
</div>
<div class="details padded">
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent eget lacus sit amet mauris interdum fringilla. In mattis nibh dui, in luctus massa tincidunt vel. Mauris vitae nisi mattis, congue nunc in, hendrerit lacus. Suspendisse imperdiet tortor a sapien eleifend lobortis. Aenean egestas fringilla ipsum eu ullamcorper. Proin condimentum interdum eros, quis rhoncus justo tristique dictum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec cursus lacus quis arcu gravida iaculis. In vulputate sollicitudin nunc in congue.</p>
<p>Donec tristique laoreet risus non lacinia. Vivamus quis ipsum a ligula dictum convallis. Suspendisse venenatis eleifend enim non posuere. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque condimentum dictum mi vitae convallis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus sollicitudin viverra fermentum. Donec vitae ligula eu purus blandit mollis. Aliquam eu scelerisque velit. Quisque imperdiet congue lacus, vel commodo urna semper id. Cras dignissim malesuada augue eget lacinia. Donec vitae malesuada lorem, ut consequat tellus. Etiam eleifend iaculis nisi ut cursus. Vestibulum eu libero non tortor dictum suscipit sit amet et leo. Aliquam eu nibh a nisl rutrum pharetra.</p>
</div>
</div>
<div class="entry">
<div class="title clearfix">
<div class="col entry-image"> <img src="images/cirque.jpg" width="400" height="569" class="background-cover"> </div>
<div class="col span-2">
<div class="info padded">
<h3>Cirque Shanghai: Warriors</h3>
<p>Cirque Shanghai combines impressive acrobatics with martial prowess. This summer’s production of Cirque Shanghai: Warriors brings an extraordinary line-up of thrilling acts to the stage, including China’s premier daredevil steel globe motorcycle troupe, “Imperial Thunder.”</p>
<a href="#" class="icon read-details">Read More</a> </div>
<div class="options"><a href="#" class="icon calendar">May 24&ndash;Sep 1</a><a href="#" class="icon buy-tickets">buy tickets</a><a href="41.8917043,-87.6086962" class="icon location map-link">Chicago Children’s Museum</a></div>
</div>
</div>
<div class="details padded">
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent eget lacus sit amet mauris interdum fringilla. In mattis nibh dui, in luctus massa tincidunt vel. Mauris vitae nisi mattis, congue nunc in, hendrerit lacus. Suspendisse imperdiet tortor a sapien eleifend lobortis. Aenean egestas fringilla ipsum eu ullamcorper. Proin condimentum interdum eros, quis rhoncus justo tristique dictum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec cursus lacus quis arcu gravida iaculis. In vulputate sollicitudin nunc in congue.</p>
<p>Donec tristique laoreet risus non lacinia. Vivamus quis ipsum a ligula dictum convallis. Suspendisse venenatis eleifend enim non posuere. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque condimentum dictum mi vitae convallis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus sollicitudin viverra fermentum. Donec vitae ligula eu purus blandit mollis. Aliquam eu scelerisque velit. Quisque imperdiet congue lacus, vel commodo urna semper id. Cras dignissim malesuada augue eget lacinia. Donec vitae malesuada lorem, ut consequat tellus. Etiam eleifend iaculis nisi ut cursus. Vestibulum eu libero non tortor dictum suscipit sit amet et leo. Aliquam eu nibh a nisl rutrum pharetra.</p>
</div>
</div>
</div>
</div>

<?php get_sidebar('ads');?>



<?php
get_footer();