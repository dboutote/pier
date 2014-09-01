<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content
 *
 * @package WordPress
 * @subpackage Navy_Pier
 * @since Navy Pier 1.0
 */
?>

<footer>
	<div class="top">
		<div class="container clearfix">
			<div class="left-col">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>
			</div>
			<div class="right-col">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
				<?php dynamic_sidebar( 'sidebar-3' ); ?>
			</div>
			<div class="bottom-row">
				<?php dynamic_sidebar( 'sidebar-4' ); ?>
			</div>
		</div>
	</div> <!-- /.top -->
	<div class="bottom">
		<div class="container">
			<a href="index.php"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/footer-logo-black.png" class="footer-logo"></a>
			<div class="right-col">
				<nav><?php echo np_get_btm_menu_primary(); ?></nav>
				<p class="copyright">Copyright &copy; <?php echo date('Y'); ?> Navy Pier, Inc., Chicago, IL. All Rights Reserved.</p>
			</div>
		</div>
	</div> <!-- /.bottom -->
</footer>

<?php wp_footer(); ?>
</body>
</html>