<?php

/**
 * Navy Pier functions and definitions
 *
 * This file contains helper functions that act as custom template tags. Others are attached to 
 * action and filter hooks in WordPress to change core functionality.
 * 
 * @link http://codex.wordpress.org/Template_Tags
 * @link http://codex.wordpress.org/Function_Reference/add_action
 * @link http://codex.wordpress.org/Function_Reference/add_filter
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes 
 * 
 * @package WordPress
 * @subpackage Navy_Pier
 * @since Navy Pier 1.0
 */
 
 
/**
 * Navy Pier only works in WordPress 3.6 or later.
 * 
 * @since Navy Pier 1.0
 */
if ( version_compare( $GLOBALS['wp_version'], '3.6', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}


/**
 * Disable the Theme Customizer
 *
 * It's not needed for this theme.
 *
 * @since Navy Pier 1.0
 */
function np_no_customize(){
	global $pagenow;
	if( 'customize.php' === $pagenow ){		
		wp_die(
			sprintf(
				__( 'The Theme Customizer is not compatible with your current theme: <strong>%s</strong>.', 'navypier' ), 
				wp_get_theme() 
			), 
			'', 
			array('back_link' => true) 
			);
	}
	remove_submenu_page( 'themes.php', 'customize.php' );
}
add_action( 'admin_menu', 'np_no_customize' );
 
 
/**
 * Disable the Admin Bar
 *
 * @since Navy Pier 1.0
 */
if( ! defined ( 'WP_DEBUG' ) || false === WP_DEBUG ) {
	show_admin_bar(false);
}

/**
 * Main Theme Setup
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since Navy Pier 1.0
 */
if ( ! function_exists( 'np_theme_setup' ) ) {

	function np_theme_setup(){
	
		/*
		 * Make this theme available for translation.
		 *
		 * Translations can be added to the /languages/ directory.
		 * If you're building a theme based on Twenty Fourteen, use a find and replace to 
		 * change 'navypier' to the name of your theme in all template files.
		 */
		load_theme_textdomain( 'navypier', get_template_directory() . '/languages' );
		
		add_post_type_support( 'page', 'excerpt' );
		
		// Add RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );
	
		// Enable support for Post Thumbnails, and declare two sizes.
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 672, 372, true );
		add_image_size( 'navypier-full-width', 1038, 576, true );
		
		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
				'primary'   => __( 'Top primary menu', 'navypier' ),
				'secondary' => __( 'Secondary menu ', 'navypier' ),
		));

		 // Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );
			
			
		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );	
	}
}
add_action( 'after_setup_theme', 'np_theme_setup' );

 
/**
 * Register styles for the front end.
 *
 * @since Navy Pier 1.0
 * @uses get_template_directory_uri()
 * @uses get_stylesheet_uri() 
 */
 
function np_register_styles(){	
	wp_register_style(
		'np-webtypes', 
		'//cloud.webtype.com/css/e692c93e-09a6-4af5-841b-00d6dc258288.css', 
		array(), 
		null
		);
	wp_register_style(
		'np-reset',
		get_stylesheet_directory_uri() . '/css/reset.min.css',
		array(),
		null		
		);
	wp_register_style(
		'np-tooltip',
		get_stylesheet_directory_uri() . '/css/tooltipster.css',
		array(),
		null		
		);
	wp_register_style(
		'np-fontawesome',
		get_stylesheet_directory_uri() . '/css/font-awesome.min.css',
		array(),
		null		
		);	
	wp_register_style(
		'np-styles',
		get_stylesheet_directory_uri() . '/css/styles.css',
		array(),
		null		
		);		
	
	$deps = array( 'np-webtypes','np-reset','np-tooltip','np-fontawesome','np-styles');
	wp_register_style( 'np-main', get_stylesheet_uri(), $deps, null, 'all' );
}
add_action('wp_enqueue_scripts', 'np_register_styles');

/**
 * Enqueue styles for the front end.
 *
 * @since Navy Pier 1.0
 */
function np_load_styles(){
	wp_enqueue_style('np-main');
}
add_action('wp_enqueue_scripts', 'np_load_styles');


/**
 * Register scripts for the front end.
 *
 * @since Navy Pier 1.0
 * @uses get_template_directory_uri()
 * @uses get_stylesheet_uri() 
 */
function np_register_scripts(){
	wp_register_script(
		'np-google-maps',
		'http://maps.google.com/maps/api/js?v=3.9&sensor=false',
		array(),
		null,
		true
	);	
	wp_register_script(
		'jquery-mobile',
		get_stylesheet_directory_uri() . '/js/jquery.mobile.custom.min.js',
		array('jquery'),
		'1.4.3',
		true
	);	
	wp_register_script(
		'viewports-buggyfill',
		get_stylesheet_directory_uri() . '/js/viewport-units-buggyfill.js',
		array(),
		'0.3.1',
		true
	);	
	wp_register_script(
		'jquery-tooltipster',
		get_stylesheet_directory_uri() . '/js/jquery.tooltipster.min.js',
		array('jquery'),
		'3.2.6',
		true
	);
	wp_register_script(
		'jquery-cycle',
		get_stylesheet_directory_uri() . '/js/jquery.cycle.min.js',
		array('jquery'),
		null,
		true
	);	
	wp_register_script(
		'jquery-backgroundcover',
		get_stylesheet_directory_uri() . '/js/jquery.backgroundcover.min.js',
		array('jquery'),
		null,
		true
	);
	$deps = array(
		'jquery', 
		'np-google-maps', 
		'jquery-mobile', 
		'viewports-buggyfill', 
		'jquery-tooltipster',
		'jquery-cycle',
		'jquery-backgroundcover'
		);		
	wp_register_script(
		'np-scripts',
		get_stylesheet_directory_uri() . '/js/scripts.js',
		$deps,
		null,
		true
	);		
}
add_action('wp_enqueue_scripts', 'np_register_scripts');


/**
 * Enqueue scripts for the front end.
 *
 * @since Navy Pier 1.0
 */
function np_load_scripts(){	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	wp_enqueue_script('np-scripts');
}
add_action('wp_enqueue_scripts', 'np_load_scripts');


/**
 * Filter the page title.
 * 
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Navy Pier 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function np_wp_title( $title, $sep ) {
	global $paged, $page;
	
	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentyfourteen' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'np_wp_title', 10, 2 );


/*
 * Add Homepage Featured Content functionality.
 *
 * To overwrite in a plugin, define your own Homepage_Featured class on or
 * before the 'setup_theme' hook.
 */
if ( ! class_exists( 'Homepage_Featured' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
	require get_template_directory() . '/inc/homepage-featured.php';
}
