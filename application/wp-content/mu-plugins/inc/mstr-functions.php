<?php

/**
 * Master functions for the site
 */


// Utility function for debugging output
function debug($var){
	echo "\n<pre style=\"text-align:left;\">";
	if( is_array($var) || is_object($var)){
		print_r($var);
	} else {
		var_dump($var);
	}
	echo "</pre>\n";
}


/**
 * Prevent the Admin Bar from appearing
 *
 * Remove the Admin Bar preference in user profile
 */
if ( !defined('WP_DEBUG') || ( defined('WP_DEBUG') && false === WP_DEBUG) ) {
	show_admin_bar(false);
	remove_action( 'personal_options', '_admin_bar_preferences' );
}


/**
 * Allow all post-types for post_tag taxonomy queries
 *
 * Without this, WP will only look for post_tag taxonomies on the "post" post-type *
 */
function post_type_tags_fix($request) {
    if ( isset($request['tag']) && !isset($request['post_type']) )
		$request['post_type'] = 'any';

    return $request;
};

//add_filter('request', 'post_type_tags_fix');

/**
 * allow all post-types for category taxonomy queries
 *
 * Without this, WP will only look for category taxonomies on the "post" post-type
 */
function post_type_category_fix($request) {
    if ( isset($request['category_name']) && !isset($request['post_type']) )
		$request['post_type'] = 'any';

    return $request;
};

//add_filter('request', 'post_type_category_fix');


/**
 * Remove the html filtering from Term descriptions
 *
 */
remove_filter( 'pre_term_description', 'wp_filter_kses' );
remove_filter( 'term_description', 'wp_kses_data' );


/**
 * Add help tab displaying the Post ID to the Editor Screen
 */
function network_admin_add_help_tab() {
	global $pagenow, $post;

	if ('post.php' == $pagenow  && (isset($_GET['action'])&& 'edit' == $_GET['action']) ) {
		$postid = ($post && '' != $post->ID ) ? $post->ID : $_GET['post'];
		$post_id_text = '<p>' . __('Your post id is: <strong>' . $postid . '</strong>  <br /><br />This number should match the number in the URL above where it says &#8220;<code>post=###</code>&#8221;.') . '</p>';
		get_current_screen()->add_help_tab( array(
			'id'      => 'your-post-id',
			'title'   => __('Post ID'),
			'content' => $post_id_text,
		) );
	}
}

add_action('load-post.php', 'network_admin_add_help_tab');


/**
 * Load a template file on singe-post-type page (if applicable)
 *
 * Works for all post-types
 */
function show_me_the_template($template) {
	if( !is_archive() ) {
		$id = get_queried_object_id();
		$template_name = get_post_meta($id, '_wp_page_template', true);
		$new_template = locate_template($template_name);

		if('' != $new_template)
			$template = $new_template;
	}
    return $template;
}

add_filter( 'template_include', 'show_me_the_template' );


// remove wp version param from any enqueued scripts
function vc_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );



/**
 * Remove the inline style for the Recent Comments Widget
 */
add_filter( 'show_recent_comments_widget_style', '__return_false' );


// chunk a string at XX characters
function abbreviate($text, $max = '95') {
	if (strlen($text)<=$max)
		return $text;
	return substr($text, 0, $max-3) . '&#8230;';
}






	
	
	
	
	
	





