<?php
/**
 * Featured Events Sidebar
 */
 
$events_title = get_post_meta( get_the_ID(), '_feat_eventbox_title', true );
$num_feat_events = get_post_meta( get_the_ID(), '_feat_events_number', true ); 

$all_events = np_get_featured_events($num_feat_events);

if( !empty($all_events) ) : ?>

	<?php global $post;?>
	
	<div id="events-featured" class="section-title">
		<h2><?php echo $events_title;?></h2>
		<?php if( count($all_events) > 3 ) { ?>
			<div class="events-nav"><a href="#"><i class="fa fa-chevron-circle-left"></i></a><a href="#"><i class="fa fa-chevron-circle-right"></i></a></div>
		<?php } ?>
	</div>
	
	<div id="feat-events-wrap" class="section-content no-bg clearfix">
		
		<?php $count = 0; ?>
		
		<?php if( count($all_events) > 3 ) { ?> <div class="slide"> <?php } ?>
		
			<?php foreach($all_events as $post) { ?>
				<?php ++$count; ?>
				<?php setup_postdata($post); ?>
				
				<div class="col">
					<div class="event-container">
						<?php
						if( has_post_thumbnail() ){
							$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');							
							$img_src = $image_url[0];
							$img_width = $image_obj[1];
							$img_height = $image_obj[2];
							?>
							<a href="<?php echo the_permalink();?>" class="image"><img src="<?php echo $img_src; ?>" width="<?php echo $img_width; ?>" height="<?php echo $img_height; ?>" class="background-cover"></a>	
						<?php }; ?>		
						<a href="<?php the_permalink(); ?>" class="text">
							<h3><?php the_title(); ?></h3>
							<?php echo tribe_events_event_schedule_details(); ?>							
						</a>
					</div>
				</div>
				
				<?php if( count($all_events) > 3 && ($count % 3 == 0) ) { ?>
					</div> <!-- /.slide --> <div class="slide">
				<?php }; ?>
				
			<?php }; ?>
		
		<?php if( count($all_events) > 3 ) { ?> </div> <!-- /.slide --> <?php } ?>
	
	</div><!-- /.section-content -->

<?php else : ?>

	<p>No events found.</p>

<?php endif; ?>	

<?php wp_reset_query();	