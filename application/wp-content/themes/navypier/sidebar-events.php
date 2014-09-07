<?php
/**
 * Upcoming Events Sidebar
 */

$events_title = get_post_meta( get_the_ID(), '_eventbox_title', true );
$num_feat_events = get_post_meta( get_the_ID(), '_events_number', true ); 

$all_events = np_get_events($num_feat_events);

if( !empty($all_events) ) : ?>

	<?php global $post;?>

	<div id="events" class="section-title">
		<h2><?php echo $events_title;?></h2>
	</div>

	<div class="section-content no-bg clearfix">

		<?php foreach($all_events as $post) { ?>

		<?php setup_postdata($post); ?>

			<div class="col">
				<div class="event-container">
					<?php
					if( has_post_thumbnail() ){
						$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
						$img_src = $image_url[0];
						?>
						<a href="<?php echo the_permalink();?>" class="image"><img src="<?php echo $img_src; ?>" width="463" height="275" class="background-cover"></a>	
					<?php }; ?>		
					<a href="<?php the_permalink(); ?>" class="text">
						<h3><?php the_title(); ?></h3>
						<?php echo tribe_events_event_schedule_details(); ?>							
					</a>
				</div>
			</div> <!-- /.col -->

		<?php }; ?>

	</div><!-- /.section-content -->

<?php else : ?>

	<p>No events found.</p>

<?php endif; ?>	

<?php wp_reset_query();