<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Navy_Pier
 * @since Navy Pier 1.0
 */

get_header(); ?>

<div id="inside-hero-region">


</div>  <!-- /#inside-hero-region -->

<div class="container">  <!-- <?php echo basename(__FILE__); ?> -->

	<div class="intro clearfix">
		
		<div class="col span-2 padded">

			<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'navypier' ), get_search_query() ); ?></h1>
	
			<?php if ( have_posts() ) : ?>
			
				<div class="search-results">
					<?php
					// Start the Loop.
					while ( have_posts() ) : the_post(); ?>
						<div class="<?php post_class('search-result');?>">
						<?php 
							the_title( '<h2 class="entry-title">', '</h1>' );
							the_content(); 
						?>
						</div>
					<?php endwhile; ?>			
				</div>
				
			<?php else : ?>
			
				<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'navypier' ); ?></p>

			<?php endif; ?>
			

		</div>
		
		<div class="col padded">
			<div class="page-actions align-right">
				<a href="#" class="icon share">share page</a><a href="#" class="icon print">print page</a>
			</div>
		</div>
		
	</div> <!-- /.intro -->


</div> <!-- /.container -->

<?php //get_sidebar('search'); ?>

<?php get_sidebar('ads'); 

get_footer();