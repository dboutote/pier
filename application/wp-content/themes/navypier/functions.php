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
		set_post_thumbnail_size( 600, 600, true );
		add_image_size( 'navypier-full-width', 1038, 576, true );
		add_image_size( 'homepage-rotator', 1200, 800, true);
		
		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
				'primary'         => __( 'Top primary menu', 'navypier' ),
				'secondary'       => __( 'Top secondary menu ', 'navypier' ),
				'social-top'      => __( 'Top social links menu ', 'navypier' ),
				'quick-top'       => __( 'Top quick links menu ', 'navypier' ),
				'footer-primary'  => __( 'Footer primary menu ', 'navypier' ),
				'quick-mobile'    => __( 'Mobile quick links menu ', 'navypier' ),
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
 * Register the widget areas.
 *
 * @since Navy Pier 1.0
 */
function np_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer Sidebar I', 'navypier' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Displays QUICK LINKS information in the footer', 'navypier' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s quick-links-footer clearfix">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title category">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Sidebar II', 'navypier' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Displays CONTACT information in the footer', 'navypier' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s contact-info-footer clearfix">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title category">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Sidebar III', 'navypier' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Displays SOCIAL MEDIA information in the footer', 'navypier' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s social-links-footer clearfix">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title category">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Sidebar IV', 'navypier' ),
		'id'            => 'sidebar-4',
		'description'   => __( 'Displays PARTNER information in the footer', 'navypier' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s sponsors-footer clearfix">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title category">',
		'after_title'   => '</h4>',
	) );	
}
add_action( 'widgets_init', 'np_widgets_init' );

 
/**
 * Register styles for the front end.
 *
 * @since Navy Pier 1.0
 * @uses get_template_directory_uri()
 * @uses get_stylesheet_directory_uri() 
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
		'np-lightbox',
		get_stylesheet_directory_uri() . '/css/nivo-lightbox.css',
		array(),
		null		
		);
	wp_register_style(
		'np-lightbox-theme',
		get_stylesheet_directory_uri() . '/css/lightbox/default.css',
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
	
	$deps = array( 'np-webtypes','np-reset','np-tooltip','np-lightbox','np-lightbox-theme','np-fontawesome','np-styles');
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
		'3.0.3',
		true
	);	
	wp_register_script(
		'jquery-backgroundcover',
		get_stylesheet_directory_uri() . '/js/jquery.backgroundcover.min.js',
		array('jquery'),
		null,
		true
	);	
	wp_register_script(
		'jquery-nivo-lightbox',
		get_stylesheet_directory_uri() . '/js/nivo-lightbox.min.js',
		array('jquery'),
		'1.2.0',
		true
	);
	$deps = array(
		'jquery', 
		'np-google-maps', 
		'jquery-mobile', 
		'viewports-buggyfill', 
		'jquery-tooltipster',
		'jquery-cycle',
		'jquery-backgroundcover',
		'jquery-nivo-lightbox'
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
	
	wp_localize_script(
		'np-scripts',
		'np_scripts',
		array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'images_url' => get_stylesheet_directory_uri() . '/images/'
		)
	);
		
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


/**
 * Retrieve a cached navigation menu
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_nav_menu
 * @see wp_nav_menu()
 *
 * @uses wp_nav_menu()
 * @uses get_transient()
 * @uses set_transient()
 * 
 * @param string $theme_location The location in the theme registered with register_nav_menu()
 * @param array $menu_args Parameters to display the menu 
 */
function np_get_cached_nav_menu( $theme_location, $menu_args ){
	
	$menu = get_transient( "navmenu_{$theme_location}" );
	
	if( false === $menu){
		$menu_args['theme_location'] = $theme_location;
		$menu_args['echo'] = 0;
		$menu = wp_nav_menu($menu_args);

		set_transient("navmenu_{$theme_location}", $menu);
	}
	
	return $menu;
}


/**
 * Display the secondary nav menu
 *
 * Wrapper for np_get_cached_nav_menu()
 *
 * @uses np_get_cached_nav_menu()
 */
function np_get_top_menu_secondary(){
	$menu_args = array(
		'menu_class' => 'text-links nav-menu',
		'container'=> '',
		'fallback_cb' => false 
	);			
	
	return np_get_cached_nav_menu( $theme_location = 'secondary', $menu_args  ); 
}

/**
 * Display the social links nav menu
 *
 * Wrapper for np_get_cached_nav_menu()
 *
 * @uses np_get_cached_nav_menu()
 */
function np_get_top_menu_social(){
	$menu_args = array(
		'menu_class' => 'social-links nav-menu',
		'container'=> '',
		'fallback_cb' => false 
	);			
	
	return np_get_cached_nav_menu( $theme_location = 'social-top', $menu_args  ); 
}


/**
 * Display the social links nav menu
 *
 * Wrapper for np_get_cached_nav_menu()
 *
 * @uses np_get_cached_nav_menu()
 */
function np_get_top_menu_quick(){
	$menu_args = array(
		'menu_class' => 'quick-links nav-menu',
		'container'=> '',
		'fallback_cb' => false,
		'items_wrap' => '<ul id="menu-top-quick-links" class="quick-links nav-menu"><li class="title">Quick Links:</li>%3$s</ul>'		
	);			
	
	return np_get_cached_nav_menu( $theme_location = 'quick-top', $menu_args  ); 
}


/**
 * Display the footer nav menu
 *
 * Wrapper for np_get_cached_nav_menu()
 *
 * @uses np_get_cached_nav_menu()
 */
function np_get_btm_menu_primary(){
	$menu_args = array(
		'menu_class' => 'nav-menu',
		'container'=> '',
		'fallback_cb' => false
	);			
	
	return np_get_cached_nav_menu( $theme_location = 'footer-primary', $menu_args  ); 
}



/**
 * Update the menu transient when a nav menu is updated
 *
 * Checks for the theme_location of the menu being updated and deletes its corresponding transient
 *
 * @since 1.0
 * @uses get_theme_mod()
 * @uses delete_transient()
 */
function np_maybe_update_menu_transient( $menu_id ){

	$locations = get_theme_mod( 'nav_menu_locations' );
	
	foreach($locations as $theme_location => $id){
		if($menu_id === $id ){
			delete_transient("navmenu_{$theme_location}");
		}
	}
	
	return $menu_id;
}

add_action( 'wp_update_nav_menu', 'np_maybe_update_menu_transient', 0,2);


/**
 * Custom search form
 * 
 * @since 1.0
 *
 */
function np_search_form( $form ){
	$form = '
	<form role="search" method="get" class="search-form" action="'. home_url( '/' ) . '">
		<input type="text" class="search-field" placeholder="Search Navy Pier" name="s" id="s" value="" />
		<input type="submit" class="search-submit" value="Submit" />
	</form>';
	return $form;
}
 
add_filter( 'get_search_form', 'np_search_form' );

/**
 * The newsletter form
 *
 * @since 1.0
 *
 */ 
function np_get_newsletter_form(){
	ob_start();
	get_template_part( 'form', 'newsletter' );
	$form = ob_get_clean();
	echo $form;
}




/**
 * Scrape Instagram
 *
 */
// based on https://gist.github.com/cosmocatalano/4544576
function np_scrape_instagram($username, $slice = 9) {
	
		$remote = wp_remote_get('http://instagram.com/'.trim($username));

		if (is_wp_error($remote))
			return new WP_Error('site_down', __('Unable to communicate with Instagram.', 'navypier'));

		if ( 200 != wp_remote_retrieve_response_code( $remote ) )
			return new WP_Error('invalid_response', __('Instagram did not return a valid response.', 'navypier'));

		$shards = explode('window._sharedData = ', $remote['body']);
		$insta_json = explode(';</script>', $shards[1]);
		$insta_array = json_decode($insta_json[0], TRUE);

		if (!$insta_array)
			return new WP_Error('bad_json', __('Instagram has returned invalid data.', 'navypier'));

		$images = $insta_array['entry_data']['UserProfile'][0]['userMedia'];

		$instagram = array();

		foreach ($images as $image) {

			if ($image['user']['username'] == $username) {

				$image['link']                          = preg_replace( "/^http:/i", "", $image['link'] );
				$image['images']['thumbnail']           = preg_replace( "/^http:/i", "", $image['images']['thumbnail'] );
				$image['images']['standard_resolution'] = preg_replace( "/^http:/i", "", $image['images']['standard_resolution'] );

				$instagram[] = array(
					'description'   => $image['caption']['text'],
					'link'          => $image['link'],
					'time'          => $image['created_time'],
					'comments'      => $image['comments']['count'],
					'likes'         => $image['likes']['count'],
					'thumbnail'     => $image['images']['thumbnail'],
					'large'         => $image['images']['standard_resolution'],
					'type'          => $image['type']
				);
			}
		}


	return array_slice($instagram, 0, $slice);
}

/**
 * Build Instagram feed
 *
 * based on https://gist.github.com/cosmocatalano/4544576
 *
 * @uses np_scrape_instagram()
 */
function np_get_instagram_feed( $username, $photos) {
	
	$feed = get_transient('instagram_feed-'.sanitize_title_with_dashes($username));
	
	if ( false === $feed ) {
		$insta_feed = np_scrape_instagram( $username, $photos );
		if ( is_wp_error($insta_feed) ) {
			$feed = $insta_feed->get_error_message();
		} else {
			$feed = '';
			foreach ($insta_feed as $item) {
				$feed .= '<div class="post"><a href="'. esc_url( $item['link'] ) .'" target="_blank"><img src="'. esc_url($item['large']['url']) .'"  alt="'. esc_attr( $item['description'] ) .'" title="'. esc_attr( $item['description'] ).'" width="640" height="640" class="background-cover"/></a></div>';				
			}			
			set_transient('instagram_feed-'.sanitize_title_with_dashes($username), $feed, HOUR_IN_SECONDS * 2);
		}
	}
	return $feed;
}



/*
 * Add Simple Tweets
 *
 * To overwrite in a plugin, define your own Simple_Tweets class on or
 * before the 'setup_theme' hook.
 */
if ( ! class_exists( 'Simple_Tweets' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
	require get_template_directory() . '/inc/simple-tweets/simple_tweets.php';
}


/**
 * String Replace text in widgets
 *
 * filter the url for images
 */
function np_filter_widget_text($text){
 $search = array(
	'<!-- theme_img_url -->'
	);
 $replace = array(
	get_stylesheet_directory_uri() . '/images'
	);
 $text = str_replace($search, $replace, $text);
 return $text;
}
add_filter('widget_text', 'np_filter_widget_text');


/*
 * Add Promotion Meta Box functionality.
 *
 * To overwrite in a plugin, define your own MetaBox_Promotion class on or 
 * before the 'setup_theme' hook.
 */
if ( ! class_exists( 'MetaBox_Promotion' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
	require get_template_directory() . '/inc/metabox_promotions.php';
}



/**
 * Load Event Calendar functions
 */
require get_template_directory() . '/tribe-events/functions_events.php';


/**
 * Generate the url for a single Promotion
 */
function np_get_promo_url($post_id = null)
{
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	$url =  home_url('/promotions/') . '#entry-' . $post_id;
	
	return apply_filters('np_promo_url', $url, $post_id);
}

/**
 * Filter WP default permalink for Promotion post types
 */
function np_replace_promo_permalink($url){
	if( 'cpt_promotion' === get_post_type() ){
		return np_get_promo_url(get_the_ID());
	}
	return $url;
}
add_filter('the_permalink', 'np_replace_promo_permalink');




/**
 * Exclude Posts from search results
 *
 */
function np_filter_search() {
    global $wp_post_types;
 
    if ( post_type_exists( 'post' ) ) { 
        // exclude from search results
        $wp_post_types['post']->exclude_from_search = true;
    }
}

add_action( 'init', 'np_filter_search', 99 );