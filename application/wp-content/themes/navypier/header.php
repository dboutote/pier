<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Navy_Pier
 * @since Navy Pier 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.min.js"></script>
<![endif]-->	
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<header>
	<div class="top">
		<div class="container">
			<nav>
				<?php echo np_get_top_menu_secondary(); ?>
				<?php echo np_get_top_menu_social(); ?>
				<?php echo np_get_top_menu_quick(); ?>
			</nav>
			<div class="search-trigger tooltip" title="Search"><i class="fa fa-search"></i></div>
		</div><!-- /.container -->
	</div><!-- /.top -->
  
	<div class="search-row">
		<div class="container">
			<?php get_search_form(); ?>
		</div>
	</div> <!-- /.search-row -->
  
<div class="middle">
	<div class="container">
	<div class="logo"><a href="<?php echo home_url('/'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png"></a></div>
	<div class="menu-btn"><i class="fa fa-bars"></i></div>
	
	<nav class="main">
		<?php 
		$menu_args = array(
			'menu_class' => 'nav-menu',
			'container'=> '',
			'fallback_cb' => false,
			'items_wrap' => '%3$s',
			'theme_location' => 'primary',
			'echo' => 0
		);	
		
		$social_menu_args = array(
			'menu_class' => 'nav-menu',
			'container'=> '',
			'fallback_cb' => false,
			'items_wrap' => '<li class="mobile-only menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item current-menu-ancestor menu-item-has-children"><a href="/#">Quick Links</a><ul class="sub-menu" id="mobile-quick-links">%3$s</ul></li>',
			'theme_location' => 'quick-mobile',
			'echo' => 0
		);
	
		$menu = '<ul id="menu-top-primary" class="nav-menu">';	
		$menu .= '<li id="mobile-map-btn" class="mobile-only"><a href="#">View Map</a></li>';
		$menu .= wp_nav_menu($social_menu_args);
		$menu .= wp_nav_menu($menu_args);
		$menu .= '</ul>';
		echo $menu;		
		?>

      </nav>
	  
</div>
</div><!-- /.middle -->

<div class="bottom">
	<div class="container">
		<div class="join-newsletter">
			<div class="join-btn"><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;&nbsp;Join our newsletter for deals and more<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/menu-caret-black.png" class="caret"></div>
			<?php np_get_newsletter_form(); ?>
		</div>
	</div>
</div>
</header>
<div id="map-canvas"></div>
<div id="map-btn" title="Map"></div>
<div id="back-to-top-btn"><i class="fa fa-chevron-up"></i></div>
