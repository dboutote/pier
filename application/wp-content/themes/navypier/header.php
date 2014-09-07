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
			<div class="search tooltip" title="Search"><i class="fa fa-search"></i></div>
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
		$menu = '<ul id="menu-top-primary" class="nav-menu">';	
		$menu .= '<li id="mobile-map-btn" class="mobile-only"><a href="#">View Map</a></li>';
		$menu .= '
          <li class="mobile-only"><a>Quick Links<img src="images/menu-caret.png" class="caret"></a>
            <div class="drop-down">
              <ul>
                <li class="title"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;Information</li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Media &amp; PR</a></li>
                <li><a href="#">Sponsorship</a></li>
                <li><a href="#">Donate</a></li>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Book Your Event</a></li>
                <li><a href="#">Contact</a></li>
              </ul>
              <ul>
                <li class="title"><i class="fa fa-comments"></i>&nbsp;&nbsp;&nbsp;Social Media</li>
                <li><a href="https://twitter.com/navypier" target="_blank">Twitter</a></li>
                <li><a href="https://www.facebook.com/navypier" target="_blank">Facebook</a></li>
                <li><a href="http://www.youtube.com/user/NavyPierTV" target="_blank">YouTube</a></li>
                <li><a href="http://instagram.com/navypierchicago" target="_blank">Instagram</a></li>
                <li><a href="http://blog.navypier.com/" target="_blank">Blog</a></li>
              </ul>
            </div>
          </li>	';	
		$menu .= wp_nav_menu($menu_args);
		$menu .= '</ul>';
		echo $menu;		
		?>

      </nav>

	  <div class="book-event"><a href="#">Book Your Event</a></div>
	  
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